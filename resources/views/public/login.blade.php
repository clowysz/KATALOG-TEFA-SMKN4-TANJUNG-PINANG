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
        <h2>Selamat Datang</h2>
        <p>Silakan masuk untuk melanjutkan ke akun Anda.</p>
    </div>

    <div class="login-card">

        <!-- Ikon Avatar menonjol ke atas -->
        <div class="login-avatar">
            <i class="ph ph-user"></i>
        </div>

        <!-- Form Login -->
        <form
            action="{{ route('login.proses') }}"
            method="POST"
            id="formLoginPembeli"
        >
            @csrf

            @if($redirect)
                <input type="hidden" name="redirect" value="{{ $redirect }}">
            @endif

            @if($back)
                <input type="hidden" name="back" value="{{ $back }}">
            @endif

            <!-- EMAIL -->
            <div class="login-form-group">
                <label>Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <input
                        type="email"
                        name="email"
                        id="emailLoginPembeli"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
            </div>

            <!-- SANDI -->
            <div class="login-form-group">
                <label>Sandi</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input
                        type="password"
                        name="password"
                        id="passwordPembeli"
                        placeholder="Masukkan sandi"
                        required
                    >
                    <i
                        class="ph ph-eye toggle-eye"
                        id="togglePasswordPembeli"
                        data-toggle-password="#passwordPembeli"
                    ></i>
                </div>
            </div>

            <div class="login-options">
                <label>
                    <input type="checkbox">
                    Ingat saya
                </label>

                <a href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            </div>

            <button type="submit" class="btn-login-submit">
                Masuk
            </button>
        </form>
    </div>

    <!-- Teks Bawah dengan Link Daftar Akun -->
    <p class="login-footer-text">
        Belum punya akun?
        <a
            href="{{ route('pembeli.register', array_filter([
                'back' => $back,
                'redirect' => $redirect
            ])) }}"
        >
            Daftar akun
        </a>
    </p>

</div>

@endsection

@push('js')
    <script src="{{ asset('js/password-toggle.js') }}"></script>
    <script src="{{ asset('js/form-validasi.js') }}"></script>
    <script src="{{ asset('js/login-pembeli.js') }}"></script>
@endpush