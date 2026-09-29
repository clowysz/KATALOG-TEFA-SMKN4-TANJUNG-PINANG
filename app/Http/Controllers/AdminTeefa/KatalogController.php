<?php

namespace App\Http\Controllers\AdminTeefa;

use App\Http\Controllers\Controller;
use App\Models\ProdukJasa;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;

class KatalogController extends Controller
{
    public function index()
    {
        $produkJasa = ProdukJasa::with('jurusan')
            ->latest()
            ->get();

        return view('admin_tefa.katalog.index', compact('produkJasa'));
    }

    public function generatePdf(Request $request)
{
    $request->validate([
        'produk_jasa' => ['required', 'array', 'min:1'],
        'produk_jasa.*' => ['integer', 'exists:produk_jasa,id_produk_jasa'],
    ]);

    $produkJasa = ProdukJasa::with([
        'jurusan',
        'gambars'
    ])
        ->whereIn('id_produk_jasa', $request->produk_jasa)
        ->get();

    return Pdf::view('admin.admin_tefa.katalog.pdf', [
        'produkJasa' => $produkJasa,
    ])
        ->format('a4')
        ->name('katalog-tefa.pdf')
        ->download();
}
}