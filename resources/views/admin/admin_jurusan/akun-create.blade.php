@extends('admin.layouts.app-jurusan')

@section('title', 'Tambah Akun')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/akun-tambah-jurusan.css') }}?v=1">
@endsection

@section('content')

<div class="jurusan-akun-create-container">

    {{-- Tombol kembali --}}
    <a href="/jurusan-admin/akun" class="jurusan-akun-back">
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
                        <li>{{ $error }}</li>
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

                <label for="nama" class="jurusan-akun-form-label">
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

                <label for="email" class="jurusan-akun-form-label">
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

                <label for="password" class="jurusan-akun-form-label">
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
                            class="icon-on"
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
                            class="icon-off"
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
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>

                    </button>

                </div>

            </div>


            {{-- ROLE --}}
            <div class="jurusan-akun-form-group">

                <label for="role" class="jurusan-akun-form-label">
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

                <button type="submit" class="jurusan-akun-btn-primary">
                    Tambah Akun
                </button>

                <a href="/jurusan-admin/akun" class="jurusan-akun-btn-secondary">
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')
<script src="{{ asset('js/akun-validasi-jurusan.js') }}"></script>
<script src="{{ asset('js/akun-tambah-jurusan.js') }}"></script>
@endsection