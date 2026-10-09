<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KartuController extends Controller
{
    private const TEMPLATE_FILES = [
        'konsultan' => [
            'depan'    => 'kartu-depan.png',
            'belakang' => 'kartu-belakang.png',
        ],
        'grcs' => [
            'depan'    => 'kartu-depan-grcs.png',
            'belakang' => 'kartu-belakang-grcs.png',
        ],
    ];
    
    private const POSITIONS = [
        'konsultan' => [
            'nama'        => ['x' => 95, 'y' => 179, 'size' => 10],
            'no_anggota'  => ['x' => 68, 'y' => 210, 'size' => 10],
            'berlaku_tgl' => ['x' => 100, 'y' => 390, 'size' => 20],
            'foto_x_pct' => 0.794,
            'foto_y_pct' => 0.324,
            'foto_w_pct' => 0.144,
            'foto_h_pct' => 0.210,
        ],
        'grcs' => [
            'no_anggota'  => ['x' => 68, 'y' => 139, 'size' => 10],
            'nama'        => ['x' => 90, 'y' => 159, 'size' => 10],
            'berlaku_tgl' => ['x' => 60, 'y' => 390, 'size' => 20],
            'foto_x_pct' => 0.74,
            'foto_y_pct' => 0.30,
            'foto_w_pct' => 0.18,
            'foto_h_pct' => 0.26,
        ],
    ];

    public function depan(Request $request, $id)
    {
        $user   = $this->authorizeUser($id);
        $canvas = $this->loadTemplate($this->resolveTemplateFile($user->role, 'depan'));

        [$hitam, $merah, $abu, $putih] = $this->allocateColors($canvas);
        $fonts = $this->loadFonts();
        $d     = $this->resolvePositions($user->role);

        $this->tulis($canvas, $user->name,              $d['nama'],        $hitam, true,  $fonts);
        $this->tulis($canvas, $user->no_anggota ?? '-', $d['no_anggota'],  $merah, true,  $fonts);

        $berlakuSd = $user->berlaku_sd
            ? Carbon::parse($user->berlaku_sd)
            : null;
        
        if ($berlakuSd) {
            $berlakuTgl = $berlakuSd->format('d / m / Y');
        } else {
            $berlakuTgl = Carbon::now()->addYear()->format('d / m / Y');
        }
        
        $this->tulis($canvas, $berlakuTgl, $d['berlaku_tgl'], $hitam, true, $fonts);

        $canvasW = imagesx($canvas);
        $canvasH = imagesy($canvas);

        $fotoX = (int) round($d['foto_x_pct'] * $canvasW);
        $fotoY = (int) round($d['foto_y_pct'] * $canvasH);
        $fotoW = (int) round($d['foto_w_pct'] * $canvasW);
        $fotoH = (int) round($d['foto_h_pct'] * $canvasH);

        $this->stampFoto($canvas, $user, $fotoX, $fotoY, $fotoW, $fotoH);

        $this->outputPng($canvas, 'kartu-' . $this->slug($user->name) . '-depan.png', $request->boolean('download'));
    }

    public function belakang(Request $request, $id)
    {
        $user   = $this->authorizeUser($id);
        $canvas = $this->loadTemplate($this->resolveTemplateFile($user->role, 'belakang'));

        $this->outputPng($canvas, 'kartu-' . $this->slug($user->name) . '-belakang.png', $request->boolean('download'));
    }

    private function resolveTemplateFile(?string $role, string $sisi): string
    {
        return self::TEMPLATE_FILES[$role][$sisi]
            ?? self::TEMPLATE_FILES['konsultan'][$sisi];
    }

    private function resolvePositions(?string $role): array
    {
        return self::POSITIONS[$role] ?? self::POSITIONS['konsultan'];
    }

    private function authorizeUser($id): User
    {
        $user = User::findOrFail($id);
        if (Auth::id() != $id && Auth::user()->role !== 'superadmin') {
            abort(403, 'Akses ditolak.');
        }
        return $user;
    }

    private function loadTemplate(string $filename)
    {
        $path = public_path('image/' . $filename);
        if (!file_exists($path)) {
            abort(404, "Template tidak ditemukan: public/image/{$filename}");
        }
        $canvas = imagecreatefrompng($path);
        if (!$canvas) {
            abort(500, "Gagal membaca template: {$filename}");
        }
        imagealphablending($canvas, true);
        imagesavealpha($canvas, true);
        return $canvas;
    }

    private function allocateColors($canvas): array
    {
        return [
            imagecolorallocate($canvas,  17,  17,  17),
            imagecolorallocate($canvas, 204,   0,   0),
            imagecolorallocate($canvas, 120, 120, 120),
            imagecolorallocate($canvas, 255, 255, 255),
        ];
    }

    private function loadFonts(): array
    {
        $dir = public_path('fonts/');
        $candidates = [
            [$dir . 'Poppins-Regular.ttf',  $dir . 'Poppins-Bold.ttf'],
            [$dir . 'Roboto-Regular.ttf',   $dir . 'Roboto-Bold.ttf'],
            [$dir . 'OpenSans-Regular.ttf', $dir . 'OpenSans-Bold.ttf'],
        ];
        foreach ($candidates as [$regular, $bold]) {
            if (file_exists($regular) && file_exists($bold)) {
                return [$regular, $bold];
            }
        }
        return [null, null];
    }

    private function tulis($canvas, string $teks, array $pos, $warna, bool $bold, array $fonts): void
    {
        $x    = $pos['x'];
        $y    = $pos['y'];
        $size = $pos['size'];

        [$fontRegular, $fontBold] = $fonts;

        if ($fontRegular !== null) {
            $font = $bold ? $fontBold : $fontRegular;
            imagettftext($canvas, $size, 0, $x, intval($y + $size), $warna, $font, $teks);
        } else {
            $gdSize = max(1, min(5, intval($size / 3)));
            imagestring($canvas, $gdSize, $x, $y, $teks, $warna);
        }
    }

    private function stampFoto($canvas, User $user, int $x, int $y, int $w, int $h): void
    {
        $fotoPath = null;
        $candidates = [
            $user->foto   ? storage_path('app/public/' . $user->foto)   : null,
            $user->avatar ? storage_path('app/public/' . $user->avatar) : null,
        ];
        foreach ($candidates as $path) {
            if ($path && file_exists($path)) {
                $fotoPath = $path;
                break;
            }
        }

        if ($fotoPath) {
            $ext = strtolower(pathinfo($fotoPath, PATHINFO_EXTENSION));
            $src = match ($ext) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($fotoPath),
                'png'         => @imagecreatefrompng($fotoPath),
                'webp'        => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($fotoPath) : false,
                default       => false,
            };

            if ($src) {
                $srcW   = imagesx($src);
                $srcH   = imagesy($src);
                $ratio  = max($w / $srcW, $h / $srcH);
                $newW   = intval($srcW * $ratio);
                $newH   = intval($srcH * $ratio);
                $cropX  = intval(($newW - $w) / 2);
                $cropY  = intval(($newH - $h) / 2);

                $resized = imagecreatetruecolor($newW, $newH);
                imagecopyresampled($resized, $src, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);
                imagecopy($canvas, $resized, $x, $y, $cropX, $cropY, $w, $h);

                imagedestroy($src);
                imagedestroy($resized);
                return;
            }
        }

        $placeholder = imagecreatetruecolor($w, $h);
        $bgColor     = imagecolorallocate($placeholder, 204, 0, 0);
        $fgColor     = imagecolorallocate($placeholder, 255, 255, 255);
        imagefill($placeholder, 0, 0, $bgColor);
        $inisial = strtoupper(mb_substr($user->name ?? 'U', 0, 1));
        imagestring($placeholder, 5, intval($w / 2) - 5, intval($h / 2) - 8, $inisial, $fgColor);
        imagecopy($canvas, $placeholder, $x, $y, 0, 0, $w, $h);
        imagedestroy($placeholder);
    }

    private function outputPng($canvas, string $filename, bool $download): void
    {
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Cache-Control: post-check=0, pre-check=0', false);
        header('Pragma: no-cache');
        header('Expires: 0');
        
        if ($download) {
            header('Content-Type: image/png');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        } else {
            header('Content-Type: image/png');
        }
        imagepng($canvas, null, 6);
        imagedestroy($canvas);
        exit;
    }

    private function slug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $name), '-'));
    }
}