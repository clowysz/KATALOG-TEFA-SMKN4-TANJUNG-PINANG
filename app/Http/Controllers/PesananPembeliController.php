<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukJasa;
use App\Models\RiwayatStatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananPembeliController extends Controller
{
    // Membuat pesanan dari halaman checkout pembeli
    public function store(Request $request)
    {
        // Pastikan yang membuat pesanan adalah pembeli
        if (Auth::user()->role !== 'pembeli') {
            abort(403, 'Hanya pembeli yang dapat membuat pesanan.');
        }

        $request->validate([
            'id_produk_jasa' => 'required|exists:produk_jasa,id_produk_jasa',
        ]);

        // Produk yang sudah di-soft-delete tidak akan ditemukan
        // sehingga tidak dapat dipesan lagi.
        $produkJasa = ProdukJasa::findOrFail(
            $request->id_produk_jasa
        );

        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'id_produk_jasa' => $produkJasa->id_produk_jasa,
            'tanggal_pesan' => now(),
            'total_harga' => $produkJasa->harga,
            'status' => 'menunggu konfirmasi',
        ]);

        // Simpan status awal pesanan ke riwayat
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'menunggu konfirmasi',
            'keterangan' => 'Pesanan berhasil dibuat oleh pembeli.',
            'tanggal_update' => now(),
            'id_user' => Auth::id(),
        ]);

        return redirect('/riwayat-pesanan')->with(
            'success',
            'Pesanan berhasil dibuat! Menunggu konfirmasi dari admin.'
        );
    }
}