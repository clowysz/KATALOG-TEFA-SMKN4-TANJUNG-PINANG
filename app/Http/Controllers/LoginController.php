<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin(Request $request)
    {
        $redirect = $request->query('redirect');
        $back = $request->query('back');

        return view('public.login', compact('redirect', 'back'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

          // PEMBELI
        if ($user->role === 'pembeli') {
        $redirect = $request->input('redirect');

       if ($redirect && str_starts_with($redirect, '/')) {
       return redirect($redirect);
       }

    return redirect()->route('profil.pembeli');
}
            // ADMIN TEFA
            if ($user->role === 'admin_tefa') {
                return redirect('/dashboard');
            }

            // ADMIN JURUSAN
            if ($user->role === 'admin_jurusan') {
                return redirect('/jurusan-admin/dashboard');
            }

            // ADMIN PRODUSER
            if ($user->role === 'admin_produser') {
                return redirect('/produser/dashboard');
            }

            // Role tidak dikenali
            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'Role akun tidak dikenali.'
                ])
                ->onlyInput('email');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.'
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
    }
}