<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\ProdukJasa;
use App\Models\Portfolio;
use App\Models\Pesanan;
use App\Models\PenugasanProduser;

class AdminJurusanController extends Controller
{
    // Dashboard Admin Jurusan
    public function dashboard()
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        $totalProduk = 0;
        $totalPortfolio = 0;
        $totalPesananJurusan = 0;
        $produkJasas = collect();
        $portfolios = collect();

        if ($jurusan) {
            $jurusanId = $jurusan->id_jurusan;

            $totalProduk = ProdukJasa::where(
                'id_jurusan',
                $jurusanId
            )->count();

            $totalPortfolio = Portfolio::where(
                'id_jurusan',
                $jurusanId
            )->count();

            $totalPesananJurusan = Pesanan::whereHas(
                'produkJasa',
                function ($q) use ($jurusanId) {
                    $q->where('id_jurusan', $jurusanId);
                }
            )->count();

            $produkJasas = ProdukJasa::where(
                'id_jurusan',
                $jurusanId
            )->get();

            $portfolios = Portfolio::where(
                'id_jurusan',
                $jurusanId
            )->get();
        }

        return view(
            'admin.admin_jurusan.dashboard',
            compact(
                'jurusan',
                'totalProduk',
                'totalPortfolio',
                'totalPesananJurusan',
                'produkJasas',
                'portfolios'
            )
        );
    }

    // Update deskripsi level 2 jurusan
    public function updateDeskripsi(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusan->update([
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with(
            'success',
            'Deskripsi jurusan berhasil diperbarui!'
        );
    }

    // Membuat Admin Produser baru
    public function storeProduser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'layanan' => 'required|array|min:1',
            'layanan.*' => 'exists:produk_jasa,id_produk_jasa',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        // Pastikan semua produk/jasa yang dipilih
        // memang milik jurusan Admin Jurusan yang sedang login
        $produkJasas = ProdukJasa::whereIn(
            'id_produk_jasa',
            $request->layanan
        )
        ->where('id_jurusan', $jurusanId)
        ->get();

        if ($produkJasas->count() !== count($request->layanan)) {
            return redirect()->back()->withErrors([
                'error' => 'Ada produk/jasa yang tidak berasal dari jurusan Anda.'
            ]);
        }

        // Buat akun Admin Produser
        $produser = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_produser',
            'id_jurusan_asal' => $jurusanId,
        ]);

        // Simpan penugasan produk/jasa
        foreach ($produkJasas as $produkJasa) {
            PenugasanProduser::create([
                'id_user_produser' => $produser->id,
                'id_produk_jasa' => $produkJasa->id_produk_jasa,
            ]);
        }

        return redirect('/jurusan-admin/akun')->with(
            'success',
            'Admin Produser berhasil ditambahkan.'
        );
    }
}