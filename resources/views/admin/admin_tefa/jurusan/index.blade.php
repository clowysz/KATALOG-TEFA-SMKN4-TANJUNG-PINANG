@extends('admin.layouts.app')

@section('title', 'Jurusan')

@section('content')
<!-- CSS ditanam langsung di sini agar kebal cache -->
<style>
    .tefa-jurusan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }
    .j-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }
    .j-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }
    .j-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .j-stat-box {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
    }
    .j-stat-num {
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 6px;
    }
    .j-stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    /* Tema Warna Garis Atas & Angka per Jurusan */
    .theme-rpl { border-top: 4px solid #d97706; }
    .theme-rpl .j-stat-num { color: #d97706; }

    .theme-tkj { border-top: 4px solid #059669; }
    .theme-tkj .j-stat-num { color: #059669; }

    .theme-dkv { border-top: 4px solid #991b1b; }
    .theme-dkv .j-stat-num { color: #991b1b; }

    .theme-animasi { border-top: 4px solid #334155; }
    .theme-animasi .j-stat-num { color: #334155; }

    .theme-gim { border-top: 4px solid #2563eb; }
    .theme-gim .j-stat-num { color: #2563eb; }

    .theme-pspt { border-top: 4px solid #ca8a04; }
    .theme-pspt .j-stat-num { color: #ca8a04; }
</style>

<div class="page-header">
    <h2 style="font-size: 20px; font-weight: bold; color: #1e293b;">Jurusan</h2>
</div>

<div class="tefa-jurusan-grid">
    <!-- Rekayasa Perangkat Lunak -->
    <div class="j-card theme-rpl">
        <div class="j-card-title">Rekayasa Perangkat Lunak</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">8</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">5</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">12</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">2</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>
    
    <!-- Teknik Komputer dan Jaringan -->
    <div class="j-card theme-tkj">
        <div class="j-card-title">Teknik Komputer dan Jaringan</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">6</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">5</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">10</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">1</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>

    <!-- Desain Komunikasi Visual -->
    <div class="j-card theme-dkv">
        <div class="j-card-title">Desain Komunikasi Visual</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">8</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">5</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">15</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">2</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>

    <!-- Animasi -->
    <div class="j-card theme-animasi">
        <div class="j-card-title">Animasi</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">9</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">1</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>

    <!-- GIM -->
    <div class="j-card theme-gim">
        <div class="j-card-title">GIM</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">8</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">1</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>

    <!-- Produk Suara Program Televisi -->
    <div class="j-card theme-pspt">
        <div class="j-card-title">Produk Suara Program Televisi</div>
        <div class="j-stats">
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Produk</div></div>
            <div class="j-stat-box"><div class="j-stat-num">4</div><div class="j-stat-label">Jasa</div></div>
            <div class="j-stat-box"><div class="j-stat-num">10</div><div class="j-stat-label">Portofolio</div></div>
            <div class="j-stat-box"><div class="j-stat-num">1</div><div class="j-stat-label">Pesanan</div></div>
        </div>
    </div>
</div>
@endsection