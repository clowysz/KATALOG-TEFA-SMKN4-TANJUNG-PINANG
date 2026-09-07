<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/faq', function () {
    return view('public.faq');
});

Route::get('/checkout', function () {
    return view('public.checkout');
});

// ======================================================
// RUTE KATALOG JURUSAN (PUBLIK)
// ======================================================

Route::get('/jurusan', function () {
    return view('public.jurusan.index'); // Halaman daftar semua jurusan
});

Route::prefix('jurusan')->group(function () {

    // ======================================================
    // RUTE DINAMIS UNTUK SEMUA JURUSAN (RPL, TKJ, ANIMASI, DKK)
    // ======================================================
    Route::prefix('{slug}')->group(function () {
        
        // Halaman Detail/Deskripsi Jurusan
        Route::get('/', function ($slug) {
            return view('public.jurusan.detail-jurusan');
        });

        // --- PORTOFOLIO ---
        Route::get('/portofolio', function ($slug) {
            return view('public.portofolio.index');
        });
        Route::get('/portofolio/detail/{id}', function ($slug, $id) {
            return view('public.portofolio.detail');
        })->name('portofolio.detail');

        // --- PRODUK ---
        Route::get('/produk', function ($slug) {
            return view('public.produk.index');
        });
        Route::get('/produk/detail/{id}', function ($slug, $id) {
            return view('public.produk.detail');
        })->name('produk.detail');

        // --- JASA ---
        Route::get('/jasa', function ($slug) {
            return view('public.jasa.index');
        });
        Route::get('/jasa/detail/{id}', function ($slug, $id) {
            return view('public.jasa.detail');
        })->name('jasa.detail');
        
    });

});


// ======================================================
// LOGIN SEMUA ADMIN
// ======================================================

Route::get('/login-admin', function () {
    return view('admin.login.login');
});


// ======================================================
// 1. ADMIN TEFA
// ======================================================

Route::get('/dashboard', function () {
    return view('admin.admin_tefa.dashboard');
});

Route::get('/pesanan', function () {
    return view('admin.admin_tefa.pesanan.index');
});

Route::get('/pesanan/detail', function () {
    return view('admin.admin_tefa.pesanan.detail');
});

Route::get('/tefa/jurusan', function () {
    return view('admin.admin_tefa.jurusan.index');
});


Route::get('/akun', function () {
    return view('admin.admin_tefa.akun.index');
});


Route::get('/akun/tambah', function () {
    return view('admin.admin_tefa.akun.create');
});

Route::get('/akun/detail', function () {
    return view('admin.admin_tefa.akun.detail');
});

Route::get('/akun/edit', function () {
    return view('admin.admin_tefa.akun.edit');
});

Route::get('/profil', function () {
    return view('admin.admin_tefa.profil.index');
});

Route::get('/tefa/faq', function () {
    return view('admin.admin_tefa.faq.index');
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