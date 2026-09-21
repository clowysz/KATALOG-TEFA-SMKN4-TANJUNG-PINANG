@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 80px; position: relative;">

    <div
        class="bubble"
        style="
            width: 100px;
            height: 100px;
            top: 20%;
            right: 10%;
            animation-duration: 7s;
        "
    ></div>

    <div
        class="jurusan-hero-content"
        style="position: relative; z-index: 10;"
    >

        <div class="jurusan-hero-image">

            <img
                src="{{ asset($jurusan->hero) }}"
                alt="Portofolio {{ $jurusan->name }}"
            >

        </div>

        <div class="jurusan-hero-text">

            <h3>PORTFOLIO</h3>

            <h1>
                KARYA & PROYEK {{ $jurusan->name }}
            </h1>

            <p>
                Berbagai karya dan proyek siswa
                {{ $jurusan->name }} SMKN 4 Tanjungpinang.
            </p>

            <a
                href="/#jurusan-unggulan"
                class="btn-kembali-beranda"
                style="position: relative; z-index: 50;"
            >
                <i class="ph ph-arrow-u-up-left"></i>
                Kembali ke Daftar Jurusan
            </a>

        </div>

    </div>

    <svg
        class="wave-jurusan"
        viewBox="0 0 1440 120"
        preserveAspectRatio="none"
    >
        <path
            d="M0,64 C240,120 480,0 720,64 C960,128 1200,20 1440,64 L1440,120 L0,120 Z"
            fill="#ffffff"
        ></path>
    </svg>

</section>


<section class="katalog-section">

    <div class="katalog-header">

        <div>
            <h2>Portofolio Terbaru</h2>
        </div>

    </div>


    <div class="katalog-grid">

        @forelse($portofolios as $item)

            @php
                $gambar = $item->gambars->first();
            @endphp

            <div class="k-card">

                <div class="k-card-img">

                    <div class="k-badge">
                        Karya
                    </div>

                    @if($gambar)

                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            alt="{{ $item->judul }}"
                        >

                    @else

                        <img
                            src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Portofolio"
                            alt="{{ $item->judul }}"
                        >

                    @endif

                </div>


                <div class="k-card-body">

                    @if($item->tahun)

                        <div class="k-card-year">
                            {{ $item->tahun }}
                        </div>

                    @endif


                    <h3 class="k-card-title">
                        {{ $item->judul }}
                    </h3>


                    <p class="k-card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 100) }}
                    </p>


                    <a
                        href="/jurusan/{{ $jurusan->slug }}/portofolio/detail/{{ $item->id_portfolio }}"
                        class="k-card-btn"
                    >
                        Lihat Selengkapnya &gt;
                    </a>

                </div>

            </div>

        @empty

            <div
                style="
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 80px 20px;
                "
            >

                <div
                    style="
                        font-size: 56px;
                        margin-bottom: 16px;
                    "
                >
                    📂
                </div>

                <h3
                    style="
                        color: var(--text-dark);
                        margin-bottom: 8px;
                    "
                >
                    Belum ada portofolio
                </h3>

                <p
                    style="
                        color: var(--text-muted);
                    "
                >
                    Belum ada karya atau proyek yang
                    ditambahkan oleh jurusan ini.
                </p>

            </div>

        @endforelse

    </div>

</section>

@endsection