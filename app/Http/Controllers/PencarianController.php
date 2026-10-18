<?php

namespace App\Http\Controllers;

use App\Models\ProdukJasa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencarianController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim($request->query('keyword', ''));

        $results = ProdukJasa::with(['gambars', 'jurusan'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('nama_produk_jasa', 'like', '%' . $keyword . '%')
                        ->orWhere('deskripsi', 'like', '%' . $keyword . '%')
                        ->orWhere('jenis', 'like', '%' . $keyword . '%');
                });
            })
            ->latest()
            ->get();

        $isAdmin = Auth::check() && in_array(Auth::user()->role, [
            'admin_tefa',
            'admin_jurusan',
            'admin_produser',
        ]);

        if ($keyword !== '' && !$isAdmin) {
            foreach ($results as $item) {
                $item->increment('jumlah_pencarian');
            }
        }

        return view('public.pencarian', compact('results', 'keyword'));
    }
}