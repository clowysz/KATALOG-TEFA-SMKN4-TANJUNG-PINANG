@extends('admin.layouts.app')

@section('title', 'Detail Katalog')

@push('css')

<link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">

<style>

/* =========================================================
   HALAMAN DETAIL
========================================================= */

.detail-page-wrapper {
    background: #F4F8FC;
    min-height: 100vh;
    padding: 40px 5% 50px;
}


/* =========================================================
   BACK
========================================================= */

.detail-page-wrapper > div:first-child {
    max-width: 1200px;
    margin: 0 auto 24px;
}


/* =========================================================
   CONTAINER ATAS
========================================================= */

.detail-top-container {
    max-width: 1200px;
    margin: 0 auto 40px;

    padding: 40px;

    background: #FFFFFF;

    border-radius: 24px;

    display: grid;

    grid-template-columns: 1.1fr 0.9fr;

    gap: 50px;

    align-items: start;

    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
}


/* =========================================================
   GALERI
========================================================= */

.detail-gallery {
    width: 100%;
}


/* =========================================================
   GALERI UTAMA
========================================================= */

.admin-product-gallery {
    width: 100%;
}


.admin-main-image {
    position: relative;

    width: 100%;

    height: 380px;

    overflow: hidden;

    border-radius: 16px;

    background: #E2E8F0;

    border: 1px solid #E2E8F0;
}


/* =========================================================
   GAMBAR
========================================================= */

.admin-gallery-image {
    position: absolute;

    inset: 0;

    width: 100%;
    height: 100%;

    object-fit: cover;

    opacity: 0;

    visibility: hidden;

    transition:
        opacity 0.3s ease,
        visibility 0.3s ease;

    cursor: zoom-in;
}


.admin-gallery-image.active {
    opacity: 1;

    visibility: visible;

    z-index: 1;
}


/* =========================================================
   TOMBOL KIRI / KANAN
========================================================= */

.admin-gallery-arrow {
    position: absolute;

    top: 50%;

    transform: translateY(-50%);

    width: 46px;
    height: 46px;

    padding: 0;

    border: none;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.95);

    color: #1E3A8A;

    font-size: 36px;

    line-height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    z-index: 10;

    box-shadow:
        0 4px 12px rgba(0, 0, 0, 0.20);

    transition:
        background 0.2s ease,
        transform 0.2s ease;
}


.admin-gallery-arrow:hover {
    background: #FFFFFF;

    transform:
        translateY(-50%)
        scale(1.06);
}


.admin-gallery-prev {
    left: 16px;
}


.admin-gallery-next {
    right: 16px;
}


/* =========================================================
   DOT
========================================================= */

.admin-gallery-dots {
    position: absolute;

    bottom: 16px;

    left: 0;
    right: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    gap: 8px;

    z-index: 10;
}


.admin-gallery-dot {
    width: 9px;
    height: 9px;

    padding: 0;

    border: none;

    border-radius: 50%;

    background: rgba(255, 255, 255, 0.70);

    cursor: pointer;

    transition:
        width 0.2s ease,
        background 0.2s ease;
}


.admin-gallery-dot.active {
    width: 24px;

    border-radius: 10px;

    background: #FFFFFF;
}


/* =========================================================
   THUMBNAIL
========================================================= */

.admin-gallery-thumbnails {
    display: flex;

    gap: 12px;

    width: 100%;

    margin-top: 16px;

    padding-bottom: 6px;

    overflow-x: auto;

    overflow-y: hidden;

    scroll-behavior: smooth;

    scrollbar-width: thin;
}


.admin-gallery-thumbnails::-webkit-scrollbar {
    height: 5px;
}


.admin-gallery-thumbnails::-webkit-scrollbar-track {
    background: transparent;
}


.admin-gallery-thumbnails::-webkit-scrollbar-thumb {
    background: #CBD5E1;

    border-radius: 5px;
}


/* =========================================================
   THUMB ITEM
========================================================= */

