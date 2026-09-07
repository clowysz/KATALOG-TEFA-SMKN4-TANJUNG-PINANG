@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 20px; position: relative;">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    
    <div class="jurusan-hero-content" style="position: relative; z-index: 10;">
        <div class="jurusan-hero-image">
            <img src="{{ asset('images/labor.jpeg') }}" alt="Portofolio RPL">
        </div>
        <div class="jurusan-hero-text">
            <h3>PORTOFOLIO</h3>
            <h1>KARYA & PROYEK RPL</h1>
            <p>Berbagai karya, inovasi, dan prestasi siswa SMKN 4 Tanjungpinang yang membanggakan.</p>
            <a href="/#jurusan-unggulan" class="btn-kembali-beranda" style="position: relative; z-index: 50;">
                <i class="ph ph-arrow-u-up-left"></i> Kembali ke Daftar Jurusan
            </a>
        </div>
    </div>
    
    <svg class="wave-jurusan" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: -1px; left: 0; width: 100%; display: block; z-index: 1;">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>

<section class="katalog-section">
    <div class="katalog-header">
        <h2>Portofolio Terbaru</h2>
        <a href="#">Lihat Semua Portofolio &gt;</a>
    </div>

    <div class="katalog-grid">
        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Karya</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=IoT+Irigasi" alt="Portofolio">
            </div>
            <div class="k-card-body">
                <div class="k-card-year">2026</div>
                <h3 class="k-card-title">IoT Untuk Irigasi Cerdas</h3>
                <p class="k-card-desc">Sistem pengairan otomatis berbasis Internet of Things untuk pertanian modern.</p>
                <a href="/jurusan/rpl/portofolio/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>

        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Karya</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=App+E-Learning" alt="Portofolio">
            </div>
            <div class="k-card-body">
                <div class="k-card-year">2025</div>
                <h3 class="k-card-title">Aplikasi E-Learning Sederhana</h3>
                <p class="k-card-desc">Platform belajar interaktif yang digunakan oleh siswa internal sekolah.</p>
                <a href="/jurusan/rpl/portofolio/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>

        <div class="k-card">
            <div class="k-card-img">
                <div class="k-badge">Karya</div>
                <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Robot+Line+Follower" alt="Portofolio">
            </div>
            <div class="k-card-body">
                <div class="k-card-year">2025</div>
                <h3 class="k-card-title">Robot Line Follower</h3>
                <p class="k-card-desc">Juara 1 Lomba Robotik tingkat Provinsi Kepulauan Riau.</p>
                <a href="/jurusan/rpl/portofolio/detail" class="k-card-btn">Lihat Selengkapnya &gt;</a>
            </div>
        </div>
    </div>
</section>
@endsection 