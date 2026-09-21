<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukJasa;
use App\Models\RiwayatStatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananPembeliController extends Controller
{
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'pembeli') {
            abort(403, 'Hanya pembeli yang dapat membuat pesanan.');
        }

        $request->validate([
            'id_produk_jasa' => 'required|exists:produk_jasa,id_produk_jasa',
            'jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:2000',
        ]);

        $produkJasa = ProdukJasa::findOrFail(
            $request->id_produk_jasa
        );

        $jumlah = (int) $request->jumlah;

        $totalHarga = $produkJasa->harga * $jumlah;

        $pesanan = Pesanan::create([
            'id_user' => Auth::id(),
            'id_produk_jasa' => $produkJasa->id_produk_jasa,
            'tanggal_pesan' => now(),
            'jumlah' => $jumlah,
            'total_harga' => $totalHarga,
            'catatan' => $request->catatan,
            'status' => 'menunggu konfirmasi',
        ]);

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