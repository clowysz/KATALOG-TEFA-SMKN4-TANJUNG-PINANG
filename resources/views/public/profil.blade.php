@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-pembeli.css') }}">
@endpush

@section('content')

@php
    $user = Auth::user();
@endphp

<div class="page-wrapper-blue">

    <!-- Gelembung Dekorasi -->
    <div
        class="bubble"
        style="width:100px;height:100px;top:15%;right:10%;animation-duration:8s;"
    ></div>

    <div
        class="bubble"
        style="width:60px;height:60px;top:40%;left:10%;animation-duration:6s;"
    ></div>

    <div
        class="bubble"
        style="width:120px;height:120px;bottom:10%;right:20%;animation-duration:9s;"
    ></div>

    <div style="width:100%;max-width:600px;z-index:10;">

        <a href="/" class="btn-back-white">
            <i class="ph ph-arrow-left"></i>
            Kembali ke Beranda
        </a>

    </div>

    <!-- Kartu Profil -->
    <div class="glass-card">

        <!-- Header Profil -->
        <div class="profil-header-center">

            <div class="profil-avatar-icon">
                <i class="ph ph-user"></i>
            </div>

            <div class="profil-name">
                {{ $user->nama }}
            </div>

        </div>

        <!-- Nomor HP -->
        <div class="profil-row">

            <div class="profil-label">
                <i class="ph ph-phone"></i>
                No. Telpon
            </div>

            <input
                type="text"
                class="profil-input"
                value="{{ $user->nomor_hp ?? '-' }}"
                readonly
            >

        </div>

        <!-- Email -->
        <div class="profil-row">

            <div class="profil-label">
                <i class="ph ph-envelope-simple"></i>
                Email
            </div>

            <input
                type="text"
                class="profil-input"
                value="{{ $user->email }}"
                readonly
            >

        </div>

        <!-- Sandi -->
        <div class="profil-row">

            <div class="profil-label">
                <i class="ph ph-lock-key"></i>
                Sandi
            </div>

            <input
                type="password"
                class="profil-input"
                value="********"
                readonly
            >

        </div>

        <!-- Area Tombol -->
        <div
            style="display:flex;flex-direction:column;align-items:center;margin-top:40px;gap:16px;"
        >

            <!-- Riwayat Pesanan -->
            <a
                href="/riwayat-pesanan"
                class="btn-riwayat-pesanan"
                style="margin:0;"
            >
                Riwayat Pesanan
            </a>

            <!-- Logout -->
            <div
                style="width:100%;display:flex;justify-content:flex-end;"
            >

                <form
                    action="{{ route('pembeli.logout') }}"
                    method="POST"
                    style="margin:0;"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn-logout-right"
                        style="margin:0;border:none;cursor:pointer;"
                    >
                        Keluar Akun
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection