<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin TEFA</title>

    <!-- CSS GLOBAL -->
    <link rel="stylesheet" href="{{ asset('css/global-admin.css') }}?v=3">

    <!-- CSS ADMIN TEFA -->
    <link rel="stylesheet" href="{{ asset('css/admin-tefa.css') }}?v=6">

    <!-- CSS KHUSUS HALAMAN -->
    @stack('css')

    <!-- PHOSPHOR ICON -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

    <!-- =========================
         HEADER
    ========================== -->

    <header class="header">

        <span
            class="hamburger"
            data-drawer-toggle
            role="button"
            aria-label="Buka menu"
        >
            ☰
        </span>

        <h2>
            @yield('title')
        </h2>

    </header>


    <!-- =========================
         NAVIGATION DRAWER
    ========================== -->

    <nav
        class="drawer"
        id="navDrawer"
    >

        <div class="drawer-top-header">

            <h3>
                TEFA Admin
            </h3>

            <span
                class="close-drawer"
                data-drawer-toggle
                role="button"
                aria-label="Tutup menu"
            >
                ✖
            </span>

        </div>


        <ul class="drawer-menu">

            <li>
                <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="ph ph-house"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/katalog-gabungan" class="{{ request()->is('katalog-gabungan*') ? 'active' : '' }}">
                    <i class="ph ph-squares-four"></i>
                    Katalog TEFA
                </a>
            </li>

            <li>
                <a href="/pesanan" class="{{ request()->is('pesanan*') ? 'active' : '' }}">
                    <i class="ph ph-shopping-bag"></i>
                    Kelola Pesanan
                </a>
            </li>

            <li>
                <a href="/tefa/jurusan" class="{{ request()->is('tefa/jurusan*') ? 'active' : '' }}">
                    <i class="ph ph-graduation-cap"></i>
                    Jurusan
                </a>
            </li>

            <li>
                <a href="/akun" class="{{ request()->is('akun*') ? 'active' : '' }}">
                    <i class="ph ph-users"></i>
                    Daftar Akun
                </a>
            </li>

            <li>
                <a href="/tefa/faq" class="{{ request()->is('tefa/faq*') ? 'active' : '' }}">
                    <i class="ph ph-question"></i>
                    Kelola FAQ
                </a>
            </li>

            <li class="menu-divider" aria-hidden="true"></li>

            <li>
                <a href="/profil" class="{{ request()->is('profil*') ? 'active' : '' }}">
                    <i class="ph ph-user-circle"></i>
                    Profil
                </a>
            </li>

            <li>
                <a
                    href="javascript:void(0)"
                    data-logout-open
                    class="logout-link"
                >
                    <i class="ph ph-sign-out"></i>
                    Logout
                </a>
            </li>

        </ul>

    </nav>


    <!-- OVERLAY -->

    <div
        class="overlay"
        id="overlay"
        data-drawer-toggle
    ></div>


    <!-- =========================
         KONTEN HALAMAN
    ========================== -->

    <main class="main-content">

        @yield('content')

    </main>


    <!-- =========================
         MODAL LOGOUT
    ========================== -->

    <div
        id="logoutModal"
        class="modal-logout-overlay"
        style="display:none;"
    >

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

                    <button
                        type="submit"
                        class="btn-modal-logout"
                    >
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </div>



    <!-- =========================
         LOGOUT JAVASCRIPT
    ========================== -->

    <script src="{{ asset('js/logout-modal.js') }}"></script>


    <!-- =========================
         JAVASCRIPT GLOBAL
    ========================== -->

    <script src="{{ asset('js/script.js') }}"></script>


    <!-- =========================
         JAVASCRIPT KHUSUS HALAMAN
    ========================== -->

    @yield('scripts')

</body>
</html>