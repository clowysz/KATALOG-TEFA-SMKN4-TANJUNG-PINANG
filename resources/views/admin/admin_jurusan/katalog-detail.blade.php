@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk/Jasa')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/katalog-detail-jurusan.css') }}?v=1">
@endsection

@section('content')

<div class="detail-page-wrapper">

    {{-- TOMBOL KEMBALI --}}
    <div class="back-link-wrapper">
        <a href="/jurusan-admin/katalog" class="back-link">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    {{-- LOADING --}}
    <div id="detailLoading" class="detail-state-box">
        <div class="detail-state-icon">
            <i class="ph ph-spinner-gap"></i>
        </div>
        <h3>Memuat detail...</h3>
        <p>Mohon tunggu sebentar, sedang mengambil data produk/jasa.</p>
    </div>

    {{-- ERROR --}}
    <div id="detailError" class="detail-state-box is-error" style="display: none;">
        <div class="detail-state-icon is-error">
            <i class="ph ph-warning"></i>
        </div>
        <h3>Data tidak ditemukan</h3>
        <p>Produk atau jasa yang dipilih tidak tersedia atau telah dihapus.</p>
    </div>

    {{-- KONTEN --}}
    <div id="detailContent" style="display: none;">

        {{-- CONTAINER ATAS: GALERI & INFO --}}
        <div class="detail-top-card">

            <div class="detail-gallery">
                <div class="admin-product-gallery">
                    <div class="admin-main-image" id="adminMainImage"></div>
                    <div class="admin-gallery-thumbnails" id="adminThumbnails" style="display: none;"></div>
                </div>
            </div>

            <div class="detail-info">
                <div class="detail-badge" id="detailBadge">-</div>

                <h1 class="detail-title" id="detailTitle">Memuat...</h1>

                <div class="price-box">
                    <div class="price-label">HARGA</div>
                    <div class="detail-price" id="detailPrice">Rp0</div>
                </div>
            </div>

        </div>

        {{-- META CARDS --}}
        <div class="detail-meta-cards">

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-tag"></i></div>
                <div>
                    <span class="meta-label">JENIS</span>
                    <span class="meta-value" id="metaJenis">-</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-shopping-cart"></i></div>
                <div>
                    <span class="meta-label">JUMLAH PESANAN</span>
                    <span class="meta-value" id="statPesanan">0</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-magnifying-glass"></i></div>
                <div>
                    <span class="meta-label">PENCARIAN</span>
                    <span class="meta-value" id="statPencarian">0</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-eye"></i></div>
                <div>
                    <span class="meta-label">TAMPILAN HALAMAN</span>
                    <span class="meta-value" id="statTampilan">0</span>
                </div>
            </div>

        </div>

        {{-- DESKRIPSI --}}
        <div class="detail-card">
            <h2 class="detail-section-title">DESKRIPSI</h2>
            <div class="detail-text" id="detailDesc">Memuat deskripsi...</div>
        </div>

    </div>
</div>

{{-- LIGHTBOX --}}
<div class="admin-gallery-lightbox" id="adminGalleryLightbox">
    <button type="button" class="admin-lightbox-close" id="adminLightboxClose" aria-label="Tutup">
        &times;
    </button>
    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Preview gambar">
</div>

@endsection


@section('scripts')
<script src="{{ asset('js/katalog-detail-jurusan.js') }}"></script>
@endsection