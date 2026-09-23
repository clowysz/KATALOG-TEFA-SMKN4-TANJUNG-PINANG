<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthPembeliController extends Controller
{
    public function showLogin(Request $request)
    {
        $redirect = $request->query('redirect');

        return view('public.login', compact('redirect'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'pembeli') {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun ini bukan akun pembeli.'
                ]);
            }

            $redirect = $request->input('redirect');

            if ($redirect && str_starts_with($redirect, '/')) {
                return redirect($redirect);
            }

            return redirect()->intended('/');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah.'
            ])
            ->onlyInput('email');
    }

    public function showRegister(Request $request)
{
    $redirect = $request->query('redirect');

    return view('public.daftar', compact('redirect'));
}
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'nomor_hp' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nomor_hp' => $request->nomor_hp,
            'role' => 'pembeli',
        ]);

      Auth::login($user);

$redirect = $request->input('redirect');

if ($redirect && str_starts_with($redirect, '/')) {
    return redirect($redirect);
}

return redirect('/');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}