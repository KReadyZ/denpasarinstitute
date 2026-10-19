<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('backoffice.dashboard');
        return view('backoffice.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('backoffice.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('backoffice.auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'nullable|string|min:8|confirmed',
            'role'             => 'required|in:konsultan,grcs',
            'phone'            => 'nullable|string|max:30',
            'tanggal_lahir'    => 'nullable|date',
            'address'          => 'nullable|string',
            'provinsi'         => 'nullable|string|max:100',
            'institution'      => 'nullable|string|max:255',
            'position'         => 'nullable|string|max:255',
            'foto'             => 'nullable|image|max:4096',
            'cv_file'          => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
            'bukti_kontribusi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:4096',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('users/foto', 'public');
        }

        $cvPath = null;
        if ($request->hasFile('cv_file')) {
            $cvPath = $request->file('cv_file')->store('users/cv', 'public');
        }

        $buktiPath = null;
        if ($request->hasFile('bukti_kontribusi')) {
            $buktiPath = $request->file('bukti_kontribusi')->store('users/bukti', 'public');
        }

        $password = !empty($validated['password'])
            ? Hash::make($validated['password'])
            : Hash::make(\Illuminate\Support\Str::random(12));

        User::create([
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'password'         => $password,
            'role'             => $validated['role'],
            'phone'            => $validated['phone'] ?? null,
            'tanggal_lahir'    => $validated['tanggal_lahir'] ?? null,
            'address'          => $validated['address'] ?? null,
            'provinsi'         => $validated['provinsi'] ?? null,
            'institution'      => $validated['institution'] ?? null,
            'position'         => $validated['position'] ?? null,
            'foto'             => $fotoPath,
            'cv_path'          => $cvPath,
            'bukti_kontribusi' => $buktiPath,
            'is_active'        => false, // Perlu aktivasi admin
            'member_since'     => now(),
            'membership_type'  => 'regular',
        ]);

        return redirect()->back()
            ->with('register_success', 'Pendaftaran berhasil dikirim! Data Anda akan diverifikasi dalam waktu maksimal 2 x 24 jam. Akun dan kartu tanda anggota akan dikirimkan melalui email.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('backoffice.login');
    }
}