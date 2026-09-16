<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\GambarPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tahun' => 'nullable|string|max:4',
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

        $portfolio = Portfolio::create([
            'id_jurusan' => $jurusan->id_jurusan,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
            'id_user' => $user->id,
        ]);

        foreach ($request->file('gambar') as $file) {
            $path = $file->store('portfolio', 'public');

            $portfolio->gambars()->create([
                'path_gambar' => $path,
            ]);
        }

        return redirect()->back()->with(
            'success',
            'Portofolio berhasil ditambahkan!'
        );
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $portfolio = Portfolio::where('id_portfolio', $id)
            ->where('id_jurusan', $jurusan->id_jurusan)
            ->firstOrFail();

        foreach ($portfolio->gambars as $gambar) {
            Storage::disk('public')->delete($gambar->path_gambar);
        }

        $portfolio->delete();

        return redirect()->back()->with(
            'success',
            'Portofolio berhasil dihapus!'
        );
    }

    public function destroyGambar($id_gambar_portfolio)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $gambar = GambarPortfolio::where(
            'id_gambar_portfolio',
            $id_gambar_portfolio
        )
        ->whereHas('portfolio', function ($query) use ($jurusan) {
            $query->where('id_jurusan', $jurusan->id_jurusan);
        })
        ->firstOrFail();

        Storage::disk('public')->delete($gambar->path_gambar);
        $gambar->delete();

        return redirect()->back()->with(
            'success',
            'Gambar berhasil dihapus!'
        );
    }
}