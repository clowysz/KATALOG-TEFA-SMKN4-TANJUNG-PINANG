@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">
    <!-- Tombol Kembali -->
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="/jurusan/rpl/portofolio" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali ke Portofolio
        </a>
    </div>

    <!-- Bagian Atas: Gambar & Judul -->
    <div class="detail-top-container">
        <div class="detail-gallery">
            <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Jasa+Buat+Portofolio" class="main-image" alt="Pembuatan Portofolio">
            <div class="thumbnail-list">
                <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Desain+1" class="thumb-item active" alt="Thumb 1">
                <img src="https://placehold.co/800x600/CBD5E1/1E3A8A?text=Desain+2" class="thumb-item" alt="Thumb 2">
            </div>
        </div>

        <div class="detail-info">
            <div class="detail-badge" style="background: #D8893D; color: white;">LAYANAN PORTOFOLIO</div>
            <h1 class="detail-title">Pembuatan Website Portofolio Personal</h1>
            
            <!-- TOMBOL PESAN SEKARANG DIKEMBALIKAN -->
            <a href="/login-pembeli" class="btn-pesan">
                <i class="ph ph-shopping-cart" style="font-size: 24px;"></i> Pesan Sekarang
            </a>
        </div>
    </div>

    <!-- Bagian Bawah: Deskripsi -->
    <div class="detail-card">
        <h2 class="detail-section-title">Deskripsi Layanan</h2>
        <p class="detail-text">Kami menyediakan layanan pembuatan website portofolio profesional untuk menampilkan karya, CV, dan pencapaian Anda. Sangat cocok bagi desainer, fotografer, programmer, maupun profesional lainnya yang ingin meningkatkan personal branding di dunia digital.</p>

        <h2 class="detail-section-title">Fitur yang Didapatkan</h2>
        <ul class="detail-list">
            <li><i class="ph ph-check-circle"></i> Desain elegan, modern, dan sesuai karakter Anda</li>
            <li><i class="ph ph-check-circle"></i> Galeri karya interaktif (Foto/Video/Project)</li>
            <li><i class="ph ph-check-circle"></i> Tampilan responsif (Bagus di HP & Laptop)</li>
            <li><i class="ph ph-check-circle"></i> Formulir kontak langsung ke email/WhatsApp Anda</li>
            <li><i class="ph ph-check-circle"></i> Integrasi ke media sosial (LinkedIn, Instagram, dll)</li>
        </ul>

        <h2 class="detail-section-title">Spesifikasi & Harga</h2>
        <table class="spec-table">
            <tr><td>Platform</td><td>: Web (HTML/CSS/JS atau WordPress)</td></tr>
            <tr><td>Waktu Pengerjaan</td><td>: 5 - 10 Hari Kerja</td></tr>
            <tr><td>Revisi Desain</td><td>: Maksimal 3 Kali</td></tr>
            <tr><td>Harga</td><td>: Mulai Rp750.000</td></tr>
        </table>
    </div>
</div>
@endsection