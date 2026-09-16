<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthPembeliController;
use App\Http\Controllers\PesananPembeliController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminJurusanController;
use App\Http\Controllers\AdminProduserController;
use App\Http\Controllers\ProdukJasaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PenugasanProduserController;


// ======================================================
// 1. BAGIAN PUBLIK / PEMBELI
// ======================================================

Route::get('/', function () {
    return view('public.home');
});


// ------------------------------------------------------
// Login & Registrasi Pembeli
// ------------------------------------------------------

Route::get('/login-pembeli', [AuthPembeliController::class, 'showLogin'])
    ->name('pembeli.login');

Route::post('/login-pembeli', [AuthPembeliController::class, 'login'])
    ->name('pembeli.login.proses');

Route::get('/daftar-pembeli', [AuthPembeliController::class, 'showRegister'])
    ->name('pembeli.register');

Route::post('/daftar-pembeli', [AuthPembeliController::class, 'register'])
    ->name('pembeli.register.proses');

Route::post('/logout-pembeli', [AuthPembeliController::class, 'logout'])
    ->name('pembeli.logout');


// ------------------------------------------------------
// Halaman Publik
// ------------------------------------------------------

Route::get('/faq', function () {
    return view('public.faq');
});

Route::get('/pencarian', function () {
    return view('public.pencarian');
});


// ------------------------------------------------------
// Halaman khusus Pembeli yang sudah login
// ------------------------------------------------------

Route::middleware(['auth', 'role:pembeli'])->group(function () {

    Route::get('/profil-pembeli', function () {
        return view('public.profil');
    });

    Route::get('/riwayat-pesanan', function () {
        return view('public.riwayat');
    });

    Route::get('/riwayat-pesanan/detail', function () {
        return view('public.riwayat-detail');
    });

    Route::get('/checkout', function () {
        return view('public.checkout');
    });

    Route::post('/checkout', [PesananPembeliController::class, 'store'])
        ->name('pesanan.store');
});


// ------------------------------------------------------
// Daftar Jurusan
// ------------------------------------------------------

Route::get('/jurusan', function () {
    return view('public.jurusan');
});


// ------------------------------------------------------
// Detail Jurusan
// ------------------------------------------------------

Route::prefix('jurusan')->group(function () {

    Route::prefix('{slug}')->group(function () {

        $getJurusan = function ($slug) {

            $data = [

                'rpl' => [
                    'name' => 'REKAYASA PERANGKAT LUNAK',
                    'description' => 'Di SMKN 4 Tanjungpinang berfokus pada pengembangan bakat dan kompetensi siswa melalui pembelajaran berbasis proyek Teknologi Informasi.',
                    'logo' => 'images/logo-rpl.png',
                    'hero' => 'images/rpl-lab.jpeg',
                ],

                'tkj' => [
                    'name' => 'TEKNIK KOMPUTER DAN JARINGAN',
                    'description' => 'Berfokus pada instalasi jaringan komputer, administrasi server, troubleshooting hardware dan software jaringan secara profesional.',
                    'logo' => 'images/logo-tkj.png',
                    'hero' => 'images/tkj-lab.jpeg',
                ],

                'dkv' => [
                    'name' => 'DESAIN KOMUNIKASI VISUAL',
                    'description' => 'Berfokus pada seni komunikasi visual, desain media cetak, ilustrasi digital, perancangan branding, dan videografi kreatif.',
                    'logo' => 'images/logo-dkv.png',
                    'hero' => 'images/dkv-lab.jpeg',
                ],

                'gim' => [
                    'name' => 'GIM',
                    'description' => 'Mempelajari logika pemrograman gim, desain aset 2D/3D, animasi interaktif, serta perancangan engine permainan.',
                    'logo' => 'images/logo-gim.png',
                    'hero' => 'images/gim-lab.jpeg',
                ],

                'pspt' => [
                    'name' => 'PRODUKSI DAN SIARAN PROGRAM TELEVISI',
                    'description' => 'Mempelajari teknik produksi film, penyiaran televisi, editing video profesional, dan tata cahaya panggung/studio.',
                    'logo' => 'images/logo-pspt.png',
                    'hero' => 'images/pspt-lab.jpeg',
                ],

                'animasi' => [
                    'name' => 'ANIMASI',
                    'description' => 'Berfokus pada pembuatan animasi 2D dan 3D, modeling karakter, rigging, serta teknik visual effects (VFX) standar industri.',
                    'logo' => 'images/logo-animasi.png',
                    'hero' => 'images/anm-lab.jpeg',
                ],
            ];

            if (!array_key_exists($slug, $data)) {
                abort(404);
            }

            $jurusan = (object) array_merge(
                ['slug' => $slug],
                $data[$slug]
            );

            // Deskripsi panjang diambil dari database
            // sehingga dapat diubah oleh Admin Jurusan.
            $jurusanDb = \App\Models\Jurusan::where(
                'slug',
                $slug
            )->first();

            $jurusan->deskripsi_panjang =
                $jurusanDb->deskripsi ?? '';

            return $jurusan;
        };


        // --------------------------------------------------
        // Halaman utama jurusan
        // --------------------------------------------------

        Route::get('/', function ($slug) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.jurusan.detail-jurusan',
                compact('jurusan', 'slug')
            );
        });


        // --------------------------------------------------
        // Portfolio
        // --------------------------------------------------

        Route::get('/portofolio', function ($slug) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.portofolio.index',
                compact('jurusan', 'slug')
            );
        });

        Route::get('/portofolio/detail/{id}', function ($slug, $id) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.portofolio.detail',
                compact('jurusan', 'slug', 'id')
            );
        })->name('portofolio.detail');


        // --------------------------------------------------
        // Produk
        // --------------------------------------------------

        Route::get('/produk', function ($slug) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.produk.index',
                compact('jurusan', 'slug')
            );
        });

        Route::get('/produk/detail/{id}', function ($slug, $id) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.produk.detail',
                compact('jurusan', 'slug', 'id')
            );
        })->name('produk.detail');


        // --------------------------------------------------
        // Jasa
        // --------------------------------------------------

        Route::get('/jasa', function ($slug) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.jasa.index',
                compact('jurusan', 'slug')
            );
        });

        Route::get('/jasa/detail/{id}', function ($slug, $id) use ($getJurusan) {

            $jurusan = $getJurusan($slug);

            return view(
                'public.jasa.detail',
                compact('jurusan', 'slug', 'id')
            );
        })->name('jasa.detail');
    });
});


