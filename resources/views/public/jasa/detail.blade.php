@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">

    <div style="max-width: 1200px; margin: 0 auto;">

        <a
            href="/jurusan/{{ $jurusan->slug }}/jasa"
            class="back-link"
        >
            <i class="ph ph-arrow-left"></i>
            Kembali ke Jasa
        </a>

    </div>


    <div class="detail-top-container">

        <div class="detail-gallery">

            @php
                $gambarUtama = $jasa->gambars->first();
            @endphp


            @if($gambarUtama)

                <img
                    src="{{ asset('storage/' . $gambarUtama->path_gambar) }}"
                    class="main-image"
                    id="mainJasaImage"
                    alt="{{ $jasa->nama_produk_jasa }}"
                >


                @if($jasa->gambars->count() > 1)

                    <div class="thumbnail-list">

                        @foreach($jasa->gambars as $gambar)

                            <img
                                src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                class="thumb-item {{ $loop->first ? 'active' : '' }}"
                                alt="{{ $jasa->nama_produk_jasa }}"
                                onclick="changeJasaImage(this)"
                            >

                        @endforeach

                    </div>

                @endif

            @else

                <img
                    src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Jasa"
                    class="main-image"
                    alt="{{ $jasa->nama_produk_jasa }}"
                >

            @endif

        </div>


        <div class="detail-info">

            <div class="detail-badge">
                JASA LAYANAN
            </div>


            <h1 class="detail-title">
                {{ $jasa->nama_produk_jasa }}
            </h1>


            <div class="detail-price">
                Rp{{ number_format($jasa->harga, 0, ',', '.') }}
            </div>


          <a
    href="{{ auth()->check() && auth()->user()->role === 'pembeli'
        ? '/checkout?id_produk_jasa=' . $jasa->id_produk_jasa
        : '/login-pembeli?redirect=' . urlencode('/checkout?id_produk_jasa=' . $jasa->id_produk_jasa)
    }}"
    class="btn-pesan"
>
    <i
        class="ph ph-shopping-cart"
        style="font-size: 24px;"
    ></i>
    Pesan Jasa Ini
</a>
                <i
                    class="ph ph-shopping-cart"
                    style="font-size: 24px;"
                ></i>
                Pesan Jasa Ini
            </a>

        </div>

    </div>


    <div class="detail-card">

        <h2 class="detail-section-title">
            Deskripsi Jasa
        </h2>


        <div class="detail-text">
            {!! nl2br(e($jasa->deskripsi)) !!}
        </div>

    </div>

</div>


<script>

    function changeJasaImage(element) {

        const mainImage =
            document.getElementById('mainJasaImage');

        if (!mainImage) {
            return;
        }

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