<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AuthForgotPasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('auth.lupa-sandi');
    }


    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'pembeli')
            ->first();


        if (!$user) {
            return back()->with(
                'status',
                'Jika email terdaftar sebagai akun pelanggan, proses reset sandi akan dilanjutkan.'
            );
        }


        $token = Str::random(64);


        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => hash('sha256', $token),
                'created_at' => now(),
            ]
        );


       return redirect()->route('password.reset', ['token' => $token]);
    }


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


        if (!hash_equals(
            $resetData->token,
            hash('sha256', $request->token)
        )) {
            return back()->withErrors([
                'email' => 'Token reset sandi tidak valid.'
            ]);
        }


        $user = User::where('email', $request->email)
            ->where('role', 'pembeli')
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Akun pelanggan tidak ditemukan.'
            ]);
        }


        $user->password = Hash::make($request->password);
        $user->save();


        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}