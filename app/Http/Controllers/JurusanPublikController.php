<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Portfolio;
use App\Models\ProdukJasa;
use Illuminate\Support\Facades\Auth;

class JurusanPublikController extends Controller
{
    // Detail jurusan
    public function show($slug)
    {
        [$jurusan] = $this->resolve($slug);

        return view('public.jurusan.detail-jurusan', compact('jurusan', 'slug'));
    }

    // Portofolio
    public function portofolio($slug)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $portofolios = Portfolio::with('gambars')
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->latest()
            ->get();

        return view('public.portofolio.index', compact('jurusan', 'slug', 'portofolios'));
    }

    // Detail portofolio
    public function portofolioDetail($slug, $id)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $portofolio = Portfolio::with('gambars')
            ->where('id_portfolio', $id)
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->firstOrFail();

        return view('public.portofolio.detail', compact('jurusan', 'slug', 'portofolio'));
    }

    // Daftar produk
    public function produk($slug)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $produks = ProdukJasa::with('gambars')
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->where('jenis', 'produk')
            ->latest()
            ->get();

        return view('public.produk.index', compact('jurusan', 'slug', 'produks'));
    }

    // Detail produk
    public function produkDetail($slug, $id)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $produk = ProdukJasa::with('gambars')
            ->where('id_produk_jasa', $id)
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->where('jenis', 'produk')
            ->firstOrFail();

        $this->hitungTampilan($produk);

        return view('public.produk.detail', compact('jurusan', 'slug', 'produk'));
    }

    // Daftar jasa
    public function jasa($slug)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $jasas = ProdukJasa::with('gambars')
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->where('jenis', 'jasa')
            ->latest()
            ->get();

        return view('public.jasa.index', compact('jurusan', 'slug', 'jasas'));
    }

    // Detail jasa
    public function jasaDetail($slug, $id)
    {
        [$jurusan, $jurusanDb] = $this->resolve($slug, true);

        $jasa = ProdukJasa::with('gambars')
            ->where('id_produk_jasa', $id)
            ->where('id_jurusan', $jurusanDb->id_jurusan)
            ->where('jenis', 'jasa')
            ->firstOrFail();

        $this->hitungTampilan($jasa);

        return view('public.jasa.detail', compact('jurusan', 'slug', 'jasa'));
    }

    // =====================================================================
    // HELPER
    // =====================================================================

    /**
     * Ambil data statis jurusan (config/jurusan.php) + data database.
     *
     * @param  bool  $wajibDb  true = 404 jika jurusan tidak ada di database
     * @return array{0: object, 1: ?Jurusan}
     */
    private function resolve(string $slug, bool $wajibDb = false): array
    {
        $data = config('jurusan');

        if (!array_key_exists($slug, $data)) {
            abort(404);
        }

        $jurusanDb = Jurusan::where('slug', $slug)->first();

        if ($wajibDb && !$jurusanDb) {
            abort(404);
        }

        $jurusan = (object) array_merge(['slug' => $slug], $data[$slug]);
        $jurusan->deskripsi_panjang = $jurusanDb->deskripsi ?? '';

        return [$jurusan, $jurusanDb];
    }

    /**
     * Statistik tampilan: guest dan pembeli dihitung, semua admin tidak.
     */
    private function hitungTampilan(ProdukJasa $item): void
    {
        $isAdmin = Auth::check() && in_array(Auth::user()->role, [
            'admin_tefa',
            'admin_jurusan',
            'admin_produser',
        ]);

        if (!$isAdmin) {
            $item->increment('jumlah_tampilan');
        }
    }
}