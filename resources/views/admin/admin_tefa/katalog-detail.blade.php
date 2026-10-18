@extends('admin.layouts.app')

@section('title', 'Detail Katalog')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/katalog-tefa.css') }}?v=2">
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
                                <button type="button" class="admin-gallery-arrow admin-gallery-prev" data-gallery-nav="prev" aria-label="Gambar sebelumnya">‹</button>
                                <button type="button" class="admin-gallery-arrow admin-gallery-next" data-gallery-nav="next" aria-label="Gambar berikutnya">›</button>

                                <div class="admin-gallery-dots">
                                    @foreach($gambars as $index => $gambar)
                                        <button type="button" class="admin-gallery-dot {{ $index === 0 ? 'active' : '' }}" data-gallery-go="{{ $index }}" aria-label="Gambar {{ $index + 1 }}"></button>
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
                                <button type="button" class="admin-gallery-thumb {{ $index === 0 ? 'active' : '' }}" data-gallery-go="{{ $index }}">
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
    <button type="button" class="admin-lightbox-close" data-gallery-close>&times;</button>
    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Preview gambar">
</div>

@endsection


@section('scripts')

<script src="{{ asset('js/detail-katalog.js') }}?v=1"></script>

@endsection