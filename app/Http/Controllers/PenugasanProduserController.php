<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProdukJasa;
use App\Models\PenugasanProduser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenugasanProduserController extends Controller
{
    /**
     * Menampilkan daftar Admin Produksi,
     * Produk/Jasa, dan penugasan pada jurusan Admin Jurusan.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil jurusan yang dimiliki Admin Jurusan
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        // Ambil Admin Produksi yang berada di jurusan ini
        $produsers = User::where('role', 'admin_produser')
            ->whereHas('penugasanProduser.produkJasa', function ($query) use ($jurusanId) {
                $query->where('id_jurusan', $jurusanId);
            })
            ->get();

        // Ambil semua produk/jasa milik jurusan ini
        $produkJasas = ProdukJasa::where('id_jurusan', $jurusanId)
            ->with('penugasanProduser.produser')
            ->get();

        // Ambil seluruh penugasan jurusan ini
        $penugasans = PenugasanProduser::whereHas('produkJasa', function ($query) use ($jurusanId) {
                $query->where('id_jurusan', $jurusanId);
            })
            ->with(['produser', 'produkJasa'])
            ->get();

        return view(
            'admin.admin_jurusan.penugasan-produser.index',
            compact(
                'jurusan',
                'produsers',
                'produkJasas',
                'penugasans'
            )
        );
    }

    /**
     * Menyimpan penugasan Admin Produksi ke Produk/Jasa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user_produser' => 'required|exists:users,id',
            'id_produk_jasa' => 'required|exists:produk_jasa,id_produk_jasa',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        // Pastikan user yang dipilih benar-benar Admin Produksi
        $produser = User::where('id', $request->id_user_produser)
            ->where('role', 'admin_produser')
            ->firstOrFail();

        // Pastikan Admin Produksi berasal dari jurusan Admin Jurusan yang login
        if ($produser->id_jurusan_asal != $jurusanId) {
            return redirect()->back()->withErrors([
                'error' => 'Admin Produksi tersebut bukan bagian dari jurusan ini.'
            ]);
        }

        // Pastikan produk/jasa berasal dari jurusan Admin Jurusan yang login
        $produkJasa = ProdukJasa::where(
            'id_produk_jasa',
            $request->id_produk_jasa
        )
        ->where('id_jurusan', $jurusanId)
        ->firstOrFail();

        // Cegah penugasan yang sama dua kali
        $sudahAda = PenugasanProduser::where(
            'id_user_produser',
            $produser->id
        )
        ->where(
            'id_produk_jasa',
            $produkJasa->id_produk_jasa
        )
        ->exists();

        if ($sudahAda) {
            return redirect()->back()->withErrors([
                'error' => 'Admin Produksi tersebut sudah ditugaskan pada produk/jasa ini.'
            ]);
        }

        PenugasanProduser::create([
            'id_user_produser' => $produser->id,
            'id_produk_jasa' => $produkJasa->id_produk_jasa,
        ]);

        return redirect()->back()->with(
            'success',
            'Admin Produksi berhasil ditugaskan ke produk/jasa.'
        );
    }

    /**
     * Menghapus penugasan Admin Produksi.
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        // Hanya boleh menghapus penugasan
        // yang produknya berada di jurusan sendiri
        $penugasan = PenugasanProduser::where(
            'id_penugasan',
            $id
        )
        ->whereHas('produkJasa', function ($query) use ($jurusan) {
            $query->where(
                'id_jurusan',
                $jurusan->id_jurusan
            );
        })
        ->firstOrFail();

        $penugasan->delete();

        return redirect()->back()->with(
            'success',
            'Penugasan Admin Produksi berhasil dihapus.'
        );
    }
}