// ======================================================
// 2. OTENTIKASI ADMIN
// ======================================================

Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])
    ->name('admin.login');

Route::post('/admin/login', [LoginController::class, 'adminLogin'])
    ->name('admin.login.proses');

Route::post('/admin/logout', function () {

    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/admin/login');

})->name('admin.logout');


// ======================================================
// 3. ADMIN TEFA
// ======================================================

Route::middleware(['auth', 'role:admin_tefa'])->group(function () {

    // --------------------------------------------------
    // Dashboard
    // --------------------------------------------------

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.tefa.dashboard');


    // --------------------------------------------------
    // Pesanan
    // --------------------------------------------------

    Route::get('/pesanan', [PesananController::class, 'index'])
        ->name('pesanan.index');

    Route::get('/pesanan/detail', function () {
        return view('admin.admin_tefa.pesanan.detail');
    });

    Route::post(
        '/pesanan/{id}/update-status',
        [PesananController::class, 'updateStatus']
    )->name('pesanan.updateStatus');


    // CATATAN:
    // Tidak ada route DELETE pesanan.
    // Pesanan tidak dihapus karena harus tetap menjadi histori.


    // --------------------------------------------------
    // Jurusan
    // --------------------------------------------------

    Route::get('/tefa/jurusan', function () {
        return view('admin.admin_tefa.jurusan.index');
    });


    // --------------------------------------------------
    // Akun Admin Jurusan
    // --------------------------------------------------

    Route::get('/akun', [AkunController::class, 'index'])
        ->name('akun.index');

    Route::get('/akun/tambah', [AkunController::class, 'create'])
        ->name('akun.create');

    Route::post('/akun', [AkunController::class, 'store'])
        ->name('akun.store');


    // --------------------------------------------------
    // Profil Admin TEFA
    // --------------------------------------------------

    Route::get('/profil', function () {
        return view('admin.admin_tefa.profil.index');
    });


    // --------------------------------------------------
    // FAQ — HANYA ADMIN TEFA
    // --------------------------------------------------

    Route::get('/tefa/faq', [FaqController::class, 'index'])
        ->name('tefa.faq.index');

    Route::post('/tefa/faq', [FaqController::class, 'store'])
        ->name('tefa.faq.store');

    Route::delete('/tefa/faq/{id}', [FaqController::class, 'destroy'])
        ->name('tefa.faq.destroy');
});


// ======================================================
// 4. ADMIN JURUSAN
// ======================================================

