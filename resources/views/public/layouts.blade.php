<!DOCTYPE html>
<html lang="id" style="scroll-behavior: smooth;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEFA SMKN 4 Tanjungpinang</title>
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
    
    @stack('css')
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #F8FAFC !important;
    }

    .jurusan-sticky-container, .hero-section {
        background-color: #1E3A8A !important; 
    }

    .jurusan-sticky-container {
        position: sticky;
        top: 0;
        z-index: 999;
        padding: 5px 20px; 
        display: flex;
        justify-content: center;
        width: 100%;
        box-sizing: border-box;
    }
    .jurusan-nav-pill {
        background: white;
        border-radius: 50px;
        padding: 8px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        max-width: 1200px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        gap: 20px;
    }
    .jurusan-nav-brand {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }
    .jurusan-nav-brand img {
        width: 40px;
        height: 40px;
        object-fit: contain;
    }
    .jurusan-nav-brand-text h4 {
        font-size: 13px;
        font-weight: 800;
        color: #1E3A8A;
        margin: 0;
        line-height: 1.2;
    }
    .jurusan-nav-brand-text p {
        font-size: 10px;
        color: #64748B;
        margin: 0;
    }
    .jurusan-nav-menu {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .jurusan-nav-menu a {
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        color: #1E2D3D;
        padding: 6px 14px;
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
        padding: 6px 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        width: 160px;
    }
    .jurusan-nav-search input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 12px;
        width: 100%;
    }
    .jurusan-nav-profile {
        width: 36px;
        height: 36px;
        background: #1E3A8A;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 16px;
    }

    main {
        padding-top: 0px !important; 
        margin-top: 0px !important;
    }
    .footer {
        background-color: #1E3A8A !important;
    }
    #jurusan-unggulan {
        scroll-margin-top: 80px;
    }

    @media (max-width: 850px) {
        .jurusan-nav-pill {
            flex-direction: column;
            border-radius: 20px;
            padding: 16px;
            gap: 16px;
        }
        .jurusan-nav-brand {
            justify-content: center;
            text-align: center;
        }
        .jurusan-nav-menu {
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
        }
        .jurusan-nav-search {
            width: 100%;
            justify-content: center;
        }
    }
</style>
</head>
<body>

    @php
        $isJurusanPage = Request::is('jurusan/*');
        $segment = Request::segment(2); 
        
        $namaJurusan = 'TEACHING FACTORY';
        $subNamaJurusan = 'SMKN 4 Tanjungpinang';
        
        if($segment == 'rpl') {
            $namaJurusan = 'REKAYASA PERANGKAT LUNAK';
        } elseif($segment == 'gim') {
            $namaJurusan = 'PEMROGRAMAN GIM';
        } elseif($segment == 'tkj') {
            $namaJurusan = 'TEKNIK KOMPUTER & JARINGAN';
        } elseif($segment == 'pspt') {
            $namaJurusan = 'PSPT';
        } elseif($segment == 'dkv') {
            $namaJurusan = 'DESAIN KOMUNIKASI VISUAL';
        } elseif($segment == 'animasi') {
            $namaJurusan = 'ANIMASI';
        }
    @endphp

    <div class="jurusan-sticky-container">
        <div class="jurusan-nav-pill">
            
            @if($isJurusanPage && in_array($segment, ['rpl', 'gim', 'tkj', 'pspt', 'dkv', 'animasi']))
                <a href="/jurusan/{{ $segment }}" class="jurusan-nav-brand">
                    <img src="{{ asset('images/logo-smk4.png') }}" alt="Logo Jurusan">
                    <div class="jurusan-nav-brand-text">
                        <h4>{{ $namaJurusan }}</h4>
                        <p>{{ $subNamaJurusan }}</p>
                    </div>
                </a>

                <div class="jurusan-nav-menu">
                    <a href="/jurusan/{{ $segment }}" class="{{ Request::is('jurusan/' . $segment) ? 'active' : '' }}">DESKRIPSI</a>
                    <a href="/jurusan/{{ $segment }}/portofolio" class="{{ Request::is('jurusan/' . $segment . '/portofolio*') ? 'active' : '' }}">PORTOFOLIO</a>
                    <a href="/jurusan/{{ $segment }}/produk" class="{{ Request::is('jurusan/' . $segment . '/produk*') ? 'active' : '' }}">PRODUK</a>
                    <a href="/jurusan/{{ $segment }}/jasa" class="{{ Request::is('jurusan/' . $segment . '/jasa*') ? 'active' : '' }}">JASA</a>
                </div>

            @else
                <a href="/" class="jurusan-nav-brand" onclick="window.location.reload();">
                    <img src="{{ asset('images/logo-smk4.png') }}" alt="Logo">
                    <div class="jurusan-nav-brand-text">
                        <h4>TEACHING FACTORY</h4>
                        <p>SMKN 4 Tanjungpinang</p>
                    </div>
                </a>

                <div class="jurusan-nav-menu">
                    <a href="/" class="{{ Request::is('/') ? 'active' : '' }}">BERANDA</a>
                    <a href="/jurusan" class="{{ Request::is('jurusan') ? 'active' : '' }}">JURUSAN</a>
                    <a href="/faq" class="{{ Request::is('faq*') ? 'active' : '' }}">FAQ</a>
                </div>
            @endif

            <div style="display: flex; align-items: center; gap: 10px;">
                
                <!-- PERBAIKAN: Kotak pencarian diubah menjadi Form -->
                <form action="/pencarian" method="GET" class="jurusan-nav-search" style="margin: 0;">
                    <button type="submit" style="background: transparent; border: none; cursor: pointer; padding: 0; display: flex; align-items: center; outline: none;">
                        <i class="ph ph-magnifying-glass" style="color: #64748B; font-size: 16px;"></i>
                    </button>
                    <input type="text" name="keyword" placeholder="Cari produk, jasa..." required style="border: none; background: transparent; outline: none; font-size: 12px; width: 100%;">
                </form>

                <a href="/profil-pembeli" class="jurusan-nav-profile">
                    <i class="ph ph-user"></i>
                </a>
            </div>

        </div>
    </div>

    <main>
        @yield('content')
    </main>

    <footer class="footer" style="background-color: #1E3A8A;">
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
    <a href="#" class="fab-wa"><i class="ph ph-whatsapp-logo"></i></a>
</body>
</html>