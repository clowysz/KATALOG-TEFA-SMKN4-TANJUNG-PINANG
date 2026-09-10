<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TEFA</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-produser.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="produser-mode">

    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()"><i class="ph ph-list"></i></span>
        <h2 style="font-family: 'Inter', sans-serif;">@yield('title')</h2>
    </header>

    <nav class="drawer" id="navDrawer">
        <div class="drawer-top-header">
            <h3>TEFA Admin Produser</h3>
            <span class="close-drawer" onclick="toggleDrawer()"><i class="ph ph-x"></i></span>
        </div>

       

        <ul class="drawer-menu">
            <li><a href="/produser/dashboard" class="{{ Request::is('produser/dashboard*') ? 'active' : '' }}"><i class="ph ph-house"></i> Dashboard</a></li>
            <li><a href="/produser/katalog" class="{{ Request::is('produser/katalog*') ? 'active' : '' }}"><i class="ph ph-folder-notch"></i> Produk/Jasa Saya</a></li>
            <li class="menu-divider"></li>
            <li><a href="/produser/profil" class="{{ Request::is('produser/profil*') ? 'active' : '' }}"><i class="ph ph-user-circle"></i> Profil Saya</a></li>
            <li><a href="#" onclick="openModal('modalLogoutProduser')" class="logout-link"><i class="ph ph-sign-out"></i> Logout</a></li>
        </ul>
    </nav>
    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Modal Logout Global -->
    <div id="modalLogoutProduser" class="modal-overlay">
        <div class="modal-box" style="border-radius: 14px;">
            <div class="modal-title">Keluar dari akun?</div>
            <div class="modal-desc" style="color: var(--prod-text-sec);">Anda akan diarahkan kembali ke halaman login.</div>
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modalLogoutProduser')">Batal</button>
                <a href="/login-tefa" class="btn-primary" style="text-decoration: none; text-align: center; background: var(--prod-error);">Logout</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="{{ asset('js/produser-action.js') }}"></script>
    <script>
        function openModal(id) { document.getElementById(id).classList.add('active'); }
        function closeModal(id) { document.getElementById(id).classList.remove('active'); }
    </script>
    @yield('scripts')
</body>
</html>