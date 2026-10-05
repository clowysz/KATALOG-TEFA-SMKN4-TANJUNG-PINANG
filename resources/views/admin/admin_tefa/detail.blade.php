@extends('admin.layouts.app')

@section('title', 'Detail Katalog')

@section('content')
<!-- SWIPER CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<style>
    .detail-container {
        padding: 28px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        max-width: 1100px;
        margin: 0 auto;
    }

    /* TOMBOL KEMBALI */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748B;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 24px;
        transition: color 0.2s ease;
    }

    .btn-back:hover {
        color: #1E40AF;
    }

    /* GRID UTAMA (ATAS) */
    .detail-top-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 36px;
        align-items: start;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {
        .detail-top-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    /* AREA SLIDER GAMBAR */
    .gallery-container {
        width: 100%;
        min-width: 0;
    }

    /* MAIN SWIPER */
    .swiper-main {
        width: 100%;
        height: 320px;
        border-radius: 20px;
        overflow: hidden;
        background-color: #F8FAFC;
        border: 1px solid #E2E8F0;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
        margin-bottom: 14px;
    }

    .swiper-main .swiper-slide {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #0F172A;
    }

    .swiper-main .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    /* THUMBNAIL SWIPER */
    .swiper-thumbs {
        width: 100%;
        height: 65px;
        margin-bottom: 16px;
    }

    .swiper-thumbs .swiper-slide {
        width: 80px;
        height: 100%;
        border-radius: 12px;
        overflow: hidden;
        opacity: 0.5;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #0F172A;
    }

    .swiper-thumbs .swiper-slide-thumb-active {
        opacity: 1;
        border: 2px solid #1E40AF;
    }

    .swiper-thumbs .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* NAVIGASI SLIDER & DRAGGABLE SCROLLBAR */
    .slider-controls-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 0 4px;
    }

    .nav-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F1F5F9;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        border: none;
        transition: background 0.2s ease;
        flex-shrink: 0;
    }

    .nav-btn:hover {
        background: #E2E8F0;
        color: #1E40AF;
    }

    /* STYLING GARIS SCROLLBAR BISA DIGESER (DRAGGABLE) */
    .custom-scrollbar {
        flex-grow: 1;
        height: 6px !important;
        background: #E2E8F0 !important;
        border-radius: 4px !important;
        position: relative !important;
        left: auto !important;
        bottom: auto !important;
        top: auto !important;
        width: auto !important;
        cursor: grab;
    }

    .custom-scrollbar:active {
        cursor: grabbing;
    }

    .custom-scrollbar .swiper-scrollbar-drag {
        background: #1E40AF !important;
        border-radius: 4px !important;
    }

    /* SISI KANAN: JUDUL & HARGA */
    .product-info-side {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        padding-top: 8px;
    }

    .product-title {
        font-size: 32px;
        font-weight: 800;
        color: #1E3A8A;
        margin: 0 0 20px 0;
        line-height: 1.25;
    }

    .price-label {
        font-size: 12px;
        font-weight: 800;
        color: #64748B;
        letter-spacing: 1px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .price-value {
        font-size: 32px;
        font-weight: 800;
        color: #1E40AF;
        margin: 0;
    }

    /* GRID 3 KOTAK INFO */
    .info-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    @media (max-width: 768px) {
        .info-cards-grid {
            grid-template-columns: 1fr;
        }
    }

    .info-box {
        background: #F0F7FF;
        border: 1px solid #E0F2FE;
        border-radius: 16px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .info-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #FFFFFF;
        color: #1E40AF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.04);
        flex-shrink: 0;
    }

    .info-label {
        font-size: 11px;
        font-weight: 800;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .info-val {
        font-size: 14px;
        font-weight: 700;
        color: #0F172A;
    }

    /* KOTAK DESKRIPSI */
    .description-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02);
    }

    .description-title {
        font-size: 16px;
        font-weight: 800;
        color: #1E40AF;
        margin: 0 0 16px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .description-content {
        font-size: 15px;
        line-height: 1.7;
        color: #475569;
        white-space: pre-line;
    }
</style>

<div class="detail-container">
    
    <!-- TOMBOL KEMBALI -->
    <a href="javascript:history.back()" class="btn-back">
        <i class="ph ph-arrow-left" style="font-size: 18px;"></i>
        <span>Kembali ke Katalog</span>
    </a>

    <!-- BARIS ATAS: SLIDER GAMBAR & NAMA PRODUK -->
    <div class="detail-top-grid">
        <!-- AREA GALERI SLIDER -->
        <div class="gallery-container">
            <!-- SLIDER UTAMA -->
            <div class="swiper swiper-main">
                <div class="swiper-wrapper">
                    @if($item->gambars && $item->gambars->count() > 0)
                        @foreach($item->gambars as $gbr)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $gbr->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}">
                            </div>
                        @endforeach
                    @else
                        <div class="swiper-slide">
                            <img src="https://placehold.co/600x400?text=Tidak+Ada+Gambar" alt="Placeholder">
                        </div>
                    @endif
                </div>
            </div>

            <!-- THUMBNAILS -->
            @if($item->gambars && $item->gambars->count() > 0)
                <div class="swiper swiper-thumbs">
                    <div class="swiper-wrapper">
                        @foreach($item->gambars as $gbr)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $gbr->path_gambar) }}" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- KONTROL PANAH < > DAN SCROLLBAR DRAGGABLE -->
            <div class="slider-controls-wrapper">
                <button class="nav-btn btn-prev">&lsaquo;</button>
                
                <!-- ELEMEN SCROLLBAR BISA DIGESER (SLIDE) -->
                <div class="swiper-scrollbar custom-scrollbar"></div>
                
                <button class="nav-btn btn-next">&rsaquo;</button>
            </div>
        </div>

        <!-- SISI KANAN: NAMA & HARGA -->
        <div class="product-info-side">
            <h1 class="product-title">{{ $item->nama_produk_jasa }}</h1>
            <div class="price-label">HARGA</div>
            <div class="price-value">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- BARIS TENGAH: 3 KOTAK INFO -->
    <div class="info-cards-grid">
        <!-- JENIS -->
        <div class="info-box">
            <div class="info-icon">
                <i class="ph ph-tag"></i>
            </div>
            <div>
                <div class="info-label">JENIS</div>
                <div class="info-val">{{ ucfirst($item->jenis ?? $item->kategori ?? 'Jasa') }}</div>
            </div>
        </div>

        <!-- JURUSAN -->
        <div class="info-box">
            <div class="info-icon">
                <i class="ph ph-bank"></i>
            </div>
            <div>
                <div class="info-label">JURUSAN</div>
                <div class="info-val">{{ $jurusan->nama_jurusan ?? ($item->jurusan->nama_jurusan ?? 'Rekayasa Perangkat Lunak') }}</div>
            </div>
        </div>

        <!-- JUMLAH PESANAN -->
        <div class="info-box">
            <div class="info-icon">
                <i class="ph ph-package"></i>
            </div>
            <div>
                <div class="info-label">JUMLAH PESANAN</div>
                <div class="info-val">{{ $item->jumlah_pesanan ?? 0 }}</div>
            </div>
        </div>
    </div>

    <!-- BARIS BAWAH: DESKRIPSI -->
    <div class="description-card">
        <h4 class="description-title">DESKRIPSI ———</h4>
        <div class="description-content">
            {{ $item->deskripsi ?? 'Belum ada deskripsi untuk produk atau jasa ini.' }}
        </div>
    </div>

</div>

<!-- SWIPER JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiperThumbs = new Swiper('.swiper-thumbs', {
            spaceBetween: 10,
            slidesPerView: 'auto',
            freeMode: true,
            watchSlidesProgress: true,
        });

        const swiperMain = new Swiper('.swiper-main', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.btn-next',
                prevEl: '.btn-prev',
            },
            thumbs: {
                swiper: swiperThumbs,
            },
            /* MENGAKTIFKAN DRAGGABLE PADA GARIS BLUE PROGRESS */
            scrollbar: {
                el: '.custom-scrollbar',
                draggable: true,
                snapOnRelease: true,
            },
        });
    });
</script>
@endsection