.admin-gallery-thumb {
    flex: 0 0 75px;

    width: 75px;
    height: 60px;

    padding: 0;

    border: 2px solid transparent;

    border-radius: 10px;

    overflow: hidden;

    background: #E2E8F0;

    opacity: 0.6;

    cursor: pointer;

    transition:
        opacity 0.2s ease,
        border-color 0.2s ease;
}


.admin-gallery-thumb:hover {
    opacity: 1;
}


.admin-gallery-thumb.active {
    opacity: 1;

    border-color: #1E3A8A;
}


.admin-gallery-thumb img {
    display: block;

    width: 100%;
    height: 100%;

    object-fit: cover;
}


/* =========================================================
   INFORMASI
========================================================= */

.detail-info {
    width: 100%;
}


.detail-badge {
    display: inline-flex;

    align-items: center;

    padding: 7px 14px;

    border-radius: 20px;

    background: #E8EEF9;

    color: #1E3A8A;

    font-size: 13px;

    font-weight: 800;

    margin-bottom: 15px;
}


.detail-title {
    color: #1E2D3D;

    font-size: 34px;

    font-weight: 800;

    line-height: 1.2;

    margin: 0 0 25px;
}


.price-label {
    color: #64748B;

    font-size: 13px;

    font-weight: 700;

    margin-bottom: 5px;
}


.detail-price {
    color: #1E3A8A;

    font-size: 30px;

    font-weight: 800;
}


/* =========================================================
   META CARD
========================================================= */

.detail-meta-cards {
    max-width: 1200px;

    margin: 30px auto 0;

    display: grid;

    grid-template-columns: repeat(3, 1fr);

    gap: 20px;
}


.meta-card-item {
    background: #FFFFFF;

    border-radius: 16px;

    padding: 20px 24px;

    display: flex;

    align-items: center;

    gap: 16px;

    border: 1px solid #E2E8F0;

    box-shadow:
        0 4px 15px rgba(0, 0, 0, 0.04);
}


.meta-icon {
    width: 44px;
    height: 44px;

    flex-shrink: 0;

    border-radius: 12px;

    background: #E8EEF9;

    color: #1E3A8A;

    display: flex;

    align-items: center;

    justify-content: center;
}


.meta-icon i {
    font-size: 22px;
}


.meta-label {
    display: block;

    color: #64748B;

    font-size: 11px;

    font-weight: 700;

    margin-bottom: 4px;
}


.meta-value {
    display: block;

    color: #1E2D3D;

    font-size: 15px;

    font-weight: 700;
}


/* =========================================================
   DESKRIPSI
========================================================= */

.detail-card {
    max-width: 1200px;

    margin: 30px auto 0;

    padding: 40px;

    background: #FFFFFF;

    border-radius: 24px;

    box-shadow:
        0 8px 25px rgba(0, 0, 0, 0.06);

    color: #1E2D3D;
}


.detail-section-title {
    margin: 0 0 20px;

    color: #1E2D3D;

    font-size: 22px;

    font-weight: 800;
}


.detail-text {
    color: #475569;

    font-size: 16px;

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

    padding: 30px;

    background: rgba(15, 23, 42, 0.92);
}


.admin-gallery-lightbox.active {
    display: flex;
}


.admin-lightbox-image {
    max-width: 90vw;

    max-height: 90vh;

    object-fit: contain;

    border-radius: 12px;
}


.admin-lightbox-close {
    position: absolute;

    top: 20px;

    right: 25px;

    width: 45px;

    height: 45px;

    border: none;

    border-radius: 50%;

    background: #FFFFFF;

    color: #1E293B;

    font-size: 30px;

    line-height: 1;

    cursor: pointer;
}


/* =========================================================
   RESPONSIVE
========================================================= */

@media (max-width: 992px) {

    .detail-top-container {
        grid-template-columns: 1fr;

        gap: 30px;

        padding: 24px;
    }

    .admin-main-image {
        height: 300px;
    }

}


