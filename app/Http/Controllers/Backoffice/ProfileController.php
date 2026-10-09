<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        foreach (['expertise', 'education', 'certifications', 'publications'] as $field) {
            if ($user->$field && is_string($user->$field)) {
                $arrayValue = json_decode($user->$field, true);
                $user->$field = is_array($arrayValue) ? implode(', ', $arrayValue) : '';
            } elseif (is_array($user->$field)) {
                $user->$field = implode(', ', $user->$field);
            }
        }

        return view('backoffice.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'nip_nim' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'background' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'position' => 'nullable|string|max:255',
            'institution' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:2000',

            // Data Pribadi (kartu anggota)
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'kode_provinsi' => 'nullable|string|max:2',
            'provinsi' => 'nullable|string|max:255',
            'motto_hidup' => 'nullable|string|max:255',

            // Akademik
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

            // ID Akademik
            'orcid_id' => 'nullable|string|max:255',
            'scopus_id' => 'nullable|string|max:255',
            'sinta_id' => 'nullable|string|max:255',
            'google_scholar_id' => 'nullable|string|max:255',
            'publon_id' => 'nullable|string|max:255',
            'garuda_id' => 'nullable|string|max:255',
            'researcher_id' => 'nullable|string|max:255',

            // Media Sosial
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|string|max:255',
            'youtube' => 'nullable|url|max:255',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Handle upload gambar
        if ($request->hasFile('avatar')) {
            if ($user->avatar) Storage::disk('public')->delete($user->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }
        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $validated['foto'] = $request->file('foto')->store('foto-anggota', 'public');
        }
        if ($request->hasFile('background')) {
            if ($user->background) Storage::disk('public')->delete($user->background);
            $validated['background'] = $request->file('background')->store('background-anggota', 'public');
        }

        // Convert comma separated text -> JSON array
        foreach (['expertise', 'education', 'certifications', 'publications'] as $field) {
            if (isset($validated[$field]) && is_string($validated[$field]) && !empty($validated[$field])) {
                $validated[$field] = json_encode(array_map('trim', explode(',', $validated[$field])));
            } elseif (isset($validated[$field])) {
                $validated[$field] = null;
            }
        }

        // Generate no_anggota otomatis kalau belum ada & tanggal_lahir baru diisi
        if (empty($user->no_anggota) && !empty($validated['tanggal_lahir']) && in_array($user->role, ['konsultan', 'grcs'])) {
            $validated['no_anggota'] = User::generateNoAnggota(
                $user->role,
                $validated['tanggal_lahir'],
                $validated['kode_provinsi'] ?? '51'
            );
        }

        // Set profile completion timestamp (sekali saja)
        if (!$user->profile_completed_at) {
            $validated['profile_completed_at'] = now();
        }

        $user->update($validated);

        return redirect()->route('backoffice.profile.edit')
            ->with('success', 'Profil berhasil diperbarui! 🎉');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        foreach (['expertise', 'education', 'certifications', 'publications'] as $field) {
            if ($user->$field && is_string($user->$field)) {
                $decoded = json_decode($user->$field, true);
                $user->{$field . '_display'} = is_array($decoded) ? implode(', ', $decoded) : '';
            } elseif (is_array($user->$field)) {
                $user->{$field . '_display'} = implode(', ', $user->$field);
            } else {
                $user->{$field . '_display'} = '';
            }
        }

        return view('backoffice.profile.show', compact('user'));
    }

    /**
     * Generate nomor anggota + tanggal "berlaku s.d" pertama kali untuk
     * kartu anggota digital. Hanya berjalan jika user belum punya
     * no_anggota, sudah mengisi tanggal_lahir, dan rolenya konsultan/grcs.
     */
    public function generateEcard($id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Hanya admin yang dapat menerbitkan kartu anggota.');
        }

        if (!empty($user->no_anggota)) {
            return redirect()->back()->with('info', 'Anda sudah memiliki kartu anggota.');
        }

        if (empty($user->tanggal_lahir)) {
            return redirect()->back()->with('error', 'Lengkapi Tanggal Lahir pada profil Anda sebelum menerbitkan kartu.');
        }

        if (!in_array($user->role, ['konsultan', 'grcs'])) {
            return redirect()->back()->with('error', 'Kartu anggota hanya berlaku untuk role Konsultan/GRCS.');
        }

        $user->no_anggota = User::generateNoAnggota(
            $user->role,
            $user->tanggal_lahir,
            $user->kode_provinsi ?? '51'
        );
        $user->member_since = $user->member_since ?? now();
        $user->berlaku_sd = now()->addYear();
        $user->save();

        return redirect()->back()->with('success', 'Kartu anggota berhasil diterbitkan! 🎉');
    }

    /**
     * Perpanjang masa berlaku kartu: mulai hari ini, berakhir 1 tahun
     * ke depan.
     */
    public function renewEcard($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() != $id && Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        if (empty($user->no_anggota)) {
            return redirect()->back()->with('error', 'Anda belum memiliki kartu anggota untuk diperpanjang.');
        }

        $user->berlaku_sd = now()->addYear();
        $user->save();

        return redirect()->back()->with('success', 'Masa berlaku kartu berhasil diperpanjang hingga ' . $user->berlaku_sd->format('d-m-Y') . ' ✅');
    }
}