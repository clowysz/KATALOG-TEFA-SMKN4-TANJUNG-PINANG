@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
    <style>
        .login-alert {
            padding: 12px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            line-height: 1.5;
            text-align: left;
        }

        .login-alert-success {
            background: #dcfce7;
            color: #166534;
        }

        .login-alert-error {
            background: #fee2e2;
            color: #991b1b;
        }

        .login-alert a {
            display: block;
            margin-top: 8px;
            color: #1E3A8A;
            font-weight: 600;
            text-decoration: underline;
        }
    </style>
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
        <h2>Lupa Sandi?</h2>
        <p>Masukkan email yang terdaftar untuk mengatur ulang sandi Anda.</p>
    </div>

    <div class="login-card">

        <div class="login-avatar">
            <i class="ph ph-lock-key-open"></i>
        </div>

        {{-- Pesan berhasil --}}
        @if(session('status'))
            <div class="login-alert login-alert-success">
                {{ session('status') }}

                @if(session('reset_url'))
                    <a href="{{ session('reset_url') }}">
                        Buka Link Reset Sandi
                    </a>
                @endif
            </div>
        @endif

        {{-- Pesan error --}}
        @if($errors->any())
            <div class="login-alert login-alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="login-form-group">
                <label for="email">Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
            </div>

            <button type="submit" class="btn-login-submit">
                Kirim Link Reset Sandi
            </button>
        </form>
    </div>

    <p class="login-footer-text">
        Ingat sandi Anda?
        <a href="{{ route('login') }}">Masuk</a>
    </p>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const emailInput = document.getElementById('email');

    if (emailInput) {

        function validateEmail() {

            const value = emailInput.value.trim();

            if (value === '') {
                emailInput.setCustomValidity('Email wajib diisi.');
                return;
            }

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(value)) {
                emailInput.setCustomValidity(
                    'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
                );
                return;
            }

            emailInput.setCustomValidity('');
        }

        emailInput.addEventListener('invalid', validateEmail);
        emailInput.addEventListener('input', validateEmail);
    }

});
</script>
@endsection