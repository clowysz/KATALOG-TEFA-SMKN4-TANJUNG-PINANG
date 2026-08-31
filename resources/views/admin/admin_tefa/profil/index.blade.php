@extends('admin.layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="tefa-card profile-container">
    <!-- Avatar Ilustrasi Modern -->
    <img src="https://api.dicebear.com/7.x/micah/svg?seed=Michaa&backgroundColor=EBF3F9" alt="Avatar Profil" class="profile-avatar">
    
    <div class="profile-name">Admin TEFA</div>
    <div class="profile-role">Administrator Utama</div>
    
    <div class="profile-details">
        <div class="detail-section">
            <div class="detail-label">Nama Lengkap</div>
            <div class="detail-value">Admin TEFA</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Email</div>
            <div class="detail-value">admin@gmail.com</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Role Akses</div>
            <div class="detail-value">Admin TEFA</div>
        </div>
    </div>
    
    <!-- Tombol Logout yang mengarah kembali ke halaman Login (/) -->
    <a href="/" class="btn-outline btn-logout">Logout dari Sistem</a>
</div>
@endsection