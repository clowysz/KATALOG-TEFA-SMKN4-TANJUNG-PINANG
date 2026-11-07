<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthPembeliController extends Controller
{
    public function showRegister(Request $request)
    {
        $redirect = $request->query('redirect');
        $back = $request->query('back');

        return view('public.daftar', compact('redirect', 'back'));
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
}