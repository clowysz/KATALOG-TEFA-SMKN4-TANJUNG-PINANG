<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukJasa;

class KatalogTefaController extends Controller
{
    public function index()
    {
        $katalog = ProdukJasa::with([
            'jurusan',
            'gambars'
        ])
            ->latest()
            ->paginate(3);

        return view(
            'admin.admin_tefa.katalog-gabungan',
            compact('katalog')
        );
    }

    public function show($id)
    {
        $produk = ProdukJasa::with([
            'jurusan',
            'gambars'
        ])
            ->withCount('pesanans')
            ->findOrFail($id);

        return view(
            'admin.admin_tefa.katalog-detail',
            compact('produk')
        );
    }
}