@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="page-header">
    <h2>Dashboard</h2>
    <p>Ringkasan Performa TEFA</p>
</div>

<!-- 5 Summary Cards -->
<div class="summary-grid">
    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #3B698F;">📦</div>
        <div class="summary-info"><p>Total Pesanan</p><h3 style="color: #3B698F;">124</h3></div>
    </div>
    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #D89B4A;">⏳</div>
        <div class="summary-info"><p>Menunggu Konfirmasi</p><h3 style="color: #D89B4A;">15</h3></div>
    </div>
    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #5B8FB9;">📋</div>
        <div class="summary-info"><p>Dikonfirmasi</p><h3 style="color: #5B8FB9;">24</h3></div>
    </div>
    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #8067A8;">⚙️</div>
        <div class="summary-info"><p>Sedang Diproses</p><h3 style="color: #8067A8;">42</h3></div>
    </div>
    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #5F9275;">✅</div>
        <div class="summary-info"><p>Selesai</p><h3 style="color: #5F9275;">43</h3></div>
    </div>
</div>

<!-- 3 Performance Cards -->
<div class="performance-grid">
    <div class="tefa-card">
        <div class="perf-header">
            <div class="perf-icon">🛒</div>
            <h3>Produk Terlaris</h3>
        </div>
        <ul class="perf-list">
            <li class="perf-item"><span>Website UMKM</span> <span class="perf-badge">24 pesanan</span></li>
            <li class="perf-item"><span>Desain Poster</span> <span class="perf-badge">18 pesanan</span></li>
            <li class="perf-item"><span>Animasi 3D</span> <span class="perf-badge">12 pesanan</span></li>
        </ul>
    </div>
    <div class="tefa-card">
        <div class="perf-header">
            <div class="perf-icon">🔍</div>
            <h3>Paling Banyak Dicari</h3>
        </div>
        <ul class="perf-list">
            <li class="perf-item"><span>Website UMKM</span> <span class="perf-badge">118 pencarian</span></li>
            <li class="perf-item"><span>Desain Poster</span> <span class="perf-badge">96 pencarian</span></li>
            <li class="perf-item"><span>Animasi 3D</span> <span class="perf-badge">74 pencarian</span></li>
        </ul>
    </div>
    <div class="tefa-card">
        <div class="perf-header">
            <div class="perf-icon">👁️</div>
            <h3>Paling Banyak Dilihat</h3>
        </div>
        <ul class="perf-list">
            <li class="perf-item"><span>Website UMKM</span> <span class="perf-badge">523 tampilan</span></li>
            <li class="perf-item"><span>Desain Poster</span> <span class="perf-badge">487 tampilan</span></li>
            <li class="perf-item"><span>Animasi 3D</span> <span class="perf-badge">401 tampilan</span></li>
        </ul>
    </div>
</div>

<!-- Bottom Section -->
<div class="bottom-grid">
    <div class="tefa-card">
        <h3 style="margin-bottom: 16px;">Pesanan Terbaru</h3>
        <div class="recent-order-item">
            <img src="https://placehold.co/100x100/EBF3F9/3B698F?text=Web" alt="Web UMKM" class="recent-img">
            <div class="recent-info">
                <h4>Website Company Profile</h4>
                <p>Rekayasa Perangkat Lunak - Hari ini, 10:24</p>
            </div>
        </div>
        <div class="recent-order-item">
            <img src="https://placehold.co/100x100/EBF3F9/3B698F?text=Poster" alt="Poster" class="recent-img">
            <div class="recent-info">
                <h4>Desain Poster Event</h4>
                <p>Desain Komunikasi Visual - Kemarin, 15:30</p>
            </div>
        </div>
        <div class="recent-order-item">
            <img src="https://placehold.co/100x100/EBF3F9/3B698F?text=3D" alt="Animasi" class="recent-img">
            <div class="recent-info">
                <h4>Animasi 3D Produk</h4>
                <p>Animasi - 22 Agu 2026</p>
            </div>
        </div>
    </div>

    <div class="tefa-card">
        <h3 style="margin-bottom: 16px;">Pesanan Berdasarkan Jurusan</h3>
        <!-- Tempat untuk Bar Chart muncul -->
        <canvas id="jurusanChart"></canvas>
    </div>
</div>
@endsection

@section('scripts')
<!-- Memanggil Library Chart.js via CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Memanggil script terpisah khusus untuk Dashboard -->
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection