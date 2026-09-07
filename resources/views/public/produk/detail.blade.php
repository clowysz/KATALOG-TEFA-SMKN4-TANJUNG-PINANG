@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">
    
    <!-- Tombol Kembali -->
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="/jurusan/rpl/produk" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali ke Produk
        </a>
    </div>

    <!-- Bagian Atas: Gambar & Judul -->
    <div class="detail-top-container">
        <!-- Galeri Gambar -->
        <div class="detail-gallery">
            <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Web+Profil+Utama" class="main-image" alt="Website Profil Sekolah">
            <div class="thumbnail-list">
                <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Tampilan+1" class="thumb-item active" alt="Thumb 1">
                <img src="https://placehold.co/800x600/CBD5E1/1E3A8A?text=Tampilan+2" class="thumb-item" alt="Thumb 2">
                <img src="https://placehold.co/800x600/94A3B8/FFFFFF?text=Tampilan+3" class="thumb-item" alt="Thumb 3">
            </div>
        </div>

        <!-- Info Produk -->
        <div class="detail-info">
            <div class="detail-badge">PRODUK</div>
            <h1 class="detail-title">Website Profil Sekolah</h1>
            
            <!-- TOMBOL MENUJU LOGIN -->
            <a href="/login-pembeli" class="btn-pesan">
                <i class="ph ph-shopping-cart" style="font-size: 24px;"></i> Pesan Sekarang
            </a>
        </div>
    </div>

    <!-- Bagian Bawah: Deskripsi & Spesifikasi -->
    <div class="detail-card">
        
        <h2 class="detail-section-title">Deskripsi Produk</h2>
        <p class="detail-text">Website Profil Sekolah adalah solusi digital untuk menampilkan informasi sekolah secara lengkap, modern, dan mudah diakses. Website ini dirancang responsif agar dapat diakses di berbagai perangkat, serta mudah dikelola oleh admin sekolah tanpa memerlukan keahlian teknis.</p>
        <p class="detail-text">Cocok digunakan oleh sekolah yang ingin meningkatkan citra profesional dan memperluas jangkauan informasi kepada siswa, orang tua, dan masyarakat.</p>

        <h2 class="detail-section-title">Fitur Unggulan</h2>
        <ul class="detail-list">
            <li><i class="ph ph-check-circle"></i> Desain responsif dan modern</li>
            <li><i class="ph ph-check-circle"></i> Profil sekolah lengkap (visi, misi, sejarah, struktur organisasi)</li>
            <li><i class="ph ph-check-circle"></i> Informasi berita dan pengumuman</li>
            <li><i class="ph ph-check-circle"></i> Galeri foto dan video kegiatan</li>
            <li><i class="ph ph-check-circle"></i> Formulir pendaftaran siswa baru online</li>
            <li><i class="ph ph-check-circle"></i> Mudah dikelola melalui dashboard admin</li>
        </ul>

        <h2 class="detail-section-title">Spesifikasi Teknis</h2>
        <table class="spec-table">
            <tr>
                <td>Platform</td>
                <td>: Web (Responsive)</td>
            </tr>
            <tr>
                <td>Teknologi</td>
                <td>: PHP, MySQL, HTML, CSS, JavaScript</td>
            </tr>
            <tr>
                <td>Framework</td>
                <td>: Laravel / CodeIgniter</td>
            </tr>
            <tr>
                <td>Database</td>
                <td>: MySQL</td>
            </tr>
            <tr>
                <td>Panel Admin</td>
                <td>: Ya</td>
            </tr>
            <tr>
                <td>Durasi</td>
                <td>: 7 - 14 Hari (estimasi)</td>
            </tr>
            <tr>
                <td>Support</td>
                <td>: Ya (WhatsApp / Email)</td>
            </tr>
        </table>

    </div>
</div>

@endsection