<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Mail\PendaftaranVerifiedMail;
use App\Mail\PendaftaranRejectedMail;

class GrcsController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'grcs');

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'pending') {
                $query->where(function($q) {
                    $q->where('verification_status', 'pending')
                      ->orWhere(function($sub) {
                          $sub->where('is_active', false)->whereNull('verification_status');
                      });
                });
            } elseif ($request->status === 'rejected') {
                $query->where('verification_status', 'rejected');
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('institution', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('no_anggota', 'like', "%{$search}%");
            });
        }

        $grcsMembers = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalActive = User::where('role', 'grcs')->where('is_active', true)->count();
        $totalInactive = User::where('role', 'grcs')->where('is_active', false)->count();
        $totalPending = User::where('role', 'grcs')->where(function($q) {
            $q->where('verification_status', 'pending')
              ->orWhere(function($sub) {
                  $sub->where('is_active', false)->whereNull('verification_status');
              });
        })->count();
        $totalPremium = User::where('role', 'grcs')->where('membership_type', 'premium')->count();
        $totalVip = User::where('role', 'grcs')->where('membership_type', 'vip')->count();

        return view('backoffice.grcs.index', compact('grcsMembers', 'totalActive', 'totalInactive', 'totalPending', 'totalPremium', 'totalVip'));
    }

    public function create()
    {
        return view('backoffice.grcs.create');
    }

    private function rules($grcsId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => $grcsId
                ? ['required', 'email', Rule::unique('users')->ignore($grcsId)]
                : 'required|email|unique:users,email',
            'password' => $grcsId ? 'nullable|string|min:8' : 'required|string|min:8',
            'nip_nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'position' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',

            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kode_provinsi' => 'nullable|string|max:2',
            'provinsi' => 'nullable|string|max:255',
            'motto_hidup' => 'nullable|string|max:255',

            'orcid_id' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'google_scholar_id' => 'nullable|string|max:255',

            'website' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|string|max:255',
            'youtube' => 'nullable|url|max:255',

            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'background' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',

            'membership_type' => 'required|in:regular,premium,vip',
            'is_active' => 'boolean',
            'berlaku_sd' => 'nullable|date',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'grcs';
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['member_since'] = now();

        if (!empty($validated['tanggal_lahir']) && empty($validated['berlaku_sd'])) {
            $validated['berlaku_sd'] = Carbon::parse($validated['tanggal_lahir'])->addYear();
        }

        if ($request->hasFile('avatar')) {
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('foto-anggota', 'public');
        }
        if ($request->hasFile('background')) {
            $validated['background'] = $request->file('background')->store('background-anggota', 'public');
        }

        User::create($validated);

        return redirect()->route('backoffice.grcs.index')
            ->with('success', 'Anggota GRCS Club berhasil ditambahkan');
    }

    public function show($id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);
        return view('backoffice.grcs.show', compact('grcsMember'));
    }

    public function edit($id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);
        return view('backoffice.grcs.edit', compact('grcsMember'));
    }

    public function update(Request $request, $id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);

        $validated = $request->validate($this->rules($grcsMember->id));

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($grcsMember->avatar) {
                Storage::disk('public')->delete($grcsMember->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->hasFile('foto')) {
            if ($grcsMember->foto) {
                Storage::disk('public')->delete($grcsMember->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-anggota', 'public');
        }
        if ($request->hasFile('background')) {
            if ($grcsMember->background) {
                Storage::disk('public')->delete($grcsMember->background);
            }
            $validated['background'] = $request->file('background')->store('background-anggota', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active', false);

        $tanggalLahirBerbeda = false;
        if (!empty($validated['tanggal_lahir'])) {
            $tanggalLahirSekarang = $grcsMember->tanggal_lahir ? Carbon::parse($grcsMember->tanggal_lahir)->format('Y-m-d') : '';
            $tanggalLahirBaru = is_string($validated['tanggal_lahir']) ? $validated['tanggal_lahir'] : Carbon::parse($validated['tanggal_lahir'])->format('Y-m-d');
            $tanggalLahirBerbeda = $tanggalLahirSekarang !== $tanggalLahirBaru;
        }

        if ((empty($grcsMember->no_anggota) || $tanggalLahirBerbeda) && !empty($validated['tanggal_lahir'])) {
            $validated['no_anggota'] = User::generateNoAnggota(
                'grcs',
                $validated['tanggal_lahir'],
                $validated['kode_provinsi'] ?? '51'
            );
        }

        if (!empty($validated['tanggal_lahir']) && empty($validated['berlaku_sd'])) {
            $validated['berlaku_sd'] = Carbon::parse($validated['tanggal_lahir'])->addYear();
        }

        $grcsMember->update($validated);

        return redirect()->route('backoffice.grcs.index')
            ->with('success', 'Data GRCS Club berhasil diperbarui');
    }

    public function destroy($id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);

        if ($grcsMember->avatar) {
            Storage::disk('public')->delete($grcsMember->avatar);
        }
        if ($grcsMember->foto) {
            Storage::disk('public')->delete($grcsMember->foto);
        }
        if ($grcsMember->background) {
            Storage::disk('public')->delete($grcsMember->background);
        }
        if ($grcsMember->kartu_path) {
            Storage::disk('public')->delete($grcsMember->kartu_path);
        }

        $memberName = $grcsMember->name;
        $grcsMember->delete();

        return redirect()->route('backoffice.grcs.index')
            ->with('success', "Anggota GRCS Club {$memberName} berhasil dihapus");
    }

    public function toggleActive($id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);
        $grcsMember->is_active = !$grcsMember->is_active;
        $grcsMember->save();

        $status = $grcsMember->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Akun {$grcsMember->name} berhasil {$status}");
    }

    public function verifikasiIndex()
    {
        $pendingMembers = User::where('role', 'grcs')
            ->where(function($q) {
                $q->where('verification_status', 'pending')
                  ->orWhere(function($sub) {
                      $sub->where('is_active', false)->whereNull('verification_status');
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backoffice.grcs.verifikasi', compact('pendingMembers'));
    }

    public function verifikasiShow($id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);

        return view('backoffice.grcs.verifikasi-show', compact('grcsMember'));
    }

    public function approve(Request $request, $id)
    {
        $grcsMember = User::where('role', 'grcs')->findOrFail($id);

        if (empty($grcsMember->no_anggota)) {
            $grcsMember->no_anggota = User::generateNoAnggota(
                'grcs',
                $grcsMember->tanggal_lahir,
                $grcsMember->kode_provinsi ?? '51'
            );
        }

        if (empty($grcsMember->berlaku_sd)) {
            $grcsMember->berlaku_sd = now()->addYear();
        }

        $grcsMember->is_active = true;
        $grcsMember->verification_status = 'approved';
        $grcsMember->verified_at = now();
        $grcsMember->verified_by = \Illuminate\Support\Facades\Auth::id();
        $grcsMember->rejection_reason = null;
        $grcsMember->save();

        // Kirim email konfirmasi verifikasi ke anggota GRCS
        $emailSent = false;
        try {
            if (!empty($grcsMember->email)) {
                Mail::to($grcsMember->email)->send(new PendaftaranVerifiedMail($grcsMember));
                $emailSent = true;
            }
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim email verifikasi GRCS ID {$grcsMember->id}: " . $e->getMessage());
        }

        $msg = "Akun Anggota GRCS Club {$grcsMember->name} berhasil diverifikasi & diaktifkan! Nomor Anggota: {$grcsMember->no_anggota}.";
        if ($emailSent) {
            $msg .= " Email konfirmasi resmi telah dikirim ke {$grcsMember->email}.";
        }

        return redirect()->route('backoffice.grcs.index')
            ->with('success', $msg);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $grcsMember = User::where('role', 'grcs')->findOrFail($id);
        $grcsMember->is_active = false;
        $grcsMember->verification_status = 'rejected';
        $grcsMember->verified_at = now();
        $grcsMember->verified_by = \Illuminate\Support\Facades\Auth::id();
        $grcsMember->rejection_reason = $request->rejection_reason;
        $grcsMember->save();

        // Kirim email pemberitahuan penolakan ke anggota GRCS
        $emailSent = false;
        try {
            if (!empty($grcsMember->email)) {
                Mail::to($grcsMember->email)->send(new PendaftaranRejectedMail($grcsMember, $request->rejection_reason));
                $emailSent = true;
            }
        } catch (\Throwable $e) {
            Log::error("Gagal mengirim email penolakan GRCS ID {$grcsMember->id}: " . $e->getMessage());
        }

        $msg = "Pendaftaran Anggota GRCS Club {$grcsMember->name} telah ditolak.";
        if ($emailSent) {
            $msg .= " Pemberitahuan telah dikirim ke {$grcsMember->email}.";
        }

        return redirect()->route('backoffice.grcs.index')
            ->with('success', $msg);
    }
}