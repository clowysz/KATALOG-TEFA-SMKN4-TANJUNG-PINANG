<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukJasa;
use App\Models\Jurusan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Umum Admin TEFA
        $totalPesanan = Pesanan::count();
        $totalProduk = ProdukJasa::count();
        $totalJurusan = Jurusan::count();
        $totalUser = User::count();

        // 2. Produk/Jasa Terlaris (Paling Banyak Dipesan)
        $produkTerlaris = ProdukJasa::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->take(5)
            ->get();

        // 3. Rekap Pesanan Berdasarkan Jurusan
        $pesananPerJurusan = Jurusan::withCount(['produkJasas as total_pesanan' => function ($query) {
            $query->join('pesanan', 'produk_jasa.id_produk_jasa', '=', 'pesanan.id_produk_jasa');
        }])->get();

        return view('admin.admin_tefa.dashboard', compact(
            'totalPesanan', 
            'totalProduk', 
            'totalJurusan', 
            'totalUser', 
            'produkTerlaris', 
            'pesananPerJurusan'
        ));
    }
}