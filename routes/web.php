<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthPembeliController;
use App\Http\Controllers\AuthForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\KatalogTefaController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\ProdukJasaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\AdminProduserController;
use App\Http\Controllers\PesananPembeliController;
use App\Http\Controllers\PencarianController;
use App\Http\Controllers\KatalogPublikController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\JurusanPublikController;

// 
// PUBLIK
// 

Route::view('/', 'public.home');

Route::get('/faq', [FaqController::class, 'publik'])
    ->name('public.faq');

Route::get('/customer-service', [CustomerServiceController::class, 'index'])
    ->name('customer.service');

Route::get('/pencarian', [PencarianController::class, 'index'])
    ->name('public.pencarian');

Route::get('/katalog', [KatalogPublikController::class, 'index'])
    ->name('public.katalog');


// 
// AUTH (LOGIN SATU DOMAIN)
// 

Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.proses');

// Logout semua role
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Alias logout admin lama (supaya route yang masih memakai admin.logout tidak error)
Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->name('admin.logout');

// Lupa sandi
Route::get('/lupa-sandi', [AuthForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/lupa-sandi', [AuthForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-sandi/{token}', [AuthForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-sandi', [AuthForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');

// Register pembeli
Route::get('/daftar-pembeli', [AuthPembeliController::class, 'showRegister'])
    ->name('pembeli.register');

Route::post('/daftar-pembeli', [AuthPembeliController::class, 'register'])
    ->name('pembeli.register.proses');


// 
// JURUSAN PUBLIK
// 

Route::prefix('jurusan/{slug}')
    ->controller(JurusanPublikController::class)
    ->group(function () {

        Route::get('/', 'show');

        Route::get('/portofolio', 'portofolio');
        Route::get('/portofolio/detail/{id}', 'portofolioDetail')
            ->name('portofolio.detail');

        Route::get('/produk', 'produk');
        Route::get('/produk/detail/{id}', 'produkDetail')
            ->name('produk.detail');

        Route::get('/jasa', 'jasa');
        Route::get('/jasa/detail/{id}', 'jasaDetail')
            ->name('jasa.detail');
    });


// 
// PEMBELI
// 

Route::middleware(['auth', 'role:pembeli'])->group(function () {

    Route::view('/profil-pembeli', 'public.profil')
        ->name('profil.pembeli');

    Route::get('/riwayat-pesanan', [PesananPembeliController::class, 'riwayat'])
        ->name('pembeli.riwayat');

    Route::get('/riwayat-pesanan/detail/{id_pesanan}', [PesananPembeliController::class, 'detail'])
        ->name('pembeli.riwayat.detail');

    Route::get('/checkout', [PesananPembeliController::class, 'checkout'])
        ->name('pesanan.checkout');

    Route::post('/checkout', [PesananPembeliController::class, 'store'])
        ->name('pesanan.store');
    Route::post('/riwayat-pesanan/{id_pesanan}/batalkan',[PesananPembeliController::class, 'batalkan'])->name('pembeli.pesanan.batalkan');
    Route::delete('/riwayat-pesanan/{id_pesanan}/hapus',[PesananPembeliController::class, 'hapusRiwayat'])->name('pembeli.riwayat.hapus');
});


// 
// ADMIN TEFA
// 

Route::middleware(['auth', 'role:admin_tefa'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.tefa.dashboard');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])
        ->name('pesanan.index');

    Route::get('/pesanan/detail/{id}', [PesananController::class, 'show'])
        ->name('pesanan.detail');

    Route::post('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])
        ->name('pesanan.updateStatus');

    Route::get('/tefa/jurusan', [DashboardController::class, 'jurusan'])
        ->name('admin.tefa.jurusan');
    
    // Permintaan pembatalan pesanan
    Route::get(
        '/pesanan/permintaan-pembatalan',
        [PesananController::class, 'permintaanPembatalan']
    )->name('pesanan.permintaan-pembatalan.index');

    Route::post(
        '/pesanan/permintaan-pembatalan/{id_permintaan}/setujui',
        [PesananController::class, 'setujuiPembatalan']
    )->name('pesanan.permintaan-pembatalan.setujui');

    Route::post(
        '/pesanan/permintaan-pembatalan/{id_permintaan}/tolak',
        [PesananController::class, 'tolakPembatalan']
    )->name('pesanan.permintaan-pembatalan.tolak');


    // Katalog gabungan TEFA
    Route::get('/katalog-gabungan', [KatalogTefaController::class, 'index'])
        ->name('admin.tefa.katalog_gabungan');

    Route::get('/katalog-gabungan/{id}', [KatalogTefaController::class, 'show'])
        ->name('admin.tefa.katalog_detail');

    Route::post('/katalog-gabungan/pdf', [KatalogTefaController::class, 'generatePdf'])
        ->name('admin.tefa.katalog_pdf');

    // Akun
    Route::get('/akun', [AkunController::class, 'index'])->name('akun.index');
    Route::get('/akun/tambah', [AkunController::class, 'create'])->name('akun.create');
    Route::post('/akun', [AkunController::class, 'store'])->name('akun.store');
    Route::get('/akun/{id}', [AkunController::class, 'show'])->name('akun.show');
    Route::get('/akun/{id}/edit', [AkunController::class, 'edit'])->name('akun.edit');
    Route::put('/akun/{id}', [AkunController::class, 'update'])->name('akun.update');
    Route::put('/akun/{id}/status', [AkunController::class, 'updateStatus'])->name('akun.updateStatus');
    Route::put('/akun/{id}/reset-password', [AkunController::class, 'resetPassword'])->name('akun.resetPassword');

    // Profil
    Route::view('/profil', 'admin.admin_tefa.profil.index')
        ->name('admin.tefa.profil');

    // FAQ
    Route::get('/tefa/faq', [FaqController::class, 'index'])->name('tefa.faq.index');
    Route::get('/tefa/faq/create', [FaqController::class, 'create'])->name('tefa.faq.create');
    Route::post('/tefa/faq', [FaqController::class, 'store'])->name('tefa.faq.store');
    Route::get('/tefa/faq/{id}/edit', [FaqController::class, 'edit'])->name('tefa.faq.edit');
    Route::put('/tefa/faq/{id}', [FaqController::class, 'update'])->name('tefa.faq.update');
    Route::delete('/tefa/faq/{id}', [FaqController::class, 'destroy'])->name('tefa.faq.destroy');
});


// 
// ADMIN JURUSAN
// 

Route::middleware(['auth', 'role:admin_jurusan'])->group(function () {

    Route::get('/jurusan-admin/dashboard', [AdminJurusanController::class, 'dashboard'])
        ->name('admin.jurusan.dashboard');

    // Halaman statis
    Route::view('/jurusan-admin/katalog', 'admin.admin_jurusan.katalog');
    Route::view('/jurusan-admin/katalog/detail', 'admin.admin_jurusan.katalog-detail');
    Route::view('/jurusan-admin/kelola-produk', 'admin.admin_jurusan.kelola-produk');
    Route::view('/jurusan-admin/kelola-jasa', 'admin.admin_jurusan.kelola-jasa');
    Route::view('/jurusan-admin/kelola-portofolio', 'admin.admin_jurusan.kelola-portofolio');

    // Deskripsi jurusan
    Route::get('/jurusan-admin/kelola-deskripsi', [AdminJurusanController::class, 'deskripsi'])
        ->name('jurusan.deskripsi.index');

    Route::post('/jurusan-admin/kelola-deskripsi', [AdminJurusanController::class, 'updateDeskripsi'])
        ->name('jurusan.updateDeskripsi');

    // Akun produser
    Route::get('/jurusan-admin/akun', [AdminJurusanController::class, 'akun'])
        ->name('jurusan.akun.index');

    Route::get('/jurusan-admin/akun/tambah', [AdminJurusanController::class, 'createProduser'])
        ->name('jurusan.akun.create');

    Route::post('/jurusan-admin/akun', [AdminJurusanController::class, 'storeProduser'])
        ->name('jurusan.akun.store');

    Route::get('/jurusan-admin/akun/detail', [AdminJurusanController::class, 'detailProduser'])
        ->name('jurusan.akun.detail');

    Route::get('/jurusan-admin/akun/edit', [AdminJurusanController::class, 'editProduser'])
        ->name('jurusan.akun.edit');

    Route::put('/jurusan-admin/akun', [AdminJurusanController::class, 'updateProduser'])
        ->name('jurusan.akun.update');

    Route::put('/jurusan-admin/akun/status', [AdminJurusanController::class, 'updateStatusProduser'])
        ->name('jurusan.akun.status');

    Route::put('/jurusan-admin/akun/reset-password', [AdminJurusanController::class, 'resetPasswordProduser'])
        ->name('jurusan.akun.resetPassword');

    Route::view('/jurusan-admin/profil', 'admin.admin_jurusan.profil')
        ->name('jurusan.profil');

    // Produk
    Route::get('/jurusan-admin/produk', [ProdukJasaController::class, 'index'])->name('produk.index');
    Route::post('/jurusan-admin/produk', [ProdukJasaController::class, 'store'])->name('produk.store');
    Route::put('/jurusan-admin/produk/{id}', [ProdukJasaController::class, 'update'])->name('produk.update');
    Route::delete('/jurusan-admin/produk/{id}', [ProdukJasaController::class, 'destroy'])->name('produk.destroy');
    Route::delete('/jurusan-admin/produk/gambar/{id_gambar}', [ProdukJasaController::class, 'destroyGambar'])
        ->name('produk.destroyGambar');

    // Portofolio
    Route::get('/jurusan-admin/portofolio', [PortfolioController::class, 'index'])->name('portofolio.index');
    Route::post('/jurusan-admin/portofolio', [PortfolioController::class, 'store'])->name('portofolio.store');
    Route::put('/jurusan-admin/portofolio/{id}', [PortfolioController::class, 'update'])->name('portofolio.update');
    Route::delete('/jurusan-admin/portofolio/{id}', [PortfolioController::class, 'destroy'])->name('portofolio.destroy');
});


// 
// ADMIN PRODUSER
// 

Route::middleware(['auth', 'role:admin_produser'])->group(function () {

    Route::get('/produser/dashboard', [AdminProduserController::class, 'dashboard'])
        ->name('admin.produser.dashboard');

    Route::get('/produser/pesanan', [AdminProduserController::class, 'pesanan'])
        ->name('admin.produser.pesanan');

    Route::get('/produser/pesanan/detail/{id_pesanan}', [AdminProduserController::class, 'showPesanan'])
        ->name('admin.produser.pesanan.detail');

    Route::post('/produser/pesanan/{id_pesanan}/update-progress', [AdminProduserController::class, 'updateProgress'])
        ->name('produser.updateProgress');

    // Tahapan pengerjaan
    Route::post('/produser/pesanan/{id_pesanan}/tahapan', [AdminProduserController::class, 'storeTahapan'])
        ->name('produser.tahapan.store');

    Route::put('/produser/pesanan/{id_pesanan}/tahapan/{id_tahapan}', [AdminProduserController::class, 'updateTahapan'])
        ->name('produser.tahapan.update');

    Route::delete('/produser/pesanan/{id_pesanan}/tahapan/{id_tahapan}', [AdminProduserController::class, 'destroyTahapan'])
        ->name('produser.tahapan.destroy');

    Route::post('/produser/pesanan/{id_pesanan}/tahapan/reorder', [AdminProduserController::class, 'reorderTahapan'])
        ->name('produser.tahapan.reorder');

    // Katalog produser
    Route::get('/produser/katalog', [AdminProduserController::class, 'katalog'])
        ->name('admin.produser.katalog');

    Route::get('/produser/katalog/detail/{id_produk_jasa}', [AdminProduserController::class, 'showKatalog'])
        ->name('admin.produser.katalog.detail');

    // Profil produser
    Route::get('/produser/profil', [AdminProduserController::class, 'profil'])
        ->name('admin.produser.profil');
});