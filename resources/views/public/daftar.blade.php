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
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
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
                    class="ph ph-eye"
                    id="togglePasswordDaftar"
                    style="cursor: pointer; margin-right: 0; margin-left: 12px;"
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
                    class="ph ph-eye"
                    id="togglePasswordKonfirmasi"
                    style="cursor: pointer; margin-right: 0; margin-left: 12px;"
                ></i>

            </div>

        </div>


        <!-- TOMBOL DAFTAR -->
        <button
            type="submit"
            class="btn-login-submit"
            style="margin-top: 10px;"
        >
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
        style="color: white; font-weight: 600; text-decoration: underline;"
    >
        Masuk di sini
    </a>

</p>

</div>

<!-- ========================================================= SCRIPT VALIDASI + TOGGLE PASSWORD ========================================================= -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById(
        'formDaftarPembeli'
    );

    const nama = document.getElementById(
        'namaPembeli'
    );

    const nomorHp = document.getElementById(
        'nomorHpPembeli'
    );

    const email = document.getElementById(
        'emailDaftarPembeli'
    );

    const password = document.getElementById(
        'passwordDaftar'
    );

    const konfirmasi = document.getElementById(
        'passwordKonfirmasi'
    );


    /*
    |--------------------------------------------------------------------------
    | NAMA
    |--------------------------------------------------------------------------
    */

    function cekNama() {

        if (nama.value.trim() === '') {

            nama.setCustomValidity(
                'Nama lengkap wajib diisi.'
            );

            return false;
        }

        nama.setCustomValidity('');

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | NOMOR HP
    |--------------------------------------------------------------------------
    */

    function cekNomorHp() {

        nomorHp.value =
            nomorHp.value.replace(
                /[^0-9]/g,
                ''
            );

        if (nomorHp.value.trim() === '') {

            nomorHp.setCustomValidity(
                'Nomor telepon wajib diisi.'
            );

            return false;
        }

        nomorHp.setCustomValidity('');

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | EMAIL
    |--------------------------------------------------------------------------
    */

    function cekEmail() {

        const value =
            email.value.trim();

        if (value === '') {

            email.setCustomValidity(
                'Email wajib diisi.'
            );

            return false;
        }

        const polaEmail =
            /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!polaEmail.test(value)) {

            email.setCustomValidity(
                'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
            );

            return false;
        }

        email.setCustomValidity('');

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | PASSWORD
    |--------------------------------------------------------------------------
    */

    function cekPassword() {

        if (password.value === '') {

            password.setCustomValidity(
                'Password wajib diisi.'
            );

            return false;
        }

        if (password.value.length < 8) {

            password.setCustomValidity(
                'Password harus memiliki minimal 8 karakter.'
            );

            return false;
        }

        password.setCustomValidity('');

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | KONFIRMASI PASSWORD
    |--------------------------------------------------------------------------
    */

    function cekKonfirmasi() {

        if (konfirmasi.value === '') {

            konfirmasi.setCustomValidity(
                'Konfirmasi password wajib diisi.'
            );

            return false;
        }

        if (konfirmasi.value.length < 8) {

            konfirmasi.setCustomValidity(
                'Konfirmasi password harus memiliki minimal 8 karakter.'
            );

            return false;
        }

        if (
            konfirmasi.value !==
            password.value
        ) {

            konfirmasi.setCustomValidity(
                'Konfirmasi password tidak sama dengan password.'
            );

            return false;
        }

        konfirmasi.setCustomValidity('');

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | VALIDASI SAAT MENGETIK
    |--------------------------------------------------------------------------
    */

    nama.addEventListener(
        'input',
        function () {

            cekNama();

        }
    );


    nomorHp.addEventListener(
        'input',
        function () {

            cekNomorHp();

        }
    );


    email.addEventListener(
        'input',
        function () {

            cekEmail();

        }
    );


    password.addEventListener(
        'input',
        function () {

            cekPassword();

            if (
                konfirmasi.value !== ''
            ) {

                cekKonfirmasi();

            }

        }
    );


    konfirmasi.addEventListener(
        'input',
        function () {

            cekKonfirmasi();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | SUBMIT FORM
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        function (event) {

            const namaValid =
                cekNama();

            const nomorHpValid =
                cekNomorHp();

            const emailValid =
                cekEmail();

            const passwordValid =
                cekPassword();

            const konfirmasiValid =
                cekKonfirmasi();


            if (!namaValid) {

                event.preventDefault();

                nama.reportValidity();

                return;
            }


            if (!nomorHpValid) {

                event.preventDefault();

                nomorHp.reportValidity();

                return;
            }


            if (!emailValid) {

                event.preventDefault();

                email.reportValidity();

                return;
            }


            if (!passwordValid) {

                event.preventDefault();

                password.reportValidity();

                return;
            }


            if (!konfirmasiValid) {

                event.preventDefault();

                konfirmasi.reportValidity();

                return;
            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | TOGGLE PASSWORD
    |--------------------------------------------------------------------------
    */

    const togglePassword =
        document.getElementById(
            'togglePasswordDaftar'
        );


    if (
        togglePassword &&
        password
    ) {

        togglePassword.addEventListener(
            'click',
            function () {

                const type =
                    password.getAttribute(
                        'type'
                    ) === 'password'
                        ? 'text'
                        : 'password';


                password.setAttribute(
                    'type',
                    type
                );


                if (
                    type === 'password'
                ) {

                    this.classList.remove(
                        'ph-eye-slash'
                    );

                    this.classList.add(
                        'ph-eye'
                    );

                } else {

                    this.classList.remove(
                        'ph-eye'
                    );

                    this.classList.add(
                        'ph-eye-slash'
                    );

                }

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | TOGGLE KONFIRMASI PASSWORD
    |--------------------------------------------------------------------------
    */

    const toggleKonfirmasi =
        document.getElementById(
            'togglePasswordKonfirmasi'
        );


    if (
        toggleKonfirmasi &&
        konfirmasi
    ) {

        toggleKonfirmasi.addEventListener(
            'click',
            function () {

                const type =
                    konfirmasi.getAttribute(
                        'type'
                    ) === 'password'
                        ? 'text'
                        : 'password';


                konfirmasi.setAttribute(
                    'type',
                    type
                );


                if (
                    type === 'password'
                ) {

                    this.classList.remove(
                        'ph-eye-slash'
                    );

                    this.classList.add(
                        'ph-eye'
                    );

                } else {

                    this.classList.remove(
                        'ph-eye'
                    );

                    this.classList.add(
                        'ph-eye-slash'
                    );

                }

            }
        );

    }

});
</script>
@endsection