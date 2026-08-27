@extends('layouts.app-jurusan')

@section('title', 'Profil Saya')

@section('content')
<div class="tefa-card" style="display: flex; flex-direction: column; align-items: center; max-width: 450px; margin: 40px auto; padding: 40px;">
    
    <!-- Avatar Modern dari Dicebear (Soft Blue & Orange Accent) -->
    <img src="https://api.dicebear.com/7.x/micah/svg?seed=AdminRPL&backgroundColor=fcf4e8" alt="Avatar" style="width: 130px; height: 130px; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 24px;">
    
    <h2 style="color: var(--text-dark); margin-bottom: 4px; font-size: 24px;">Admin Jurusan</h2>
    <div style="background: #f0f7ff; color: var(--primary); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 32px;">
        Hak Akses: Pengelola Data Jurusan
    </div>
    
    <div style="width: 100%; text-align: left; margin-bottom: 32px;">
        <div class="detail-section" style="border-bottom: 1px solid #f5f5f5; padding-bottom: 16px; margin-bottom: 16px;">
            <div class="detail-label">Email Terdaftar</div>
            <div class="detail-value" style="font-weight: 500;">adminrpl@gmail.com</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Penugasan Jurusan</div>
            <div style="display: flex; align-items: center; gap: 8px; margin-top: 4px;">
                <span style="font-size: 20px;">💻</span>
                <span style="font-weight: 600; color: var(--accent-rpl);">Rekayasa Perangkat Lunak (RPL)</span>
            </div>
        </div>
    </div>
    
    <!-- Tombol Logout ke Login Admin Jurusan -->
    <a href="/login-jurusan" class="btn-outline" style="width: 100%; text-align: center; color: #dc3545; border-color: #dc3545;">Logout dari Sistem</a>
</div>
@endsection