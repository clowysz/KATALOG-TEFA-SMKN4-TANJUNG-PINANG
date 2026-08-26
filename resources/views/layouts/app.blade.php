<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Header -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()">☰</span>
        <h2>@yield('title')</h2>
    </header>

    <!-- Navigation Drawer -->
    <nav class="drawer" id="navDrawer">
        <ul class="drawer-menu">    
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/pesanan">Kelola Pesanan</a></li>
            <li><a href="/jurusan">Jurusan</a></li>
            <li><a href="/akun">Daftar Akun</a></li>
            <!-- INI BARIS YANG DITAMBAHKAN UNTUK MENU FAQ -->
            <li><a href="/faq">Kelola FAQ</a></li>
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