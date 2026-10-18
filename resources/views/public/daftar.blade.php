@extends('public.layouts')

@push('css')
<link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
@endpush

@section('content')

<div class="login-page-wrapper">

    {{-- Tombol Kembali --}}
    @if($back)
        <div class="login-back-button">
            <a href="{{ $back }}">
                <i class="ph ph-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
    @endif

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

        <!-- Form Registrasi -->
        <form
            action="{{ route('pembeli.register.proses') }}"
            method="POST"
            id="formDaftarPembeli"
            novalidate
        >

            @csrf

            @if($redirect)
                <input type="hidden" name="redirect" value="{{ $redirect }}">
            @endif

            @if($back)
                <input type="hidden" name="back" value="{{ $back }}">
            @endif


            <!-- NAMA LENGKAP -->
            <div class="login-form-group">

                <label>Nama Lengkap</label>

                <div class="login-input-box">

                    <i class="ph ph-user"></i>

                    <input
                        type="text"
                        name="nama"
                        id="namaPembeli"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama') }}"
                        required
                    >

                </div>

            </div>


            <!-- NO. TELEPON -->
            <div class="login-form-group">

                <label>No. Telepon</label>

                <div class="login-input-box">

                    <i class="ph ph-phone"></i>

                    <input
                        type="text"
                        name="nomor_hp"
                        id="nomorHpPembeli"
                        inputmode="numeric"
                        placeholder="Contoh: 08123456789"
                        value="{{ old('nomor_hp') }}"
                        required
                    >

                </div>

            </div>


            <!-- EMAIL -->
            <div class="login-form-group">

                <label>Email</label>

                <div class="login-input-box">

                    <i class="ph ph-envelope"></i>

                    <input
                        type="email"
                        name="email"
                        id="emailDaftarPembeli"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >

                </div>

            </div>


            <!-- PASSWORD -->
            <div class="login-form-group">

                <label>Password</label>

                <div class="login-input-box">

                    <i class="ph ph-lock-key"></i>

                    <input
                        type="password"
                        name="password"
                        id="passwordDaftar"
                        placeholder="Minimal 8 karakter"
                        minlength="8"
                        required
                    >

                    <i
                        class="ph ph-eye toggle-eye"
                        id="togglePasswordDaftar"
                        data-toggle-password="#passwordDaftar"
                    ></i>

                </div>

            </div>


            <!-- KONFIRMASI PASSWORD -->
            <div class="login-form-group">

                <label>Konfirmasi Password</label>

                <div class="login-input-box">

                    <i class="ph ph-lock-key"></i>

                    <input
                        type="password"
                        name="password_confirmation"
                        id="passwordKonfirmasi"
                        placeholder="Ulangi password"
                        minlength="8"
                        required
                    >

                    <i
                        class="ph ph-eye toggle-eye"
                        id="togglePasswordKonfirmasi"
                        data-toggle-password="#passwordKonfirmasi"
                    ></i>

                </div>

            </div>


            <!-- TOMBOL DAFTAR -->
            <button type="submit" class="btn-login-submit btn-spaced">
                Daftar
            </button>

        </form>

    </div>


    <!-- Teks Bawah Kembali ke Login -->
    <p class="login-footer-text">

        Sudah punya akun?

        <a
            href="{{ route('login', array_filter([
                'back' => $back,
                'redirect' => $redirect
            ])) }}"
        >
            Masuk di sini
        </a>

    </p>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/password-toggle.js') }}"></script>
    <script src="{{ asset('js/register-pembeli.js') }}"></script>
@endpush