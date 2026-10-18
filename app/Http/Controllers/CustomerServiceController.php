<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    private const WHATSAPP_URL = 'https://wa.me/6289653628650';

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
        $hasPesanan = Pesanan::where('id_user', Auth::id())->exists();

        if ($hasPesanan) {
            return redirect()->away(self::WHATSAPP_URL);
        }

        return view('public.customer-service');
    }
}