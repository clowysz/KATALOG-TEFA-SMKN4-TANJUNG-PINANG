<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthPembeliController;
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

Route::get('/debug-chrome', function () {
    $chrome = config('laravel-pdf.chrome.chrome_binary');

    $profile = storage_path('app/debug-chrome-profile');

    if (!is_dir($profile)) {
        mkdir($profile, 0777, true);
    }

    $command = '"' . $chrome . '"'
        . ' --headless'
        . ' --disable-gpu'
        . ' --no-sandbox'
        . ' --remote-debugging-port=9224'
        . ' --user-data-dir="' . $profile . '"'
        . ' about:blank';

    exec($command . ' 2>&1', $output, $exitCode);

    return response()->json([
        'exit_code' => $exitCode,
        'output' => $output,
        'command' => $command,
    ]);
});
// =========================================================================
// PUBLIK
// =========================================================================

Route::get('/', fn () => view('public.home'));


// =========================================================================
// LOGIN SATU DOMAIN
// =========================================================================

// Satu halaman login untuk semua role
Route::get('/login', [LoginController::class, 'showLogin'])
    ->name('login');

// Proses login semua role
Route::post('/login', [LoginController::class, 'login'])
    ->name('login.proses');

// Register pembeli
Route::get('/daftar-pembeli', [AuthPembeliController::class, 'showRegister'])
    ->name('pembeli.register');

Route::post('/daftar-pembeli', [AuthPembeliController::class, 'register'])
    ->name('pembeli.register.proses');

// Logout semua role
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');

// Alias logout admin lama
// Dipertahankan supaya route yang masih memakai admin.logout
// tidak error.
Route::post('/admin/logout', [LoginController::class, 'logout'])
    ->name('admin.logout');


// =========================================================================
// FAQ PUBLIK
// =========================================================================

Route::get('/faq', function () {

    $faqs = \App\Models\Faq::latest('id_faq')->get();

    return view('public.faq', compact('faqs'));

})->name('public.faq');

// CUSTOMER SERVICE
Route::get('/customer-service', function () {

    // Belum login
   if (!Auth::check()) {
    return redirect()->route('login', [
        'redirect' => '/customer-service',
        'back' => url()->previous()
    ]);
}

    // Cek apakah akun ini punya pesanan
    $hasPesanan = \App\Models\Pesanan::where('id_user', Auth::id())->exists();

    if ($hasPesanan) {
        return redirect()->away('https://wa.me/6289653628650');
    }

    return view('public.customer-service');

})->name('customer.service');
// =====================================================
// PENCARIAN PUBLIK
// =========================================================================

Route::get('/pencarian', function (Request $request) {

    $keyword = trim($request->query('keyword', ''));

    $results = \App\Models\ProdukJasa::with([
        'gambars',
        'jurusan'
    ])
        ->when($keyword !== '', function ($query) use ($keyword) {

            $query->where(function ($q) use ($keyword) {

                $q->where(
                    'nama_produk_jasa',
                    'like',
                    '%' . $keyword . '%'
                )
                ->orWhere(
                    'deskripsi',
                    'like',
                    '%' . $keyword . '%'
                )
                ->orWhere(
                    'jenis',
                    'like',
                    '%' . $keyword . '%'
                );

            });

        })
        ->latest()
        ->get();

    return view(
        'public.pencarian',
        compact('results', 'keyword')
    );

})->name('public.pencarian');


// =========================================================================
// KATALOG PUBLIK
// =========================================================================

