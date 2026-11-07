<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - Admin Produser</title>
    @include('partials.favicon')

    <link rel="stylesheet" href="{{ asset('css/global-admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-produser.css') }}">

    
    @stack('styles')

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="produser-mode">

    
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()">
            <i class="ph ph-list"></i>
        </span>

        <h2 class="header-title">@yield('title')</h2>
    </header>

    
    <nav class="drawer" id="navDrawer" aria-label="Menu admin produser">

        <div class="drawer-top-header">
            <h3>TEFA Admin Produser</h3>

            <span class="close-drawer" onclick="toggleDrawer()">
                <i class="ph ph-x"></i>
            </span>
        </div>

        <ul class="drawer-menu">

            <li>
                <a href="/produser/dashboard"
                   class="{{ Request::is('produser/dashboard*') ? 'active' : '' }}">
                    <i class="ph ph-house"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="/produser/pesanan"
                   class="{{ Request::is('produser/pesanan*') ? 'active' : '' }}">
                    <i class="ph ph-receipt"></i>
                    Pesanan
                </a>
            </li>

            <li>
                <a href="/produser/katalog"
                   class="{{ Request::is('produser/katalog*') ? 'active' : '' }}">
                    <i class="ph ph-folder-notch"></i>
                    Produk/Jasa Saya
                </a>
            </li>

            <li class="menu-divider"></li>

            <li>
                <a href="/produser/profil"
                   class="{{ Request::is('produser/profil*') ? 'active' : '' }}">
                    <i class="ph ph-user-circle"></i>
                    Profil Saya
                </a>
            </li>

            <li>
                <button type="button"
                        class="logout-link"
                        data-modal-open="modalLogoutProduser">
                    <i class="ph ph-sign-out"></i>
                    Logout
                </button>
            </li>

        </ul>

    </nav>

    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    
    <main class="main-content">
        @yield('content')
    </main>

    
    <div id="modalLogoutProduser" class="modal-overlay">
        <div class="modal-box" role="dialog" aria-modal="true" aria-labelledby="logoutTitle">

            <div class="modal-title" id="logoutTitle">
                Keluar dari akun?
            </div>

            <div class="modal-desc">
                Anda akan diarahkan kembali ke halaman login.
            </div>

            <div class="modal-actions">

                <button type="button"
                        class="btn-outline"
                        data-modal-close="modalLogoutProduser">
                    Batal
                </button>

                
                <form action="{{ url('/admin/logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn-primary btn-danger-produser">
                        Logout
                    </button>
                </form>

            </div>

        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/produser-action.js') }}"></script>
    <script src="{{ asset('js/layout-produser.js') }}"></script>

    @stack('scripts')

</body>
</html>