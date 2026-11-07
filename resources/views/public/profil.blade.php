@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-pembeli.css') }}">
@endpush

@section('content')

@php
    $user = Auth::user();
@endphp

<div class="page-wrapper-blue">

    
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

    <div class="back-wrap narrow">

        <a href="/" class="btn-back-white">
            <i class="ph ph-arrow-left"></i>
            Kembali ke Beranda
        </a>

    </div>

    
    <div class="glass-card">

        
        <div class="profil-header-center">

            <div class="profil-avatar-icon">
                <i class="ph ph-user"></i>
            </div>

            <div class="profil-name">
                {{ $user->nama }}
            </div>

        </div>

        
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

        
        <div class="profil-actions">

            
            <a href="/riwayat-pesanan" class="btn-riwayat-pesanan">
                Riwayat Pesanan
            </a>

            
            <div class="profil-logout-row">

                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="btn-logout-right">
                        Keluar Akun
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection