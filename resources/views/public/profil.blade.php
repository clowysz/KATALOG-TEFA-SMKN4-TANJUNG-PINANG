@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-pembeli.css') }}">
@endpush

@section('content')
<div class="page-wrapper-blue">
    <!-- Gelembung Dekorasi -->
    <div class="bubble" style="width: 100px; height: 100px; top: 15%; right: 10%; animation-duration: 8s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; top: 40%; left: 10%; animation-duration: 6s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; bottom: 10%; right: 20%; animation-duration: 9s;"></div>

    <div style="width: 100%; max-width: 600px; z-index: 10;">
        <a href="/" class="btn-back-white">
            <i class="ph ph-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <!-- Kartu Kaca (Glassmorphism) -->
    <div class="glass-card">
        <div class="profil-header-center">
            <div class="profil-avatar-icon"><i class="ph ph-user"></i></div>
            <div class="profil-name">Andira Brikendi Refica Sado</div>
        </div>

        <div class="profil-row">
            <div class="profil-label"><i class="ph ph-phone"></i> No. Telpon</div>
            <input type="text" class="profil-input" value="+62 | 865 - 1899 - 9292" readonly>
        </div>

        <div class="profil-row">
            <div class="profil-label"><i class="ph ph-envelope-simple"></i> Email</div>
            <input type="text" class="profil-input" value="Andiradira123@gmail.com" readonly>
        </div>

        <div class="profil-row">
            <div class="profil-label"><i class="ph ph-lock-key"></i> Sandi</div>
            <input type="password" class="profil-input" value="123456" readonly>
        </div>

        <!-- Area Tombol -->
        <div style="display: flex; flex-direction: column; align-items: center; margin-top: 40px; gap: 16px;">
            <!-- Tombol Menuju Riwayat Pesanan -->
            <a href="/riwayat-pesanan" class="btn-riwayat-pesanan" style="margin: 0;">Riwayat Pesanan</a>
            
            <!-- Tombol Logout di Kanan Bawah -->
            <div style="width: 100%; display: flex; justify-content: flex-end;">
                <a href="/login-pembeli" class="btn-logout-right" style="margin: 0;">Keluar Akun</a>
            </div>
        </div>

    </div>
</div>
@endsection