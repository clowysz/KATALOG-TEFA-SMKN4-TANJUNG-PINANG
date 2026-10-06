@extends('admin.layouts.app-jurusan')

@section('title', 'Tambah Akun')

@section('content')

<div class="jurusan-akun-create-container">

    {{-- Tombol kembali --}}
    <a
        href="/jurusan-admin/akun"
        class="jurusan-akun-back"
    >
        &larr; Kembali ke Daftar Akun
    </a>


    <h2 class="jurusan-akun-create-title">
        Tambah Akun Baru
    </h2>


    <div class="jurusan-akun-form-card">

        {{-- Pesan error validasi --}}
        @if($errors->any())

            <div class="jurusan-akun-error">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
    id="formTambahAkun"
    action="{{ route('jurusan.akun.store') }}"
    method="POST"
>

            @csrf


            {{-- NAMA PENGGUNA --}}
            <div class="jurusan-akun-form-group">

                <label
                    for="nama"
                    class="jurusan-akun-form-label"
                >
                    Nama Pengguna
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="jurusan-akun-form-control"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('nama') }}"
                    required
                >

            </div>


            {{-- EMAIL --}}
            <div class="jurusan-akun-form-group">

                <label
                    for="email"
                    class="jurusan-akun-form-label"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="jurusan-akun-form-control"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >

            </div>


            {{-- KATA SANDI --}}
            <div class="jurusan-akun-form-group">

                <label
                    for="password"
                    class="jurusan-akun-form-label"
                >
                    Kata Sandi
                </label>


                <div class="jurusan-akun-password-wrapper">

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="jurusan-akun-form-control"
                        placeholder="Buat Kata Sandi"
                        minlength="6"
                        required
                    >


                    <button
                        type="button"
                        id="togglePassBtn"
                        class="jurusan-akun-toggle-password"
                        title="Lihat Kata Sandi"
                    >

                        {{-- Mata terbuka --}}
                        <svg
                            id="eyeIcon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>


                        {{-- Mata tertutup --}}
                        <svg
                            id="eyeOffIcon"
                            xmlns="http://www.w3.org/2000/svg"
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            style="display:none;"
                        >
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>

                    </button>

                </div>

            </div>


            {{-- ROLE --}}
            <div class="jurusan-akun-form-group">

                <label
                    for="role"
                    class="jurusan-akun-form-label"
                >
                    Role
                </label>


                <input
                    type="text"
                    id="role"
                    class="jurusan-akun-form-control"
                    value="Admin Produser"
                    readonly
                >

            </div>


            {{-- PRODUK / JASA TANGGUNG JAWAB --}}
            <div class="jurusan-akun-form-group">

                <label class="jurusan-akun-form-label">
                    Produk/Jasa Tanggung Jawab
                </label>


                <div class="jurusan-akun-checkbox-grid">

                    @forelse ($produkJasas as $produkJasa)

                        <label class="jurusan-akun-checkbox-item">

                            <input
                                type="checkbox"
                                name="layanan[]"
                                value="{{ $produkJasa->id_produk_jasa }}"
                                {{ is_array(old('layanan')) && in_array($produkJasa->id_produk_jasa, old('layanan')) ? 'checked' : '' }}
                            >

                            <span>
                                {{ $produkJasa->nama_produk_jasa }}
                            </span>

                        </label>

                    @empty

                        <p class="jurusan-akun-help-text">
                            Belum ada produk atau jasa yang tersedia untuk jurusan Anda.
                        </p>

                    @endforelse

                </div>


                <div class="jurusan-akun-help-text">
                    Pilih minimal satu produk/jasa yang menjadi tanggung jawab Admin Produser.
                </div>

            </div>


            {{-- TOMBOL --}}
            <div class="jurusan-akun-form-actions">

                <button
                    type="submit"
                    class="jurusan-akun-btn-primary"
                >
                    Tambah Akun
                </button>


                <a
                    href="/jurusan-admin/akun"
                    class="jurusan-akun-btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection



@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const formTambahAkun = document.getElementById('formTambahAkun');

    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const toggleBtn = document.getElementById('togglePassBtn');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    const layananCheckboxes =
        document.querySelectorAll('input[name="layanan[]"]');


    // =========================================================
    // TOGGLE PASSWORD
    // =========================================================

    if (toggleBtn && passwordInput) {

        toggleBtn.addEventListener('click', function () {

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                if (eyeIcon) {
                    eyeIcon.style.display = 'none';
                }

                if (eyeOffIcon) {
                    eyeOffIcon.style.display = 'block';
                }

            } else {

                passwordInput.type = 'password';

                if (eyeIcon) {
                    eyeIcon.style.display = 'block';
                }

                if (eyeOffIcon) {
                    eyeOffIcon.style.display = 'none';
                }

            }

        });

    }


    // =========================================================
    // NAMA
    // Sama seperti Admin TEFA
    // =========================================================

    if (namaInput) {

        namaInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Nama pengguna wajib diisi.'
                );

            } else {

                this.setCustomValidity('');

            }

        });

        namaInput.addEventListener('input', function () {

            this.setCustomValidity('');

        });

    }


    // =========================================================
    // EMAIL
    // Sama seperti Admin TEFA
    // =========================================================

    if (emailInput) {

        function validateEmail() {

            const value = emailInput.value.trim();

            if (value === '') {

                emailInput.setCustomValidity(
                    'Email wajib diisi.'
                );

                return;

            }

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(value)) {

                emailInput.setCustomValidity(
                    'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
                );

                return;

            }

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
    // PASSWORD
    // Sama seperti Admin TEFA
    // =========================================================

    if (passwordInput) {

        passwordInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Password wajib diisi.'
                );

            } else if (this.validity.tooShort) {

                this.setCustomValidity(
                    'Password harus memiliki minimal 6 karakter.'
                );

            } else {

                this.setCustomValidity('');

            }

        });


        passwordInput.addEventListener('input', function () {

            if (this.value.length === 0) {

                this.setCustomValidity(
                    'Password wajib diisi.'
                );

            } else if (this.value.length < 6) {

                this.setCustomValidity(
                    'Password harus memiliki minimal 6 karakter.'
                );

            } else {

                this.setCustomValidity('');

            }

        });

    }


    // =========================================================
    // PRODUK / JASA
    // Minimal 1 harus dipilih
    // =========================================================

    if (formTambahAkun && layananCheckboxes.length > 0) {

        formTambahAkun.addEventListener('submit', function (event) {

            const jumlahDipilih =
                document.querySelectorAll(
                    'input[name="layanan[]"]:checked'
                ).length;

            if (jumlahDipilih === 0) {

                event.preventDefault();

                layananCheckboxes[0].setCustomValidity(
                    'Pilih minimal satu produk/jasa yang menjadi tanggung jawab Admin Produser.'
                );

                layananCheckboxes[0].reportValidity();

            } else {

                layananCheckboxes[0].setCustomValidity('');

            }

        });


        layananCheckboxes.forEach(function (checkbox) {

            checkbox.addEventListener('change', function () {

                const jumlahDipilih =
                    document.querySelectorAll(
                        'input[name="layanan[]"]:checked'
                    ).length;

                if (jumlahDipilih > 0) {

                    layananCheckboxes[0].setCustomValidity('');

                }

            });

        });

    }

});
</script>


@endsection