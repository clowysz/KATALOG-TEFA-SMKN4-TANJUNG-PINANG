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
                    <span class="k-badge">
                        KARYA
                    </span>

                    @if($gambar)
                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            alt="{{ $item->judul }}"
                        >
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E2E8F0;color:#64748B;">
                            <i class="ph ph-image" style="font-size:48px;"></i>
                        </div>
                    @endif
                </div>

                <div class="k-card-body">
                    @if($item->tahun)
                        <div class="k-card-year">
                            {{ $item->tahun }}
                        </div>
                    @endif

                    <div class="k-card-title">
                        {{ $item->judul }}
                    </div>

                    <div class="k-card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}
                    </div>

                    <a
                        href="/jurusan/{{ $jurusan->slug }}/portofolio/detail/{{ $item->id_portfolio }}"
                        class="k-card-btn"
                    >
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div
                style="
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 60px 20px;
                    background: white;
                    border-radius: 12px;
                    border: 1px dashed #CBD5E1;
                "
            >
                <i
                    class="ph ph-folder"
                    style="
                        font-size: 48px;
                        color: #94A3B8;
                        margin-bottom: 16px;
                    "
                ></i>

                <h3
                    style="
                        font-size: 18px;
                        font-weight: 600;
                        color: #1E2D3D;
                        margin-bottom: 8px;
                    "
                >
                    Belum ada portofolio
                </h3>

                <p
                    style="
                        font-size: 14px;
                        color: #64748B;
                        margin: 0;
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