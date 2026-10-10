<!DOCTYPE html>
<html lang="id" style="scroll-behavior:smooth;">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TEFA SMKN 4 Tanjungpinang')</title>

    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">

    @stack('css')

    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="{{ asset('js/navbar.js') }}" defer></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #F8FAFC !important;
        }

        /* Latar navbar putih (sama seperti tampilan desktop sebelumnya) */
        .jurusan-sticky-container {
            background: white !important;
        }

        main {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        .footer {
            background-color: #1E3A8A !important;
        }

        /* Desktop: pertahankan jarak & bayangan asli layout ini */
        @media (min-width: 851px) {
            .jurusan-sticky-container {
                padding: 12px 20px;
            }

            .jurusan-nav-pill {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            }
        }
    </style>

</head>


<body>
@php
    $isPembeli   = Auth::check() && Auth::user()->role === 'pembeli';
    $profilLabel = 'Profil';
@endphp

    {{-- ================= NAVBAR ================= --}}

    <div class="jurusan-sticky-container">

        <div class="jurusan-nav-pill">


            @if(isset($jurusan))

                @php
                    $segment = $jurusan->slug ?? Request::segment(2);
                @endphp

                <a
                    href="{{ url('/jurusan/' . $jurusan->slug) }}"
                    class="jurusan-nav-brand"
                >

                    <img
                        src="{{ asset($jurusan->logo) }}"
                        alt="Logo {{ $jurusan->name }}"
                    >

                    <div class="jurusan-nav-brand-text">
                        <h4>{{ $jurusan->name }}</h4>
                        <p>SMKN 4 Tanjungpinang</p>
                    </div>

                </a>

            @else

                <a href="/" class="jurusan-nav-brand">

                    <img
                        src="{{ asset('images/logo-smk4.png') }}"
                        alt="Logo SMKN 4"
                    >

                    <div class="jurusan-nav-brand-text">
                        <h4>TEACHING FACTORY</h4>
                        <p>SMKN 4 Tanjungpinang</p>
                    </div>

                </a>

            @endif


            {{-- ================= MENU (terlipat di HP) ================= --}}

            <div class="jurusan-nav-menu" id="jurusanNavMenu">

                @if(isset($jurusan))

                    <a
                        href="{{ url('/jurusan/' . $segment) }}"
                        class="{{ Request::is('jurusan/' . $segment) ? 'active' : '' }}"
                    >
                        DESKRIPSI
                    </a>

                    <a
                        href="{{ url('/jurusan/' . $segment . '/portofolio') }}"
                        class="{{ Request::is('jurusan/' . $segment . '/portofolio*') ? 'active' : '' }}"
                    >
                        PORTOFOLIO
                    </a>

                    <a
                        href="{{ url('/jurusan/' . $segment . '/produk') }}"
                        class="{{ Request::is('jurusan/' . $segment . '/produk*') ? 'active' : '' }}"
                    >
                        PRODUK
                    </a>

                    <a
                        href="{{ url('/jurusan/' . $segment . '/jasa') }}"
                        class="{{ Request::is('jurusan/' . $segment . '/jasa*') ? 'active' : '' }}"
                    >
                        JASA
                    </a>

                @else

                    <a
                        href="/"
                        class="{{ Request::is('/') ? 'active' : '' }}"
                    >
                        BERANDA
                    </a>

                    <a href="/#jurusan-unggulan">
                        JURUSAN
                    </a>

                    <a
                        href="/faq"
                        class="{{ Request::is('faq*') ? 'active' : '' }}"
                    >
                        FAQ
                    </a>

                @endif

                {{-- Profil: hanya tampil di dalam hamburger (HP/tablet) --}}
                <a href="/profil-pembeli" class="nav-profile-link">
                    <i class="ph ph-user"></i>
                    <span>{{ $profilLabel }}</span>
                </a>

            </div>


            {{-- ================= TOMBOL HAMBURGER ================= --}}

            <button
                type="button"
                class="jurusan-nav-toggle"
                id="jurusanNavToggle"
                aria-label="Buka menu navigasi"
                aria-expanded="false"
                aria-controls="jurusanNavMenu"
            >
                <i class="ph ph-list"></i>
            </button>


            {{-- ================= PENCARIAN + PROFIL (desktop) ================= --}}

            <div class="jurusan-nav-actions">

                <form
                    action="{{ route('public.pencarian') }}"
                    method="GET"
                    class="jurusan-nav-search"
                >

                    <button type="submit" aria-label="Cari">
                        <i class="ph ph-magnifying-glass"></i>
                    </button>

                    <input
                        type="text"
                        name="keyword"
                        placeholder="Cari produk, jasa..."
                        data-placeholder-mobile="Cari..."
                        value="{{ request('keyword') }}"
                    >

                </form>

                <a
                    href="/profil-pembeli"
                    class="jurusan-nav-profile"
                    title="Profil Pembeli"
                >
                    <i class="ph ph-user"></i>
                </a>

            </div>


        </div>

    </div>


    {{-- ================= KONTEN ================= --}}

    <main>

        @yield('content')

    </main>


    {{-- ================= FOOTER ================= --}}

    <footer class="footer">

        <div class="footer-grid">


            {{-- LOGO SMKN 4 --}}

            <div class="footer-col">

                <div class="footer-logo">

                    <img
                        src="{{ asset('images/logo-smk4.png') }}"
                        alt="Logo SMKN 4"
                    >

                    <h2>
                        TEACHING FACTORY
                        <br>
                        <span class="footer-logo-sub">SMKN 4 Tanjungpinang</span>
                    </h2>

                </div>

                <p class="footer-desc">
                    Mewujudkan pendidikan vokasi berbasis dunia kerja yang
                    inovatif, kreatif, dan berdaya saing global.
                </p>

            </div>


            {{-- LINK CEPAT --}}

            <div class="footer-col">

                <h3>LINK CEPAT</h3>

                <ul class="footer-links">

                    <li>
                        <a href="/">
                            <i class="ph ph-caret-right"></i>
                            Beranda
                        </a>
                    </li>

                    <li>
                        <a href="/#jurusan-unggulan">
                            <i class="ph ph-caret-right"></i>
                            Jurusan
                        </a>
                    </li>

                    <li>
                        <a href="/faq">
                            <i class="ph ph-caret-right"></i>
                            FAQ
                        </a>
                    </li>

                </ul>

            </div>


            {{-- INFORMASI --}}

            <div class="footer-col">

                <h3>INFORMASI</h3>

                <div class="footer-contact">
                    <i class="ph ph-map-pin"></i>
                    <span>Jl. Nusantara Km.14</span>
                </div>

                <div class="footer-contact">
                    <i class="ph ph-phone"></i>
                    <span>0771-123456</span>
                </div>

            </div>


            {{-- HUBUNGI KAMI --}}

            <div class="footer-col">

                <h3>HUBUNGI KAMI</h3>

                <img
                    src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=Halo+Admin+TEFA"
                    class="qr-code"
                    alt="QR Admin TEFA"
                >

            </div>


        </div>


        <div class="footer-bottom">
            &copy; 2026 SMKN 4 Tanjungpinang.
            All Rights Reserved.
        </div>

    </footer>


    {{-- WHATSAPP --}}

    <a href="#" class="fab-wa" aria-label="WhatsApp">
        <i class="ph ph-whatsapp-logo"></i>
    </a>


    @stack('scripts')


</body>

</html>