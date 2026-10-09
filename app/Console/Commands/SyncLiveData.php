<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use App\Models\Berita;
use App\Models\KategoriBerita;
use App\Models\Event;
use App\Models\KategoriEvent;
use App\Models\User;
use Carbon\Carbon;

class SyncLiveData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:live-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menarik semua data Berita, Event, GRCS Club, Kategori, dan gambar dari website hosting (latifabagroup.com) ke database localhost';

    protected string $baseUrl = 'https://latifabagroup.com';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("=================================================");
        $this->info("  MEMULAI SINKRONISASI DATA DARI HOSTING KE LOCAL");
        $this->info("  Sumber: {$this->baseUrl}");
        $this->info("=================================================\n");

        // 1. Dapatkan user admin fallback untuk created_by
        $user = User::first();
        $userId = $user ? $user->id : 1;

        // 2. Pastikan direktori storage tersedia
        File::ensureDirectoryExists(storage_path('app/public/berita/image'));
        File::ensureDirectoryExists(storage_path('app/public/event/image'));
        File::ensureDirectoryExists(storage_path('app/public/avatars'));

        // 3. Sinkronisasi Berita
        $this->syncBerita($userId);

        // 4. Sinkronisasi Event
        $this->syncEvent($userId);

        // 5. Sinkronisasi GRCS Club
        $this->syncGrcs();

        // 6. Pastikan symlink storage:link aktif
        $this->info("\nMemastikan symlink storage publik...");
        try {
            Artisan::call('storage:link');
            $this->line(Artisan::output());
        } catch (\Exception $e) {
            $this->warn("storage:link notice: " . $e->getMessage());
        }

        $this->info("\n=================================================");
        $this->info("  SINKRONISASI SELESAI!");
        $this->info("  Total Berita di localhost:    " . Berita::count());
        $this->info("  Total Event di localhost:     " . Event::count());
        $this->info("  Total GRCS Club di localhost: " . User::where('role', 'grcs')->count());
        $this->info("=================================================");

        return Command::SUCCESS;
    }

    /**
     * Sinkronisasi data Berita
     */
    protected function syncBerita(int $userId): void
    {
        $this->info("--- [1/3] Menarik Data Berita ---");

        $allLinks = [];
        for ($page = 1; $page <= 10; $page++) {
            $url = $this->baseUrl . "/berita" . ($page > 1 ? "?page={$page}" : "");
            $this->line("Memeriksa halaman berita {$page}...");

            try {
                $response = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($url);

                if (!$response->successful()) {
                    break;
                }

                $html = $response->body();
                preg_match_all('/href=["\'](?:https?:\/\/latifabagroup\.com)?\/berita\/(\d+)["\']/i', $html, $matches);

                $pageLinks = array_unique($matches[1] ?? []);
                if (empty($pageLinks)) {
                    break;
                }

                $newCount = 0;
                foreach ($pageLinks as $id) {
                    if (!in_array($id, $allLinks)) {
                        $allLinks[] = $id;
                        $newCount++;
                    }
                }

                if ($newCount === 0) {
                    break;
                }
            } catch (\Exception $e) {
                $this->warn("Gagal membaca halaman {$url}: " . $e->getMessage());
                break;
            }
        }

        $this->info("Ditemukan " . count($allLinks) . " artikel berita di hosting.");

        foreach ($allLinks as $id) {
            $itemUrl = "{$this->baseUrl}/berita/{$id}";
            try {
                $resp = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($itemUrl);

                if (!$resp->successful()) {
                    continue;
                }

                $html = $resp->body();

                // Ekstraksi Title
                preg_match('/<h1[^>]*class=["\'][^"\']*article-title[^"\']*["\'][^>]*>(.*?)<\/h1>/si', $html, $tm);
                if (empty($tm[1])) {
                    preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $html, $tm);
                }
                $title = trim(strip_tags($tm[1] ?? ''));
                if (empty($title)) {
                    continue;
                }

                // Cek apakah sudah ada di database
                if (Berita::where('title', $title)->exists()) {
                    $this->line(" [SKIP] Berita sudah ada: {$title}");
                    continue;
                }

                // Ekstraksi Kategori
                preg_match('/class=["\'][^"\']*article-kategori-badge[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $km);
                $kategori = trim(strip_tags($km[1] ?? 'Berita'));
                if (empty($kategori)) {
                    $kategori = 'Berita';
                }

                // Simpan kategori jika belum ada
                KategoriBerita::firstOrCreate(['nama' => $kategori]);

                // Ekstraksi Views
                preg_match('/class=["\'][^"\']*badge-views[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $vm);
                $views = isset($vm[1]) && is_numeric(trim($vm[1])) ? (int)trim($vm[1]) : rand(50, 200);

                // Ekstraksi Kontributor
                preg_match('/Kontributor:\s*([^<\n]+)/i', $html, $kontribM);
                $kontributor = trim($kontribM[1] ?? 'Admin');

                // Ekstraksi Tanggal
                preg_match('/<i class=["\'][^"\']*fa-clock[^"\']*["\']><\/i>\s*([^<\n]+)/i', $html, $dateM);
                $publishedAt = $this->parseIndonesianDate($dateM[1] ?? '');

                // Ekstraksi Image
                preg_match('/class=["\'][^"\']*article-image-wrap[^"\']*["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\']/si', $html, $imgM);
                $imageUrl = $imgM[1] ?? '';
                if (empty($imageUrl)) {
                    preg_match('/<img[^>]+src=["\']([^"\']*(?:berita|storage)[^"\']*)["\']/si', $html, $imgM);
                    $imageUrl = $imgM[1] ?? '';
                }

                $imagePath = $this->downloadMedia($imageUrl, 'berita/image');

                // Ekstraksi Konten Artikel
                preg_match('/<div class=["\'][^"\']*article-body[^"\']*["\'][^>]*>(.*?)<\/div>\s*<div class=["\'][^"\']*article-bottom-meta/si', $html, $bodyM);
                if (empty($bodyM[1])) {
                    preg_match('/<div class=["\'][^"\']*article-body[^"\']*["\'][^>]*>(.*?)<\/div>/si', $html, $bodyM);
                }
                $content = trim($bodyM[1] ?? '');
                if (empty($content)) {
                    $content = '<p>' . htmlspecialchars($title) . '</p>';
                }

                // Bersihkan URL gambar internal pada konten jika menunjuk ke hosting lama
                $content = str_replace($this->baseUrl . '/storage/', '/storage/', $content);

                // Simpan ke database
                Berita::create([
                    'kategori'      => $kategori,
                    'kontributor'   => $kontributor,
                    'no_anggota'    => '369',
                    'published_at'  => $publishedAt,
                    'title'         => $title,
                    'content'       => $content,
                    'image'         => $imagePath,
                    'views'         => $views,
                    'is_active'     => true,
                    'status'        => 'approved',
                    'created_by'    => $userId,
                    'approved_by'   => $userId,
                    'approved_at'   => $publishedAt,
                ]);

                $this->info(" [OK] Berhasil import berita: {$title}");
            } catch (\Exception $e) {
                $this->error(" Gagal import berita {$itemUrl}: " . $e->getMessage());
            }
        }
    }

    /**
     * Sinkronisasi data Event
     */
    protected function syncEvent(int $userId): void
    {
        $this->info("\n--- [2/3] Menarik Data Event ---");

        $allLinks = [];
        for ($page = 1; $page <= 10; $page++) {
            $url = $this->baseUrl . "/event" . ($page > 1 ? "?page={$page}" : "");
            $this->line("Memeriksa halaman event {$page}...");

            try {
                $response = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($url);

                if (!$response->successful()) {
                    break;
                }

                $html = $response->body();
                preg_match_all('/href=["\'](?:https?:\/\/latifabagroup\.com)?\/event\/(\d+)["\']/i', $html, $matches);

                $pageLinks = array_unique($matches[1] ?? []);
                if (empty($pageLinks)) {
                    break;
                }

                $newCount = 0;
                foreach ($pageLinks as $id) {
                    if (!in_array($id, $allLinks)) {
                        $allLinks[] = $id;
                        $newCount++;
                    }
                }

                if ($newCount === 0) {
                    break;
                }
            } catch (\Exception $e) {
                $this->warn("Gagal membaca halaman {$url}: " . $e->getMessage());
                break;
            }
        }

        $this->info("Ditemukan " . count($allLinks) . " event di hosting.");

        foreach ($allLinks as $id) {
            $itemUrl = "{$this->baseUrl}/event/{$id}";
            try {
                $resp = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($itemUrl);

                if (!$resp->successful()) {
                    continue;
                }

                $html = $resp->body();

                // Ekstraksi Title
                preg_match('/<h1[^>]*class=["\'][^"\']*article-title[^"\']*["\'][^>]*>(.*?)<\/h1>/si', $html, $tm);
                if (empty($tm[1])) {
                    preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $html, $tm);
                }
                $title = trim(strip_tags($tm[1] ?? ''));
                if (empty($title)) {
                    continue;
                }

                // Cek apakah sudah ada di database
                if (Event::where('title', $title)->exists()) {
                    $this->line(" [SKIP] Event sudah ada: {$title}");
                    continue;
                }

                // Ekstraksi Kategori
                preg_match('/class=["\'][^"\']*article-kategori-badge[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $km);
                $kategori = trim(strip_tags($km[1] ?? 'Event'));
                if (empty($kategori)) {
                    $kategori = 'Event';
                }

                // Simpan kategori jika belum ada
                KategoriEvent::firstOrCreate(['nama' => $kategori]);

                // Ekstraksi Views
                preg_match('/class=["\'][^"\']*badge-views[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $vm);
                $views = isset($vm[1]) && is_numeric(trim($vm[1])) ? (int)trim($vm[1]) : rand(50, 200);

                // Ekstraksi Kontributor
                preg_match('/Kontributor:\s*([^<\n]+)/i', $html, $kontribM);
                $kontributor = trim($kontribM[1] ?? 'Admin');

                // Ekstraksi Tanggal
                preg_match('/<i class=["\'][^"\']*fa-clock[^"\']*["\']><\/i>\s*([^<\n]+)/i', $html, $dateM);
                $publishedAt = $this->parseIndonesianDate($dateM[1] ?? '');

                // Ekstraksi Image
                preg_match('/class=["\'][^"\']*article-image-wrap[^"\']*["\'][^>]*>.*?<img[^>]+src=["\']([^"\']+)["\']/si', $html, $imgM);
                $imageUrl = $imgM[1] ?? '';
                if (empty($imageUrl)) {
                    preg_match('/<img[^>]+src=["\']([^"\']*(?:event|storage)[^"\']*)["\']/si', $html, $imgM);
                    $imageUrl = $imgM[1] ?? '';
                }

                $imagePath = $this->downloadMedia($imageUrl, 'event/image');

                // Ekstraksi Konten Artikel
                preg_match('/<div class=["\'][^"\']*article-body[^"\']*["\'][^>]*>(.*?)<\/div>\s*<div class=["\'][^"\']*article-bottom-meta/si', $html, $bodyM);
                if (empty($bodyM[1])) {
                    preg_match('/<div class=["\'][^"\']*article-body[^"\']*["\'][^>]*>(.*?)<\/div>/si', $html, $bodyM);
                }
                $content = trim($bodyM[1] ?? '');
                if (empty($content)) {
                    $content = '<p>' . htmlspecialchars($title) . '</p>';
                }

                // Bersihkan URL gambar internal pada konten jika menunjuk ke hosting lama
                $content = str_replace($this->baseUrl . '/storage/', '/storage/', $content);

                // Simpan ke database
                Event::create([
                    'kategori'      => $kategori,
                    'kontributor'   => $kontributor,
                    'no_anggota'    => '369',
                    'published_at'  => $publishedAt,
                    'title'         => $title,
                    'content'       => $content,
                    'image'         => $imagePath,
                    'views'         => $views,
                    'is_active'     => true,
                    'status'        => 'approved',
                    'created_by'    => $userId,
                    'approved_by'   => $userId,
                    'approved_at'   => $publishedAt,
                ]);

                $this->info(" [OK] Berhasil import event: {$title}");
            } catch (\Exception $e) {
                $this->error(" Gagal import event {$itemUrl}: " . $e->getMessage());
            }
        }
    }

    /**
     * Sinkronisasi data Anggota GRCS Club
     */
    protected function syncGrcs(): void
    {
        $this->info("\n--- [3/3] Menarik Data Anggota GRCS Club ---");

        $allMembers = [];
        for ($page = 1; $page <= 10; $page++) {
            $url = $this->baseUrl . "/grcs-club" . ($page > 1 ? "?page={$page}" : "");
            $this->line("Memeriksa halaman GRCS Club {$page}...");

            try {
                $response = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($url);

                if (!$response->successful()) {
                    break;
                }

                $html = $response->body();
                preg_match_all('/<a[^>]*href=["\'](?:https?:\/\/latifabagroup\.com)?\/grcs-club\/(\d+)["\'][^>]*>(.*?)<\/a>/si', $html, $matches);

                $pageLinks = $matches[1] ?? [];
                if (empty($pageLinks)) {
                    break;
                }

                $newCount = 0;
                for ($i = 0; $i < count($pageLinks); $i++) {
                    $id = $pageLinks[$i];
                    $cardHtml = $matches[2][$i] ?? '';
                    if (!isset($allMembers[$id])) {
                        preg_match('/<img[^>]+src=["\']([^"\']+)["\']/si', $cardHtml, $pm);
                        preg_match('/class=["\'][^"\']*g-card-banner-badge[^"\']*["\'][^>]*>(.*?)<\/span>/si', $cardHtml, $bm);
                        preg_match('/class=["\'][^"\']*g-card-name[^"\']*["\'][^>]*>(.*?)<\/div>/si', $cardHtml, $nm);

                        $allMembers[$id] = [
                            'id' => $id,
                            'card_photo' => $pm[1] ?? null,
                            'card_badge' => trim(strip_tags($bm[1] ?? 'Regular')),
                            'card_name'  => trim(strip_tags($nm[1] ?? '')),
                        ];
                        $newCount++;
                    }
                }

                if ($newCount === 0) {
                    break;
                }
            } catch (\Exception $e) {
                $this->warn("Gagal membaca halaman {$url}: " . $e->getMessage());
                break;
            }
        }

        $this->info("Ditemukan " . count($allMembers) . " anggota GRCS Club di hosting.");

        foreach ($allMembers as $id => $cardData) {
            $itemUrl = "{$this->baseUrl}/grcs-club/{$id}";
            try {
                $resp = Http::timeout(15)
                    ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                    ->get($itemUrl);

                $name = $cardData['card_name'];
                $noAnggota = null;
                $membershipType = strtolower($cardData['card_badge'] ?: 'regular');
                $institution = null;
                $position = null;
                $tempatLahir = null;
                $tanggalLahir = null;
                $provinsi = null;
                $photoUrl = $cardData['card_photo'];

                if ($resp->successful()) {
                    $html = $resp->body();

                    // Name
                    preg_match('/<h1[^>]*class=["\'][^"\']*gd-name[^"\']*["\'][^>]*>(.*?)<\/h1>/si', $html, $nm);
                    if (empty($nm[1])) {
                        preg_match('/<h1[^>]*>(.*?)<\/h1>/si', $html, $nm);
                    }
                    if (!empty($nm[1])) {
                        $name = trim(strip_tags($nm[1]));
                    }

                    // No Anggota
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-info-label[^"\']*["\'][^>]*>No\.\s*Anggota<\/span>\s*<span[^>]*class=["\'][^"\']*gd-info-value[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $noM);
                    if (!empty($noM[1])) {
                        $noAnggota = trim(strip_tags($noM[1]));
                    }

                    // Tipe Keanggotaan
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-badge-type[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $tm);
                    if (!empty($tm[1])) {
                        $membershipType = strtolower(trim(strip_tags($tm[1])));
                    }

                    // Institusi
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-detail-label[^"\']*["\'][^>]*>Institusi<\/span>\s*<span[^>]*class=["\'][^"\']*gd-detail-value[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $instM);
                    $instVal = trim(strip_tags($instM[1] ?? ''));
                    if (!empty($instVal) && $instVal !== '-') {
                        $institution = $instVal;
                    }

                    // Posisi
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-detail-label[^"\']*["\'][^>]*>Posisi\s*\/\s*Divisi<\/span>\s*<span[^>]*class=["\'][^"\']*gd-detail-value[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $posM);
                    $posVal = trim(strip_tags($posM[1] ?? ''));
                    if (!empty($posVal) && $posVal !== '-') {
                        $position = $posVal;
                    }

                    // Tempat Tanggal Lahir
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-detail-label[^"\']*["\'][^>]*>Tempat,\s*Tanggal Lahir<\/span>\s*<span[^>]*class=["\'][^"\']*gd-detail-value[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $ttlM);
                    if (!empty($ttlM[1])) {
                        $ttlRaw = trim(strip_tags($ttlM[1]));
                        $ttlParts = explode(',', $ttlRaw);
                        $tTempat = trim($ttlParts[0] ?? '');
                        if (!empty($tTempat) && $tTempat !== '-') {
                            $tempatLahir = $tTempat;
                        }
                        if (isset($ttlParts[1])) {
                            $tTgl = trim($ttlParts[1]);
                            if (!empty($tTgl) && $tTgl !== '-') {
                                $tanggalLahir = $this->parseIndonesianDate($tTgl);
                            }
                        }
                    }

                    // Provinsi
                    preg_match('/<span[^>]*class=["\'][^"\']*gd-detail-label[^"\']*["\'][^>]*>Provinsi<\/span>\s*<span[^>]*class=["\'][^"\']*gd-detail-value[^"\']*["\'][^>]*>(.*?)<\/span>/si', $html, $provM);
                    $provVal = trim(strip_tags($provM[1] ?? ''));
                    if (!empty($provVal) && $provVal !== '-') {
                        $provinsi = $provVal;
                    }

                    // Detail Photo
                    preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*class=["\'][^"\']*gd-photo/si', $html, $dpm);
                    if (!empty($dpm[1])) {
                        $photoUrl = $dpm[1];
                    }
                }

                if (empty($name)) {
                    continue;
                }

                // Cek apakah member sudah ada di database
                $exists = false;
                if (!empty($noAnggota)) {
                    $exists = User::where('no_anggota', $noAnggota)->exists();
                }
                if (!$exists) {
                    $exists = User::where('name', $name)->where('role', 'grcs')->exists();
                }

                if ($exists) {
                    $this->line(" [SKIP] Anggota GRCS sudah ada: {$name}");
                    continue;
                }

                // Download avatar
                $avatarPath = $this->downloadMedia($photoUrl, 'avatars');

                // Generate no_anggota fallback jika kosong
                if (empty($noAnggota)) {
                    $noAnggota = '369.51.' . date('dmy') . '.' . str_pad($id, 3, '0', STR_PAD_LEFT);
                }

                // Generate email unik
                $email = 'grcs_' . $id . '@denpasarinstitute.id';
                if (User::where('email', $email)->exists()) {
                    $email = 'grcs_' . $id . '_' . time() . '@denpasarinstitute.id';
                }

                User::create([
                    'name'            => $name,
                    'email'           => $email,
                    'password'        => bcrypt('password123'),
                    'role'            => 'grcs',
                    'is_active'       => true,
                    'no_anggota'      => $noAnggota,
                    'membership_type' => $membershipType,
                    'institution'     => $institution,
                    'position'        => $position,
                    'tempat_lahir'    => $tempatLahir,
                    'tanggal_lahir'   => $tanggalLahir,
                    'provinsi'        => $provinsi,
                    'avatar'          => $avatarPath,
                    'member_since'    => now(),
                ]);

                $this->info(" [OK] Berhasil import GRCS: {$name} ({$noAnggota})");
            } catch (\Exception $e) {
                $this->error(" Gagal import GRCS ID {$id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Download file gambar dan simpan ke folder storage lokal
     */
    protected function downloadMedia(?string $url, string $subfolder): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (!str_starts_with($url, 'http')) {
            $url = ltrim($url, '/');
            $url = $this->baseUrl . '/' . $url;
        }

        $filename = basename(parse_url($url, PHP_URL_PATH));
        if (empty($filename)) {
            return null;
        }

        $destinationDir = storage_path("app/public/{$subfolder}");
        File::ensureDirectoryExists($destinationDir);
        $destinationPath = $destinationDir . '/' . $filename;

        // Jika sudah ada di disk lokal, tidak perlu download ulang
        if (File::exists($destinationPath) && filesize($destinationPath) > 0) {
            return "{$subfolder}/{$filename}";
        }

        try {
            $response = Http::timeout(25)
                ->withHeaders(['User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)'])
                ->get($url);

            if ($response->successful()) {
                File::put($destinationPath, $response->body());
                return "{$subfolder}/{$filename}";
            }
        } catch (\Exception $e) {
            $this->warn("   Gagal mengunduh gambar {$url}: " . $e->getMessage());
        }

        return null;
    }

    /**
     * Helper parsing format tanggal Indonesia / Inggris
     */
    protected function parseIndonesianDate(?string $dateStr): Carbon
    {
        if (empty($dateStr)) {
            return now();
        }

        $idMonths = [
            'Januari'   => 'January',
            'Februari'  => 'February',
            'Maret'     => 'March',
            'April'     => 'April',
            'Mei'       => 'May',
            'Juni'      => 'June',
            'Juli'      => 'July',
            'Agustus'   => 'August',
            'September' => 'September',
            'Oktober'   => 'October',
            'November'  => 'November',
            'Desember'  => 'December',
        ];

        $cleaned = str_ireplace(array_keys($idMonths), array_values($idMonths), trim($dateStr));
        try {
            return Carbon::parse($cleaned);
        } catch (\Exception $e) {
            return now();
        }
    }
}
