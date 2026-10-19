<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackofficeMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('backoffice.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        if (!$user->is_active) {
            $msg = $user->verification_status === 'pending'
                ? 'Akun Anda sedang dalam proses verifikasi oleh Super Admin. Mohon menunggu.'
                : ($user->verification_status === 'rejected'
                    ? 'Pendaftaran akun Anda ditolak. Silakan hubungi administrator.'
                    : 'Akun Anda belum aktif. Hubungi administrator.');

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('backoffice.login')->with('error', $msg);
        }

        if (!empty($roles) && !in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}