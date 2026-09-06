@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="/jurusan/rpl/jasa" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali ke Jasa
        </a>
    </div>

    <div class="detail-top-container">
        <div class="detail-gallery">
            <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Jasa+Maintenance" class="main-image" alt="Jasa Maintenance">
        </div>

        <div class="detail-info">
            <div class="detail-badge">JASA LAYANAN</div>
            <h1 class="detail-title">Maintenance & Support IT</h1>
            
            <!-- TOMBOL PESAN SEKARANG -->
            <a href="/login-pembeli" class="btn-pesan">
                <i class="ph ph-shopping-cart" style="font-size: 24px;"></i> Pesan Jasa Ini
            </a>
        </div>
    </div>

    <div class="detail-card">
        <h2 class="detail-section-title">Deskripsi Jasa</h2>
        <p class="detail-text">Layanan perawatan sistem, jaringan, dan perangkat lunak secara berkala untuk memastikan operasional bisnis Anda berjalan lancar tanpa kendala teknis.</p>

        <h2 class="detail-section-title">Apa yang Anda Dapatkan?</h2>
        <ul class="detail-list">
            <li><i class="ph ph-check-circle"></i> Pengecekan kesehatan server dan jaringan</li>
            <li><i class="ph ph-check-circle"></i> Pembaruan keamanan (Security Patch)</li>
            <li><i class="ph ph-check-circle"></i> Backup data rutin mingguan</li>
            <li><i class="ph ph-check-circle"></i> Dukungan teknis via Remote / On-site</li>
        </ul>

        <h2 class="detail-section-title">Spesifikasi Layanan</h2>
        <table class="spec-table">
            <tr><td>Sistem Kerja</td><td>: Kontrak Bulanan / Panggilan</td></tr>
            <tr><td>Kunjungan</td><td>: Maksimal 4x Kunjungan Fisik / Bulan</td></tr>
            <tr><td>Waktu Respon</td><td>: 1 x 24 Jam</td></tr>
            <tr><td>Harga</td><td>: Rp500.000 / Bulan</td></tr>
        </table>
    </div>
</div>
@endsection