@media (max-width: 768px) {

    .detail-meta-cards {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 600px) {

    .detail-page-wrapper {
        padding: 25px 20px 40px;
    }

    .detail-top-container {
        padding: 18px;

        border-radius: 20px;
    }

    .admin-main-image {
        height: 260px;
    }

    .admin-gallery-arrow {
        width: 38px;
        height: 38px;

        font-size: 30px;
    }

    .admin-gallery-prev {
        left: 10px;
    }

    .admin-gallery-next {
        right: 10px;
    }

    .detail-title {
        font-size: 27px;
    }

    .detail-price {
        font-size: 25px;
    }

    .detail-card {
        padding: 24px;
    }

}

</style>

@endpush


@section('content')

<div class="detail-page-wrapper">


    {{-- =====================================================
         BACK
    ====================================================== --}}

    <div style="max-width:1200px;margin:0 auto 24px;">

        <a
            href="{{ route('admin.tefa.katalog_gabungan') }}"
            class="back-link"
        >
            <i class="ph ph-arrow-left"></i>

            Kembali ke Katalog

        </a>

    </div>


    {{-- =====================================================
         DETAIL ATAS
    ====================================================== --}}

    <div class="detail-top-container">


        {{-- =================================================
             GALERI
        ================================================== --}}

        <div class="detail-gallery">

            @php
                $gambars = $produk->gambars;
            @endphp


            <div class="admin-product-gallery">


                {{-- =========================================
                     GAMBAR UTAMA
                ========================================== --}}

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


                        {{-- =================================
                             TOMBOL KIRI
                        ================================== --}}

                        @if($gambars->count() > 1)

                            <button
                                type="button"
                                class="admin-gallery-arrow admin-gallery-prev"
                                onclick="adminGalleryPrev()"
                                aria-label="Gambar sebelumnya"
                            >
                                ‹
                            </button>


                            {{-- =============================
                                 TOMBOL KANAN
                            ============================== --}}

                            <button
                                type="button"
                                class="admin-gallery-arrow admin-gallery-next"
                                onclick="adminGalleryNext()"
                                aria-label="Gambar berikutnya"
                            >
                                ›
                            </button>


                            {{-- =============================
                                 DOT
                            ============================== --}}

                            <div class="admin-gallery-dots">

                                @foreach($gambars as $index => $gambar)

                                    <button
                                        type="button"
                                        class="admin-gallery-dot {{ $index === 0 ? 'active' : '' }}"
                                        onclick="adminGalleryGo({{ $index }})"
                                        aria-label="Gambar {{ $index + 1 }}"
                                    ></button>

                                @endforeach

                            </div>

                        @endif


                    @else


                        {{-- =================================
                             PLACEHOLDER
                        ================================== --}}

                        <img
                            src="https://placehold.co/800x600/E2E8F0/1E3A8A?text={{ ucfirst($produk->jenis) }}"
                            class="admin-gallery-image active"
                            alt="{{ $produk->nama_produk_jasa }}"
                        >


                    @endif


                </div>


                {{-- =================================================
                     THUMBNAIL
                ================================================== --}}

                @if($gambars->count() > 1)

                    <div class="admin-gallery-thumbnails">

                        @foreach($gambars as $index => $gambar)

                            <button
                                type="button"
                                class="admin-gallery-thumb {{ $index === 0 ? 'active' : '' }}"
                                onclick="adminGalleryGo({{ $index }})"
                            >

                                <img
                                    src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                    alt="Gambar {{ $index + 1 }}"
                                >

                            </button>

                        @endforeach

                    </div>

                @endif


            </div>

        </div>


        {{-- =================================================
             INFORMASI PRODUK / JASA
        ================================================== --}}

        <div class="detail-info">


            <div class="detail-badge">

                {{ strtoupper($produk->jenis) }}

            </div>


            <h1 class="detail-title">

                {{ $produk->nama_produk_jasa }}

            </h1>


            <div class="price-label">

                HARGA

            </div>


            <div class="detail-price">

                Rp{{ number_format($produk->harga, 0, ',', '.') }}{{ $produk->satuan_harga ? '/' . $produk->satuan_harga : '' }}

            </div>


        </div>

    </div>


    {{-- =====================================================
         META
    ====================================================== --}}

    <div class="detail-meta-cards">


        {{-- JENIS --}}

        <div class="meta-card-item">

            <div class="meta-icon">

                <i class="ph ph-tag"></i>

            </div>

            <div>

                <span class="meta-label">

                    JENIS

                </span>

                <span class="meta-value">

                    {{ ucfirst($produk->jenis) }}

                </span>

            </div>

        </div>


        {{-- JURUSAN --}}

        <div class="meta-card-item">

            <div class="meta-icon">

                <i class="ph ph-graduation-cap"></i>

            </div>

            <div>

                <span class="meta-label">

                    JURUSAN

                </span>

                <span class="meta-value">

                    {{ $produk->jurusan->nama_jurusan ?? 'Semua Jurusan' }}

                </span>

            </div>

        </div>


        {{-- JUMLAH PESANAN --}}

        <div class="meta-card-item">

            <div class="meta-icon">

                <i class="ph ph-shopping-cart"></i>

            </div>

            <div>

                <span class="meta-label">

                    JUMLAH PESANAN

                </span>

                <span class="meta-value">

                    {{ $produk->pesanans_count }}

                </span>

            </div>

        </div>


    </div>


    {{-- =====================================================
         DESKRIPSI
    ====================================================== --}}

    <div class="detail-card">

        <h2 class="detail-section-title">

            DESKRIPSI

        </h2>


        <div class="detail-text">

            {!! nl2br(e($produk->deskripsi)) !!}

        </div>

    </div>


</div>


{{-- =========================================================
     LIGHTBOX
========================================================= --}}

<div
    class="admin-gallery-lightbox"
    id="adminGalleryLightbox"
>

    <button
        type="button"
        class="admin-lightbox-close"
        onclick="adminGalleryCloseLightbox()"
    >
        &times;
    </button>


    <img
        src=""
        class="admin-lightbox-image"
        id="adminLightboxImage"
        alt="Preview gambar"
    >

</div>


<script>

/* =========================================================
   GALERI
========================================================= */

let adminGalleryIndex = 0;


/* =========================================================
   AMBIL GAMBAR
========================================================= */

function adminGalleryImages()
{
    return document.querySelectorAll(
        '.admin-gallery-image'
    );
}


/* =========================================================
   UPDATE GALERI
========================================================= */

function adminGalleryUpdate()
{
    const images =
        adminGalleryImages();

    const dots =
        document.querySelectorAll(
            '.admin-gallery-dot'
        );

    const thumbs =
        document.querySelectorAll(
            '.admin-gallery-thumb'
        );


    if (!images.length) {
        return;
    }


    /* ============================
       GAMBAR
    ============================ */

    images.forEach(
        function(image, index)
        {

            image.classList.toggle(
                'active',
                index === adminGalleryIndex
            );

        }
    );


    /* ============================
       DOT
    ============================ */

    dots.forEach(
        function(dot, index)
        {

            dot.classList.toggle(
                'active',
                index === adminGalleryIndex
            );

        }
    );


    /* ============================
       THUMBNAIL
    ============================ */

    thumbs.forEach(
        function(thumb, index)
        {

            thumb.classList.toggle(
                'active',
                index === adminGalleryIndex
            );

        }
    );


    /* ============================
       SCROLL THUMBNAIL AKTIF
    ============================ */

    const activeThumb =
        document.querySelector(
            '.admin-gallery-thumb.active'
        );


    if (activeThumb) {

        activeThumb.scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });

    }

}


