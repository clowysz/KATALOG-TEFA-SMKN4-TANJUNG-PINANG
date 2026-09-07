<<<<<<< HEAD:resources/views/admin/admin_tefa/akun/create.blade.php
@extends('admin.layouts.app')
=======

@extends('layouts.app')
>>>>>>> 2846f9b (update sistem admin TEFA):resources/views/akun/create.blade.php

@section('title', 'Tambah Akun')

@section('content')

<div class="page-header">

    <a href="{{ route('akun.index') }}"
       class="btn-outline"
       style="margin-bottom: 16px;">
        ← Kembali ke Daftar Akun
    </a>

    <h2>Tambah Akun Baru</h2>

    <p>Tambahkan admin baru untuk mengelola TEFA</p>

</div>


<div class="tefa-card" style="max-width: 600px;">

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <form
        action="{{ route('akun.store') }}"
        method="POST"
    >

        @csrf


        <!-- Nama Pengguna -->
        <label for="nama_pengguna" class="detail-label">
            Nama Pengguna
        </label>

        <input
            type="text"
            id="nama_pengguna"
            name="nama_pengguna"
            class="form-control"
            placeholder="Masukkan nama"
            value="{{ old('nama_pengguna') }}"
            required
        >


        <!-- Email -->
        <label for="email" class="detail-label">
            Email
        </label>

        <input
            type="email"
            id="email"
            name="email"
            class="form-control"
            placeholder="Masukkan email"
            value="{{ old('email') }}"
            required
        >


        <!-- Password -->
        <label for="password" class="detail-label">
            Password
        </label>

        <input
            type="password"
            id="password"
            name="password"
            class="form-control"
            placeholder="Masukkan password"
            required
        >


        <!-- Role -->
        <label for="role" class="detail-label">
            Role
        </label>

        <select
            id="role"
            name="role"
            class="form-control"
            required
        >

            <option value="" disabled selected>
                Pilih Role...
            </option>

            <option value="Admin TEFA">
                Admin TEFA
            </option>

            <option value="Admin Jurusan">
                Admin Jurusan
            </option>

        </select>


        <!-- Jurusan -->
        <div id="jurusanContainer" style="display: none;">

            <label for="jurusan" class="detail-label">
                Jurusan
            </label>

            <select
                id="jurusan"
                name="jurusan"
                class="form-control"
            >

                <option value="" disabled selected>
                    Pilih Jurusan...
                </option>

                <option value="RPL">
                    Rekayasa Perangkat Lunak
                </option>

                <option value="TKJ">
                    Teknik Komputer dan Jaringan
                </option>

                <option value="DKV">
                    Desain Komunikasi Visual
                </option>

                <option value="ANIMASI">
                    Animasi
                </option>

                <option value="GIM">
                    GIM
                </option>

                <option value="PSPT">
                    Produk Suara Program Televisi
                </option>

            </select>

        </div>


        <!-- Bantuan Jurusan -->
        <span
            id="helpTextJurusan"
            class="help-text"
        >
            Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.
        </span>


        <!-- Status -->
        <label for="status" class="detail-label">
            Status
        </label>

        <select
            id="status"
            name="status"
            class="form-control"
            required
        >
        <label for="status" class="detail-label">Status</label>
            <option value="Aktif" selected>Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>


        <button
            type="submit"
            class="btn-primary"
            style="margin-top: 16px;"
        >
            Tambah Akun
        </button>

    </form>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/akun.js') }}"></script>

@endsection

