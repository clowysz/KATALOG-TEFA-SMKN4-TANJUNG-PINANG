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


        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;



        $produsers = User::where('role', 'admin_produser')
            ->where('id_jurusan_asal', $jurusanId)
            ->orderBy('nama')
            ->get();



        $produkJasas = ProdukJasa::where(
            'id_jurusan',
            $jurusanId
        )
        ->with('penugasanProduser.produser')
        ->orderBy('nama_produk_jasa')
        ->get();



        $penugasans = PenugasanProduser::whereHas(
            'produkJasa',
            function ($query) use ($jurusanId) {
                $query->where(
                    'id_jurusan',
                    $jurusanId
                );
            }
        )
        ->with([
            'produser',
            'produkJasa',
        ])
        ->latest()
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
     * Menyimpan penugasan Admin Produksi
     * ke Produk/Jasa.
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



        $produser = User::where(
            'id',
            $request->id_user_produser
        )
        ->where(
            'role',
            'admin_produser'
        )
        ->where(
            'id_jurusan_asal',
            $jurusanId
        )
        ->first();

        if (!$produser) {
            return redirect()->back()->withErrors([
                'error' => 'Admin Produksi tersebut bukan bagian dari jurusan ini.'
            ]);
        }



        $produkJasa = ProdukJasa::where(
            'id_produk_jasa',
            $request->id_produk_jasa
        )
        ->where(
            'id_jurusan',
            $jurusanId
        )
        ->first();

        if (!$produkJasa) {
            return redirect()->back()->withErrors([
                'error' => 'Produk/jasa tersebut bukan milik jurusan ini.'
            ]);
        }


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



        $penugasan = PenugasanProduser::where(
            'id_penugasan',
            $id
        )
        ->whereHas(
            'produkJasa',
            function ($query) use ($jurusan) {
                $query->where(
                    'id_jurusan',
                    $jurusan->id_jurusan
                );
            }
        )
        ->first();

        if (!$penugasan) {
            return redirect()->back()->withErrors([
                'error' => 'Penugasan tidak ditemukan atau bukan bagian dari jurusan ini.'
            ]);
        }

        $penugasan->delete();

        return redirect()->back()->with(
            'success',
            'Penugasan Admin Produksi berhasil dihapus.'
        );
    }
}