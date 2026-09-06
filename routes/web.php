<?php

use Illuminate\Support\Facades\Route;

// ================= BAGIAN PUBLIK / PEMBELI =================

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

// ================= RUTE KATALOG JURUSAN (PUBLIK) =================
Route::get('/jurusan', function () {
    return view('public.jurusan.index'); // Halaman daftar seluruh Jurusan Unggulan
});

Route::prefix('jurusan')->group(function () {
    
// 1. Rekayasa Perangkat Lunak (RPL)
    Route::prefix('rpl')->group(function () {
        Route::get('/', function () { return view('public.jurusan.rpl.index'); });
        
        Route::get('/portofolio', function () { return view('public.jurusan.rpl.portofolio'); });
        Route::get('/portofolio/detail', function () { return view('public.jurusan.rpl.detail-portofolio'); });
        
        Route::get('/produk', function () { return view('public.jurusan.rpl.produk'); });
        Route::get('/produk/detail', function () { return view('public.jurusan.rpl.detail-produk'); });
        
        Route::get('/jasa', function () { return view('public.jurusan.rpl.jasa'); });
        Route::get('/jasa/detail', function () { return view('public.jurusan.rpl.detail-jasa'); });
    });

    // 2. Pemrograman GIM
    Route::prefix('gim')->group(function () {
        Route::get('/', function () { return view('public.jurusan.gim.index'); });
        Route::get('/portofolio', function () { return view('public.jurusan.gim.portofolio'); });
        Route::get('/produk', function () { return view('public.jurusan.gim.produk'); });
        Route::get('/jasa', function () { return view('public.jurusan.gim.jasa'); });
    });

    // 3. Teknik Komputer & Jaringan (TKJ)
    Route::prefix('tkj')->group(function () {
        Route::get('/', function () { return view('public.jurusan.tkj.index'); });
        Route::get('/portofolio', function () { return view('public.jurusan.tkj.portofolio'); });
        Route::get('/produk', function () { return view('public.jurusan.tkj.produk'); });
        Route::get('/jasa', function () { return view('public.jurusan.tkj.jasa'); });
    });

    // 4. Produksi & Siaran Program Televisi (PSPT)
    Route::prefix('pspt')->group(function () {
        Route::get('/', function () { return view('public.jurusan.pspt.index'); });
        Route::get('/portofolio', function () { return view('public.jurusan.pspt.portofolio'); });
        Route::get('/produk', function () { return view('public.jurusan.pspt.produk'); });
        Route::get('/jasa', function () { return view('public.jurusan.pspt.jasa'); });
    });

    // 5. Desain Komunikasi Visual (DKV)
    Route::prefix('dkv')->group(function () {
        Route::get('/', function () { return view('public.jurusan.dkv.index'); });
        Route::get('/portofolio', function () { return view('public.jurusan.dkv.portofolio'); });
        Route::get('/produk', function () { return view('public.jurusan.dkv.produk'); });
        Route::get('/jasa', function () { return view('public.jurusan.dkv.jasa'); });
    });

    // 6. Animasi
    Route::prefix('animasi')->group(function () {
        Route::get('/', function () { return view('public.jurusan.animasi.index'); });
        Route::get('/portofolio', function () { return view('public.jurusan.animasi.portofolio'); });
        Route::get('/produk', function () { return view('public.jurusan.animasi.produk'); });
        Route::get('/jasa', function () { return view('public.jurusan.animasi.jasa'); });
    });

});


// ================= RUTE LOGIN SEMUA ADMIN =================

Route::get('/login-tefa', function () {
    return view('admin.login.login-tefa'); 
});

Route::get('/login-jurusan', function () {
    return view('admin.admin_jurusan.login-jurusan'); 
});

Route::get('/login-produser', function () {
    return view('admin.admin_produser.login-produser'); 
});


// ================= 1. ADMIN TEFA =================

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



// ================= 2. ADMIN JURUSAN =================

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



// ================= 3. ADMIN PRODUK/JASA (PRODUSER) =================

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