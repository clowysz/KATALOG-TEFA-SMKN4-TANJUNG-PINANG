@extends('admin.layouts.app')

@section('title', 'Detail Katalog')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">

<style>
/*  HALAMAN DETAIL (SPACING DI-DEMPETKAN) */
.detail-page-wrapper {
    background-color: #f8fafc;
    min-height: 100vh;
    padding: 0px 24px 40px; /* Padding atas dikurangi dari 32px menjadi 16px */
}

/* =========================================================
   TOMBOL KEMBALI
   Disamakan dengan tombol kembali halaman FAQ
========================================================= */
.back-link-wrapper {
    margin-bottom: 2px;
}

.back-link {
    display: inline-block !important;
    padding: 8px 16px !important;
    border: 1px solid #1E3A8A !important;
    border-radius: 8px !important;
    color: #1E3A8A !important;
    background: #FFFFFF !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    opacity: 1 !important;
    filter: none !important;
    box-shadow: none !important;
    transform: none !important;
}

.back-link i {
    color: #1E3A8A !important;
    opacity: 1 !important;
    filter: none !important;
}

.back-link:hover {
    background: #1E3A8A !important;
    color: #FFFFFF !important;
    border-color: #1E3A8A !important;
    opacity: 1 !important;
    filter: none !important;
}

.back-link:hover i {
    color: #FFFFFF !important;
    opacity: 1 !important;
}
/* =========================================================
   CONTAINER UTAMA (GALERI + INFO)
========================================================= */
.detail-top-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px 32px; /* Padding atas/bawah kartu dikurangi dari 32px ke 24px */
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    align-items: start;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    border: 1px solid #f1f5f9;
    margin-bottom: 20px;
}

/* =========================================================
   GALERI & SLIDER
========================================================= */
.detail-gallery {
    width: 100%;
}

.admin-product-gallery {
    width: 100%;
}

.admin-main-image {
    position: relative;
    width: 100%;
    height: 380px;
    overflow: hidden;
    border-radius: 14px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
}

.admin-gallery-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    cursor: zoom-in;
}

.admin-gallery-image.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
}

/* TOMBOL NAVIGASI GALERI */
.admin-gallery-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #0f172a;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: background 0.2s ease, transform 0.2s ease;
}

.admin-gallery-arrow:hover {
    background: #ffffff;
    transform: translateY(-50%) scale(1.08);
}

.admin-gallery-prev { left: 14px; }
.admin-gallery-next { right: 14px; }

/* DOTS */
.admin-gallery-dots {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    z-index: 10;
}

.admin-gallery-dot {
    width: 8px;
    height: 8px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.2s ease;
}

.admin-gallery-dot.active {
    width: 20px;
    border-radius: 10px;
    background: #ffffff;
}

/* THUMBNAILS */
.admin-gallery-thumbnails {
    display: flex;
    gap: 10px;
    width: 100%;
    margin-top: 14px;
    padding-bottom: 4px;
    overflow-x: auto;
    scrollbar-width: thin;
}

.admin-gallery-thumbnails::-webkit-scrollbar {
    height: 4px;
}

.admin-gallery-thumbnails::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.admin-gallery-thumb {
    flex: 0 0 70px;
    width: 70px;
    height: 55px;
    padding: 0;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    background: #e2e8f0;
    opacity: 0.6;
    cursor: pointer;
    transition: all 0.2s ease;
}

.admin-gallery-thumb:hover,
.admin-gallery-thumb.active {
    opacity: 1;
    border-color: #1e3a8a;
}

.admin-gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* =========================================================
   INFORMASI PRODUK / JASA
========================================================= */
.detail-info {
    display: flex;
    flex-direction: column;
}

.detail-badge {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
}

.detail-title {
    color: #0f172a;
    font-size: 28px;
    font-weight: 800;
    line-height: 1.3;
    margin: 0 0 20px;
}

.price-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
}

.price-label {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-price {
    color: #1e3a8a;
    font-size: 28px;
    font-weight: 800;
}

/* =========================================================
   META CARDS (JENIS, JURUSAN, PESANAN)
========================================================= */
.detail-meta-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.meta-card-item {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
}

.meta-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border-radius: 10px;
    background: #eff6ff;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
}

.meta-icon i {
    font-size: 20px;
}

.meta-label {
    display: block;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.3px;
    margin-bottom: 2px;
}

.meta-value {
    display: block;
    color: #0f172a;
    font-size: 14px;
    font-weight: 700;
}

/* =========================================================
   CARD DESKRIPSI
========================================================= */
.detail-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    border: 1px solid #f1f5f9;
    color: #0f172a;
}

