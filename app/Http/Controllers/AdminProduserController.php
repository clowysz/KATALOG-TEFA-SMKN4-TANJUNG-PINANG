<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProdukJasa;
use App\Models\Pesanan;
use App\Models\ProgressPengerjaan;

class AdminProduserController extends Controller
{
    /**
     * Dashboard Admin Produksi
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Ambil ID produk/jasa yang ditugaskan kepada Admin Produksi ini
        $idProdukSaya = $user->penugasanProduser()
            ->pluck('id_produk_jasa');

        // Hitung jumlah produk/jasa yang ditugaskan
        $totalProdukSaya = $idProdukSaya->count();

        // Ambil pesanan yang:
        // 1. Produk/jasanya memang ditugaskan kepada user ini
        // 2. Statusnya sudah diproses
        $pesananMasuk = Pesanan::with([
                'pembeli',
                'produkJasa',
                'progressPengerjaan'
            ])
            ->whereIn('id_produk_jasa', $idProdukSaya)
            ->where('status', 'diproses')
            ->get();

        $totalPesananMasuk = $pesananMasuk->count();

        return view(
            'admin.admin_produser.dashboard',
            compact(
                'pesananMasuk',
                'totalProdukSaya',
                'totalPesananMasuk'
            )
        );
    }

    /**
     * Admin Produksi menambahkan progress pengerjaan.
     */
    public function updateProgress(Request $request, $id_pesanan)
    {
        $request->validate([
            'keterangan_progress' => 'required|string|max:255',
            'persentase_progress' => 'required|integer|min:0|max:100',
        ]);

        $user = Auth::user();

        // Ambil produk/jasa yang memang ditugaskan
        // kepada Admin Produksi yang sedang login
        $idProdukSaya = $user->penugasanProduser()
            ->pluck('id_produk_jasa');

        // Pastikan pesanan berasal dari produk/jasa
        // yang memang menjadi tanggung jawab user ini
        $pesanan = Pesanan::where('id_pesanan', $id_pesanan)
            ->whereIn('id_produk_jasa', $idProdukSaya)
            ->where('status', 'diproses')
            ->firstOrFail();

        // Simpan riwayat progress
        ProgressPengerjaan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'persentase_progress' => $request->persentase_progress,
            'keterangan_progress' => $request->keterangan_progress,
            'tanggal_update' => now(),
            'id_user' => $user->id,
        ]);

        return redirect()->back()->with(
            'success',
            'Progress pengerjaan berhasil diperbarui!'
        );
    }
}