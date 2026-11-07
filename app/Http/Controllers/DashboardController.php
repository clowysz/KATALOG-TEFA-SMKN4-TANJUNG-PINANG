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





        $totalProduk = ProdukJasa::where(
            'jenis',
            'produk'
        )->count();

        $totalJurusan = Jurusan::count();

        $totalUser = User::count();






        $produkTerlaris = ProdukJasa::withCount('pesanans')
            ->orderBy('pesanans_count', 'desc')
            ->take(5)
            ->get();





        $pesananTerbaru = Pesanan::with([
            'pembeli',
            'produkJasa.jurusan',
            'produkJasa.gambars'
        ])
            ->latest('tanggal_pesan')
            ->take(5)
            ->get();





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





        $chartLabels = [];
        $chartData = [];

        foreach ($jurusans as $jurusan) {

            $chartLabels[] = $jurusan->kode_jurusan
                ?: $jurusan->nama_jurusan;

            $chartData[] = $pesananPerJurusan[
                $jurusan->id_jurusan
            ] ?? 0;
        }





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




        $jurusans = Jurusan::withCount([

            'produkJasas as total_produk' => function ($query) {
                $query->where('jenis', 'produk');
            },

            'produkJasas as total_jasa' => function ($query) {
                $query->where('jenis', 'jasa');
            },

            'portfolios as total_portofolio',

        ])->get();





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





        foreach ($jurusans as $jurusan) {

            $jurusan->total_pesanan =
                $pesananPerJurusan[
                    $jurusan->id_jurusan
                ] ?? 0;
        }





        return view(
            'admin.admin_tefa.jurusan.index',
            compact('jurusans')
        );
    }
}