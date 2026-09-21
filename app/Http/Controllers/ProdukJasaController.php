<?php

namespace App\Http\Controllers;

use App\Models\ProdukJasa;
use App\Models\GambarProdukJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukJasaController extends Controller
{
    // Ambil data Produk/Jasa
    public function index(Request $request)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $query = ProdukJasa::with('gambars')
            ->withCount('pesanans')
            ->where('id_jurusan', $jurusan->id_jurusan);

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $data = $query
            ->latest()
            ->get();

        return response()->json([
            'data' => $data
        ]);
    }

    // Tambah Produk/Jasa
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
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
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

        return response()->json([
            'message' => 'Produk/Jasa berhasil ditambahkan!'
        ]);
    }

    // Edit Produk/Jasa
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk_jasa' => 'required|string|max:255',
            'jenis' => 'required|in:produk,jasa',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|array',
            'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
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

        $produkJasa->update([
            'nama_produk_jasa' => $request->nama_produk_jasa,
            'jenis' => $request->jenis,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ]);

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $path = $file->store('produk_jasa', 'public');

                $produkJasa->gambars()->create([
                    'path_gambar' => $path,
                ]);
            }
        }

        return response()->json([
            'message' => 'Produk/Jasa berhasil diperbarui!'
        ]);
    }

    // Soft delete Produk/Jasa
    public function destroy($id)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
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

        $produkJasa->delete();

        return response()->json([
            'message' => 'Produk/Jasa berhasil dihapus dari katalog!'
        ]);
    }

    // Hapus satu gambar
    public function destroyGambar($id_gambar)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
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

        return response()->json([
            'message' => 'Gambar berhasil dihapus!'
        ]);
    }
}