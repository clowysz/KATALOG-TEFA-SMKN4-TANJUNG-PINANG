<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\GambarPortfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Ambil semua portofolio milik jurusan Admin Jurusan yang login
     */
    public function index()
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $portfolios = Portfolio::with('gambars')
            ->where('id_jurusan', $jurusan->id_jurusan)
            ->latest('id_portfolio')
            ->get();

        return response()->json([
            'data' => $portfolios
        ]);
    }

    /**
     * Tambah Portofolio
     */
    public function store(Request $request)
    {
        $request->validate([
    'judul' => 'required|string|max:255',
    'deskripsi' => 'required|string',
    'tahun' => ['required', 'digits:4', 'integer', 'between:2000,' . date('Y')],
    'gambar' => 'required|array|min:1',
    'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',

], $this->pesanValidasi());

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
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

        return response()->json([
            'message' => 'Portofolio berhasil ditambahkan!'
        ]);
    }

    /**
     * Edit Portofolio
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
    'judul' => 'required|string|max:255',
    'deskripsi' => 'required|string',
    'tahun' => ['required', 'digits:4', 'integer', 'between:2000,' . date('Y')],
    'gambar' => 'nullable|array',
    'gambar.*' => 'image|mimes:jpg,jpeg,png|max:2048',

], $this->pesanValidasi());
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $portfolio = Portfolio::where(
            'id_portfolio',
            $id
        )
        ->where(
            'id_jurusan',
            $jurusan->id_jurusan
        )
        ->firstOrFail();

        $portfolio->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tahun' => $request->tahun,
        ]);

        if ($request->hasFile('gambar')) {

            foreach ($request->file('gambar') as $file) {

                $path = $file->store('portfolio', 'public');

                $portfolio->gambars()->create([
                    'path_gambar' => $path,
                ]);
            }
        }

        return response()->json([
            'message' => 'Portofolio berhasil diperbarui!'
        ]);
    }

    /**
     * Hapus Portofolio
     */
    public function destroy(int $id)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $portfolio = Portfolio::where(
            'id_portfolio',
            $id
        )
        ->where(
            'id_jurusan',
            $jurusan->id_jurusan
        )
        ->firstOrFail();

        foreach ($portfolio->gambars as $gambar) {

            Storage::disk('public')->delete(
                $gambar->path_gambar
            );

            $gambar->delete();
        }

        $portfolio->delete();

        return response()->json([
            'message' => 'Portofolio berhasil dihapus!'
        ]);
    }

    /**
     * Hapus satu gambar Portofolio
     */
    public function destroyGambar(int $id_gambar_portfolio)
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $gambar = GambarPortfolio::where(
            'id_gambar_portfolio',
            $id_gambar_portfolio
        )
        ->whereHas('portfolio', function ($query) use ($jurusan) {

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
    private function pesanValidasi(): array
{
    return [
        'judul.required'     => 'Judul portofolio wajib diisi.',
        'judul.max'          => 'Judul portofolio maksimal 255 karakter.',
        'deskripsi.required' => 'Deskripsi singkat wajib diisi.',
        'tahun.required'     => 'Tahun / periode wajib diisi.',
        'tahun.digits'       => 'Tahun harus terdiri dari 4 angka, contoh: 2026.',
        'gambar.required'    => 'Minimal satu gambar wajib diunggah.',
        'gambar.min'         => 'Minimal satu gambar wajib diunggah.',
        'gambar.*.image'     => 'File harus berupa gambar.',
        'gambar.*.mimes'     => 'Gambar harus berformat JPG, JPEG, atau PNG.',
        'gambar.*.max'       => 'Ukuran setiap gambar maksimal 2 MB.',
        'gambar.*.uploaded'  => 'Gambar gagal diunggah. Pastikan ukuran maksimal 2 MB.',
        'tahun.integer'      => 'Tahun harus berupa angka.',
        'tahun.between'      => 'Tahun harus diantara 2000 sampai ' . date('Y') . '.',
        ];
}
}