<?php

namespace App\Http\Controllers;

use App\Models\ProdukJasa;

class KatalogTefaController extends Controller
{
    public function index()
    {
        $katalog = ProdukJasa::with(['jurusan', 'gambars'])
            ->latest()
            ->paginate(12);

        return view('admin.admin_tefa.katalog.index', compact('katalog'));
    }
}