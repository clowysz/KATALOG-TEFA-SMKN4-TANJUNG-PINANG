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
        // Kalau user belum login,
        // arahkan ke satu halaman login bersama.
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Ambil data user yang sedang login.
        $user = Auth::user();

        // Cek apakah role user sesuai dengan role
        // yang diizinkan oleh route.
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Kalau sudah login tetapi role-nya tidak sesuai,
        // tampilkan 403.
        abort(403, 'Unauthorized action. Kamu tidak punya hak akses ke halaman ini.');
    }
}