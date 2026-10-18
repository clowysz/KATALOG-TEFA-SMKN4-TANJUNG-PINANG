@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
@endpush

@section('content')

<div class="login-page-wrapper">

    {{-- Tombol Kembali --}}
    <div class="login-back-button">
        <a href="{{ route('login') }}">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Animasi Gelembung -->
    <div class="bubble" style="width: 80px; height: 80px; top: 15%; left: 15%; animation-duration: 5s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 40%; right: 15%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 50px; height: 50px; bottom: 25%; left: 25%; animation-duration: 6s;"></div>
    <div class="bubble" style="width: 90px; height: 90px; bottom: 15%; right: 25%; animation-duration: 8s;"></div>

    <div class="login-header-text">
        <h2>Buat Sandi Baru</h2>
        <p>Silakan buat sandi baru untuk akun Anda.</p>
    </div>

    <div class="login-card">

        <div class="login-avatar">
            <i class="ph ph-lock-key-open"></i>
        </div>

        @if($errors->any())
            <div class="login-alert login-alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="login-form-group">
                <label for="password">Sandi Baru</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan sandi baru"
                        required
                    >
                    <i
                        class="ph ph-eye toggle-eye"
                        data-toggle-password="#password"
                    ></i>
                </div>
            </div>

            <div class="login-form-group">
                <label for="password_confirmation">Konfirmasi Sandi</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi sandi baru"
                        required
                    >
                    <i
                        class="ph ph-eye toggle-eye"
                        data-toggle-password="#password_confirmation"
                    ></i>
                </div>
            </div>

            <button type="submit" class="btn-login-submit">
                Simpan Sandi Baru
            </button>
        </form>
    </div>

    <p class="login-footer-text">
        Ingat sandi Anda?
        <a href="{{ route('login') }}">Masuk</a>
    </p>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/password-toggle.js') }}"></script>
    <script src="{{ asset('js/reset-sandi-pembeli.js') }}"></script>
@endpush