<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthPembeliController extends Controller
{
    /**
     * Menampilkan halaman daftar akun pembeli.
     */
    public function showRegister(Request $request)
    {
        $redirect = $request->query('redirect');
        $back = $request->query('back');

        return view('public.daftar', compact('redirect', 'back'));
    }

    /**
     * Memproses pendaftaran akun pembeli.
     */
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

        // Langsung login setelah berhasil daftar
        Auth::login($user);

        // Ambil tujuan setelah berhasil daftar
        $redirect = $request->input('redirect');

        // Hanya izinkan redirect ke URL internal aplikasi
        if ($redirect && str_starts_with($redirect, '/')) {
            return redirect($redirect);
        }

        // Jika tidak ada tujuan khusus, kembali ke halaman utama
        return redirect('/');
    }
}