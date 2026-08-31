@extends('admin.layouts.app-produser')

@section('title', 'Detail Produk/Jasa')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="/produser/katalog" class="btn-outline" style="border: none; padding-left: 0; color: white; background: var(--prod-text-sec); padding: 8px 16px; border-radius: 8px; text-decoration: none;"><i class="ph ph-arrow-left"></i> Detail Produk/Jasa</a>
</div>

<div class="tefa-card" style="padding: 0; background: white; margin-bottom: 24px;">
    
    <!-- Hero Image Ber-Overlay Teks -->
    <div class="katalog-hero-container">
        <img id="detKatalogImg" src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1000&q=80" class="katalog-hero-img">
        <div class="katalog-hero-overlay">
            <div class="katalog-badges">
                <span class="katalog-badge-light" id="detKatalogTypeBadge">Memuat...</span>
                <span class="katalog-badge-dark" id="detKatalogCode">Kode: PRD-000</span>
            </div>
            <h2 id="detKatalogName" style="font-size: 32px; font-weight: 700; margin: 0;">Memuat Judul...</h2>
        </div>
    </div>
    
    <!-- Detail Spesifikasi -->
    <div style="padding: 32px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
            <div>
                <div class="hero-stat-label">Kategori</div>
                <div class="hero-stat-value" id="detKatalogKategori" style="margin-bottom: 16px;">Web Development</div>
                <div class="hero-stat-label">Jenis</div>
                <div class="hero-stat-value" id="detKatalogType">Memuat...</div>
            </div>
            <div>
                <div class="hero-stat-label">Harga</div>
                <div class="hero-stat-value" id="detKatalogPrice" style="color: var(--primary); font-size: 20px; margin-bottom: 16px;">Rp 0</div>
                <div class="hero-stat-label">Jumlah Pesanan</div>
                <div class="hero-stat-value" id="detKatalogTotalOrders" style="color: #D8893D; font-size: 20px;">0</div>
            </div>
        </div>
        
        <div style="margin-bottom: 24px;">
            <h3 style="font-size: 15px; color: var(--prod-text-main); margin-bottom: 12px; font-weight: 700;">Deskripsi</h3>
            <div id="detKatalogDesc" style="font-size: 14px; color: var(--prod-text-sec); line-height: 1.7;">Memuat deskripsi...</div>
        </div>

        <div>
            <h3 style="font-size: 15px; color: var(--prod-text-main); margin-bottom: 12px; font-weight: 700;">Yang Termasuk</h3>
            <ul class="check-list" id="detKatalogFeatures">
                <!-- Dimuat oleh JS -->
            </ul>
        </div>
    </div>
</div>

<!-- Tabel Pesanan Terkait di bagian bawah -->
<div class="tefa-card" style="padding: 24px; background: white;">
    <h3 style="font-size: 16px; margin-bottom: 16px; font-weight: 700;">Pesanan Terkait (<span id="totalRelatedOrders">0</span>)</h3>
    <div class="table-responsive">
        <table class="table-modern" style="width: 100%;">
            <thead>
                <tr>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Order ID</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Produk/Jasa</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Customer</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Status Pengerjaan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Status Pesanan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="relatedOrderTable">
                <!-- Dimuat oleh JS -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/produser-action.js') }}"></script>
@endsection