Route::get('/katalog', function (Request $request) {

    $keyword = trim($request->query('keyword', ''));

    $jenis = $request->query('jenis', 'semua');

    $id_jurusan = $request->query(
        'jurusan',
        'semua'
    );

    $query = \App\Models\ProdukJasa::with([
        'gambars',
        'jurusan'
    ]);

    if (in_array($jenis, ['produk', 'jasa'])) {

        $query->where(
            'jenis',
            $jenis
        );

    }

    if ($id_jurusan !== 'semua') {

        $query->where(
            'id_jurusan',
            $id_jurusan
        );

    }

    if ($keyword !== '') {

        $query->where(function ($q) use ($keyword) {

            $q->where(
                'nama_produk_jasa',
                'like',
                '%' . $keyword . '%'
            )
            ->orWhere(
                'deskripsi',
                'like',
                '%' . $keyword . '%'
            );

        });

    }

    $katalog = $query
        ->latest()
        ->paginate(15)
        ->withQueryString();

    $daftarJurusan = \App\Models\Jurusan::orderBy(
        'nama_jurusan',
        'asc'
    )->get();

    return view(
        'public.katalog',
        compact(
            'katalog',
            'keyword',
            'jenis',
            'id_jurusan',
            'daftarJurusan'
        )
    );

})->name('public.katalog');


// =========================================================================
// PEMBELI
// =========================================================================

Route::middleware([
    'auth',
    'role:pembeli'
])->group(function () {

    Route::get(
        '/profil-pembeli',
        fn () => view('public.profil')
    )->name('profil.pembeli');


    Route::get(
        '/riwayat-pesanan',
        function (Request $request) {

            $query = \App\Models\Pesanan::with([
                'produkJasa.gambars',
                'produkJasa.jurusan',
                'riwayatStatus'
            ])
                ->where(
                    'id_user',
                    Auth::id()
                );

            $status = $request->query('status');

            $keyword = trim(
                $request->query(
                    'keyword',
                    ''
                )
            );

            if (
                $status &&
                in_array(
                    $status,
                    [
                        'menunggu konfirmasi',
                        'konfirmasi',
                        'diproses',
                        'selesai',
                        'dibatalkan'
                    ]
                )
            ) {

                $query->where(
                    'status',
                    $status
                );

            }

            if ($keyword !== '') {

                $query->whereHas(
                    'produkJasa',
                    function ($q) use ($keyword) {

                        $q->where(
                            'nama_produk_jasa',
                            'like',
                            '%' . $keyword . '%'
                        )
                        ->orWhere(
                            'deskripsi',
                            'like',
                            '%' . $keyword . '%'
                        );

                    }
                );

            }

            $riwayats = $query
                ->latest('tanggal_pesan')
                ->latest('id_pesanan')
                ->get();

            return view(
                'public.riwayat',
                compact(
                    'riwayats',
                    'status',
                    'keyword'
                )
            );

        }
    )->name('pembeli.riwayat');


    Route::get(
        '/riwayat-pesanan/detail/{id_pesanan}',
        function ($id_pesanan) {

            $pesanan = \App\Models\Pesanan::with([

                'produkJasa.gambars',
                'produkJasa.jurusan',
                'pembeli',
                'riwayatStatus.pelaksana',
                'progressPengerjaan.pelaksana',
                'tahapanPengerjaan'

            ])
                ->where(
                    'id_pesanan',
                    $id_pesanan
                )
                ->where(
                    'id_user',
                    Auth::id()
                )
                ->firstOrFail();

            return view(
                'public.riwayat-detail',
                compact('pesanan')
            );

        }
    )->name('pembeli.riwayat.detail');


    // Checkout
    Route::get(
        '/checkout',
        function (Request $request) {

            $request->validate([
                'id_produk_jasa' =>
                    'required|exists:produk_jasa,id_produk_jasa'
            ]);

            $produkJasa =
                \App\Models\ProdukJasa::with('gambars')
                    ->findOrFail(
                        $request->id_produk_jasa
                    );

            return view(
                'public.checkout',
                compact('produkJasa')
            );

        }
    );


    Route::post(
        '/checkout',
        [PesananPembeliController::class, 'store']
    )->name('pesanan.store');

});


// =========================================================================
// JURUSAN PUBLIK
// =========================================================================