/* =========================================================
   NEXT
========================================================= */

function adminGalleryNext()
{
    const images =
        adminGalleryImages();


    if (images.length <= 1) {
        return;
    }


    adminGalleryIndex++;


    if (
        adminGalleryIndex >= images.length
    ) {

        adminGalleryIndex = 0;

    }


    adminGalleryUpdate();
}


/* =========================================================
   PREVIOUS
========================================================= */

function adminGalleryPrev()
{
    const images =
        adminGalleryImages();


    if (images.length <= 1) {
        return;
    }


    adminGalleryIndex--;


    if (adminGalleryIndex < 0) {

        adminGalleryIndex =
            images.length - 1;

    }


    adminGalleryUpdate();
}


/* =========================================================
   GO TO
========================================================= */

function adminGalleryGo(index)
{
    const images =
        adminGalleryImages();


    if (
        index < 0 ||
        index >= images.length
    ) {

        return;

    }


    adminGalleryIndex = index;

    adminGalleryUpdate();
}


/* =========================================================
   LIGHTBOX
========================================================= */

function adminGalleryOpenLightbox(src)
{
    const modal =
        document.getElementById(
            'adminGalleryLightbox'
        );


    const image =
        document.getElementById(
            'adminLightboxImage'
        );


    if (!modal || !image) {
        return;
    }


    image.src = src;

    modal.classList.add('active');
}


