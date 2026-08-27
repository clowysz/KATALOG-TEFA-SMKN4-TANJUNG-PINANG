<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Jurusan TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- Memanggil Library Ikon Modern (Sama persis dengan desainmu) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <!-- Header Atas -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()"><i class="ph ph-list"></i></span>
        <h2>@yield('title')</h2>
    </header>

    <!-- Navigation Drawer (Sesuai Desain Figma) -->
    <nav class="drawer" id="navDrawer">
        <!-- Header Drawer -->
        <div class="drawer-top-header">
            <h3>TEFA Admin</h3>
            <span class="close-drawer" onclick="toggleDrawer()"><i class="ph ph-x"></i></span>
        </div>

        <!-- Identitas Jurusan RPL -->
        <div class="drawer-identity-box">
            <div class="identity-logo">RPL</div>
            <div class="identity-text">
                <h4>RPL</h4>
                <p>Rekayasa Perangkat Lunak</p>
            </div>
        </div>

        <!-- Daftar Menu -->
        <ul class="drawer-menu">
            <li><a href="/jurusan-admin/dashboard"><i class="ph ph-house"></i> Dashboard</a></li>
            <li><a href="/jurusan-admin/katalog"><i class="ph ph-tote"></i> Produk dan Jasa</a></li>
            
            <!-- Sub menu (Menjorok ke dalam) -->
            <li class="sub-menu"><a href="/jurusan-admin/kelola-produk"><i class="ph ph-hexagon"></i> Kelola Produk</a></li>
            <li class="sub-menu"><a href="/jurusan-admin/kelola-jasa"><i class="ph ph-wrench"></i> Kelola Jasa</a></li>
            <li class="sub-menu"><a href="/jurusan-admin/kelola-portofolio"><i class="ph ph-image"></i> Kelola Portofolio</a></li>

            <li class="menu-divider"></li>

            <li><a href="/jurusan-admin/kelola-deskripsi"><i class="ph ph-file-text"></i> Deskripsi Jurusan</a></li>
            <li><a href="/jurusan-admin/akun/tambah"><i class="ph ph-user-plus"></i> Tambah Akun</a></li>
            
            <!-- Contoh menu aktif (Daftar Akun) -->
            <li><a href="/jurusan-admin/akun" class="active"><i class="ph ph-users"></i> Daftar Akun</a></li>

            <li class="menu-divider"></li>

            <li><a href="/jurusan-admin/profil"><i class="ph ph-user"></i> Profil</a></li>
            <li><a href="/login-jurusan" class="logout-link"><i class="ph ph-sign-out"></i> Logout</a></li>
        </ul>

        <!-- Footer Drawer -->
        <div class="drawer-footer">
            SMKN 4 Tanjungpinang © 2026
        </div>
    </nav>
    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <!-- Konten Utama -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Script Global -->
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>