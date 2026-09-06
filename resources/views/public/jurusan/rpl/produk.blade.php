@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 20px;">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; bottom: 40%; right: 20%; animation-duration: 5s;"></div>

    <div class="jurusan-hero-content">
        <div class="jurusan-hero-image">
            <img src="{{ asset('images/rpl-lab.jpeg') }}" alt="Produk RPL">
        </div>
        <div class="jurusan-hero-text">
            <h3>PRODUK</h3>
            <h1>PRODUK KAMI</h1>
            <p>Berbagai produk digital inovatif yang dikembangkan oleh siswa-siswi SMKN 4 Tanjungpinang untuk memenuhi kebutuhan di era digital.</p>
            <a href="/jurusan" class="btn-kembali-beranda">
                <i class="ph ph-arrow-u-up-left"></i> Kembali ke Daftar Jurusan
            </a>
        </div>
    </div>

    <svg class="wave-jurusan" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>

<section class="katalog-section">
    <div class="katalog-header">
        <h2>Produk Terlaris</h2>
        <a href="#">Lihat Semua Produk &gt;</a>
    </div>

    <div class="katalog-grid">
        <!-- Produk 1 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Produk</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Web+Profil+Sekolah" alt="Website Profil Sekolah">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Website Profil Sekolah</h3>
                <p class="k-card-desc">Website profil sekolah yang modern dan responsif untuk kebutuhan branding pendidikan.</p>
                <div class="k-card-price">Rp1.000.000</div>
                <a href="/jurusan/rpl/produk/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>

        <!-- Produk 2 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Produk</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Web+UMKM+Kijang" alt="Website UMKM">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Website UMKM Kijang</h3>
                <p class="k-card-desc">Katalog online untuk UMKM dengan fitur pemesanan langsung via WhatsApp.</p>
                <div class="k-card-price">Rp2.000.000</div>
                <a href="/jurusan/rpl/produk/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>

        <!-- Produk 3 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Produk</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=App+Inventaris" alt="Aplikasi Inventaris">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Aplikasi Inventaris Barang</h3>
                <p class="k-card-desc">Aplikasi inventaris barang berbasis mobile untuk memudahkan pencatatan stok.</p>
                <div class="k-card-price">Rp750.000</div>
                <a href="/jurusan/rpl/produk/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>
        
        <!-- Produk 4 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Produk</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Sistem+Monitoring" alt="Sistem Monitoring">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Sistem Monitoring Jaringan</h3>
                <p class="k-card-desc">Sistem pemantauan status jaringan secara real-time berbasis antarmuka web.</p>
                <div class="k-card-price">Rp1.500.000</div>
                <a href="/jurusan/rpl/produk/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>
    </div>
</section>

@endsection