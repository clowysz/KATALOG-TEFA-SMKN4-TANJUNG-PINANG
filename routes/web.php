<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\FaqController;

// ======================================================
// BAGIAN PUBLIK / PEMBELI
// ======================================================

Route::get('/', function () { return view('public.home'); });
Route::get('/login-pembeli', function () { return view('public.login'); });
Route::get('/daftar-pembeli', function () { return view('public.daftar'); });
Route::get('/profil-pembeli', function () { return view('public.profil'); });
Route::get('/riwayat-pesanan', function () { return view('public.riwayat'); });
Route::get('/riwayat-pesanan/detail', function () { return view('public.riwayat-detail'); });
Route::get('/faq', function () { return view('public.faq'); });
Route::get('/checkout', function () { return view('public.checkout'); });
Route::get('/pencarian', function () { return view('public.pencarian'); });

// ======================================================
// RUTE KATALOG JURUSAN (PUBLIK)
// ======================================================

Route::get('/jurusan', function () { 
    return view('public.jurusan'); 
});

Route::prefix('jurusan')->group(function () {
    Route::prefix('{slug}')->group(function () {
        
        // FUNGSI PEMETA DATA DINAMIS PER JURUSAN
        $getJurusan = function($slug) {
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
                    'name' => 'PENGEMBANGAN PERANGKAT LUNAK DAN GIM',
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

            return (object) array_merge(['slug' => $slug], $data[$slug]);
        };

        // SEMUA RUTE DIBAWAH OTOMATIS MENGIRIM DATA $jurusan KE BLADE
        Route::get('/', function ($slug) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.jurusan.detail-jurusan', compact('jurusan', 'slug')); 
        });
        
        Route::get('/portofolio', function ($slug) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.portofolio.index', compact('jurusan', 'slug')); 
        });
        
        Route::get('/portofolio/detail/{id}', function ($slug, $id) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.portofolio.detail', compact('jurusan', 'slug', 'id')); 
        })->name('portofolio.detail');
        
        Route::get('/produk', function ($slug) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.produk.index', compact('jurusan', 'slug')); 
        });
        
        Route::get('/produk/detail/{id}', function ($slug, $id) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.produk.detail', compact('jurusan', 'slug', 'id')); 
        })->name('produk.detail');
        
        Route::get('/jasa', function ($slug) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.jasa.index', compact('jurusan', 'slug')); 
        });
        
        Route::get('/jasa/detail/{id}', function ($slug, $id) use ($getJurusan) { 
            $jurusan = $getJurusan($slug);
            return view('public.jasa.detail', compact('jurusan', 'slug', 'id')); 
        })->name('jasa.detail');
    });
});

// ======================================================
// LOGIN SEMUA ADMIN 
// ======================================================

Route::get('/login-tefa', function () { return view('admin.login.login-tefa'); });
Route::get('/login-jurusan', function () { return view('admin.admin_jurusan.login-jurusan'); });
Route::get('/login-produser', function () { return view('admin.admin_produser.login-produser'); });


// ======================================================
// 1. ADMIN TEFA 
// ======================================================

Route::get('/dashboard', function () { return view('admin.admin_tefa.dashboard'); });

// Rute Pesanan (Tanpa Database)
Route::get('/pesanan', function () { return view('admin.admin_tefa.pesanan.index'); });
Route::get('/pesanan/detail', function () { return view('admin.admin_tefa.pesanan.detail'); });

Route::get('/tefa/jurusan', function () { return view('admin.admin_tefa.jurusan.index'); });

// Rute Akun (Tanpa Database)
Route::get('/akun', function () { return view('admin.admin_tefa.akun.index'); });

Route::get('/profil', function () { return view('admin.admin_tefa.profil.index'); });

// Rute FAQ (Tanpa Database)
Route::get('/tefa/faq', function () { return view('admin.admin_tefa.faq.index'); });


// ======================================================
// 2. ADMIN JURUSAN
// ======================================================

Route::get('/jurusan-admin/dashboard', function () { return view('admin.admin_jurusan.dashboard'); });
Route::get('/jurusan-admin/katalog', function () { return view('admin.admin_jurusan.katalog'); });
Route::get('/jurusan-admin/katalog/detail', function () { return view('admin.admin_jurusan.katalog-detail'); });
Route::get('/jurusan-admin/kelola-produk', function () { return view('admin.admin_jurusan.kelola-produk'); });
Route::get('/jurusan-admin/kelola-jasa', function () { return view('admin.admin_jurusan.kelola-jasa'); });
Route::get('/jurusan-admin/kelola-portofolio', function () { return view('admin.admin_jurusan.kelola-portofolio'); });
Route::get('/jurusan-admin/kelola-deskripsi', function () { return view('admin.admin_jurusan.kelola-deskripsi'); });
Route::get('/jurusan-admin/akun', function () { return view('admin.admin_jurusan.akun-index'); });
Route::get('/jurusan-admin/akun/tambah', function () { return view('admin.admin_jurusan.akun-create'); });
Route::get('/jurusan-admin/akun/detail', function () { return view('admin.admin_jurusan.akun-detail'); });
Route::get('/jurusan-admin/akun/edit', function () { return view('admin.admin_jurusan.akun-edit'); });
Route::get('/jurusan-admin/profil', function () { return view('admin.admin_jurusan.profil'); });

Route::resource('jurusan-admin/faq', FaqController::class);

// ======================================================
// 3. ADMIN PRODUK / JASA (PRODUSER)
// ======================================================

Route::get('/produser/dashboard', function () { return view('admin.admin_produser.dashboard'); });
Route::get('/produser/pesanan', function () { return view('admin.admin_produser.pesanan'); });
Route::get('/produser/pesanan/detail', function () { return view('admin.admin_produser.pesanan-detail'); });
Route::get('/produser/katalog', function () { return view('admin.admin_produser.katalog'); });
Route::get('/produser/katalog/detail', function () { return view('admin.admin_produser.katalog-detail'); });
Route::get('/produser/profil', function () { return view('admin.admin_produser.profil'); });