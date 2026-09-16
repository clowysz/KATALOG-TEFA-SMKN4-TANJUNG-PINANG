<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PenugasanProduser;
use App\Models\RiwayatStatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with([
            'pembeli',
            'produkJasa'
        ])->get();

        return view(
            'admin.admin_tefa.pesanan.index',
            compact('pesanans')
        );
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu konfirmasi,konfirmasi,diproses,selesai,dibatalkan',
        ]);

        $pesanan = Pesanan::with('produkJasa')
            ->findOrFail($id);

        // Jika status menjadi "diproses",
        // pastikan produk/jasa sudah memiliki Admin Produksi.
        if ($request->status === 'diproses') {

            $adaProduser = PenugasanProduser::where(
                'id_produk_jasa',
                $pesanan->id_produk_jasa
            )->exists();

            if (!$adaProduser) {
                return redirect()->back()->withErrors([
                    'error' => 'Produk/jasa ini belum memiliki Admin Produksi yang ditugaskan.'
                ]);
            }
        }

        // Simpan status baru
        $pesanan->status = $request->status;
        $pesanan->save();

        // Simpan riwayat perubahan status
        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => $request->status,
            'keterangan' => 'Status pesanan diperbarui oleh Admin TEFA.',
            'tanggal_update' => now(),
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with(
            'success',
            'Status pesanan berhasil diperbarui!'
        );
    }
}