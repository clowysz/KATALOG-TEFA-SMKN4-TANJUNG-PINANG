<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/admin/login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        $user = Auth::user();

        // Cek apakah role user yang login ada di dalam daftar izin middleware
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Kalau tidak punya hak akses, tendang ke halaman dashboard masing-masing atau abort 403
        abort(403, 'Unauthorized action. Kamu tidak punya hak akses ke halaman ini.');
    }
}