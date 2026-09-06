@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
@endpush

@section('content')

<div class="login-page-wrapper">
    <!-- Animasi Gelembung -->
    <div class="bubble" style="width: 80px; height: 80px; top: 15%; left: 15%; animation-duration: 5s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 40%; right: 15%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 50px; height: 50px; bottom: 25%; left: 25%; animation-duration: 6s;"></div>
    <div class="bubble" style="width: 90px; height: 90px; bottom: 15%; right: 25%; animation-duration: 8s;"></div>

    <div class="login-header-text">
        <h2>Selamat Datang</h2>
        <p>Silakan masuk untuk melanjutkan ke akun Anda.</p>
    </div>

    <div class="login-card">
        <!-- Ikon Avatar menonjol ke atas -->
        <div class="login-avatar">
            <i class="ph ph-user"></i>
        </div>

        <form action="/checkout" method="GET">
            <!-- Hanya Email dan Sandi -->
            <div class="login-form-group">
                <label>Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <input type="email" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="login-form-group">
                <label>Sandi</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input type="password" id="passwordPembeli" placeholder="Masukkan sandi" required>
                    <i class="ph ph-eye" id="togglePasswordPembeli" style="cursor: pointer; margin-right: 0; margin-left: 12px;"></i>
                </div>
            </div>

            <div class="login-options">
                <label>
                    <input type="checkbox"> Ingat saya
                </label>
                <a href="#">Lupa sandi?</a>
            </div>

            <button type="submit" class="btn-login-submit">Masuk</button>
        </form>
    </div>

    <!-- Teks Bawah dengan Link Daftar Akun -->
    <p class="login-footer-text">
        Belum punya akun? <a href="/daftar-pembeli" style="color: white; font-weight: 600; text-decoration: underline;">Daftar akun</a>
    </p>
</div>

<!-- Script untuk Tombol Mata Password -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelector('#togglePasswordPembeli');
        const password = document.querySelector('#passwordPembeli');

        if (togglePassword && password) {
            togglePassword.addEventListener('click', function () {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                if (type === 'password') {
                    this.classList.remove('ph-eye-slash');
                    this.classList.add('ph-eye');
                } else {
                    this.classList.remove('ph-eye');
                    this.classList.add('ph-eye-slash');
                }
            });
        }
    });
</script>

@endsection