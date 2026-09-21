@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@section('content')

<div class="tefa-card profile-container">

    <!-- Avatar -->
    <img
        src="https://api.dicebear.com/7.x/micah/svg?seed={{ urlencode(Auth::user()->nama) }}&backgroundColor=EBF3F9"
        alt="Avatar Profil"
        class="profile-avatar"
    >

    <!-- Nama -->
    <div class="profile-name">
        {{ Auth::user()->nama }}
    </div>

    <!-- Role -->
    <div class="profile-role">
        Administrator Utama
    </div>

    <!-- Detail Profil -->
    <div class="profile-details">

        <div class="detail-section">
            <div class="detail-label">
                Nama Lengkap
            </div>

            <div class="detail-value">
                {{ Auth::user()->nama }}
            </div>
        </div>


        <div class="detail-section">
            <div class="detail-label">
                Email
            </div>

            <div class="detail-value">
                {{ Auth::user()->email }}
            </div>
        </div>


        <div class="detail-section">
            <div class="detail-label">
                Role Akses
            </div>

            <div class="detail-value">
                Admin TEFA
            </div>
        </div>

    </div>


    <!-- Logout -->
    <form
        action="{{ route('admin.logout') }}"
        method="POST"
        style="margin: 0;"
    >

        @csrf

        <button
            type="submit"
            class="btn-outline btn-logout"
        >
            Logout dari Sistem
        </button>

    </form>

</div>

@endsection