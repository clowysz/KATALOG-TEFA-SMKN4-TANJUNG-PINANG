<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukJasa;
use Spatie\LaravelPdf\Facades\Pdf;

class KatalogTefaController extends Controller
{
    public function index()
    {
        $katalog = ProdukJasa::with([
            'jurusan',
            'gambars'
        ])
            ->latest()
            ->paginate(10);

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

    public function generatePdf(Request $request)
    {
        $validated = $request->validate([
            'produk_jasa_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'produk_jasa_ids.*' => [
                'integer',
                'distinct',
                'exists:produk_jasa,id_produk_jasa',
            ],
        ], [
            'produk_jasa_ids.required' =>
                'Silakan pilih minimal satu produk atau jasa.',

            'produk_jasa_ids.min' =>
                'Silakan pilih minimal satu produk atau jasa.',

            'produk_jasa_ids.*.exists' =>
                'Terdapat produk atau jasa yang tidak valid.',
        ]);

        $ids = array_values(
            array_map(
                'intval',
                $validated['produk_jasa_ids']
            )
        );

        $produkJasas = ProdukJasa::with([
            'jurusan',
            'gambars',
        ])
            ->whereIn(
                'id_produk_jasa',
                $ids
            )
            ->get()
            ->keyBy('id_produk_jasa');

        $produkJasas = collect($ids)
            ->map(function ($id) use ($produkJasas) {
                return $produkJasas->get($id);
            })
            ->filter()
            ->values();

        if ($produkJasas->isEmpty()) {
            return redirect()
                ->back()
                ->withErrors([
                    'produk_jasa_ids' =>
                        'Silakan pilih minimal satu produk atau jasa.',
                ]);
        }

        $fileName =
            'katalog-tefa-smkn4-' .
            now()->format('Y-m-d') .
            '.pdf';

        return Pdf::view(
            'admin.admin_tefa.pdf',
            [
                'produkJasas' => $produkJasas,
            ]
        )
            ->format('a4')
            ->portrait()
            ->name($fileName);
    }
}