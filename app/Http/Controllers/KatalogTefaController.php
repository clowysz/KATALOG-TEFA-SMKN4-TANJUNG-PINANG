<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukJasa;

class KatalogTefaController extends Controller
{
    public function index()
    {
        $katalog = ProdukJasa::with(['jurusan', 'gambars'])->latest()->paginate(3);
        
        return view('admin.admin_tefa.katalog-gabungan', compact('katalog'));
    }

    // 👇 FUNGSI BARU UNTUK MENAMPILKAN HALAMAN DETAIL
    public function showDetail($id)
    {
        // Ambil data produk/jasa beserta relasi jurusan dan gambarnya
$item = ProdukJasa::with(['jurusan', 'gambars'])
                ->where('id_produk_jasa', $id)
                ->firstOrFail();
                
    $jurusan = $item->jurusan;

    return view('admin.admin_tefa.detail', compact('item', 'jurusan'));
}
}