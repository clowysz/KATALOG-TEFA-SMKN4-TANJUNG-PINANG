@extends('admin.layouts.app-jurusan')

@section('title', 'Edit Akun')

@section('content')

<style>
    .edit-account-wrapper {
        padding: 24px;
    }

    .edit-account-header {
        margin-bottom: 24px;
    }

    .edit-account-title {
        margin: 0;
        color: #1E3A8A;
        font-weight: 700;
    }

    .edit-account-subtitle {
        margin: 5px 0 0;
        color: #6c757d;
        font-size: 14px;
    }

    .edit-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
    }

    .edit-card-title {
        color: #1E3A8A;
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #343a40;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 14px;
        border: 1px solid #ced4da;
        border-radius: 10px;
        outline: none;
        font-size: 14px;
        background: #fff;
    }

    .form-control:focus {
        border-color: #1E3A8A;
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }

    /* =========================
       PRODUK / JASA
    ========================= */

    .service-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .service-option {
        position: relative;
        display: block;
        cursor: pointer;
    }

    .service-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .service-box {
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 50px;
        padding: 12px 14px;
        border: 1px solid #d8dee9;
        border-radius: 10px;
        background: #fff;
        color: #343a40;
        transition: all 0.2s ease;
        cursor: pointer;
        box-sizing: border-box;
    }

    .service-box:hover {
        border-color: #1E3A8A;
        background: #f8faff;
    }

    .service-check {
        width: 19px;
        height: 19px;
        flex: 0 0 19px;
        border: 2px solid #adb5bd;
        border-radius: 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .service-check::after {
        content: "✓";
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        opacity: 0;
    }

    .service-option input:checked + .service-box {
        border-color: #1E3A8A;
        background: #eff6ff;
        color: #1E3A8A;
    }

    .service-option input:checked + .service-box .service-check {
        background: #1E3A8A;
        border-color: #1E3A8A;
    }

    .service-option input:checked + .service-box .service-check::after {
        opacity: 1;
    }

    .service-name {
        font-weight: 600;
        font-size: 14px;
        line-height: 1.4;
    }

    .empty-service {
        padding: 14px;
        border-radius: 10px;
        background: #f8f9fa;
        color: #6c757d;
    }

    /* =========================
       STATUS
    ========================= */

    .status-options {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
    }

    .status-option {
        position: relative;
        cursor: pointer;
    }

    .status-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .status-box {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        padding: 11px 16px;
        border: 1px solid #d8dee9;
        border-radius: 10px;
        background: #fff;
        cursor: pointer;
        font-weight: 600;
        color: #495057;
        transition: all 0.2s ease;
    }

    .status-dot {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 2px solid #adb5bd;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-dot::after {
        content: "";
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #fff;
        opacity: 0;
    }

    .status-option input:checked + .status-box {
        border-color: #1E3A8A;
        background: #eff6ff;
        color: #1E3A8A;
    }

    .status-option input:checked + .status-box .status-dot {
        background: #1E3A8A;
        border-color: #1E3A8A;
    }

    .status-option input:checked + .status-box .status-dot::after {
        opacity: 1;
    }

    /* =========================
       ERROR
    ========================= */

    .error-box {
        background: #fff1f2;
        border: 1px solid #fecdd3;
        color: #9f1239;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .error-box ul {
        margin: 0;
        padding-left: 20px;
    }

    /* =========================
       BUTTON
    ========================= */

    .form-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-action {
        border: none;
        border-radius: 10px;
        padding: 11px 18px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        box-sizing: border-box;
    }

    .btn-save {
        background: #1E3A8A;
        color: #fff;
    }

    .btn-save:hover {
        background: #172f70;
        color: #fff;
    }

    .btn-cancel {
        background: #e9ecef;
        color: #343a40;
    }

    .btn-cancel:hover {
        background: #dee2e6;
        color: #343a40;
    }

    @media (max-width: 768px) {

        .edit-account-wrapper {
            padding: 15px;
        }

        .service-grid {
            grid-template-columns: 1fr;
        }

        .edit-card {
            padding: 18px;
        }

    }
</style>


<div class="edit-account-wrapper">

    {{-- HEADER --}}
    <div class="edit-account-header">

        <h2 class="edit-account-title">
            Edit Akun Admin Produser
        </h2>

        <p class="edit-account-subtitle">
            Ubah informasi akun, status, dan produk atau jasa
            yang ditugaskan kepada Admin Produser.
        </p>

    </div>


    {{-- ERROR VALIDATION --}}
    @if ($errors->any())

        <div class="error-box">

            <ul>

                @foreach ($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORM --}}
    <form
        action="{{ route('jurusan.akun.update') }}"
        method="POST"
    >

        @csrf

        @method('PUT')

        {{-- ID AKUN --}}
        <input
            type="hidden"
            name="id"
            value="{{ $akun->id }}"
        >


        {{-- INFORMASI AKUN --}}
        <div class="edit-card">

            <div class="edit-card-title">
                Informasi Akun
            </div>


            {{-- NAMA --}}
            <div class="form-group">

                <label
                    for="nama"
                    class="form-label"
                >
                    Nama
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $akun->nama) }}"
                    required
                >

            </div>


            {{-- EMAIL --}}
            <div class="form-group">

                <label
                    for="email"
                    class="form-label"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $akun->email) }}"
                    required
                >

            </div>

        </div>


        {{-- PRODUK / JASA --}}
        <div class="edit-card">

            <div class="edit-card-title">
                Produk / Jasa yang Ditugaskan
            </div>

            <p
                style="
                    color:#6c757d;
                    font-size:14px;
                    margin-top:-10px;
                    margin-bottom:18px;
                "
            >
                Pilih produk atau jasa yang akan ditangani oleh
                Admin Produser ini.
            </p>


            <div class="service-grid">

                @forelse ($produkJasas as $produkJasa)

                    @php

                        $sudahDitugaskan =
                            $akun->penugasanProduser->contains(
                                'id_produk_jasa',
                                $produkJasa->id_produk_jasa
                            );

                    @endphp


                    <label class="service-option">

                        <input
                            type="checkbox"
                            name="layanan[]"
                            value="{{ $produkJasa->id_produk_jasa }}"
                            {{ old(
                                'layanan',
                                $akun->penugasanProduser
                                    ->pluck('id_produk_jasa')
                                    ->toArray()
                            ) && in_array(
                                $produkJasa->id_produk_jasa,
                                old(
                                    'layanan',
                                    $akun->penugasanProduser
                                        ->pluck('id_produk_jasa')
                                        ->toArray()
                                )
                            )
                                ? 'checked'
                                : ''
                            }}
                        >

                        <span class="service-box">

                            <span class="service-check"></span>

                            <span class="service-name">
                                {{ $produkJasa->nama_produk_jasa }}
                            </span>

                        </span>

                    </label>

                @empty

                    <div class="empty-service">

                        Belum ada produk atau jasa yang tersedia
                        untuk jurusan Anda.

                    </div>

                @endforelse

            </div>

        </div>


        {{-- STATUS --}}
        <div class="edit-card">

            <div class="edit-card-title">
                Status Akun
            </div>

            <div class="status-options">

                {{-- AKTIF --}}
                <label class="status-option">

                    <input
                        type="radio"
                        name="status"
                        value="aktif"
                        {{ old('status', $akun->status) === 'aktif'
                            ? 'checked'
                            : ''
                        }}
                    >

                    <span class="status-box">

                        <span class="status-dot"></span>

                        Aktif

                    </span>

                </label>


                {{-- TIDAK AKTIF --}}
                <label class="status-option">

                    <input
                        type="radio"
                        name="status"
                        value="tidak_aktif"
                        {{ old('status', $akun->status) === 'tidak_aktif'
                            ? 'checked'
                            : ''
                        }}
                    >

                    <span class="status-box">

                        <span class="status-dot"></span>

                        Tidak Aktif

                    </span>

                </label>

            </div>

        </div>


        {{-- BUTTON --}}
        <div class="form-actions">

            <button
                type="submit"
                class="btn-action btn-save"
            >
                Simpan Perubahan
            </button>


            <a
                href="{{ route('jurusan.akun.detail', ['id' => $akun->id]) }}"
                class="btn-action btn-cancel"
            >
                Batal
            </a>

        </div>

    </form>

</div>

@endsection