<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProdukJasa;
use Illuminate\Http\Request;

class KatalogPublikController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->query('keyword', ''));
        $jenis = $request->query('jenis', 'semua');
        $id_jurusan = $request->query('jurusan', 'semua');

        $query = ProdukJasa::with(['gambars', 'jurusan']);

        if (in_array($jenis, ['produk', 'jasa'])) {
            $query->where('jenis', $jenis);
        }

        if ($id_jurusan !== 'semua') {
            $query->where('id_jurusan', $id_jurusan);
        }

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk_jasa', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        $katalog = $query
            ->latest()
            ->paginate(24)
            ->withQueryString();

        $daftarJurusan = Jurusan::orderBy('nama_jurusan', 'asc')->get();

        return view('public.katalog', compact(
            'katalog',
            'keyword',
            'jenis',
            'id_jurusan',
            'daftarJurusan'
        ));
    }
}