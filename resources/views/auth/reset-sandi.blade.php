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

        .login-alert-error {
            background: #fee2e2;
            color: #991b1b;
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
                        class="ph ph-eye toggle-password"
                        data-target="password"
                        style="cursor: pointer; margin-right: 0; margin-left: 12px;"
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
                        class="ph ph-eye toggle-password"
                        data-target="password_confirmation"
                        style="cursor: pointer; margin-right: 0; margin-left: 12px;"
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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');

    // ================= TOGGLE MATA =================
    document.querySelectorAll('.toggle-password').forEach(function (icon) {
        icon.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            if (!input) return;

            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');

            this.classList.toggle('ph-eye', !isPassword);
            this.classList.toggle('ph-eye-slash', isPassword);
        });
    });

    // ================= SANDI BARU =================
    if (passwordInput) {

        passwordInput.addEventListener('invalid', function () {
            if (this.validity.valueMissing) {
                this.setCustomValidity('Sandi baru wajib diisi.');
            } else {
                this.setCustomValidity('');
            }
        });

        passwordInput.addEventListener('input', function () {
            this.setCustomValidity('');
            checkConfirmation();
        });
    }

    // ================= KONFIRMASI SANDI =================
    function checkConfirmation() {

        if (!confirmInput || !passwordInput) return;

        if (confirmInput.value === '') {
            confirmInput.setCustomValidity('Konfirmasi sandi wajib diisi.');
            return;
        }

        if (confirmInput.value !== passwordInput.value) {
            confirmInput.setCustomValidity('Konfirmasi sandi tidak sama dengan sandi baru.');
            return;
        }

        confirmInput.setCustomValidity('');
    }

    if (confirmInput) {
        confirmInput.addEventListener('invalid', checkConfirmation);
        confirmInput.addEventListener('input', checkConfirmation);
    }

});
</script>

@endsection