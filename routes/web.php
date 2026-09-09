<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\FaqController;

// ======================================================
// BAGIAN PUBLIK / PEMBELI
// ======================================================

Route::get('/', function () {
    return view('public.home');
});

Route::get('/login-pembeli', function () {
    return view('public.login');
});

Route::get('/daftar-pembeli', function () {
    return view('public.daftar');
});

Route::get('/profil-pembeli', function () {
    return view('public.profil');
});

Route::get('/riwayat-pesanan', function () {
    return view('public.riwayat');
});

Route::get('/riwayat-pesanan/detail', function () {
    return view('public.riwayat-detail');
});

// ======================================================
// FAQ PEMBELI
// ======================================================

Route::get('/faq', [FaqController::class, 'index'])
    ->name('faq.index');

Route::get('/checkout', function () {
    return view('public.checkout');
});

Route::get('/pencarian', function () {
    return view('public.pencarian');
});


// ======================================================
// KATALOG JURUSAN PUBLIK
// ======================================================

Route::prefix('jurusan')->group(function () {

    // Jurusan berdasarkan slug
    Route::prefix('{slug}')->group(function () {

        Route::get('/', function ($slug) {
            return view('public.jurusan.detail-jurusan');
        });

        Route::get('/portofolio', function ($slug) {
            return view('public.portofolio.index');
        });

        Route::get('/portofolio/detail/{id}', function ($slug, $id) {
            return view('public.portofolio.detail');
        })->name('portofolio.detail');

        Route::get('/produk', function ($slug) {
            return view('public.produk.index');
        });

        Route::get('/produk/detail/{id}', function ($slug, $id) {
            return view('public.produk.detail');
        })->name('produk.detail');

        Route::get('/jasa', function ($slug) {
            return view('public.jasa.index');
        });

        Route::get('/jasa/detail/{id}', function ($slug, $id) {
            return view('public.jasa.detail');
        })->name('jasa.detail');
    });


    // ==================================================
    // GIM
    // ==================================================

    Route::prefix('gim')->group(function () {

        Route::get('/', function () {
            return view('public.jurusan.gim.index');
        });

        Route::get('/portofolio', function () {
            return view('public.jurusan.gim.portofolio');
        });

        Route::get('/produk', function () {
            return view('public.jurusan.gim.produk');
        });

        Route::get('/jasa', function () {
            return view('public.jurusan.gim.jasa');
        });
    });


    // ==================================================
    // TKJ
    // ==================================================

    Route::prefix('tkj')->group(function () {

        Route::get('/', function () {
            return view('public.jurusan.tkj.index');
        });

        Route::get('/portofolio', function () {
            return view('public.jurusan.tkj.portofolio');
        });

        Route::get('/produk', function () {
            return view('public.jurusan.tkj.produk');
        });

        Route::get('/jasa', function () {
            return view('public.jurusan.tkj.jasa');
        });
    });


    // ==================================================
    // PSPT
    // ==================================================

    Route::prefix('pspt')->group(function () {

        Route::get('/', function () {
            return view('public.jurusan.pspt.index');
        });

        Route::get('/portofolio', function () {
            return view('public.jurusan.pspt.portofolio');
        });

        Route::get('/produk', function () {
            return view('public.jurusan.pspt.produk');
        });

        Route::get('/jasa', function () {
            return view('public.jurusan.pspt.jasa');
        });
    });


    // ==================================================
    // DKV
    // ==================================================

    Route::prefix('dkv')->group(function () {

        Route::get('/', function () {
            return view('public.jurusan.dkv.index');
        });

        Route::get('/portofolio', function () {
            return view('public.jurusan.dkv.portofolio');
        });

        Route::get('/produk', function () {
            return view('public.jurusan.dkv.produk');
        });

        Route::get('/jasa', function () {
            return view('public.jurusan.dkv.jasa');
        });
    });


    // ==================================================
    // ANIMASI
    // ==================================================

    Route::prefix('animasi')->group(function () {

        Route::get('/', function () {
            return view('public.jurusan.animasi.index');
        });

        Route::get('/portofolio', function () {
            return view('public.jurusan.animasi.portofolio');
        });

        Route::get('/produk', function () {
            return view('public.jurusan.animasi.produk');
        });

        Route::get('/jasa', function () {
            return view('public.jurusan.animasi.jasa');
        });
    });
});


// ======================================================
// LOGIN SEMUA ADMIN
// ======================================================

Route::get('/login-tefa', function () {
    return view('admin.login.login-tefa');
});

Route::get('/login-jurusan', function () {
    return view('admin.admin_jurusan.login-jurusan');
});

Route::get('/login-produser', function () {
    return view('admin.admin_produser.login-produser');
});


