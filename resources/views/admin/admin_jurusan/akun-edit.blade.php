@extends('admin.layouts.app-jurusan')

@section('title', 'Edit Akun')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/akun-edit-jurusan.css') }}?v=1">
@endsection

@section('content')

@php
    $kembaliUrl = request('from') === 'index'
        ? route('jurusan.akun.index')
        : route('jurusan.akun.detail', ['id' => $akun->id]);

    // Produk/jasa yang tercentang: input lama (jika validasi gagal) atau penugasan saat ini
    $layananTerpilih = old(
        'layanan',
        $akun->penugasanProduser->pluck('id_produk_jasa')->toArray()
    );
@endphp

<div class="akun-edit-wrapper">

    {{-- HEADER --}}
    <div class="akun-edit-header">

        <a href="{{ $kembaliUrl }}" class="btn-jurusan-outline">
            ← Kembali
        </a>

        <div>
            <h2 class="akun-edit-title">
                Edit Akun Admin Produser
            </h2>

            <p class="akun-edit-subtitle">
                Ubah informasi akun, status, dan produk atau jasa
                yang ditugaskan kepada Admin Produser.
            </p>
        </div>

    </div>


    {{-- ERROR VALIDATION --}}
    @if ($errors->any())

        <div class="akun-edit-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

    @endif


    {{-- FORM --}}
    <form
        id="formEditAkun"
        action="{{ route('jurusan.akun.update') }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <input type="hidden" name="id" value="{{ $akun->id }}">


        {{-- INFORMASI AKUN --}}
        <div class="akun-edit-card">

            <div class="akun-edit-card-title">
                Informasi Akun
            </div>

            <div class="akun-edit-group">

                <label for="nama" class="akun-edit-label">
                    Nama
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="akun-edit-input"
                    value="{{ old('nama', $akun->nama) }}"
                    required
                >

            </div>

            <div class="akun-edit-group">

                <label for="email" class="akun-edit-label">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="akun-edit-input"
                    value="{{ old('email', $akun->email) }}"
                    required
                >

            </div>

        </div>


        {{-- PRODUK / JASA --}}
        <div class="akun-edit-card">

            <div class="akun-edit-card-title">
                Produk / Jasa yang Ditugaskan
            </div>

            <p class="akun-edit-card-desc">
                Pilih produk atau jasa yang akan ditangani oleh
                Admin Produser ini.
            </p>

            <div class="akun-edit-service-grid">

                @forelse ($produkJasas as $produkJasa)

                    <label class="akun-edit-service-option">

                        <input
                            type="checkbox"
                            name="layanan[]"
                            value="{{ $produkJasa->id_produk_jasa }}"
                            {{ in_array($produkJasa->id_produk_jasa, $layananTerpilih) ? 'checked' : '' }}
                        >

                        <span class="akun-edit-service-box">
                            <span class="akun-edit-service-check"></span>

                            <span class="akun-edit-service-name">
                                {{ $produkJasa->nama_produk_jasa }}
                            </span>
                        </span>

                    </label>

                @empty

                    <div class="akun-edit-empty">
                        Belum ada produk atau jasa yang tersedia
                        untuk jurusan Anda.
                    </div>

                @endforelse

            </div>

        </div>


        {{-- STATUS --}}
        <div class="akun-edit-card">

            <div class="akun-edit-card-title">
                Status Akun
            </div>

            <div class="akun-edit-status-options">

                <label class="akun-edit-status-option">

                    <input
                        type="radio"
                        name="status"
                        value="aktif"
                        {{ old('status', $akun->status) === 'aktif' ? 'checked' : '' }}
                    >

                    <span class="akun-edit-status-box">
                        <span class="akun-edit-status-dot"></span>
                        Aktif
                    </span>

                </label>

                <label class="akun-edit-status-option">

                    <input
                        type="radio"
                        name="status"
                        value="tidak_aktif"
                        {{ old('status', $akun->status) === 'tidak_aktif' ? 'checked' : '' }}
                    >

                    <span class="akun-edit-status-box">
                        <span class="akun-edit-status-dot"></span>
                        Tidak Aktif
                    </span>

                </label>

            </div>

        </div>


        {{-- TOMBOL --}}
        <div class="akun-edit-actions">

            <button type="submit" class="btn-jurusan-primary">
                Simpan Perubahan
            </button>

            <a href="{{ $kembaliUrl }}" class="btn-jurusan-secondary">
                Batal
            </a>

        </div>

    </form>

</div>

@endsection


@section('scripts')
<script src="{{ asset('js/akun-validasi-jurusan.js') }}"></script>
<script src="{{ asset('js/akun-edit-jurusan.js') }}"></script>
@endsection