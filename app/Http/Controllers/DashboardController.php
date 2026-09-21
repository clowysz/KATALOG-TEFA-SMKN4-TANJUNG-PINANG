<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukJasa;
use App\Models\Jurusan;
use App\Models\User;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN TEFA
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        // =====================================================
        // 1. STATISTIK PESANAN
        // =====================================================

        $totalPesanan = Pesanan::count();

        $menungguKonfirmasi = Pesanan::where(
            'status',
            'menunggu konfirmasi'
        )->count();

        $dikonfirmasi = Pesanan::where(
            'status',
            'konfirmasi'
        )->count();

        $sedangDiproses = Pesanan::where(
            'status',
            'diproses'
        )->count();

        $selesai = Pesanan::where(
            'status',
            'selesai'
        )->count();


        // =====================================================
        // 2. DATA TAMBAHAN
        // =====================================================

        $totalProduk = ProdukJasa::where(
            'jenis',
            'produk'
        )->count();

        $totalJurusan = Jurusan::count();

        $totalUser = User::count();


        // =====================================================
        // 3. PRODUK / JASA TERLARIS
        // Berdasarkan jumlah pesanan
        // =====================================================

        $produkTerlaris = ProdukJasa::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->take(5)
            ->get();


        // =====================================================
        // 4. PESANAN TERBARU
        // =====================================================

        $pesananTerbaru = Pesanan::with([
            'pembeli',
            'produkJasa.jurusan',
            'produkJasa.gambars'
        ])
            ->latest('tanggal_pesan')
            ->take(5)
            ->get();


        // =====================================================
        // 5. PESANAN BERDASARKAN JURUSAN
        // =====================================================

        $jurusans = Jurusan::orderBy('nama_jurusan')->get();


        $pesananPerJurusan = Pesanan::query()
            ->join(
                'produk_jasa',
                'pesanan.id_produk_jasa',
                '=',
                'produk_jasa.id_produk_jasa'
            )
            ->selectRaw(
                'produk_jasa.id_jurusan, COUNT(pesanan.id_pesanan) as total_pesanan'
            )
            ->groupBy('produk_jasa.id_jurusan')
            ->pluck(
                'total_pesanan',
                'id_jurusan'
            );


        // =====================================================
        // 6. DATA UNTUK CHART
        // =====================================================

        $chartLabels = [];
        $chartData = [];


        foreach ($jurusans as $jurusan) {

            $chartLabels[] = $jurusan->kode_jurusan
                ?: $jurusan->nama_jurusan;

            $chartData[] = $pesananPerJurusan[
                $jurusan->id_jurusan
            ] ?? 0;
        }


        // =====================================================
        // 7. KIRIM DATA KE DASHBOARD
        // =====================================================

        return view(
            'admin.admin_tefa.dashboard',
            compact(
                'totalPesanan',
                'menungguKonfirmasi',
                'dikonfirmasi',
                'sedangDiproses',
                'selesai',
                'totalProduk',
                'totalJurusan',
                'totalUser',
                'produkTerlaris',
                'pesananTerbaru',
                'chartLabels',
                'chartData'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | HALAMAN JURUSAN ADMIN TEFA
    |--------------------------------------------------------------------------
    */

    public function jurusan()
    {
        // =====================================================
        // 1. AMBIL SEMUA JURUSAN
        // =====================================================

        $jurusans = Jurusan::withCount([

            'produkJasas as total_produk' => function ($query) {
                $query->where('jenis', 'produk');
            },

            'produkJasas as total_jasa' => function ($query) {
                $query->where('jenis', 'jasa');
            },

            'portfolios as total_portofolio',

        ])->get();


        // =====================================================
        // 2. HITUNG PESANAN PER JURUSAN
        // =====================================================

        /*
         * Pesanan tidak mempunyai id_jurusan secara langsung.
         *
         * Alurnya:
         *
         * pesanan
         *     ↓
         * id_produk_jasa
         *     ↓
         * produk_jasa
         *     ↓
         * id_jurusan
         */

        $pesananPerJurusan = Pesanan::query()
            ->join(
                'produk_jasa',
                'pesanan.id_produk_jasa',
                '=',
                'produk_jasa.id_produk_jasa'
            )
            ->selectRaw(
                'produk_jasa.id_jurusan, COUNT(pesanan.id_pesanan) as total_pesanan'
            )
            ->groupBy('produk_jasa.id_jurusan')
            ->pluck(
                'total_pesanan',
                'id_jurusan'
            );


        // =====================================================
        // 3. MASUKKAN JUMLAH PESANAN KE SETIAP JURUSAN
        // =====================================================

        foreach ($jurusans as $jurusan) {

            $jurusan->total_pesanan =
                $pesananPerJurusan[
                    $jurusan->id_jurusan
                ] ?? 0;
        }


        // =====================================================
        // 4. KIRIM KE HALAMAN JURUSAN
        // =====================================================

        return view(
            'admin.admin_tefa.jurusan.index',
            compact('jurusans')
        );
    }
}