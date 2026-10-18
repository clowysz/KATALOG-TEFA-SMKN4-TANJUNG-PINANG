@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section hero-page">

    <div
        class="bubble"
        style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"
    ></div>

    <div
        class="bubble"
        style="width: 60px; height: 60px; bottom: 40%; right: 20%; animation-duration: 5s;"
    ></div>

    <div class="jurusan-hero-content">

        <div class="jurusan-hero-image">
            <img
                src="{{ asset($jurusan->hero) }}"
                alt="{{ $jurusan->name }}"
            >
        </div>

        <div class="jurusan-hero-text">

            <h3>JURUSAN</h3>

            <h1>{{ $jurusan->name }}</h1>

            <p>
                {{ $jurusan->description }}
            </p>

            <a href="/#jurusan-unggulan" class="btn-kembali-beranda">
                <i class="ph ph-arrow-u-up-left"></i>
                Kembali ke Daftar Jurusan
            </a>

        </div>

    </div>

    <svg
        class="wave-jurusan"
        viewBox="0 0 1440 320"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            fill="#F8FAFC"
            fill-opacity="1"
            d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"
        ></path>
    </svg>

</section>


<section class="deskripsi-content deskripsi-page">

    <div class="deskripsi-wrapper">

        @if(!empty($jurusan->deskripsi_panjang))

            @foreach(
                preg_split(
                    "/\R{2,}/",
                    trim($jurusan->deskripsi_panjang)
                ) as $paragraph
            )

                @if(trim($paragraph) !== '')

                    <p>
                        {{ $paragraph }}
                    </p>

                @endif

            @endforeach

        @else

            <div class="katalog-empty">

                <i class="ph ph-info"></i>

                <h3>Deskripsi Jurusan Belum Tersedia</h3>

                <p>Informasi lengkap mengenai jurusan ini belum ditambahkan.</p>

            </div>

        @endif

    </div>

</section>

@endsection