Route::prefix('jurusan')->group(function () {

    Route::prefix('{slug}')->group(function () {

        $getJurusan = function ($slug) {

            $data = [

                'rpl' => [
                    'name' =>
                        'REKAYASA PERANGKAT LUNAK',

                    'description' =>
                        'Di SMKN 4 Tanjungpinang berfokus pada pengembangan bakat dan kompetensi siswa melalui pembelajaran berbasis proyek Teknologi Informasi.',

                    'logo' =>
                        'images/logo-rpl.png',

                    'hero' =>
                        'images/rpl1.jpeg',
                ],

                'tkj' => [
                    'name' =>
                        'TEKNIK KOMPUTER DAN JARINGAN',

                    'description' =>
                        'Berfokus pada instalasi jaringan komputer, administrasi server, troubleshooting hardware dan software jaringan secara profesional.',

                    'logo' =>
                        'images/logo-tkj.png',

                    'hero' =>
                        'images/tkj1.jpeg',
                ],

                'dkv' => [
                    'name' =>
                        'DESAIN KOMUNIKASI VISUAL',

                    'description' =>
                        'Berfokus pada seni komunikasi visual, desain media cetak, ilustrasi digital, perancangan branding, dan videografi kreatif.',

                    'logo' =>
                        'images/logo-dkv.png',

                    'hero' =>
                        'images/dkv1.jpeg',
                ],

                'gim' => [
                    'name' =>
                        'GIM',

                    'description' =>
                        'Mempelajari logika pemrograman gim, desain aset 2D/3D, animasi interaktif, serta perancangan engine permainan.',

                    'logo' =>
                        'images/logo-gim.png',

                    'hero' =>
                        'images/gim1.jpeg',
                ],

                'pspt' => [
                    'name' =>
                        'PRODUKSI DAN SIARAN PROGRAM TELEVISI',

                    'description' =>
                        'Mempelajari teknik produksi film, penyiaran televisi, editing video profesional, dan tata cahaya panggung/studio.',

                    'logo' =>
                        'images/logo-pspt.png',

                    'hero' =>
                        'images/pspt1.jpeg',
                ],

                'animasi' => [
                    'name' =>
                        'ANIMASI',

                    'description' =>
                        'Berfokus pada pembuatan animasi 2D dan 3D, modeling karakter, rigging, serta teknik visual effects (VFX) standar industri.',

                    'logo' =>
                        'images/logo-animasi.png',

                    'hero' =>
                        'images/anm1.jpeg',
                ],

            ];

            if (!array_key_exists($slug, $data)) {
                abort(404);
            }

            $jurusan = (object) array_merge(
                ['slug' => $slug],
                $data[$slug]
            );

            $jurusanDb =
                \App\Models\Jurusan::where(
                    'slug',
                    $slug
                )->first();

            $jurusan->deskripsi_panjang =
                $jurusanDb->deskripsi ?? '';

            return $jurusan;
        };


        // Detail jurusan
        Route::get(
            '/',
            function ($slug) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                return view(
                    'public.jurusan.detail-jurusan',
                    compact(
                        'jurusan',
                        'slug'
                    )
                );

            }
        );


        // Portofolio
        Route::get(
            '/portofolio',
            function ($slug) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $portofolios =
                    \App\Models\Portfolio::with('gambars')
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->latest()
                        ->get();

                return view(
                    'public.portofolio.index',
                    compact(
                        'jurusan',
                        'slug',
                        'portofolios'
                    )
                );

            }
        );


        // Detail portofolio
        Route::get(
            '/portofolio/detail/{id}',
            function ($slug, $id) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $portofolio =
                    \App\Models\Portfolio::with('gambars')
                        ->where(
                            'id_portfolio',
                            $id
                        )
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->firstOrFail();

                return view(
                    'public.portofolio.detail',
                    compact(
                        'jurusan',
                        'slug',
                        'portofolio'
                    )
                );

            }
        )->name('portofolio.detail');


        // Produk
        Route::get(
            '/produk',
            function ($slug) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $produks =
                    \App\Models\ProdukJasa::with('gambars')
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->where(
                            'jenis',
                            'produk'
                        )
                        ->latest()
                        ->get();

                return view(
                    'public.produk.index',
                    compact(
                        'jurusan',
                        'slug',
                        'produks'
                    )
                );

            }
        );


        // Detail produk
        Route::get(
            '/produk/detail/{id}',
            function ($slug, $id) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $produk =
                    \App\Models\ProdukJasa::with('gambars')
                        ->where(
                            'id_produk_jasa',
                            $id
                        )
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->where(
                            'jenis',
                            'produk'
                        )
                        ->firstOrFail();

                return view(
                    'public.produk.detail',
                    compact(
                        'jurusan',
                        'slug',
                        'produk'
                    )
                );

            }
        )->name('produk.detail');


        // Jasa
        Route::get(
            '/jasa',
            function ($slug) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $jasas =
                    \App\Models\ProdukJasa::with('gambars')
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->where(
                            'jenis',
                            'jasa'
                        )
                        ->latest()
                        ->get();

                return view(
                    'public.jasa.index',
                    compact(
                        'jurusan',
                        'slug',
                        'jasas'
                    )
                );

            }
        );


        // Detail jasa
        Route::get(
            '/jasa/detail/{id}',
            function ($slug, $id) use ($getJurusan) {

                $jurusan =
                    $getJurusan($slug);

                $jurusanDb =
                    \App\Models\Jurusan::where(
                        'slug',
                        $slug
                    )->firstOrFail();

                $jasa =
                    \App\Models\ProdukJasa::with('gambars')
                        ->where(
                            'id_produk_jasa',
                            $id
                        )
                        ->where(
                            'id_jurusan',
                            $jurusanDb->id_jurusan
                        )
                        ->where(
                            'jenis',
                            'jasa'
                        )
                        ->firstOrFail();

                return view(
                    'public.jasa.detail',
                    compact(
                        'jurusan',
                        'slug',
                        'jasa'
                    )
                );

            }
        )->name('jasa.detail');

    });

});


