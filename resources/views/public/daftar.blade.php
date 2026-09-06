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
        <h2>Daftar Akun</h2>
        <p>Buat akun baru untuk mengakses semua fitur yang tersedia.</p>
    </div>

    <div class="login-card">
        <!-- Ikon Avatar Tambah -->
        <div class="login-avatar">
            <i class="ph ph-user-plus"></i>
        </div>

        <form action="/login-pembeli" method="GET">
            <div class="login-form-group">
                <label>Nama Lengkap</label>
                <div class="login-input-box">
                    <i class="ph ph-user"></i>
                    <input type="text" placeholder="Masukkan nama lengkap" required>
                </div>
            </div>

            <div class="login-form-group">
                <label>No. Telepon</label>
                <div class="login-input-box">
                    <i class="ph ph-phone"></i>
                    <input type="text" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Contoh: 08123456789" required>
                </div>
            </div>

            <div class="login-form-group">
                <label>Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <input type="email" placeholder="Masukkan email" required>
                </div>
            </div>

            <div class="login-form-group">
                <label>Password</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input type="password" id="passwordDaftar" placeholder="Minimal 8 karakter" required>
                    <i class="ph ph-eye" id="togglePasswordDaftar" style="cursor: pointer; margin-right: 0; margin-left: 12px;"></i>
                </div>
            </div>

            <div class="login-form-group">
                <label>Konfirmasi Password</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input type="password" id="passwordKonfirmasi" placeholder="Ulangi password" required>
                    <i class="ph ph-eye" id="togglePasswordKonfirmasi" style="cursor: pointer; margin-right: 0; margin-left: 12px;"></i>
                </div>
            </div>

            <button type="submit" class="btn-login-submit" style="margin-top: 10px;">Daftar</button>
        </form>
    </div>

    <!-- Teks Bawah Kembali ke Login -->
    <p class="login-footer-text">
        Sudah punya akun? <a href="/login-pembeli" style="color: white; font-weight: 600; text-decoration: underline;">Masuk di sini</a>
    </p>
</div>

<!-- Script untuk Toggle Password -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Toggle Password 1
        const togglePass1 = document.querySelector('#togglePasswordDaftar');
        const pass1 = document.querySelector('#passwordDaftar');
        if(togglePass1 && pass1) {
            togglePass1.addEventListener('click', function () {
                const type = pass1.getAttribute('type') === 'password' ? 'text' : 'password';
                pass1.setAttribute('type', type);
                this.classList.toggle('ph-eye');
                this.classList.toggle('ph-eye-slash');
            });
        }

        // Toggle Password 2
        const togglePass2 = document.querySelector('#togglePasswordKonfirmasi');
        const pass2 = document.querySelector('#passwordKonfirmasi');
        if(togglePass2 && pass2) {
            togglePass2.addEventListener('click', function () {
                const type = pass2.getAttribute('type') === 'password' ? 'text' : 'password';
                pass2.setAttribute('type', type);
                this.classList.toggle('ph-eye');
                this.classList.toggle('ph-eye-slash');
            });
        }
    });
</script>

@endsection