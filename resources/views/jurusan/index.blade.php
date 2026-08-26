@extends('layouts.app')

@section('title', 'Jurusan')

@section('content')
<div class="page-header">
    <h2>Daftar Jurusan</h2>
    <p>Statistik produk, jasa, portofolio, dan pesanan per jurusan TEFA</p>
</div>

<div class="jurusan-grid">
    <!-- Card Rekayasa Perangkat Lunak -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #D8893D;">
        <div class="jurusan-header">Rekayasa Perangkat Lunak</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">8</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">12</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">24</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>

    <!-- Card Teknik Komputer dan Jaringan -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #5F9275;">
        <div class="jurusan-header">Teknik Komputer dan Jaringan</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">6</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">10</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">12</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>

    <!-- Card Desain Komunikasi Visual -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #A85C5C;">
        <div class="jurusan-header">Desain Komunikasi Visual</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">8</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">15</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">18</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>

    <!-- Card Animasi -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #315B7A;">
        <div class="jurusan-header">Animasi</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">9</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">8</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>

    <!-- Card GIM -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #6FA6C8;">
        <div class="jurusan-header">GIM</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">8</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">5</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>

    <!-- Card Produk Suara Program Televisi -->
    <div class="tefa-card jurusan-card" style="--jurusan-color: #D6AD4B;">
        <div class="jurusan-header">Produk Suara Program Televisi</div>
        <div class="jurusan-stats">
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Produk</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Jasa</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">10</div><div class="stat-label">Portofolio</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">4</div><div class="stat-label">Pesanan</div>
            </div>
        </div>
    </div>
</div>
@endsection