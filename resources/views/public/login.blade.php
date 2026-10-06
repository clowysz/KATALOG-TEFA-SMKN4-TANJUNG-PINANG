@extends('public.layouts')

@push('css') <link rel="stylesheet" href="{{ asset('css/login-pembeli.css') }}">
@endpush

@section('content')

<div class="login-page-wrapper">

```
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
            <input
                type="hidden"
                name="redirect"
                value="{{ $redirect }}"
            >
        @endif

        @if($back)
            <input
                type="hidden"
                name="back"
                value="{{ $back }}"
            >
        @endif

        <!-- EMAIL -->
        <div class="login-form-group">
            <label>Email</label>

            <div class="login-input-box">
                <i class="ph ph-envelope"></i>

                <input
                    type="email"
                    name="email"
                    id="emailPembeli"
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
                    class="ph ph-eye"
                    id="togglePasswordPembeli"
                    style="cursor: pointer; margin-right: 0; margin-left: 12px;"
                ></i>
            </div>
        </div>

        <div class="login-options">
            <label>
                <input type="checkbox">
                Ingat saya
            </label>

            <a href="#">
                Lupa sandi?
            </a>
        </div>

        <button
            type="submit"
            class="btn-login-submit"
        >
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
        style="color: white; font-weight: 600; text-decoration: underline;"
    >
        Daftar akun
    </a>
</p>
```

</div>

<!-- Script Validasi + Tombol Mata Password -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formLoginPembeli = document.getElementById('formLoginPembeli');
    const emailInput = document.getElementById('emailPembeli');
    const passwordInput = document.getElementById('passwordPembeli');
    const togglePassword = document.getElementById('togglePasswordPembeli');


    // =========================================================
    // TOGGLE PASSWORD
    // =========================================================

    if (togglePassword && passwordInput) {

        togglePassword.addEventListener('click', function () {

            const type = passwordInput.getAttribute('type') === 'password'
                ? 'text'
                : 'password';

            passwordInput.setAttribute('type', type);

            if (type === 'password') {

                this.classList.remove('ph-eye-slash');
                this.classList.add('ph-eye');

            } else {

                this.classList.remove('ph-eye');
                this.classList.add('ph-eye-slash');

            }
        });
    }


    // =========================================================
    // EMAIL
    // =========================================================

    if (emailInput) {

        function validateEmail() {

            const value = emailInput.value.trim();

            // Email kosong
            if (value === '') {

                emailInput.setCustomValidity(
                    'Email wajib diisi.'
                );

                return;
            }


            // Format email
            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;


            if (!emailPattern.test(value)) {

                emailInput.setCustomValidity(
                    'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
                );

                return;
            }


            // Valid
            emailInput.setCustomValidity('');
        }


        emailInput.addEventListener('invalid', function () {
            validateEmail();
        });


        emailInput.addEventListener('input', function () {
            validateEmail();
        });
    }


    // =========================================================
    // SANDI
    // =========================================================

    if (passwordInput) {

        passwordInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Kata sandi wajib diisi.'
                );

            } else {

                this.setCustomValidity('');
            }
        });


        passwordInput.addEventListener('input', function () {

            if (this.value.trim() === '') {

                this.setCustomValidity(
                    'Kata sandi wajib diisi.'
                );

            } else {

                this.setCustomValidity('');
            }
        });
    }


    // =========================================================
    // VALIDASI SAAT SUBMIT
    // =========================================================

    if (formLoginPembeli) {

        formLoginPembeli.addEventListener('submit', function () {

            // Validasi email
            if (emailInput) {
                emailInput.dispatchEvent(
                    new Event('input', { bubbles: true })
                );
            }


            // Validasi sandi
            if (passwordInput) {
                passwordInput.dispatchEvent(
                    new Event('input', { bubbles: true })
                );
            }
        });
    }

});
</script>

@endsection
