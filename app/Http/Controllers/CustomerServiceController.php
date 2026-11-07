<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    public function index()
    {
        // Belum login
        if (!Auth::check()) {
            return redirect()->route('login', [
                'redirect' => '/customer-service',
                'back' => url()->previous(),
            ]);
        }

        // Akun yang sudah punya pesanan langsung diarahkan ke WhatsApp
        // (nomor CS diatur admin Tefa di halaman Katalog Gabungan)
        $hasPesanan = Pesanan::where('id_user', Auth::id())->exists();

        if ($hasPesanan) {
            return redirect()->away(Pengaturan::urlWhatsapp());
        }

        return view('public.customer-service');
    }
}