// =========================================================================
// ADMIN TEFA
// =========================================================================

Route::middleware([
    'auth',
    'role:admin_tefa'
])->group(function () {

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('admin.tefa.dashboard');

    Route::get(
        '/pesanan',
        [PesananController::class, 'index']
    )->name('pesanan.index');

    Route::get(
        '/pesanan/detail/{id}',
        [PesananController::class, 'show']
    )->name('pesanan.detail');

    Route::post(
        '/pesanan/{id}/update-status',
        [PesananController::class, 'updateStatus']
    )->name('pesanan.updateStatus');

    Route::get(
        '/tefa/jurusan',
        [DashboardController::class, 'jurusan']
    )->name('admin.tefa.jurusan');


    // Katalog gabungan TEFA
    Route::get(
        '/katalog-gabungan',
        [KatalogTefaController::class, 'index']
    )->name('admin.tefa.katalog_gabungan');

    Route::get('/katalog-gabungan/{id}', [KatalogTefaController::class, 'show'])
    ->name('admin.tefa.katalog_detail');
    Route::post(
    '/katalog-gabungan/pdf',
    [KatalogTefaController::class, 'generatePdf']
)->name('admin.tefa.katalog_pdf');


    // Akun
    Route::get(
        '/akun',
        [AkunController::class, 'index']
    )->name('akun.index');

    Route::get(
        '/akun/tambah',
        [AkunController::class, 'create']
    )->name('akun.create');

    Route::post(
        '/akun',
        [AkunController::class, 'store']
    )->name('akun.store');

    Route::get(
        '/akun/{id}',
        [AkunController::class, 'show']
    )->name('akun.show');

    Route::get(
        '/akun/{id}/edit',
        [AkunController::class, 'edit']
    )->name('akun.edit');

    Route::put(
        '/akun/{id}',
        [AkunController::class, 'update']
    )->name('akun.update');

    Route::put(
        '/akun/{id}/status',
        [AkunController::class, 'updateStatus']
    )->name('akun.updateStatus');

    Route::put(
        '/akun/{id}/reset-password',
        [AkunController::class, 'resetPassword']
    )->name('akun.resetPassword');


    // Profil
    Route::get(
        '/profil',
        fn () => view('admin.admin_tefa.profil.index')
    )->name('admin.tefa.profil');


    // FAQ
    Route::get(
        '/tefa/faq',
        [FaqController::class, 'index']
    )->name('tefa.faq.index');

    Route::get(
        '/tefa/faq/create',
        [FaqController::class, 'create']
    )->name('tefa.faq.create');

    Route::post(
        '/tefa/faq',
        [FaqController::class, 'store']
    )->name('tefa.faq.store');

    Route::get(
        '/tefa/faq/{id}/edit',
        [FaqController::class, 'edit']
    )->name('tefa.faq.edit');

    Route::put(
        '/tefa/faq/{id}',
        [FaqController::class, 'update']
    )->name('tefa.faq.update');

    Route::delete(
        '/tefa/faq/{id}',
        [FaqController::class, 'destroy']
    )->name('tefa.faq.destroy');

});