.detail-section-title {
    margin: 0 0 16px;
    color: #0f172a;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.3px;
    position: relative;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f5f9;
}

.detail-text {
    color: #334155;
    font-size: 15px;
    line-height: 1.8;
}

/* =========================================================
   LIGHTBOX
========================================================= */
.admin-gallery-lightbox {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(4px);
}

.admin-gallery-lightbox.active {
    display: flex;
}

.admin-lightbox-image {
    max-width: 90vw;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.admin-lightbox-close {
    position: absolute;
    top: 20px;
    right: 24px;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
    transition: background 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.admin-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* =========================================================
   RESPONSIVE
========================================================= */
@media (max-width: 992px) {
    .detail-top-card {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 24px;
    }
    .admin-main-image {
        height: 320px;
    }
}

@media (max-width: 768px) {
    .detail-meta-cards {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .detail-page-wrapper {
        padding: 20px 16px 36px;
    }
    .detail-top-card,
    .detail-card {
        padding: 20px;
        border-radius: 16px;
    }
    .admin-main-image {
        height: 250px;
    }
    .detail-title {
        font-size: 22px;
    }
    .detail-price {
        font-size: 24px;
    }
}
</style>
@endpush


@section('content')
<div class="detail-page-wrapper">
    <div class="detail-container-inner">

       {{-- BACK BUTTON --}}
<div class="back-link-wrapper">
    <a href="{{ route('admin.tefa.katalog_gabungan') }}" class="back-link">
        <i class="ph ph-arrow-left"></i>
        <span>Kembali ke Katalog</span>
    </a>
</div>

        {{-- CONTAINER ATAS: GALERI & DETAIL --}}
        <div class="detail-top-card">

            {{-- GALERI --}}
            <div class="detail-gallery">
                @php
                    $gambars = $produk->gambars;
                @endphp

                <div class="admin-product-gallery">
                    <div class="admin-main-image">
                        @if($gambars->count() > 0)
                            @foreach($gambars as $index => $gambar)
                                <img
                                    src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                    class="admin-gallery-image {{ $index === 0 ? 'active' : '' }}"
                                    data-index="{{ $index }}"
                                    alt="{{ $produk->nama_produk_jasa }}"
                                >
                            @endforeach

                            @if($gambars->count() > 1)
                                <button type="button" class="admin-gallery-arrow admin-gallery-prev" onclick="adminGalleryPrev()" aria-label="Gambar sebelumnya">‹</button>
                                <button type="button" class="admin-gallery-arrow admin-gallery-next" onclick="adminGalleryNext()" aria-label="Gambar berikutnya">›</button>

                                <div class="admin-gallery-dots">
                                    @foreach($gambars as $index => $gambar)
                                        <button type="button" class="admin-gallery-dot {{ $index === 0 ? 'active' : '' }}" onclick="adminGalleryGo({{ $index }})" aria-label="Gambar {{ $index + 1 }}"></button>
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <img
                                src="https://placehold.co/800x600/E2E8F0/1E3A8A?text={{ ucfirst($produk->jenis) }}"
                                class="admin-gallery-image active"
                                alt="{{ $produk->nama_produk_jasa }}"
                            >
                        @endif
                    </div>

                    @if($gambars->count() > 1)
                        <div class="admin-gallery-thumbnails">
                            @foreach($gambars as $index => $gambar)
                                <button type="button" class="admin-gallery-thumb {{ $index === 0 ? 'active' : '' }}" onclick="adminGalleryGo({{ $index }})">
                                    <img src="{{ asset('storage/' . $gambar->path_gambar) }}" alt="Gambar {{ $index + 1 }}">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- INFORMASI PRODUK / JASA --}}
            <div class="detail-info">
                <div class="detail-badge">
                    {{ strtoupper($produk->jenis) }}
                </div>

                <h1 class="detail-title">
                    {{ $produk->nama_produk_jasa }}
                </h1>

                <div class="price-box">
                    <div class="price-label">HARGA</div>
                    <div class="detail-price">
                        Rp{{ number_format($produk->harga, 0, ',', '.') }}{{ $produk->satuan_harga ? '/' . $produk->satuan_harga : '' }}
                    </div>
                </div>
            </div>

        </div>

        {{-- META CARDS --}}
        <div class="detail-meta-cards">
            {{-- JENIS --}}
            <div class="meta-card-item">
                <div class="meta-icon">
                    <i class="ph ph-tag"></i>
                </div>
                <div>
                    <span class="meta-label">JENIS</span>
                    <span class="meta-value">{{ ucfirst($produk->jenis) }}</span>
                </div>
            </div>

            {{-- JURUSAN --}}
            <div class="meta-card-item">
                <div class="meta-icon">
                    <i class="ph ph-graduation-cap"></i>
                </div>
                <div>
                    <span class="meta-label">JURUSAN</span>
                    <span class="meta-value">{{ $produk->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</span>
                </div>
            </div>

            {{-- JUMLAH PESANAN --}}
            <div class="meta-card-item">
                <div class="meta-icon">
                    <i class="ph ph-shopping-cart"></i>
                </div>
                <div>
                    <span class="meta-label">JUMLAH PESANAN</span>
                    <span class="meta-value">{{ $produk->pesanans_count }}</span>
                </div>
            </div>
        </div>

        {{-- DESKRIPSI --}}
        <div class="detail-card">
            <h2 class="detail-section-title">DESKRIPSI</h2>
            <div class="detail-text">
                {!! nl2br(e($produk->deskripsi)) !!}
            </div>
        </div>

    </div>
</div>

{{-- LIGHTBOX --}}
<div class="admin-gallery-lightbox" id="adminGalleryLightbox">
    <button type="button" class="admin-lightbox-close" onclick="adminGalleryCloseLightbox()">&times;</button>
    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Preview gambar">
</div>

<script>
/* =========================================================
   GALERI LOGIC (DIPERTAHANKAN 100%)
========================================================= */
let adminGalleryIndex = 0;

function adminGalleryImages() {
    return document.querySelectorAll('.admin-gallery-image');
}

function adminGalleryUpdate() {
    const images = adminGalleryImages();
    const dots = document.querySelectorAll('.admin-gallery-dot');
    const thumbs = document.querySelectorAll('.admin-gallery-thumb');

    if (!images.length) return;

    images.forEach((image, index) => {
        image.classList.toggle('active', index === adminGalleryIndex);
    });

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === adminGalleryIndex);
    });

    thumbs.forEach((thumb, index) => {
        thumb.classList.toggle('active', index === adminGalleryIndex);
    });

    const activeThumb = document.querySelector('.admin-gallery-thumb.active');
    if (activeThumb) {
        activeThumb.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });
    }
}

