<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukJasa;
use App\Models\Jurusan;
use App\Services\ChromePdfGenerator;

class KatalogTefaController extends Controller
{
    /**
     * Jumlah item per halaman yang diizinkan.
     * 16 = desktop/tablet (4 kolom x 4 baris)
     * 15 = mobile (3 kolom x 5 baris)
     */
    private const PER_PAGE_OPTIONS = [15, 16];
    private const PER_PAGE_DEFAULT = 16;

    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', self::PER_PAGE_DEFAULT);

        if (!in_array($perPage, self::PER_PAGE_OPTIONS, true)) {
            $perPage = self::PER_PAGE_DEFAULT;
        }

        // ----- Filter dari URL (?keyword=...&jenis=...&jurusan=...) -----

        $rawKeyword = $request->query('keyword', '');
        $keyword = is_scalar($rawKeyword) ? trim((string) $rawKeyword) : '';

        $jenis = $request->query('jenis');
        $jenis = in_array($jenis, ['produk', 'jasa'], true) ? $jenis : 'semua';

        $rawJurusan = $request->query('jurusan');
        $idJurusan = is_scalar($rawJurusan) && ctype_digit((string) $rawJurusan)
            ? (int) $rawJurusan
            : 'semua';

        $adaFilter = $keyword !== '' || $jenis !== 'semua' || $idJurusan !== 'semua';

        // Query dasar. Filter diterapkan di sini, sehingga daftar card
        // dan tombol "Pilih Semua" selalu memakai hasil query yang sama.
        $query = ProdukJasa::query();

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_produk_jasa', 'like', '%' . $keyword . '%')
                    ->orWhere('deskripsi', 'like', '%' . $keyword . '%');
            });
        }

        if ($jenis !== 'semua') {
            $query->where('jenis', $jenis);
        }

        if ($idJurusan !== 'semua') {
            $query->where('id_jurusan', $idJurusan);
        }

        // ID seluruh item hasil query (SEMUA halaman), dipakai tombol "Pilih Semua"
        $semuaId = (clone $query)->pluck('id_produk_jasa');

        $katalog = $query
            ->with([
                'jurusan',
                'gambars'
            ])
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        // Pilihan pada dropdown filter jurusan
        $daftarJurusan = Jurusan::orderBy('nama_jurusan')
            ->get(['id_jurusan', 'nama_jurusan']);

        return view(
            'admin.admin_tefa.katalog-gabungan',
            compact(
                'katalog',
                'semuaId',
                'daftarJurusan',
                'keyword',
                'jenis',
                'idJurusan',
                'adaFilter'
            )
        );
    }

    public function show(int $id)
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

    public function generatePdf(Request $request, ChromePdfGenerator $generator)
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

        return $generator->fromView(
            'admin.admin_tefa.pdf',
            [
                'produkJasas' => $produkJasas,
            ],
            $fileName
        );
    }

    // Fungsi untuk menampilkan halaman detail
    public function showDetail(int $id)
    {
        // Ambil data produk/jasa beserta relasi jurusan dan gambarnya
        $item = ProdukJasa::with(['jurusan', 'gambars'])
            ->where('id_produk_jasa', $id)
            ->firstOrFail();

        $jurusan = $item->jurusan;

        return view('admin.admin_tefa.detail', compact('item', 'jurusan'));
    }
}