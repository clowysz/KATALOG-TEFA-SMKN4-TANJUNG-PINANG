<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthForgotPasswordController extends Controller
{
    // Menampilkan halaman lupa sandi
    public function showForgotForm()
    {
        return view('auth.lupa-sandi');
    }

    // Memproses email yang dimasukkan
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'pembeli')
            ->first();

        // Jika email tidak ditemukan
        if (!$user) {
            return back()->with(
                'status',
                'Jika email terdaftar sebagai akun pelanggan, proses reset sandi akan dilanjutkan.'
            );
        }

        // Membuat token reset
        $token = Str::random(64);

        // Menyimpan token
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );

        // Untuk sementara, tampilkan link reset untuk pengujian
       return redirect()->route('password.reset', ['token' => $token]);
    }

    // Menampilkan halaman reset sandi
   public function showResetForm(string $token)
{
    $resetData = DB::table('password_reset_tokens')
        ->where('token', hash('sha256', $token))
        ->first();

    if (!$resetData) {
        return redirect()
            ->route('password.request')
            ->withErrors([
                'email' => 'Link reset sandi tidak valid atau sudah digunakan.'
            ]);
    }

    return view('auth.reset-sandi', [
        'token' => $token,
        'email' => $resetData->email,
    ]);
}

    // Memproses password baru
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetData) {
            return back()->withErrors([
                'email' => 'Link reset sandi tidak valid atau sudah tidak tersedia.'
            ]);
        }

        // Cek token
        if (!hash_equals(
            $resetData->token,
            hash('sha256', $request->token)
        )) {
            return back()->withErrors([
                'email' => 'Token reset sandi tidak valid.'
            ]);
        }

        // Cari akun pembeli
        $user = User::where('email', $request->email)
            ->where('role', 'pembeli')
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun pelanggan tidak ditemukan.'
            ]);
        }

        // Ubah password
        $user->password = Hash::make($request->password);
        $user->save();

        // Hapus token setelah digunakan
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}