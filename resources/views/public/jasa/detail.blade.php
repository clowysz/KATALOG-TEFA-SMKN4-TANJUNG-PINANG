@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">

    <div class="detail-back-wrap">
        @php
            $isFromKatalog = request()->query('from') === 'katalog';

            $backFromKatalog = request()->query('back');

            $backUrl = $isFromKatalog
                && $backFromKatalog
                && str_starts_with($backFromKatalog, '/')
                ? $backFromKatalog
                : url('/jurusan/' . $jurusan->slug . '/jasa');
        @endphp

        <a href="{{ $backUrl }}" class="back-link">
            <i class="ph ph-arrow-left"></i>

            {{ $isFromKatalog ? 'Kembali ke Katalog' : 'Kembali ke Jasa' }}
        </a>
    </div>

    <div class="detail-top-container">

        <!-- Slider Galeri Gambar Utama & Thumbnail Kecil -->
        <div class="detail-gallery">
            @php
                $gambars = $jasa->gambars;
            @endphp

            @if($gambars->count() > 0)
                <div class="image-carousel">
                    <div class="carousel-track-container">
                        <div class="carousel-track" id="carouselTrack">
                            @foreach($gambars as $index => $gambar)
                                <div class="carousel-slide {{ $index === 0 ? 'current-slide' : '' }}">
                                    <img src="{{ asset('storage/' . $gambar->path_gambar) }}" alt="{{ $jasa->nama_produk_jasa }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if($gambars->count() > 1)
                        <button type="button" class="carousel-btn prev-btn" aria-label="Gambar sebelumnya" data-slide-dir="-1">
                            <i class="ph ph-caret-left"></i>
                        </button>
                        <button type="button" class="carousel-btn next-btn" aria-label="Gambar berikutnya" data-slide-dir="1">
                            <i class="ph ph-caret-right"></i>
                        </button>

                        <div class="carousel-nav-dots">
                            @foreach($gambars as $index => $gambar)
                                <button type="button" class="carousel-dot {{ $index === 0 ? 'active' : '' }}" aria-label="Gambar {{ $index + 1 }}" data-slide-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- PREVIEW GAMBAR KECIL DI BAWAH -->
                @if($gambars->count() > 1)
                    <div class="carousel-thumbnails">
                        @foreach($gambars as $index => $gambar)
                            <div class="thumb-item {{ $index === 0 ? 'active' : '' }}" data-slide-index="{{ $index }}">
                                <img src="{{ asset('storage/' . $gambar->path_gambar) }}" alt="Thumbnail {{ $index + 1 }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="image-carousel">
                    <div class="carousel-track-container">
                        <div class="carousel-track">
                            <div class="carousel-slide current-slide">
                                <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Jasa" alt="{{ $jasa->nama_produk_jasa }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Info Jasa -->
        <div class="detail-info">
            <h1 class="detail-title">
                {{ $jasa->nama_produk_jasa }}
            </h1>

            <div class="price-label">HARGA</div>
            <div class="detail-price">
                Rp{{ number_format($jasa->harga, 0, ',', '.') }}{{ $jasa->satuan_harga ? '/' . $jasa->satuan_harga : '' }}
            </div>

            @php
                $checkoutUrl = '/checkout?id_produk_jasa=' . $jasa->id_produk_jasa;

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
                <i class="ph ph-shopping-cart ico-lead"></i>
                Pesan Sekarang
                <i class="ph ph-arrow-right ico-arrow"></i>
            </a>
        </div>

    </div>

    <!-- Kotak Meta Info (Jenis, Jurusan, Jumlah Pesanan) -->
    <div class="detail-meta-cards">
        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-tag"></i></div>
            <div>
                <span class="meta-label">JENIS</span>
                <span class="meta-value">Jasa</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-graduation-cap"></i></div>
            <div>
                <span class="meta-label">JURUSAN</span>
                <span class="meta-value">{{ $jurusan->nama_jurusan ?? ucfirst($jurusan->slug) }}</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-cube"></i></div>
            <div>
                <span class="meta-label">JUMLAH PESANAN</span>
                <span class="meta-value">0</span>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Deskripsi -->
    <div class="detail-card">
        <h2 class="detail-section-title">
            DESKRIPSI
        </h2>

        <div class="detail-text">
            {!! nl2br(e($jasa->deskripsi)) !!}
        </div>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/detail-galeri-pembeli.js') }}"></script>
@endpush