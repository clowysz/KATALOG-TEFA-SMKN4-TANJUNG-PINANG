<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEFA SMKN 4 Tanjungpinang</title>
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
    @stack('css')
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        /* CSS Spesifik untuk Header Khusus Jurusan (Gambar 3) */
        .jurusan-top-nav-bar {
            background: #1E3A8A;
            padding: 30px 5% 20px 5%;
            display: flex;
            justify-content: center;
        }
        .jurusan-nav-pill {
            background: white;
            border-radius: 50px;
            padding: 12px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 1200px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            gap: 20px;
        }
        .jurusan-nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .jurusan-nav-brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }
        .jurusan-nav-brand-text h4 {
            font-size: 14px;
            font-weight: 800;
            color: #1E3A8A;
            margin: 0;
            line-height: 1.2;
        }
        .jurusan-nav-brand-text p {
            font-size: 11px;
            color: #64748B;
            margin: 0;
        }
        .jurusan-nav-menu {
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .jurusan-nav-menu a {
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            color: #1E2D3D;
            padding: 8px 16px;
            border-radius: 20px;
            transition: 0.3s;
        }
        .jurusan-nav-menu a:hover, .jurusan-nav-menu a.active {
            background: #1E3A8A;
            color: white;
        }
        .jurusan-nav-search {
            background: #F1F5F9;
            border-radius: 20px;
            padding: 8px 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 200px;
        }
        .jurusan-nav-search input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13px;
            width: 100%;
        }
        .jurusan-nav-profile {
            width: 40px;
            height: 40px;
            background: #1E3A8A;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 20px;
        }
    </style>
</head>
<body>

    <!-- NAVBAR UTAMA WEBSITE -->
    <nav class="navbar">
        <a href="/" class="nav-logo">
            <img src="{{ asset('images/logo-smk4.png') }}" alt="Logo">
            <div>
                <h1>TEACHING FACTORY</h1>
                <p>SMKN 4 Tanjungpinang</p>
            </div>
        </a>

        <div class="nav-links">
            <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">BERANDA</a>
            <a href="/jurusan" class="{{ Request::is('jurusan') ? 'active-btn' : '' }}">JURUSAN</a>
            <a href="/faq" class="{{ Request::is('faq*') ? 'active' : '' }}">FAQ</a>
        </div>

        <div class="nav-right">
            <div class="search-box">
                <i class="ph ph-magnifying-glass"></i>
                <input type="text" placeholder="Pencarian">
            </div>
            <a href="/profil-pembeli" class="profile-btn">
                <i class="ph ph-user"></i>
            </a>
        </div>
    </nav>

    <!-- BILAH NAVIGASI KHUSUS JURUSAN (GAMBAR 3) -->
    <div class="jurusan-top-nav-bar">
        <div class="jurusan-nav-pill">
            <!-- Logo & Nama Jurusan di Kiri -->
            <div class="jurusan-nav-brand">
                <img src="{{ asset('images/logo-smk4.png') }}" alt="Logo Jurusan">
                <div class="jurusan-nav-brand-text">
                    <h4>REKAYASA PERANGKAT LUNAK</h4>
                    <p>SMKN 4 TanjungPinang</p>
                </div>
            </div>

            <!-- Menu Sub-Navigasi di Tengah -->
            <div class="jurusan-nav-menu">
                <a href="/jurusan/rpl" class="{{ Request::is('jurusan/rpl') ? 'active' : '' }}">DESKRIPSI</a>
                <a href="/jurusan/rpl/portofolio" class="{{ Request::is('jurusan/rpl/portofolio*') ? 'active' : '' }}">PORTOFOLIO</a>
                <a href="/jurusan/rpl/produk" class="{{ Request::is('jurusan/rpl/produk*') ? 'active' : '' }}">PRODUK</a>
                <a href="/jurusan/rpl/jasa" class="{{ Request::is('jurusan/rpl/jasa*') ? 'active' : '' }}">JASA</a>
            </div>

            <!-- Pencarian & Profil di Kanan -->
            <div style="display: flex; align-items: center; gap: 12px;">
                <div class="jurusan-nav-search">
                    <i class="ph ph-magnifying-glass" style="color: #64748B;"></i>
                    <input type="text" placeholder="Pencarian">
                </div>
                <a href="/profil-pembeli" class="jurusan-nav-profile">
                    <i class="ph ph-user"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- KONTEN UTAMA HALAMAN JURUSAN -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <img src="{{ asset('images/logo-smk4.png') }}" alt="Logo SMKN 4">
                    <h2>TEACHING FACTORY<br><span style="font-size: 11px; font-weight:400;">SMKN 4 Tanjungpinang</span></h2>
                </div>
                <p class="footer-desc">Mewujudkan pendidikan vokasi berbasis dunia kerja yang inovatif, kreatif, dan berdaya saing global.</p>
            </div>
            <div class="footer-col">
                <h3>LINK CEPAT</h3>
                <ul class="footer-links">
                    <li><a href="/"><i class="ph ph-caret-right"></i> Beranda</a></li>
                    <li><a href="/jurusan"><i class="ph ph-caret-right"></i> Jurusan</a></li>
                    <li><a href="/faq"><i class="ph ph-caret-right"></i> FAQ</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h3>INFORMASI</h3>
                <div class="footer-contact"><i class="ph ph-map-pin"></i> <span>Jl. Brigjend Katamso No.92</span></div>
                <div class="footer-contact"><i class="ph ph-phone"></i> <span>0771-123456</span></div>
            </div>
            <div class="footer-col">
                <h3>HUBUNGI KAMI</h3>
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Halo+Admin+TEFA" class="qr-code" alt="QR">
            </div>
        </div>
        <div class="footer-bottom">&copy; 2026 SMKN 4 Tanjungpinang. All Rights Reserved.</div>
    </footer>
</body>
</html>