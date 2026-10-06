@extends('public.layouts')

@push('css') <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">


<div style="max-width: 1200px; margin: 0 auto;">

    @php
        $isFromKatalog = request()->query('from') === 'katalog';

        $backFromKatalog = request()->query('back');

        $backUrl = $isFromKatalog
            && $backFromKatalog
            && str_starts_with($backFromKatalog, '/')
            ? $backFromKatalog
            : url('/jurusan/' . $jurusan->slug . '/produk');
    @endphp

    <a
        href="{{ $backUrl }}"
        class="back-link"
    >
        <i class="ph ph-arrow-left"></i>
        {{ $isFromKatalog ? 'Kembali ke Katalog' : 'Kembali ke Produk' }}
    </a>

</div>


<div class="detail-top-container">

    <!-- Slider Galeri Gambar Utama & Thumbnail Kecil -->
    <div class="detail-gallery">

        @php
            $gambars = $produk->gambars;
        @endphp

        @if($gambars->count() > 0)

            <div class="image-carousel">

                <div class="carousel-track-container">

                    <div class="carousel-track" id="carouselTrack">

                        @foreach($gambars as $index => $gambar)

                            <div class="carousel-slide {{ $index === 0 ? 'current-slide' : '' }}">

                                <img
                                    src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                    alt="{{ $produk->nama_produk_jasa }}"
                                >

                            </div>

                        @endforeach

                    </div>

                </div>


                @if($gambars->count() > 1)

                    <button
                        type="button"
                        class="carousel-btn prev-btn"
                        onclick="moveSlide(-1)"
                    >
                        <i class="ph ph-caret-left"></i>
                    </button>


                    <button
                        type="button"
                        class="carousel-btn next-btn"
                        onclick="moveSlide(1)"
                    >
                        <i class="ph ph-caret-right"></i>
                    </button>


                    <div class="carousel-nav-dots">

                        @foreach($gambars as $index => $gambar)

                            <button
                                type="button"
                                class="carousel-dot {{ $index === 0 ? 'active' : '' }}"
                                onclick="goToSlide({{ $index }})"
                            ></button>

                        @endforeach

                    </div>

                @endif

            </div>


            <!-- PREVIEW GAMBAR KECIL DI BAWAH -->
            @if($gambars->count() > 1)

                <div class="carousel-thumbnails">

                    @foreach($gambars as $index => $gambar)

                        <div
                            class="thumb-item {{ $index === 0 ? 'active' : '' }}"
                            onclick="goToSlide({{ $index }})"
                        >

                            <img
                                src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                alt="Thumbnail {{ $index + 1 }}"
                            >

                        </div>

                    @endforeach

                </div>

            @endif


        @else

            <div class="image-carousel">

                <div class="carousel-track-container">

                    <div class="carousel-track">

                        <div class="carousel-slide current-slide">

                            <img
                                src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Produk"
                                alt="{{ $produk->nama_produk_jasa }}"
                            >

                        </div>

                    </div>

                </div>

            </div>

        @endif

    </div>


    <!-- Info Produk -->

    <div class="detail-info">

        <div class="detail-badge">
            PRODUK
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


        @php
            $checkoutUrl = '/checkout?id_produk_jasa=' . $produk->id_produk_jasa;

            $loginUrl = route('login', [
                'back' => request()->getRequestUri(),
                'redirect' => $checkoutUrl,
            ]);
        @endphp


        <a
            href="{{ auth()->check() && auth()->user()->role === 'pembeli'
                ? $checkoutUrl
                : $loginUrl }}"
            class="btn-pesan"
        >

            <i
                class="ph ph-shopping-cart"
                style="font-size: 24px;"
            ></i>

            Pesan Sekarang

            <i
                class="ph ph-arrow-right"
                style="font-size: 18px; margin-left: auto;"
            ></i>

        </a>

    </div>

</div>


<!-- Kotak Meta Info -->
<div class="detail-meta-cards">

    <div class="meta-card-item">

        <div class="meta-icon">
            <i class="ph ph-tag"></i>
        </div>

        <div>

            <span class="meta-label">
                JENIS
            </span>

            <span class="meta-value">
                Produk
            </span>

        </div>

    </div>


    <div class="meta-card-item">

        <div class="meta-icon">
            <i class="ph ph-graduation-cap"></i>
        </div>

        <div>

            <span class="meta-label">
                JURUSAN
            </span>

            <span class="meta-value">
                {{ $jurusan->nama_jurusan ?? ucfirst($jurusan->slug) }}
            </span>

        </div>

    </div>


    <div class="meta-card-item">

        <div class="meta-icon">
            <i class="ph ph-cube"></i>
        </div>

        <div>

            <span class="meta-label">
                JUMLAH PESANAN
            </span>

            <span class="meta-value">
                0
            </span>

        </div>

    </div>

</div>


<!-- Bagian Deskripsi -->
<div class="detail-card">

    <h2 class="detail-section-title">
        DESKRIPSI
    </h2>

    <div class="detail-text">
        {!! nl2br(e($produk->deskripsi)) !!}
    </div>

</div>


</div>

<script>

    let currentIndex = 0;


    function moveSlide(direction) {

        const track = document.getElementById('carouselTrack');

        if (!track) return;

        const slides = Array.from(track.children);


        currentIndex += direction;


        if (currentIndex >= slides.length) {

            currentIndex = 0;

        } else if (currentIndex < 0) {

            currentIndex = slides.length - 1;

        }


        updateCarousel();

    }


    function goToSlide(index) {

        currentIndex = index;

        updateCarousel();

    }


    function updateCarousel() {

        const track = document.getElementById('carouselTrack');

        if (!track) return;

        const slides = Array.from(track.children);

        if (slides.length === 0) return;


        const slideWidth =
            slides[0].getBoundingClientRect().width;


        track.style.transform =
            'translateX(-' + (currentIndex * slideWidth) + 'px';


        // Update Dots
        const dots =
            document.querySelectorAll('.carousel-dot');


        dots.forEach((dot, idx) => {

            if (idx === currentIndex) {

                dot.classList.add('active');

            } else {

                dot.classList.remove('active');

            }

        });


        // Update Thumbnails Active State
        const thumbs =
            document.querySelectorAll('.thumb-item');


        thumbs.forEach((thumb, idx) => {

            if (idx === currentIndex) {

                thumb.classList.add('active');

            } else {

                thumb.classList.remove('active');

            }

        });

    }


    window.addEventListener('resize', () => {

        updateCarousel();

    });


    // LIGHTBOX FOTO NGAMBANG
    document.addEventListener('DOMContentLoaded', function() {

        const modal = document.createElement('div');

        modal.className = 'image-lightbox-modal';


        modal.innerHTML = `
            <button class="lightbox-close">&times;</button>
            <img class="lightbox-content" src="" alt="Preview Besar">
        `;


        document.body.appendChild(modal);


        const lightboxImg =
            modal.querySelector('.lightbox-content');

        const closeBtn =
            modal.querySelector('.lightbox-close');

        const clickableImages =
            document.querySelectorAll('.carousel-slide img');


        clickableImages.forEach(img => {

            img.addEventListener('click', function() {

                lightboxImg.src = this.src;

                modal.classList.add('active');

            });

        });


        closeBtn.addEventListener('click', () => {

            modal.classList.remove('active');

        });


        modal.addEventListener('click', (e) => {

            if (e.target === modal) {

                modal.classList.remove('active');

            }

        });


        document.addEventListener('keydown', (e) => {

            if (e.key === 'Escape') {

                modal.classList.remove('active');

            }

        });

    });

</script>

@endsection