// =========================================================================
// ADMIN JURUSAN
// =========================================================================

Route::middleware([
    'auth',
    'role:admin_jurusan'
])->group(function () {

    Route::get(
        '/jurusan-admin/dashboard',
        [AdminJurusanController::class, 'dashboard']
    )->name('admin.jurusan.dashboard');


    Route::get(
        '/jurusan-admin/katalog',
        fn () => view('admin.admin_jurusan.katalog')
    );

    Route::get(
        '/jurusan-admin/katalog/detail',
        fn () => view('admin.admin_jurusan.katalog-detail')
    );

    Route::get(
        '/jurusan-admin/kelola-produk',
        fn () => view('admin.admin_jurusan.kelola-produk')
    );

    Route::get(
        '/jurusan-admin/kelola-jasa',
        fn () => view('admin.admin_jurusan.kelola-jasa')
    );

    Route::get(
        '/jurusan-admin/kelola-portofolio',
        fn () => view('admin.admin_jurusan.kelola-portofolio')
    );


    Route::get(
        '/jurusan-admin/kelola-deskripsi',
        function () {

            $user = Auth::user();

            $jurusan =
                $user->jurusanDipegang;

            if (!$jurusan) {
                abort(
                    404,
                    'Jurusan untuk akun ini belum ditemukan.'
                );
            }

            return view(
                'admin.admin_jurusan.kelola-deskripsi',
                compact('jurusan')
            );

        }
    )->name('jurusan.deskripsi.index');


    Route::post(
        '/jurusan-admin/kelola-deskripsi',
        [AdminJurusanController::class, 'updateDeskripsi']
    )->name('jurusan.updateDeskripsi');


    // Akun produser
    Route::get(
        '/jurusan-admin/akun',
        [AdminJurusanController::class, 'akun']
    )->name('jurusan.akun.index');

    Route::get(
        '/jurusan-admin/akun/tambah',
        [AdminJurusanController::class, 'createProduser']
    )->name('jurusan.akun.create');

    Route::post(
        '/jurusan-admin/akun',
        [AdminJurusanController::class, 'storeProduser']
    )->name('jurusan.akun.store');

    Route::get(
        '/jurusan-admin/akun/detail',
        [AdminJurusanController::class, 'detailProduser']
    )->name('jurusan.akun.detail');

    Route::get(
        '/jurusan-admin/akun/edit',
        [AdminJurusanController::class, 'editProduser']
    )->name('jurusan.akun.edit');

    Route::put(
        '/jurusan-admin/akun',
        [AdminJurusanController::class, 'updateProduser']
    )->name('jurusan.akun.update');

    Route::put(
        '/jurusan-admin/akun/status',
        [AdminJurusanController::class, 'updateStatusProduser']
    )->name('jurusan.akun.status');

    Route::put(
        '/jurusan-admin/akun/reset-password',
        [AdminJurusanController::class, 'resetPasswordProduser']
    )->name('jurusan.akun.resetPassword');


    Route::get(
        '/jurusan-admin/profil',
        fn () => view('admin.admin_jurusan.profil')
    )->name('jurusan.profil');


    // Produk
    Route::get(
        '/jurusan-admin/produk',
        [ProdukJasaController::class, 'index']
    )->name('produk.index');

    Route::post(
        '/jurusan-admin/produk',
        [ProdukJasaController::class, 'store']
    )->name('produk.store');

    Route::put(
        '/jurusan-admin/produk/{id}',
        [ProdukJasaController::class, 'update']
    )->name('produk.update');

    Route::delete(
        '/jurusan-admin/produk/{id}',
        [ProdukJasaController::class, 'destroy']
    )->name('produk.destroy');

    Route::delete(
        '/jurusan-admin/produk/gambar/{id_gambar}',
        [ProdukJasaController::class, 'destroyGambar']
    )->name('produk.destroyGambar');


    // Portofolio
    Route::get(
        '/jurusan-admin/portofolio',
        [PortfolioController::class, 'index']
    )->name('portofolio.index');

    Route::post(
        '/jurusan-admin/portofolio',
        [PortfolioController::class, 'store']
    )->name('portofolio.store');

    Route::put(
        '/jurusan-admin/portofolio/{id}',
        [PortfolioController::class, 'update']
    )->name('portofolio.update');

    Route::delete(
        '/jurusan-admin/portofolio/{id}',
        [PortfolioController::class, 'destroy']
    )->name('portofolio.destroy');

    Route::delete(
        '/jurusan-admin/portofolio/gambar/{id_gambar_portfolio}',
        [PortfolioController::class, 'destroyGambar']
    )->name('portofolio.destroyGambar');

});


