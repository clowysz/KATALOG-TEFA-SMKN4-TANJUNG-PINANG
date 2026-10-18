<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Jurusan TEFA</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="{{ asset('css/global-admin.css') }}?v=1">

    <!-- CSS ADMIN JURUSAN -->
    <link rel="stylesheet" href="{{ asset('css/admin-jurusan.css') }}?v=4">
    <link rel="stylesheet" href="{{ asset('css/logout-modal-jurusan.css') }}?v=1">

    <!-- CSS KHUSUS HALAMAN -->
    @yield('styles')

    <!-- PHOSPHOR ICON -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

</head>

<body>

    <!-- =========================
         HEADER
    ========================== -->

    <header class="header">

        <span class="hamburger" data-drawer-toggle>
            <i class="ph ph-list"></i>
        </span>

        <h2>
            @yield('title')
        </h2>

    </header>


    <!-- =========================
         NAVIGATION DRAWER
    ========================== -->

    <nav class="drawer" id="navDrawer">

        <div class="drawer-top-header">

            <h3>
                TEFA Admin Jurusan
            </h3>

            <span class="close-drawer" data-drawer-toggle>
                <i class="ph ph-x"></i>
            </span>

        </div>


        <ul class="drawer-menu">

            <li>
                <a
                    href="/jurusan-admin/dashboard"
                    class="{{ request()->is('jurusan-admin/dashboard') ? 'active' : '' }}"
                >
                    <i class="ph ph-house"></i>
                    Dashboard
                </a>
            </li>


            <li>
                <a
                    href="/jurusan-admin/katalog"
                    class="{{ request()->is('jurusan-admin/katalog') ? 'active' : '' }}"
                >
                    <i class="ph ph-tote"></i>
                    Produk dan Jasa
                </a>
            </li>


            <li class="sub-menu">
                <a
                    href="/jurusan-admin/kelola-produk"
                    class="{{ request()->is('jurusan-admin/kelola-produk') ? 'active' : '' }}"
                >
                    <i class="ph ph-hexagon"></i>
                    Kelola Produk
                </a>
            </li>


            <li class="sub-menu">
                <a
                    href="/jurusan-admin/kelola-jasa"
                    class="{{ request()->is('jurusan-admin/kelola-jasa') ? 'active' : '' }}"
                >
                    <i class="ph ph-wrench"></i>
                    Kelola Jasa
                </a>
            </li>


            <li class="sub-menu">
                <a
                    href="/jurusan-admin/kelola-portofolio"
                    class="{{ request()->is('jurusan-admin/kelola-portofolio') ? 'active' : '' }}"
                >
                    <i class="ph ph-image"></i>
                    Kelola Portofolio
                </a>
            </li>


            <li class="menu-divider"></li>


            <li>
                <a
                    href="/jurusan-admin/kelola-deskripsi"
                    class="{{ request()->is('jurusan-admin/kelola-deskripsi') ? 'active' : '' }}"
                >
                    <i class="ph ph-file-text"></i>
                    Deskripsi Jurusan
                </a>
            </li>


            <li>
                <a
                    href="/jurusan-admin/akun/tambah"
                    class="{{ request()->is('jurusan-admin/akun/tambah') ? 'active' : '' }}"
                >
                    <i class="ph ph-user-plus"></i>
                    Tambah Akun
                </a>
            </li>


            <li>
                <a
                    href="/jurusan-admin/akun"
                    class="{{ request()->is('jurusan-admin/akun') ? 'active' : '' }}"
                >
                    <i class="ph ph-users"></i>
                    Daftar Akun
                </a>
            </li>


            <li class="menu-divider"></li>


            <li>
                <a
                    href="/jurusan-admin/profil"
                    class="{{ request()->is('jurusan-admin/profil') ? 'active' : '' }}"
                >
                    <i class="ph ph-user-circle"></i>
                    Profil
                </a>
            </li>


            <li>
                <a href="#" class="logout-link" data-logout-open>
                    <i class="ph ph-sign-out"></i>
                    Logout
                </a>
            </li>

        </ul>


        <div class="drawer-footer">
            SMKN 4 Tanjungpinang © 2026
        </div>

    </nav>


    <!-- =========================
         OVERLAY
    ========================== -->

    <div class="overlay" id="overlay" data-drawer-toggle></div>


    <!-- =========================
         KONTEN
    ========================== -->

    <main class="main-content">

        @yield('content')

    </main>


    <!-- =========================
         MODAL LOGOUT
    ========================== -->

    <div id="logoutModal" class="modal-logout-overlay">

        <div class="modal-logout-box">

            <h3 class="modal-logout-title">
                Keluar dari akun?
            </h3>

            <p class="modal-logout-desc">
                Anda akan diarahkan kembali ke halaman login.
            </p>


            <div class="modal-logout-actions">

                <button
                    type="button"
                    class="btn-modal-cancel"
                    data-logout-close
                >
                    Batal
                </button>


                <form
                    action="{{ route('admin.logout') }}"
                    method="POST"
                    class="modal-logout-form"
                >

                    @csrf

                    <button type="submit" class="btn-modal-logout">
                        Keluar
                    </button>

                </form>

            </div>

        </div>

    </div>


    <!-- =========================
         JAVASCRIPT
    ========================== -->

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/logout-modal-jurusan.js') }}"></script>

    @yield('scripts')

</body>
</html>