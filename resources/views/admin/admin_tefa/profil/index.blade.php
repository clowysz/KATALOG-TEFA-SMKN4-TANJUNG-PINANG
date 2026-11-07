@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="tefa-card profile-container">

    
    <img
        src="https://api.dicebear.com/7.x/micah/svg?seed={{ urlencode(Auth::user()->nama) }}&backgroundColor=EBF3F9"
        alt="Avatar Profil"
        class="profile-avatar"
    >

    
    <div class="profile-name">
        {{ Auth::user()->nama }}
    </div>

    
    <div class="profile-role">
        Administrator Utama
    </div>

    
    <div class="profile-details">

        
        <div class="profile-section">
            <div class="detail-label">
                Nama Lengkap
            </div>

            <div class="detail-value">
                {{ Auth::user()->nama }}
            </div>
        </div>

        
        <div class="profile-section">
            <div class="detail-label">
                Email
            </div>

            <div class="detail-value">
                {{ Auth::user()->email }}
            </div>
        </div>

        
        <div class="profile-section">
            <div class="detail-label">
                Role Akses
            </div>

            <div class="detail-value">
                Admin TEFA
            </div>
        </div>

    </div>

    
    <button
        type="button"
        class="btn-outline btn-logout"
        data-logout-open
    >
        Logout
    </button>

</div>

@endsection