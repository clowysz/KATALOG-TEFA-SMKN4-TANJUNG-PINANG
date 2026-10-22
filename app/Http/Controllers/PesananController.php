<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\PenugasanProduser;
use App\Models\RiwayatStatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermintaanPembatalan;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
   public function index()
{
    $pesanans = Pesanan::with([
        'pembeli',
        'produkJasa.jurusan',
        'permintaanPembatalan',
    ])->get();

    return view(
        'admin.admin_tefa.pesanan.index',
        compact('pesanans')
    );
}

    public function show($id)
    {
        $pesanan = Pesanan::with([
            'pembeli',
            'produkJasa.jurusan'
        ])->findOrFail($id);

        return view(
            'admin.admin_tefa.pesanan.detail',
            compact('pesanan')
        );
    }
public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:menunggu konfirmasi,konfirmasi,diproses,selesai,dibatalkan',
    ]);

    $pesanan = Pesanan::with('permintaanPembatalan')
        ->findOrFail($id);

    // Pesanan yang sudah dibatalkan tidak boleh diubah lagi.
if ($pesanan->status === 'dibatalkan') {
    return redirect()->back()->withErrors([
        'error' => 'Pesanan sudah dibatalkan dan statusnya tidak dapat diubah lagi.',
    ]);
}
    
        // Pesanan yang sudah dibatalkan tidak boleh diubah lagi.
if ($pesanan->status === 'dibatalkan') {
    return redirect()->back()->withErrors([
        'error' => 'Pesanan sudah dibatalkan dan statusnya tidak dapat diubah lagi.',
    ]);
}
    // Blokir perubahan status selama permintaan pembatalan menunggu.
    if (
        $pesanan->permintaanPembatalan &&
        $pesanan->permintaanPembatalan->status_permintaan === 'menunggu'
    ) {
        return redirect()->back()->withErrors([
            'error' => 'Status pesanan terkunci karena permintaan pembatalan sedang menunggu keputusan Admin TEFA.',
        ]);
    }

    // Pembatalan harus melalui proses khusus.
    if ($request->status === 'dibatalkan') {
        return redirect()->back()->withErrors([
            'error' => 'Gunakan proses pembatalan pesanan untuk mengubah status menjadi dibatalkan.',
        ]);
    }

    if ($request->status === 'diproses') {
        $adaProduser = PenugasanProduser::where(
            'id_produk_jasa',
            $pesanan->id_produk_jasa
        )->exists();

        if (!$adaProduser) {
            return redirect()->back()->withErrors([
                'error' => 'Produk/jasa ini belum memiliki Admin Produksi yang ditugaskan.',
            ]);
        }
    }

    $pesanan->status = $request->status;
    $pesanan->save();

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
    
public function permintaanPembatalan()
{
    $permintaanPembatalan = PermintaanPembatalan::with([
        'pesanan.pembeli',
        'pesanan.produkJasa.jurusan',
        'admin',
    ])->latest()->get();

    return view(
        'admin.admin_tefa.pesanan.permintaan-pembatalan',
        compact('permintaanPembatalan')
    );
}

public function setujuiPembatalan(Request $request, $id_permintaan)
{
    $data = $request->validate([
        'catatan_admin' => 'nullable|string|max:2000',
    ]);

    return DB::transaction(function () use ($data, $id_permintaan) {
        $permintaan = PermintaanPembatalan::where(
            'id_permintaan',
            $id_permintaan
        )->lockForUpdate()->firstOrFail();

        if ($permintaan->status_permintaan !== 'menunggu') {
            return back()->withErrors([
                'error' => 'Permintaan ini sudah diputuskan sebelumnya.',
            ]);
        }

        $pesanan = Pesanan::where(
            'id_pesanan',
            $permintaan->id_pesanan
        )->lockForUpdate()->firstOrFail();

        if ($pesanan->status !== 'konfirmasi') {
            return back()->withErrors([
                'error' => 'Status pesanan sudah berubah. Permintaan tidak dapat disetujui.',
            ]);
        }

        $pesanan->update([
            'status' => 'dibatalkan',
        ]);

        $permintaan->update([
            'status_permintaan' => 'disetujui',
            'catatan_admin' => $data['catatan_admin'] ?? null,
            'tanggal_keputusan' => now(),
            'id_admin' => Auth::id(),
        ]);

        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => 'dibatalkan',
            'keterangan' => 'Permintaan pembatalan disetujui Admin TEFA. Alasan pembeli: '
                . $permintaan->alasan,
            'tanggal_update' => now(),
            'id_user' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Permintaan pembatalan disetujui dan pesanan berhasil dibatalkan.'
        );
    });
}

public function tolakPembatalan(Request $request, $id_permintaan)
{
    $data = $request->validate([
        'catatan_admin' => 'nullable|string|max:2000',
    ]);

    return DB::transaction(function () use ($data, $id_permintaan) {
        $permintaan = PermintaanPembatalan::where(
            'id_permintaan',
            $id_permintaan
        )->lockForUpdate()->firstOrFail();

        if ($permintaan->status_permintaan !== 'menunggu') {
            return back()->withErrors([
                'error' => 'Permintaan ini sudah diputuskan sebelumnya.',
            ]);
        }

        $pesanan = Pesanan::where(
            'id_pesanan',
            $permintaan->id_pesanan
        )->lockForUpdate()->firstOrFail();

        if ($pesanan->status !== 'konfirmasi') {
            return back()->withErrors([
                'error' => 'Status pesanan sudah berubah. Permintaan tidak dapat ditolak melalui proses ini.',
            ]);
        }

        $permintaan->update([
            'status_permintaan' => 'ditolak',
            'catatan_admin' => $data['catatan_admin'] ?? null,
            'tanggal_keputusan' => now(),
            'id_admin' => Auth::id(),
        ]);

        RiwayatStatusPesanan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => $pesanan->status,
            'keterangan' => 'Permintaan pembatalan ditolak Admin TEFA.'
                . (!empty($data['catatan_admin'])
                    ? ' Catatan admin: ' . $data['catatan_admin']
                    : ''),
            'tanggal_update' => now(),
            'id_user' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Permintaan pembatalan ditolak. Pesanan tetap berstatus konfirmasi.'
        );
    });
}

}