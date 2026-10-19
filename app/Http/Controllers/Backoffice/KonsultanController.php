<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class KonsultanController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'konsultan');

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

        $konsultans = $query->orderBy('created_at', 'desc')->paginate(10);

        $totalActive = User::where('role', 'konsultan')->where('is_active', true)->count();
        $totalInactive = User::where('role', 'konsultan')->where('is_active', false)->count();
        $totalPending = User::where('role', 'konsultan')->where(function($q) {
            $q->where('verification_status', 'pending')
              ->orWhere(function($sub) {
                  $sub->where('is_active', false)->whereNull('verification_status');
              });
        })->count();
        $totalPremium = User::where('role', 'konsultan')->where('membership_type', 'premium')->count();
        $totalVip = User::where('role', 'konsultan')->where('membership_type', 'vip')->count();

        return view('backoffice.konsultan.index', compact('konsultans', 'totalActive', 'totalInactive', 'totalPending', 'totalPremium', 'totalVip'));
    }

    public function create()
    {
        return view('backoffice.konsultan.create');
    }

    private function rules($konsultanId = null): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => $konsultanId
                ? ['required', 'email', Rule::unique('users')->ignore($konsultanId)]
                : 'required|email|unique:users,email',
            'password' => $konsultanId ? 'nullable|string|min:8' : 'required|string|min:8',
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

            'pendidikan_terakhir' => 'nullable|string|max:255',
            'bidang_ilmu' => 'nullable|string|max:255',
            'praktisi_bidang' => 'nullable|string|max:255',
            'keahlian_utama' => 'nullable|string|max:255',
            'keahlian_penunjang' => 'nullable|string|max:255',
            'minat_riset_bidang' => 'nullable|string',
            'minat_pengabdian_bidang' => 'nullable|string',
            'profil' => 'nullable|string',
            'expertise' => 'nullable|string',
            'education' => 'nullable|string',
            'certifications' => 'nullable|string',
            'publications' => 'nullable|string',

            'orcid_id' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'google_scholar_id' => 'nullable|string|max:255',
            'publon_id' => 'nullable|string|max:255',
            'garuda_id' => 'nullable|string|max:255',
            'researcher_id' => 'nullable|string|max:255',

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
        $validated['role'] = 'konsultan';
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

        $arrayFields = ['expertise', 'education', 'certifications', 'publications'];
        foreach ($arrayFields as $field) {
            if (isset($validated[$field]) && is_string($validated[$field]) && !empty($validated[$field])) {
                $arrayValue = array_map('trim', explode(',', $validated[$field]));
                $validated[$field] = json_encode($arrayValue);
            } elseif (isset($validated[$field])) {
                $validated[$field] = null;
            }
        }

        User::create($validated);

        return redirect()->route('backoffice.konsultan.index')
            ->with('success', 'Anggota Konsultan berhasil ditambahkan');
    }

    public function show($id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        $arrayFields = ['expertise', 'education', 'certifications', 'publications'];
        foreach ($arrayFields as $field) {
            if ($konsultan->$field && is_string($konsultan->$field)) {
                $decoded = json_decode($konsultan->$field, true);
                $konsultan->{$field . '_display'} = is_array($decoded) ? implode(', ', $decoded) : '';
            } elseif ($konsultan->$field && is_array($konsultan->$field)) {
                $konsultan->{$field . '_display'} = implode(', ', $konsultan->$field);
            } else {
                $konsultan->{$field . '_display'} = '';
            }
        }

        return view('backoffice.konsultan.show', compact('konsultan'));
    }

    public function edit($id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        $arrayFields = ['expertise', 'education', 'certifications', 'publications'];
        foreach ($arrayFields as $field) {
            if ($konsultan->$field && is_string($konsultan->$field)) {
                $arrayValue = json_decode($konsultan->$field, true);
                $konsultan->$field = is_array($arrayValue) ? implode(', ', $arrayValue) : '';
            } elseif ($konsultan->$field && is_array($konsultan->$field)) {
                $konsultan->$field = implode(', ', $konsultan->$field);
            }
        }

        return view('backoffice.konsultan.edit', compact('konsultan'));
    }

    public function update(Request $request, $id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        $validated = $request->validate($this->rules($konsultan->id));

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($konsultan->avatar) {
                Storage::disk('public')->delete($konsultan->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->hasFile('foto')) {
            if ($konsultan->foto) {
                Storage::disk('public')->delete($konsultan->foto);
            }
            $validated['foto'] = $request->file('foto')->store('foto-anggota', 'public');
        }
        if ($request->hasFile('background')) {
            if ($konsultan->background) {
                Storage::disk('public')->delete($konsultan->background);
            }
            $validated['background'] = $request->file('background')->store('background-anggota', 'public');
        }

        $arrayFields = ['expertise', 'education', 'certifications', 'publications'];
        foreach ($arrayFields as $field) {
            if (isset($validated[$field]) && is_string($validated[$field]) && !empty($validated[$field])) {
                $arrayValue = array_map('trim', explode(',', $validated[$field]));
                $validated[$field] = json_encode($arrayValue);
            } elseif (isset($validated[$field])) {
                $validated[$field] = null;
            }
        }

        $validated['is_active'] = $request->boolean('is_active', false);

        $tanggalLahirBerbeda = false;
        if (!empty($validated['tanggal_lahir'])) {
            $tanggalLahirSekarang = optional($konsultan->tanggal_lahir)->format('Y-m-d') ?? '';
            $tanggalLahirBaru = isset($validated['tanggal_lahir']) ? (is_string($validated['tanggal_lahir']) ? $validated['tanggal_lahir'] : Carbon::parse($validated['tanggal_lahir'])->format('Y-m-d')) : '';
            $tanggalLahirBerbeda = $tanggalLahirSekarang !== $tanggalLahirBaru;
        }

        if ((empty($konsultan->no_anggota) || $tanggalLahirBerbeda) && !empty($validated['tanggal_lahir'])) {
            $validated['no_anggota'] = User::generateNoAnggota(
                'konsultan',
                $validated['tanggal_lahir'],
                $validated['kode_provinsi'] ?? '51'
            );
        }

        if (!empty($validated['tanggal_lahir']) && empty($validated['berlaku_sd'])) {
            $validated['berlaku_sd'] = Carbon::parse($validated['tanggal_lahir'])->addYear();
        }

        $konsultan->update($validated);

        return redirect()->route('backoffice.konsultan.index')
            ->with('success', 'Data Konsultan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        if ($konsultan->avatar) {
            Storage::disk('public')->delete($konsultan->avatar);
        }
        if ($konsultan->foto) {
            Storage::disk('public')->delete($konsultan->foto);
        }
        if ($konsultan->background) {
            Storage::disk('public')->delete($konsultan->background);
        }
        if ($konsultan->kartu_path) {
            Storage::disk('public')->delete($konsultan->kartu_path);
        }

        $konsultanName = $konsultan->name;
        $konsultan->delete();

        return redirect()->route('backoffice.konsultan.index')
            ->with('success', "Konsultan {$konsultanName} berhasil dihapus");
    }

    public function toggleActive($id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);
        $konsultan->is_active = !$konsultan->is_active;
        $konsultan->save();

        $status = $konsultan->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->back()
            ->with('success', "Akun {$konsultan->name} berhasil {$status}");
    }

    public function verifikasiIndex()
    {
        $pendingKonsultans = User::where('role', 'konsultan')
            ->where(function($q) {
                $q->where('verification_status', 'pending')
                  ->orWhere(function($sub) {
                      $sub->where('is_active', false)->whereNull('verification_status');
                  });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('backoffice.konsultan.verifikasi', compact('pendingKonsultans'));
    }

    public function verifikasiShow($id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        $arrayFields = ['expertise', 'education', 'certifications', 'publications'];
        foreach ($arrayFields as $field) {
            if ($konsultan->$field && is_string($konsultan->$field)) {
                $decoded = json_decode($konsultan->$field, true);
                $konsultan->{$field . '_display'} = is_array($decoded) ? implode(', ', $decoded) : '';
            } elseif ($konsultan->$field && is_array($konsultan->$field)) {
                $konsultan->{$field . '_display'} = implode(', ', $konsultan->$field);
            } else {
                $konsultan->{$field . '_display'} = '';
            }
        }

        return view('backoffice.konsultan.verifikasi-show', compact('konsultan'));
    }

    public function approve(Request $request, $id)
    {
        $konsultan = User::where('role', 'konsultan')->findOrFail($id);

        if (empty($konsultan->no_anggota)) {
            $konsultan->no_anggota = User::generateNoAnggota(
                'konsultan',
                $konsultan->tanggal_lahir,
                $konsultan->kode_provinsi ?? '51'
            );
        }

        if (empty($konsultan->berlaku_sd)) {
            $konsultan->berlaku_sd = now()->addYear();
        }

        $konsultan->is_active = true;
        $konsultan->verification_status = 'approved';
        $konsultan->verified_at = now();
        $konsultan->verified_by = \Illuminate\Support\Facades\Auth::id();
        $konsultan->rejection_reason = null;
        $konsultan->save();

        return redirect()->route('backoffice.konsultan.index')
            ->with('success', "Akun Konsultan {$konsultan->name} berhasil diverifikasi & diaktifkan! Nomor Anggota: {$konsultan->no_anggota}");
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $konsultan = User::where('role', 'konsultan')->findOrFail($id);
        $konsultan->is_active = false;
        $konsultan->verification_status = 'rejected';
        $konsultan->verified_at = now();
        $konsultan->verified_by = \Illuminate\Support\Facades\Auth::id();
        $konsultan->rejection_reason = $request->rejection_reason;
        $konsultan->save();

        return redirect()->route('backoffice.konsultan.index')
            ->with('success', "Pendaftaran Konsultan {$konsultan->name} telah ditolak.");
    }
}