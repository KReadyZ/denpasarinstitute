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
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required|confirmed|min:8',
            'role'         => 'required|in:konsultan,grcs',
            'phone'        => 'nullable|string|max:20',
            'institution'  => 'nullable|string|max:255',
            'position'     => 'nullable|string|max:255',
        ]);

        User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'role'          => $validated['role'],
            'phone'         => $validated['phone'] ?? null,
            'institution'   => $validated['institution'] ?? null,
            'position'      => $validated['position'] ?? null,
            'is_active'     => false, // Perlu aktivasi admin
            'member_since'  => now(),
            'membership_type' => 'regular',
        ]);

        return redirect()->route('backoffice.login')
            ->with('success', 'Pendaftaran berhasil! Silakan tunggu aktivasi dari admin.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('backoffice.login');
    }
}