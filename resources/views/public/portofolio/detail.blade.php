@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">

    <div style="max-width: 1200px; margin: 0 auto;">

        <a
            href="/jurusan/{{ $jurusan->slug }}/portofolio"
            class="back-link"
        >
            <i class="ph ph-arrow-left"></i>
            Kembali ke Portofolio
        </a>

    </div>


    <div class="detail-top-container">

        <div class="detail-gallery">

            @php
                $gambarUtama = $portofolio->gambars->first();
            @endphp

            @if($gambarUtama)

                <img
                    src="{{ asset('storage/' . $gambarUtama->path_gambar) }}"
                    class="main-image"
                    id="mainPortfolioImage"
                    alt="{{ $portofolio->judul }}"
                >

                @if($portofolio->gambars->count() > 1)

                    <div class="thumbnail-list">

                        @foreach($portofolio->gambars as $gambar)

                            <img
                                src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                class="thumb-item {{ $loop->first ? 'active' : '' }}"
                                alt="{{ $portofolio->judul }}"
                                onclick="changePortfolioImage(this)"
                            >

                        @endforeach

                    </div>

                @endif

            @else

                <img
                    src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Portofolio"
                    class="main-image"
                    alt="{{ $portofolio->judul }}"
                >

            @endif

        </div>


        <div class="detail-info">

            <div
                class="detail-badge"
                style="
                    background: #16A34A;
                    color: white;
                "
            >
                KARYA SISWA
            </div>


            <h1 class="detail-title">
                {{ $portofolio->judul }}
            </h1>


            @if($portofolio->tahun)

                <div
                    style="
                        margin-top: 24px;
                        display: flex;
                        align-items: center;
                        gap: 12px;
                    "
                >

                    <div
                        style="
                            background: #F1F5F9;
                            padding: 12px;
                            border-radius: 8px;
                            color: #1E3A8A;
                        "
                    >
                        <i
                            class="ph ph-calendar-blank"
                            style="font-size: 24px;"
                        ></i>
                    </div>

                    <div>

                        <div
                            style="
                                font-size: 13px;
                                color: #64748B;
                            "
                        >
                            Tahun Pembuatan
                        </div>

                        <div
                            style="
                                font-size: 16px;
                                font-weight: 600;
                                color: #1E2D3D;
                            "
                        >
                            {{ $portofolio->tahun }}
                        </div>

                    </div>

                </div>

            @endif

        </div>

    </div>


    <div class="detail-card">

        <h2 class="detail-section-title">
            Deskripsi Portofolio
        </h2>

        <div class="detail-text">
            {!! nl2br(e($portofolio->deskripsi)) !!}
        </div>

    </div>

</div>


<script>

    function changePortfolioImage(element) {

        const mainImage =
            document.getElementById('mainPortfolioImage');

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