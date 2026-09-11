<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // =========================
    // TAMPILKAN HALAMAN LOGIN ADMIN
    // =========================
    public function showAdminLogin()
    {
        return view('admin.login.login');
    }

    // =========================
    // PROSES LOGIN ADMIN
    // =========================
    public function adminLogin(Request $request)
    {
        // Validasi email dan password
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cek email dan password ke tabel users
        if (Auth::attempt($credentials)) {

            // Regenerasi session setelah berhasil login
            $request->session()->regenerate();

            // Ambil data user yang sedang login
            $user = Auth::user();

            // =========================
            // ADMIN TEFA
            // =========================
            if ($user->role === 'admin_tefa') {
                return redirect('/dashboard');
            }

            // =========================
            // ADMIN JURUSAN
            // =========================
            if ($user->role === 'admin_jurusan') {
                return redirect('/jurusan-admin/dashboard');
            }

            // =========================
            // ADMIN PRODUSER
            // =========================
            if ($user->role === 'admin_produser') {
                return redirect('/produser/dashboard');
            }

            // =========================
            // ROLE TIDAK DIKENALI
            // =========================
            Auth::logout();

            return back()->withErrors([
                'email' => 'Role akun tidak dikenali.',
            ])->onlyInput('email');
        }

        // =========================
        // EMAIL / PASSWORD SALAH
        // =========================
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}

