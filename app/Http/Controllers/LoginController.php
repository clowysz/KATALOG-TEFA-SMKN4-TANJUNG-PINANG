<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showAdminLogin()
    {
        return view('admin.login.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['status'] = 'aktif';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin_tefa') {
                return redirect('/dashboard');
            }

            if ($user->role === 'admin_jurusan') {
                return redirect('/jurusan-admin/dashboard');
            }

            if ($user->role === 'admin_produser') {
                return redirect('/produser/dashboard');
            }

            Auth::logout();

            return back()
                ->withErrors(['email' => 'Role akun tidak dikenali.'])
                ->onlyInput('email');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}