Route::middleware(['auth', 'role:admin_jurusan'])->group(function () {

    // --------------------------------------------------
    // Dashboard
    // --------------------------------------------------

    Route::get(
        '/jurusan-admin/dashboard',
        [AdminJurusanController::class, 'dashboard']
    )->name('admin.jurusan.dashboard');


    // --------------------------------------------------
    // Katalog
    // --------------------------------------------------

    Route::get('/jurusan-admin/katalog', function () {
        return view('admin.admin_jurusan.katalog');
    });

    Route::get('/jurusan-admin/katalog/detail', function () {
        return view('admin.admin_jurusan.katalog-detail');
    });


    // --------------------------------------------------
    // Kelola Produk
    // --------------------------------------------------

    Route::get('/jurusan-admin/kelola-produk', function () {
        return view('admin.admin_jurusan.kelola-produk');
    });


    // --------------------------------------------------
    // Kelola Jasa
    // --------------------------------------------------

    Route::get('/jurusan-admin/kelola-jasa', function () {
        return view('admin.admin_jurusan.kelola-jasa');
    });


    // --------------------------------------------------
    // Kelola Portfolio
    // --------------------------------------------------

    Route::get('/jurusan-admin/kelola-portofolio', function () {
        return view('admin.admin_jurusan.kelola-portofolio');
    });


    // --------------------------------------------------
    // Kelola Deskripsi
    // --------------------------------------------------

    Route::get('/jurusan-admin/kelola-deskripsi', function () {
        return view('admin.admin_jurusan.kelola-deskripsi');
    });

    Route::post(
        '/jurusan-admin/kelola-deskripsi',
        [AdminJurusanController::class, 'updateDeskripsi']
    )->name('jurusan.updateDeskripsi');


    // --------------------------------------------------
    // Penugasan Admin Produksi
    // --------------------------------------------------

    Route::get(
        '/jurusan-admin/penugasan-produser',
        [PenugasanProduserController::class, 'index']
    )->name('admin.jurusan.penugasan.index');

    Route::post(
        '/jurusan-admin/penugasan-produser',
        [PenugasanProduserController::class, 'store']
    )->name('admin.jurusan.penugasan.store');

    Route::delete(
        '/jurusan-admin/penugasan-produser/{id}',
        [PenugasanProduserController::class, 'destroy']
    )->name('admin.jurusan.penugasan.destroy');


    // --------------------------------------------------
    // Akun Admin Produksi
    // --------------------------------------------------

    Route::get('/jurusan-admin/akun', function () {
        return view('admin.admin_jurusan.akun-index');
    });

    Route::get('/jurusan-admin/akun/tambah', function () {
        return view('admin.admin_jurusan.akun-create');
    });

    Route::post(
        '/jurusan-admin/akun',
        [AdminJurusanController::class, 'storeProduser']
    )->name('jurusan.akun.store');

    Route::get('/jurusan-admin/akun/detail', function () {
        return view('admin.admin_jurusan.akun-detail');
    });

    Route::get('/jurusan-admin/akun/edit', function () {
        return view('admin.admin_jurusan.akun-edit');
    });


    // --------------------------------------------------
    // Profil Admin Jurusan
    // --------------------------------------------------

    Route::get('/jurusan-admin/profil', function () {
        return view('admin.admin_jurusan.profil');
    });


    // --------------------------------------------------
    // FAQ
    // --------------------------------------------------
    // FAQ sengaja tidak tersedia untuk Admin Jurusan.
    // FAQ hanya dikelola Admin TEFA.


    // --------------------------------------------------
    // Produk & Jasa
    // --------------------------------------------------

    Route::post(
        '/jurusan-admin/produk',
        [ProdukJasaController::class, 'store']
    )->name('produk.store');

    Route::delete(
        '/jurusan-admin/produk/{id}',
        [ProdukJasaController::class, 'destroy']
    )->name('produk.destroy');

    Route::delete(
        '/jurusan-admin/produk/gambar/{id_gambar}',
        [ProdukJasaController::class, 'destroyGambar']
    )->name('produk.destroyGambar');


    // --------------------------------------------------
    // Portfolio
    // --------------------------------------------------

    Route::post(
        '/jurusan-admin/portofolio',
        [PortfolioController::class, 'store']
    )->name('portofolio.store');

    Route::delete(
        '/jurusan-admin/portofolio/{id}',
        [PortfolioController::class, 'destroy']
    )->name('portofolio.destroy');

    Route::delete(
        '/jurusan-admin/portofolio/gambar/{id_gambar_portfolio}',
        [PortfolioController::class, 'destroyGambar']
    )->name('portofolio.destroyGambar');
});


// ======================================================
// 5. ADMIN PRODUK / JASA (PRODUSER)
// ======================================================

Route::middleware(['auth', 'role:admin_produser'])->group(function () {

    // --------------------------------------------------
    // Dashboard
    // --------------------------------------------------

    Route::get(
        '/produser/dashboard',
        [AdminProduserController::class, 'dashboard']
    )->name('admin.produser.dashboard');


    // --------------------------------------------------
    // Pesanan
    // --------------------------------------------------

    Route::get('/produser/pesanan', function () {
        return view('admin.admin_produser.pesanan');
    });

    Route::get('/produser/pesanan/detail', function () {
        return view('admin.admin_produser.pesanan-detail');
    });


    // --------------------------------------------------
    // Update Progress
    // --------------------------------------------------

    Route::post(
        '/produser/pesanan/{id_pesanan}/update-progress',
        [AdminProduserController::class, 'updateProgress']
    )->name('produser.updateProgress');


    // --------------------------------------------------
    // Katalog
    // --------------------------------------------------

    Route::get('/produser/katalog', function () {
        return view('admin.admin_produser.katalog');
    });

    Route::get('/produser/katalog/detail', function () {
        return view('admin.admin_produser.katalog-detail');
    });


    // --------------------------------------------------
    // Profil
    // --------------------------------------------------

    Route::get('/produser/profil', function () {
        return view('admin.admin_produser.profil');
    });
});