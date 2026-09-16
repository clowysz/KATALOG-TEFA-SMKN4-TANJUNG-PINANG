<?php

namespace App\Http\Controllers;

use App\Models\ProdukJasa;
use App\Models\GambarProdukJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukJasaController extends Controller
{
    /**
     * Menambahkan Produk/Jasa.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk_jasa' => 'required|string|max:255',
            'jenis' => 'required|in:produk,jasa',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'required|array|min:1',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $produkJasa = ProdukJasa::create([
            'nama_produk_jasa' => $request->nama_produk_jasa,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'id_jurusan' => $jurusan->id_jurusan,
            'id_user' => $user->id,
        ]);

        foreach ($request->file('gambar') as $file) {
            $path = $file->store('produk_jasa', 'public');

            $produkJasa->gambars()->create([
                'path_gambar' => $path,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Produk/Jasa berhasil ditambahkan!'
        );
    }

    /**
     * Menghapus Produk/Jasa dari katalog.
     *
     * Menggunakan Soft Delete.
     *
     * Catatan:
     * Jangan menghapus file gambar di sini.
     * Produk hanya diberi deleted_at, sedangkan gambar
     * tetap disimpan agar riwayat pesanan lama tetap
     * dapat menampilkan foto produk.
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

        $produkJasa = ProdukJasa::where(
            'id_produk_jasa',
            $id
        )
        ->where(
            'id_jurusan',
            $jurusan->id_jurusan
        )
        ->firstOrFail();

        // Soft delete:
        // Produk hilang dari katalog,
        // tetapi data produk dan gambar tetap tersimpan.
        $produkJasa->delete();

        return redirect()->back()->with(
            'success',
            'Produk/Jasa berhasil dihapus dari katalog!'
        );
    }

    /**
     * Menghapus satu gambar Produk/Jasa.
     *
     * Ini benar-benar menghapus file gambar yang dipilih.
     */
    public function destroyGambar($id_gambar)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $gambar = GambarProdukJasa::where(
            'id_gambar',
            $id_gambar
        )
        ->whereHas('produkJasa', function ($query) use ($jurusan) {
            $query->where(
                'id_jurusan',
                $jurusan->id_jurusan
            );
        })
        ->firstOrFail();

        Storage::disk('public')->delete(
            $gambar->path_gambar
        );

        $gambar->delete();

        return redirect()->back()->with(
            'success',
            'Gambar berhasil dihapus!'
        );
    }
}