function adminGalleryNext() {
    const images = adminGalleryImages();
    if (images.length <= 1) return;
    adminGalleryIndex++;
    if (adminGalleryIndex >= images.length) adminGalleryIndex = 0;
    adminGalleryUpdate();
}

function adminGalleryPrev() {
    const images = adminGalleryImages();
    if (images.length <= 1) return;
    adminGalleryIndex--;
    if (adminGalleryIndex < 0) adminGalleryIndex = images.length - 1;
    adminGalleryUpdate();
}

function adminGalleryGo(index) {
    const images = adminGalleryImages();
    if (index < 0 || index >= images.length) return;
    adminGalleryIndex = index;
    adminGalleryUpdate();
}

function adminGalleryOpenLightbox(src) {
    const modal = document.getElementById('adminGalleryLightbox');
    const image = document.getElementById('adminLightboxImage');
    if (!modal || !image) return;
    image.src = src;
    modal.classList.add('active');
}

function adminGalleryCloseLightbox() {
    const modal = document.getElementById('adminGalleryLightbox');
    if (!modal) return;
    modal.classList.remove('active');
}

document.addEventListener('DOMContentLoaded', function() {
    adminGalleryUpdate();

    const images = adminGalleryImages();
    images.forEach(function(image) {
        image.addEventListener('click', function() {
            adminGalleryOpenLightbox(this.src);
        });
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            adminGalleryCloseLightbox();
        }
    });

    const modal = document.getElementById('adminGalleryLightbox');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                adminGalleryCloseLightbox();
            }
        });
    }

    const mainImage = document.querySelector('.admin-main-image');
    if (mainImage) {
        let startX = 0;
        let startY = 0;

        mainImage.addEventListener('touchstart', function(event) {
            if (!event.touches.length) return;
            startX = event.touches[0].clientX;
            startY = event.touches[0].clientY;
        }, { passive: true });

        mainImage.addEventListener('touchend', function(event) {
            if (!event.changedTouches.length) return;
            const endX = event.changedTouches[0].clientX;
            const endY = event.changedTouches[0].clientY;
            const diffX = startX - endX;
            const diffY = startY - endY;

            if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
                if (diffX > 0) {
                    adminGalleryNext();
                } else {
                    adminGalleryPrev();
                }
            }
        }, { passive: true });
    }
});
</script>
@endsection