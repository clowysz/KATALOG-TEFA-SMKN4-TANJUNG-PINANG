<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukJasa;
use App\Models\RiwayatStatusPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermintaanPembatalan;
use Illuminate\Support\Facades\DB;

class PesananPembeliController extends Controller
{
    private const STATUS_VALID = [
        'menunggu konfirmasi',
        'konfirmasi',
        'diproses',
        'selesai',
        'dibatalkan',
    ];

    // Daftar riwayat pesanan pembeli
    public function riwayat(Request $request)
    {
        $query = Pesanan::with([
            'produkJasa.gambars',
            'produkJasa.jurusan',
            'riwayatStatus',
        ])->where('id_user', Auth::id());

        $status = $request->query('status');
        $keyword = trim($request->query('keyword', ''));

        if ($status && in_array($status, self::STATUS_VALID)) {
            $query->where('status', $status);
        }

        if ($keyword !== '') {
            $query->whereHas('produkJasa', function ($q) use ($keyword) {
                $q->where('nama_produk_jasa', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $riwayats = $query
            ->latest('tanggal_pesan')
            ->latest('id_pesanan')
            ->get();

        return view('public.riwayat', compact('riwayats', 'status', 'keyword'));
    }

    // Detail riwayat pesanan
    public function detail($id_pesanan)
    {
        $pesanan = Pesanan::with([
            'produkJasa.gambars',
            'produkJasa.jurusan',
            'pembeli',
            'riwayatStatus.pelaksana',
            'progressPengerjaan.pelaksana',
            'tahapanPengerjaan',
        ])
            ->where('id_pesanan', $id_pesanan)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        return view('public.riwayat-detail', compact('pesanan'));
    }

    // Halaman checkout
    public function checkout(Request $request)
    {
        $request->validate([
            'id_produk_jasa' => 'required|exists:produk_jasa,id_produk_jasa',
        ]);

        $produkJasa = ProdukJasa::with('gambars')
            ->findOrFail($request->id_produk_jasa);

        return view('public.checkout', compact('produkJasa'));
    }

    // Simpan pesanan
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

        $produkJasa = ProdukJasa::findOrFail($request->id_produk_jasa);

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
    public function batalkan(Request $request, $id_pesanan)
    {
        if (auth()->user()->role !== 'pembeli') {
            abort(403, 'Hanya pembeli yang dapat membatalkan pesanan.');
        }

        $data = $request->validate([
            'alasan' => 'required|string|max:2000',
        ]);

        return DB::transaction(function () use ($data, $id_pesanan) {
            $pesanan = Pesanan::where('id_pesanan', $id_pesanan)
                ->where('id_user', auth()->id())
                ->lockForUpdate()
                ->firstOrFail();

            // Pesanan yang masih menunggu konfirmasi langsung dibatalkan.
            if ($pesanan->status === 'menunggu konfirmasi') {
                $pesanan->status = 'dibatalkan';
                $pesanan->save();

                RiwayatStatusPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'status' => 'dibatalkan',
                    'keterangan' => 'Pesanan dibatalkan langsung oleh pembeli. Alasan: '
                        . $data['alasan'],
                    'tanggal_update' => now(),
                    'id_user' => auth()->id(),
                ]);

                return redirect('/riwayat-pesanan')
                    ->with('success', 'Pesanan berhasil dibatalkan.');
            }

            // Pesanan yang sudah dikonfirmasi perlu persetujuan admin.
            if ($pesanan->status === 'konfirmasi') {
                $permintaan = PermintaanPembatalan::firstOrCreate(
                    ['id_pesanan' => $pesanan->id_pesanan],
                    [
                        'alasan' => $data['alasan'],
                        'status_permintaan' => 'menunggu',
                    ]
                );

                if (!$permintaan->wasRecentlyCreated) {
                    if ($permintaan->status_permintaan === 'menunggu') {
                        return redirect('/riwayat-pesanan')
                            ->withErrors([
                                'error' => 'Permintaan pembatalan pesanan ini masih menunggu keputusan admin.',
                            ]);
                    }

                    // Jika permintaan sebelumnya ditolak, izinkan pengajuan ulang.
                    if ($permintaan->status_permintaan === 'ditolak') {
                        $permintaan->update([
                            'alasan' => $data['alasan'],
                            'status_permintaan' => 'menunggu',
                            'catatan_admin' => null,
                            'tanggal_keputusan' => null,
                            'id_admin' => null,
                        ]);
                    } else {
                        return redirect('/riwayat-pesanan')
                            ->withErrors([
                                'error' => 'Permintaan pembatalan ini sudah disetujui.',
                            ]);
                    }
                }

                return redirect('/riwayat-pesanan')
                    ->with('success', 'Permintaan pembatalan berhasil diajukan dan menunggu keputusan Admin TEFA.');
            }

            return redirect('/riwayat-pesanan')
                ->withErrors([
                    'error' => 'Pesanan tidak dapat dibatalkan karena statusnya sudah '
                        . $pesanan->status . '.',
                ]);
        });
    }


        }
