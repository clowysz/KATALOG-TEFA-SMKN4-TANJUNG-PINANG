<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin_tefa.css') }}?v=1"> 
    
    <!-- Script Phosphor Icons agar logo muncul -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <!-- CSS Tambahan agar ikon sejajar dengan teks dan ukuran teks mengecil -->
    <style>
        .drawer-menu a {
            display: flex;
            align-items: center;
            gap: 12px; /* Jarak antara ikon dan tulisan */
            font-size: 15px; /* Mengecilkan ukuran tulisan menu */
            text-decoration: none;
        }
        .drawer-menu a i {
            font-size: 20px; /* Ukuran ikon */
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()">☰</span>
        <h2>@yield('title')</h2>
    </header>

   <!-- Navigation Drawer -->
<nav class="drawer" id="navDrawer">

    <!-- TAMBAHKAN KEMBALI BLOK HEADER INI -->
    <div class="drawer-top-header" style="display: flex; justify-content: space-between; align-items: center; padding: 20px; border-bottom: 1px solid #4a5568;">
        <!-- Font size ditambahkan agar judul admin lebih proporsional -->
        <h3 style="color: white; margin: 0; font-size: 20px;">TEFA Admin</h3>
        <span class="close-drawer" onclick="toggleDrawer()" style="cursor: pointer; color: white; font-size: 18px;">✖</span>
    </div>
    <!-- ================================== -->

    <ul class="drawer-menu">    
        <!-- Tag <i> ditambahkan untuk memanggil logo -->
        <li><a href="/dashboard"><i class="ph ph-house"></i> Dashboard</a></li>
        <li><a href="/pesanan"><i class="ph ph-shopping-bag"></i> Kelola Pesanan</a></li>
        <li><a href="/tefa/jurusan"><i class="ph ph-graduation-cap"></i> Jurusan</a></li>
        <li><a href="/akun"><i class="ph ph-users"></i> Daftar Akun</a></li>
        <li><a href="/tefa/faq"><i class="ph ph-question"></i> Kelola FAQ</a></li>
        
        <!-- Jarak pemisah sebelum Profil & Logout -->
        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.1);"></div>
        
        <li><a href="/profil"><i class="ph ph-user-circle"></i> Profil</a></li>
        <li><a href="/" style="color: #F87171;"><i class="ph ph-sign-out"></i> Logout</a></li>
    </ul>
</nav>
    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <!-- Konten Halaman yang akan berubah-ubah -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Memanggil JavaScript Global -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Tempat untuk Script Khusus per Halaman -->
    @yield('scripts')
    
</body>
</html>