// ======================================================
// 1. ADMIN TEFA
// ======================================================

// Dashboard
Route::get('/dashboard', function () {
    return view('admin.admin_tefa.dashboard');
});


// ======================================================
// PESANAN ADMIN TEFA
// ======================================================

Route::get('/pesanan', [PesananController::class, 'index'])
    ->name('pesanan.index');

Route::put('/pesanan/{id}/status', [PesananController::class, 'updateStatus'])
    ->name('pesanan.updateStatus');

Route::get('/pesanan/detail', function () {
    return view('admin.admin_tefa.pesanan.detail');
});


// ======================================================
// JURUSAN ADMIN TEFA
// ======================================================

Route::get('/jurusan', function () {
    return view('admin.admin_tefa.jurusan.index');
})->name('jurusan.index');


// ======================================================
// AKUN ADMIN TEFA
// ======================================================

Route::get('/akun', [AkunController::class, 'index'])
    ->name('akun.index');

Route::get('/akun/tambah', [AkunController::class, 'create'])
    ->name('akun.create');

Route::post('/akun', [AkunController::class, 'store'])
    ->name('akun.store');

Route::get('/akun/{id}', [AkunController::class, 'show'])
    ->name('akun.show');

Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])
    ->name('akun.edit');

Route::put('/akun/{id}', [AkunController::class, 'update'])
    ->name('akun.update');

Route::put('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])
    ->name('akun.reset-password');

Route::put('/akun/{id}/hapus-akses', [AkunController::class, 'hapusAkses'])
    ->name('akun.hapus-akses');


// ======================================================
// FAQ ADMIN TEFA
// ======================================================

Route::prefix('admin')->group(function () {

    // Daftar FAQ
    Route::get('/faq', [FaqController::class, 'adminIndex'])
        ->name('admin.faq.index');

    // Tambah FAQ
    Route::get('/faq/create', [FaqController::class, 'create'])
        ->name('admin.faq.create');

    // Simpan FAQ
    Route::post('/faq', [FaqController::class, 'store'])
        ->name('admin.faq.store');

    // Edit FAQ
    Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])
        ->name('admin.faq.edit');

    // Update FAQ
    Route::put('/faq/{id}', [FaqController::class, 'update'])
        ->name('admin.faq.update');

    // Hapus FAQ
    Route::delete('/faq/{id}', [FaqController::class, 'destroy'])
        ->name('admin.faq.destroy');
});

    Route::get('/profil', function () {
    return view('admin.admin_tefa.profil.index');
});



// ======================================================
// 2. ADMIN JURUSAN
// ======================================================

Route::get('/jurusan-admin/dashboard', function () {
    return view('admin.admin_jurusan.dashboard');
});

Route::get('/jurusan-admin/katalog', function () {
    return view('admin.admin_jurusan.katalog');
});

Route::get('/jurusan-admin/katalog/detail', function () {
    return view('admin.admin_jurusan.katalog-detail');
});

Route::get('/jurusan-admin/kelola-produk', function () {
    return view('admin.admin_jurusan.kelola-produk');
});

Route::get('/jurusan-admin/kelola-jasa', function () {
    return view('admin.admin_jurusan.kelola-jasa');
});

Route::get('/jurusan-admin/kelola-portofolio', function () {
    return view('admin.admin_jurusan.kelola-portofolio');
});

Route::get('/jurusan-admin/kelola-deskripsi', function () {
    return view('admin.admin_jurusan.kelola-deskripsi');
});

Route::get('/jurusan-admin/akun', function () {
    return view('admin.admin_jurusan.akun-index');
});

Route::get('/jurusan-admin/akun/tambah', function () {
    return view('admin.admin_jurusan.akun-create');
});

Route::get('/jurusan-admin/akun/detail', function () {
    return view('admin.admin_jurusan.akun-detail');
});

Route::get('/jurusan-admin/akun/edit', function () {
    return view('admin.admin_jurusan.akun-edit');
});

Route::get('/jurusan-admin/profil', function () {
    return view('admin.admin_jurusan.profil');
});


// ======================================================
// 3. ADMIN PRODUK / JASA (PRODUSER)
// ======================================================

Route::get('/produser/dashboard', function () {
    return view('admin.admin_produser.dashboard');
});

Route::get('/produser/pesanan', function () {
    return view('admin.admin_produser.pesanan');
});

Route::get('/produser/pesanan/detail', function () {
    return view('admin.admin_produser.pesanan-detail');
});

Route::get('/produser/katalog', function () {
    return view('admin.admin_produser.katalog');
});

Route::get('/produser/katalog/detail', function () {
    return view('admin.admin_produser.katalog-detail');
});

Route::get('/produser/profil', function () {
    return view('admin.admin_produser.profil');
});