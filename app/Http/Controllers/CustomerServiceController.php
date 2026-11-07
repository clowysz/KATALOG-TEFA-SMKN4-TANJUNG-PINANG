<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class CustomerServiceController extends Controller
{
    public function index()
    {

        if (!Auth::check()) {
            return redirect()->route('login', [
                'redirect' => '/customer-service',
                'back' => url()->previous(),
            ]);
        }

        $hasPesanan = Pesanan::where('id_user', Auth::id())->exists();

        if ($hasPesanan) {
            return redirect()->away(Pengaturan::urlWhatsapp());
        }

        return view('public.customer-service');
    }
}