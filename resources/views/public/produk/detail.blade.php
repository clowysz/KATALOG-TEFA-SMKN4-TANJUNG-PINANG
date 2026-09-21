@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">

    <!-- Tombol Kembali -->
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="/jurusan/{{ $jurusan->slug }}/produk" class="back-link">
            <i class="ph ph-arrow-left"></i>
            Kembali ke Produk
        </a>
    </div>

    <!-- Bagian Atas: Gambar & Judul -->
    <div class="detail-top-container">

        <!-- Galeri Gambar -->
        <div class="detail-gallery">

            @php
                $gambarUtama = $produk->gambars->first();
            @endphp

            @if($gambarUtama)

                <img
                    src="{{ asset('storage/' . $gambarUtama->path_gambar) }}"
                    class="main-image"
                    id="mainProductImage"
                    alt="{{ $produk->nama_produk_jasa }}"
                >

                <div class="thumbnail-list">

                    @foreach($produk->gambars as $gambar)

                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            class="thumb-item {{ $loop->first ? 'active' : '' }}"
                            alt="{{ $produk->nama_produk_jasa }}"
                            onclick="changeProductImage(this)"
                        >

                    @endforeach

                </div>

            @else

                <img
                    src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Produk"
                    class="main-image"
                    alt="{{ $produk->nama_produk_jasa }}"
                >

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

            <div class="detail-price">
                Rp{{ number_format($produk->harga, 0, ',', '.') }}
            </div>

            <a
                href="/login-pembeli"
                class="btn-pesan"
            >
                <i
                    class="ph ph-shopping-cart"
                    style="font-size: 24px;"
                ></i>
                Pesan Sekarang
            </a>

        </div>

    </div>

    <!-- Bagian Bawah: Deskripsi -->
    <div class="detail-card">

        <h2 class="detail-section-title">
            Deskripsi Produk
        </h2>

        <div class="detail-text">
            {!! nl2br(e($produk->deskripsi)) !!}
        </div>

    </div>

</div>

<script>
    function changeProductImage(element) {

        const mainImage =
            document.getElementById('mainProductImage');

        if (!mainImage) return;

        mainImage.src = element.src;

        document
            .querySelectorAll('.thumb-item')
            .forEach(function (thumb) {
                thumb.classList.remove('active');
            });

        element.classList.add('active');
    }
</script>

@endsection