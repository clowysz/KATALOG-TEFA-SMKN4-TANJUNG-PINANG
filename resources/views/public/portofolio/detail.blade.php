@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">

    <div class="detail-back-wrap">

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

            <div class="detail-badge badge-karya">
                KARYA DAN PROYEK
            </div>


            <h1 class="detail-title">
                {{ $portofolio->judul }}
            </h1>


            @if($portofolio->tahun)

                <div class="detail-year">

                    <div class="detail-year-icon">
                        <i class="ph ph-calendar-blank"></i>
                    </div>

                    <div>

                        <div class="detail-year-label">
                            Tahun Pembuatan
                        </div>

                        <div class="detail-year-value">
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

@endsection

@push('scripts')
    <script src="{{ asset('js/portofolio-detail-pembeli.js') }}"></script>
@endpush