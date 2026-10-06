@extends('admin.layouts.app-jurusan')

@section('title', 'Profil Saya')

@section('content')

@php
$user = Auth::user();
$jurusan = $user->jurusanDipegang;
@endphp

<div class="tefa-card profile-container">

<!-- Avatar -->
<img
    src="https://api.dicebear.com/7.x/micah/svg?seed={{ urlencode($user->nama) }}&backgroundColor=EBF3F9"
    alt="Avatar Profil"
    class="profile-avatar"
>

<!-- Nama -->
<div class="profile-name">
    {{ $user->nama }}
</div>

<!-- Role -->
<div class="profile-role">
    Admin Jurusan
</div>

<!-- Detail Profil -->
<div class="profile-details">

    <!-- Nama Lengkap -->
    <div class="detail-section">
        <div class="detail-label">
            Nama Lengkap
        </div>

        <div class="detail-value">
            {{ $user->nama }}
        </div>
    </div>

    <!-- Email -->
    <div class="detail-section">
        <div class="detail-label">
            Email
        </div>

        <div class="detail-value">
            {{ $user->email }}
        </div>
    </div>

    <!-- Role Akses -->
    <div class="detail-section">
        <div class="detail-label">
            Role Akses
        </div>

        <div class="detail-value">
            Admin Jurusan
        </div>
    </div>

    <!-- Penugasan Jurusan -->
    <div class="detail-section">

        <div class="detail-label">
            Penugasan Jurusan
        </div>

        @if($jurusan)

            <div class="profile-jurusan">
                <i class="ph ph-laptop"></i>

                <span class="profile-jurusan-name">
                    {{ $jurusan->nama_jurusan }}
                </span>
            </div>

        @else

            <div class="profile-jurusan-empty">
                Belum memiliki penugasan jurusan.
            </div>

        @endif

    </div>

</div>

<!-- Logout -->
<button
    type="button"
    class="btn-outline btn-profile-logout"
    onclick="openLogoutModal()"
>
    Logout
</button> 


</div>

@endsection