function adminGalleryCloseLightbox()
{
    const modal =
        document.getElementById(
            'adminGalleryLightbox'
        );


    if (!modal) {
        return;
    }


    modal.classList.remove('active');
}


/* =========================================================
   DOM READY
========================================================= */

document.addEventListener(
    'DOMContentLoaded',
    function()
    {


        /* ============================
           INIT
        ============================ */

        adminGalleryUpdate();


        /* ============================
           KLIK GAMBAR
        ============================ */

        const images =
            adminGalleryImages();


        images.forEach(
            function(image)
            {

                image.addEventListener(
                    'click',
                    function()
                    {

                        adminGalleryOpenLightbox(
                            this.src
                        );

                    }
                );

            }
        );


        /* ============================
           ESC LIGHTBOX
        ============================ */

        document.addEventListener(
            'keydown',
            function(event)
            {

                if (
                    event.key === 'Escape'
                ) {

                    adminGalleryCloseLightbox();

                }

            }
        );


        /* ============================
           KLIK LUAR LIGHTBOX
        ============================ */

        const modal =
            document.getElementById(
                'adminGalleryLightbox'
            );


        if (modal) {

            modal.addEventListener(
                'click',
                function(event)
                {

                    if (
                        event.target === modal
                    ) {

                        adminGalleryCloseLightbox();

                    }

                }
            );

        }


        /* ============================
           SWIPE HP
        ============================ */

        const mainImage =
            document.querySelector(
                '.admin-main-image'
            );


        if (mainImage) {

            let startX = 0;
            let startY = 0;


            mainImage.addEventListener(
                'touchstart',
                function(event)
                {

                    if (
                        !event.touches.length
                    ) {

                        return;

                    }


                    startX =
                        event.touches[0].clientX;

                    startY =
                        event.touches[0].clientY;

                },
                {
                    passive: true
                }
            );


            mainImage.addEventListener(
                'touchend',
                function(event)
                {

                    if (
                        !event.changedTouches.length
                    ) {

                        return;

                    }


                    const endX =
                        event.changedTouches[0].clientX;

                    const endY =
                        event.changedTouches[0].clientY;


                    const diffX =
                        startX - endX;

                    const diffY =
                        startY - endY;


                    /* Hanya swipe horizontal */

                    if (
                        Math.abs(diffX) > 50 &&
                        Math.abs(diffX) > Math.abs(diffY)
                    ) {


                        if (diffX > 0) {

                            adminGalleryNext();

                        } else {

                            adminGalleryPrev();

                        }

                    }

                },
                {
                    passive: true
                }
            );

        }

    }
);

</script>

@endsection