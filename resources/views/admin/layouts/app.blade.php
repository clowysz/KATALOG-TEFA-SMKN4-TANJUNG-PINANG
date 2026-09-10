<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin_tefa.css') }}?v=1">  
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
        <h3 style="color: white; margin: 0;">TEFA Admin</h3>
        <span class="close-drawer" onclick="toggleDrawer()" style="cursor: pointer; color: white; font-size: 18px;">✖</span>
    </div>
    <!-- ================================== -->

    <ul class="drawer-menu">    
        <li><a href="/dashboard">Dashboard</a></li>
        <li><a href="/pesanan">Kelola Pesanan</a></li>
        <li><a href="/tefa/jurusan">Jurusan</a></li>
        <li><a href="/akun">Daftar Akun</a></li>
        <!-- INI BARIS YANG DITAMBAHKAN UNTUK MENU FAQ -->
        <li><a href="/tefa/faq">Kelola FAQ</a></li>
        <li><a href="/profil">Profil</a></li>
        <li><a href="/">Logout</a></li>
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