@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 20px;">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    
    <div class="jurusan-hero-content">
        <div class="jurusan-hero-image">
            <img src="{{ asset('images/rpl-lab.jpeg') }}" alt="Jasa RPL">
        </div>
        <div class="jurusan-hero-text">
            <h3>JASA</h3>
            <h1>LAYANAN JASA</h1>
            <p>Kami menyediakan berbagai layanan di bidang teknologi informasi yang dirancang untuk membantu kebutuhan teknis maupun instansi.</p>
            <a href="/jurusan" class="btn-kembali-beranda"><i class="ph ph-arrow-u-up-left"></i> Kembali ke Daftar Jurusan</a>
        </div>
    </div>
    
    <svg class="wave-jurusan" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg"><path fill="#F8FAFC" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
</section>

<section class="katalog-section">
    <div class="katalog-header">
        <h2>Jasa Terlaris</h2>
        <a href="#">Lihat Semua Jasa &gt;</a>
    </div>

    <div class="katalog-grid">
        <!-- Jasa 1 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Jasa</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Maintenance+Server" alt="Jasa">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Maintenance & Support</h3>
                <p class="k-card-desc">Layanan perawatan sistem, update keamanan, dan dukungan teknis secara berkala.</p>
                <div class="k-card-price">Rp500.000 / Bulan</div>
                <a href="/jurusan/rpl/jasa/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>

        <!-- Jasa 2 -->
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Jasa</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Instalasi+Jaringan" alt="Jasa">
            </div>
            <div class="k-card-body">
                <h3 class="k-card-title">Instalasi Jaringan Komputer</h3>
                <p class="k-card-desc">Pemasangan dan konfigurasi jaringan LAN/Wi-Fi untuk kantor dan sekolah.</p>
                <div class="k-card-price">Mulai Rp1.200.000</div>
                <a href="/jurusan/rpl/jasa/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>
    </div>
</section>

@endsection