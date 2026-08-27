@extends('layouts.app-jurusan')

@section('title', 'Dashboard Jurusan')

@section('content')
<div style="margin-bottom: 24px;">
    <p style="color: var(--text-muted); font-size: 14px;">Ringkasan Performa Rekayasa Perangkat Lunak</p>
</div>

<!-- 3 Summary Cards (Gaya Foto ke-3) -->
<div class="summary-grid" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 24px;">
    <div class="tefa-card" style="padding: 24px;">
        <div style="font-size: 24px; margin-bottom: 12px;">📦</div>
        <h2 style="color: var(--primary); font-size: 28px; margin-bottom: 4px;">8</h2>
        <p style="color: var(--text-muted); font-size: 13px;">Total Produk</p>
    </div>
    <div class="tefa-card" style="padding: 24px;">
        <div style="font-size: 24px; margin-bottom: 12px;">🔧</div>
        <h2 style="color: var(--accent-rpl); font-size: 28px; margin-bottom: 4px;">5</h2>
        <p style="color: var(--text-muted); font-size: 13px;">Total Jasa</p>
    </div>
    <div class="tefa-card" style="padding: 24px;">
        <div style="font-size: 24px; margin-bottom: 12px;">📁</div>
        <h2 style="color: #5F9275; font-size: 28px; margin-bottom: 4px;">12</h2>
        <p style="color: var(--text-muted); font-size: 13px;">Total Portofolio</p>
    </div>
</div>

<!-- List Terlaris (Foto ke-3) -->
<div class="dashboard-list-card">
    <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
        <h3 style="font-size: 16px; color: var(--text-dark);">📈 Produk/Jasa Terlaris</h3>
        <span style="font-size: 12px; color: var(--text-muted);">Berdasarkan pesanan</span>
    </div>
    
    <div class="rank-item">
        <div class="rank-left">
            <div class="rank-circle rank-1">1</div>
            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=100&q=80" class="list-item-img">
            <div><div class="list-item-title">Aplikasi Kasir</div><div class="list-item-subtitle">Produk</div></div>
        </div>
        <span class="catalog-stats" style="background: #f0f7ff;">24 pesanan</span>
    </div>
    <div class="rank-item">
        <div class="rank-left">
            <div class="rank-circle rank-2">2</div>
            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=100&q=80" class="list-item-img">
            <div><div class="list-item-title">Sistem Informasi Sekolah</div><div class="list-item-subtitle">Produk</div></div>
        </div>
        <span class="catalog-stats" style="background: #f0f7ff;">18 pesanan</span>
    </div>
    <div class="rank-item">
        <div class="rank-left">
            <div class="rank-circle rank-3">3</div>
            <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=100&q=80" class="list-item-img">
            <div><div class="list-item-title">Pembuatan Website</div><div class="list-item-subtitle">Jasa</div></div>
        </div>
        <span class="catalog-stats" style="background: #f0f7ff;">18 pesanan</span>
    </div>
</div>

<!-- List Paling Banyak Dicari & Dilihat (Foto ke-4) -->
<div class="dashboard-list-card">
    <h3 style="font-size: 16px; color: var(--text-dark); margin-bottom: 16px;">🔍 Produk/Jasa Paling Banyak Dicari</h3>
    <div class="rank-item">
        <div class="rank-left">
            <div class="rank-circle rank-1">1</div>
            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=100&q=80" class="list-item-img">
            <div><div class="list-item-title">Aplikasi Kasir</div><div class="list-item-subtitle">Produk</div></div>
        </div>
        <span class="catalog-stats" style="background: #f0f7ff;">118 pencarian</span>
    </div>
    <div class="rank-item">
        <div class="rank-left">
            <div class="rank-circle rank-2">2</div>
            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=100&q=80" class="list-item-img">
            <div><div class="list-item-title">Sistem Informasi Sekolah</div><div class="list-item-subtitle">Produk</div></div>
        </div>
        <span class="catalog-stats" style="background: #f0f7ff;">96 pencarian</span>
    </div>
</div>

<!-- Performa Produk/Jasa (Foto ke-5) -->
<div class="dashboard-list-card">
    <h3 style="font-size: 16px; color: var(--text-dark); margin-bottom: 24px;">📊 Performa Produk/Jasa</h3>
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; align-items: center;">
        
        <!-- Area Doughnut Chart -->
        <div style="display: flex; gap: 24px; justify-content: center;">
            <div style="text-align: center;">
                <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 12px auto;">
                    <canvas id="chartDilihat"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; font-size: 18px; color: var(--primary);">100%</div>
                </div>
                <div style="font-weight: 700; color: var(--primary); font-size: 16px;">2,552</div>
                <div style="font-size: 11px; color: var(--text-muted);">Total Tampilan</div>
            </div>
            <div style="text-align: center;">
                <div style="position: relative; width: 100px; height: 100px; margin: 0 auto 12px auto;">
                    <canvas id="chartDicari"></canvas>
                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-weight: bold; font-size: 18px; color: var(--accent-rpl);">89%</div>
                </div>
                <div style="font-weight: 700; color: var(--accent-rpl); font-size: 16px;">531</div>
                <div style="font-size: 11px; color: var(--text-muted);">Total Pencarian</div>
            </div>
        </div>

        <!-- Area Horizontal Bar -->
        <div>
            <div class="bar-row"><span>Aplikasi Kasir</span><span style="color:var(--text-muted); font-weight:normal;">523 tampilan</span></div>
            <div class="progress-bar-bg"><div class="progress-fill-blue" style="width: 100%;"></div></div>
            
            <div class="bar-row"><span>Sistem Informasi Sekolah</span><span style="color:var(--text-muted); font-weight:normal;">487 tampilan</span></div>
            <div class="progress-bar-bg"><div class="progress-fill-blue" style="width: 85%;"></div></div>
            
            <div class="bar-row"><span>Pembuatan Website</span><span style="color:var(--text-muted); font-weight:normal;">401 tampilan</span></div>
            <div class="progress-bar-bg"><div class="progress-fill-blue" style="width: 70%;"></div></div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Script Khusus untuk 2 Doughnut (Foto ke-5)
document.addEventListener("DOMContentLoaded", function() {
    new Chart(document.getElementById('chartDilihat'), {
        type: 'doughnut',
        data: { datasets: [{ data: [100, 0], backgroundColor: ['#3B698F', '#eee'], borderWidth: 0 }] },
        options: { cutout: '75%', responsive: true, maintainAspectRatio: false, plugins: { tooltip: { enabled: false } } }
    });
    new Chart(document.getElementById('chartDicari'), {
        type: 'doughnut',
        data: { datasets: [{ data: [89, 11], backgroundColor: ['#D8893D', '#eee'], borderWidth: 0 }] },
        options: { cutout: '75%', responsive: true, maintainAspectRatio: false, plugins: { tooltip: { enabled: false } } }
    });
});
</script>
@endsection