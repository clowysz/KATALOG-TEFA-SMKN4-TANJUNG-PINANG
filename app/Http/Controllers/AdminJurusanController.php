<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\ProdukJasa;
use App\Models\Portfolio;
use App\Models\Pesanan;
use App\Models\PenugasanProduser;

class AdminJurusanController extends Controller
{
    // =========================================================
    // DASHBOARD ADMIN JURUSAN
    // =========================================================

    public function dashboard()
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        $totalProduk = 0;
        $totalJasa = 0;
        $totalPortfolio = 0;
        $totalPesananJurusan = 0;
        $totalPesananProduk = 0;
        $totalPesananJasa = 0;
        $produkTerlaris = collect();

        if ($jurusan) {
            $jurusanId = $jurusan->id_jurusan;

            $produkJasas = ProdukJasa::withCount('pesanans')
                ->where('id_jurusan', $jurusanId)
                ->latest()
                ->get();

            $totalProduk = $produkJasas
                ->where('jenis', 'produk')
                ->count();

            $totalJasa = $produkJasas
                ->where('jenis', 'jasa')
                ->count();

            $totalPortfolio = Portfolio::where(
                'id_jurusan',
                $jurusanId
            )->count();

            $totalPesananJurusan = $produkJasas->sum(
                'pesanans_count'
            );

            $totalPesananProduk = $produkJasas
                ->where('jenis', 'produk')
                ->sum('pesanans_count');

            $totalPesananJasa = $produkJasas
                ->where('jenis', 'jasa')
                ->sum('pesanans_count');

            $produkTerlaris = $produkJasas
                ->sortByDesc('pesanans_count')
                ->take(5)
                ->values();
        }

        return view(
            'admin.admin_jurusan.dashboard',
            compact(
                'jurusan',
                'totalProduk',
                'totalJasa',
                'totalPortfolio',
                'totalPesananJurusan',
                'totalPesananProduk',
                'totalPesananJasa',
                'produkTerlaris'
            )
        );
    }


    // =========================================================
    // DAFTAR AKUN ADMIN PRODUSER
    // =========================================================

    public function akun()
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        $akuns = User::with([
            'penugasanProduser.produkJasa'
        ])
        ->where('role', 'admin_produser')
        ->where('id_jurusan_asal', $jurusanId)
        ->get();

        $produkJasas = ProdukJasa::where(
            'id_jurusan',
            $jurusanId
        )->get();

        return view(
            'admin.admin_jurusan.akun-index',
            compact(
                'akuns',
                'produkJasas',
                'jurusan'
            )
        );
    }


    // =========================================================
    // TAMBAH AKUN ADMIN PRODUSER
    // =========================================================

    public function createProduser()
    {
        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $produkJasas = ProdukJasa::where(
            'id_jurusan',
            $jurusan->id_jurusan
        )->get();

        return view(
            'admin.admin_jurusan.akun-create',
            compact(
                'produkJasas',
                'jurusan'
            )
        );
    }


    // =========================================================
    // DETAIL AKUN ADMIN PRODUSER
    // =========================================================

    public function detailProduser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $akun = User::with([
            'penugasanProduser.produkJasa'
        ])
        ->where('id', $request->id)
        ->where('role', 'admin_produser')
        ->where('id_jurusan_asal', $jurusan->id_jurusan)
        ->first();

        if (!$akun) {
            abort(404, 'Akun Admin Produser tidak ditemukan.');
        }

        return view(
            'admin.admin_jurusan.akun-detail',
            compact(
                'akun',
                'jurusan'
            )
        );
    }


    // =========================================================
    // EDIT AKUN ADMIN PRODUSER
    // =========================================================

    public function editProduser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $akun = User::with([
            'penugasanProduser'
        ])
        ->where('id', $request->id)
        ->where('role', 'admin_produser')
        ->where('id_jurusan_asal', $jurusan->id_jurusan)
        ->first();

        if (!$akun) {
            abort(404, 'Akun Admin Produser tidak ditemukan.');
        }

        $produkJasas = ProdukJasa::where(
            'id_jurusan',
            $jurusan->id_jurusan
        )->get();

        return view(
            'admin.admin_jurusan.akun-edit',
            compact(
                'akun',
                'produkJasas',
                'jurusan'
            )
        );
    }


    // =========================================================
    // UPDATE AKUN ADMIN PRODUSER
    // =========================================================

    public function updateProduser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',

            'nama' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($request->id),
            ],

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak_aktif',
                ]),
            ],

            'layanan' => [
                'required',
                'array',
                'min:1',
            ],

            'layanan.*' => [
                'integer',
                'exists:produk_jasa,id_produk_jasa',
            ],
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        $akun = User::where('id', $request->id)
            ->where('role', 'admin_produser')
            ->where('id_jurusan_asal', $jurusanId)
            ->first();

        if (!$akun) {
            abort(404, 'Akun Admin Produser tidak ditemukan.');
        }

        $produkJasas = ProdukJasa::whereIn(
            'id_produk_jasa',
            $request->layanan
        )
        ->where('id_jurusan', $jurusanId)
        ->get();

        if (
            $produkJasas->count() !==
            count($request->layanan)
        ) {
            return redirect()->back()->withErrors([
                'error' => 'Ada produk/jasa yang tidak berasal dari jurusan Anda.'
            ]);
        }

        $akun->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        PenugasanProduser::where(
            'id_user_produser',
            $akun->id
        )->delete();

        foreach ($produkJasas as $produkJasa) {
            PenugasanProduser::create([
                'id_user_produser' => $akun->id,
                'id_produk_jasa' => $produkJasa->id_produk_jasa,
            ]);
        }

        return redirect(
            '/jurusan-admin/akun/detail?id=' . $akun->id
        )->with(
            'success',
            'Akun Admin Produser berhasil diperbarui.'
        );
    }


    // =========================================================
    // HAPUS AKSES / NONAKTIFKAN AKUN
    // =========================================================

    public function updateStatusProduser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',

            'status' => [
                'required',
                Rule::in([
                    'aktif',
                    'tidak_aktif',
                ]),
            ],
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $akun = User::where('id', $request->id)
            ->where('role', 'admin_produser')
            ->where(
                'id_jurusan_asal',
                $jurusan->id_jurusan
            )
            ->first();

        if (!$akun) {
            return response()->json([
                'message' => 'Akun Admin Produser tidak ditemukan.'
            ], 404);
        }

        $akun->update([
            'status' => $request->status,
        ]);

        $pesan = $request->status === 'aktif'
            ? 'Akses akun berhasil diaktifkan.'
            : 'Akses akun berhasil dinonaktifkan.';

        return response()->json([
            'success' => true,
            'message' => $pesan,
            'status' => $akun->status,
        ]);
    }


    // =========================================================
    // RESET PASSWORD ADMIN PRODUSER
    // =========================================================

    public function resetPasswordProduser(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:users,id',

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
            ],
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return response()->json([
                'message' => 'Akun ini belum memiliki jurusan.'
            ], 404);
        }

        $akun = User::where('id', $request->id)
            ->where('role', 'admin_produser')
            ->where(
                'id_jurusan_asal',
                $jurusan->id_jurusan
            )
            ->first();

        if (!$akun) {
            return response()->json([
                'message' => 'Akun Admin Produser tidak ditemukan.'
            ], 404);
        }

        $akun->update([
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password Admin Produser berhasil diubah.'
        ]);
    }


    // =========================================================
    // UPDATE DESKRIPSI JURUSAN
    // =========================================================

    public function updateDeskripsi(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusan->update([
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with(
            'success',
            'Deskripsi jurusan berhasil diperbarui!'
        );
    }


    // =========================================================
    // MEMBUAT ADMIN PRODUSER BARU
    // =========================================================

    public function storeProduser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:6',
            ],

            'layanan' => [
                'required',
                'array',
                'min:1',
            ],

            'layanan.*' => [
                'integer',
                'exists:produk_jasa,id_produk_jasa',
            ],
        ]);

        $user = Auth::user();
        $jurusan = $user->jurusanDipegang;

        if (!$jurusan) {
            return redirect()->back()->withErrors([
                'error' => 'Akun ini belum memiliki jurusan.'
            ]);
        }

        $jurusanId = $jurusan->id_jurusan;

        $produkJasas = ProdukJasa::whereIn(
            'id_produk_jasa',
            $request->layanan
        )
        ->where('id_jurusan', $jurusanId)
        ->get();

        if (
            $produkJasas->count() !==
            count($request->layanan)
        ) {
            return redirect()->back()->withErrors([
                'error' => 'Ada produk/jasa yang tidak berasal dari jurusan Anda.'
            ]);
        }

        $produser = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin_produser',
            'id_jurusan_asal' => $jurusanId,
            'status' => 'aktif',
        ]);

        foreach ($produkJasas as $produkJasa) {
            PenugasanProduser::create([
                'id_user_produser' => $produser->id,
                'id_produk_jasa' => $produkJasa->id_produk_jasa,
            ]);
        }

        return redirect(
            '/jurusan-admin/akun'
        )->with(
            'success',
            'Admin Produser berhasil ditambahkan.'
        );
    }
}