// =========================================================================
// ADMIN PRODUSER
// =========================================================================

Route::middleware([
    'auth',
    'role:admin_produser'
])->group(function () {

    Route::get(
        '/produser/dashboard',
        [AdminProduserController::class, 'dashboard']
    )->name('admin.produser.dashboard');

    Route::get(
        '/produser/pesanan',
        [AdminProduserController::class, 'pesanan']
    )->name('admin.produser.pesanan');

    Route::get(
        '/produser/pesanan/detail/{id_pesanan}',
        [AdminProduserController::class, 'showPesanan']
    )->name('admin.produser.pesanan.detail');

    Route::post(
        '/produser/pesanan/{id_pesanan}/update-progress',
        [AdminProduserController::class, 'updateProgress']
    )->name('produser.updateProgress');


    // Tahapan pengerjaan
    Route::post(
        '/produser/pesanan/{id_pesanan}/tahapan',
        [AdminProduserController::class, 'storeTahapan']
    )->name('produser.tahapan.store');

    Route::put(
        '/produser/pesanan/{id_pesanan}/tahapan/{id_tahapan}',
        [AdminProduserController::class, 'updateTahapan']
    )->name('produser.tahapan.update');

    Route::delete(
        '/produser/pesanan/{id_pesanan}/tahapan/{id_tahapan}',
        [AdminProduserController::class, 'destroyTahapan']
    )->name('produser.tahapan.destroy');

    Route::post(
        '/produser/pesanan/{id_pesanan}/tahapan/reorder',
        [AdminProduserController::class, 'reorderTahapan']
    )->name('produser.tahapan.reorder');


    // Katalog produser
    Route::get(
        '/produser/katalog',
        [AdminProduserController::class, 'katalog']
    )->name('admin.produser.katalog');

    Route::get(
        '/produser/katalog/detail/{id_produk_jasa}',
        [AdminProduserController::class, 'showKatalog']
    )->name('admin.produser.katalog.detail');


    // Profil produser
    Route::get(
        '/produser/profil',
        [AdminProduserController::class, 'profil']
    )->name('admin.produser.profil');

});

