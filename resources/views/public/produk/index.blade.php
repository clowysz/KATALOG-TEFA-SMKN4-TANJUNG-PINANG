@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section hero-page">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; bottom: 40%; right: 20%; animation-duration: 5s;"></div>

    <div class="jurusan-hero-content">
        <div class="jurusan-hero-image">
            <img
                src="{{ asset($jurusan->hero) }}"
                alt="Produk {{ $jurusan->name }}"
            >
        </div>

        <div class="jurusan-hero-text">
            <h3>PRODUK</h3>
            <h1>PRODUK {{ $jurusan->name }}</h1>
            <p>
                Berbagai produk inovatif yang dikembangkan oleh
                siswa-siswi SMKN 4 Tanjungpinang untuk memenuhi
                kebutuhan di era digital.
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

<section class="katalog-section">
    <div class="katalog-header">
        <h2>Produk Terlaris</h2>
        <a href="/jurusan/{{ $jurusan->slug }}/produk">
            Lihat Semua Produk &gt;
        </a>
    </div>

    <div class="katalog-grid">
        @forelse($produks as $item)
            @php
                $gambar = $item->gambars->first();
            @endphp

            <div class="k-card">
                <div class="k-card-img">
                    <span class="k-badge">
                        PRODUK
                    </span>

                    @if($gambar)
                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            alt="{{ $item->nama_produk_jasa }}"
                            loading="lazy"
                        >
                    @else
                        <div class="k-card-img-empty">
                            <i class="ph ph-image"></i>
                        </div>
                    @endif
                </div>

                <div class="k-card-body">
                    <div class="k-card-title">
                        {{ $item->nama_produk_jasa }}
                    </div>

                    <div class="k-card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}
                    </div>

                    <div class="k-card-price">
                        Rp{{ number_format($item->harga, 0, ',', '.') }}{{ $item->satuan_harga ? '/' . $item->satuan_harga : '' }}
                    </div>

                    <a
                        href="/jurusan/{{ $jurusan->slug }}/produk/detail/{{ $item->id_produk_jasa }}"
                        class="k-card-btn"
                    >
                        Lihat Detail
                    </a>
                </div>
            </div>
        @empty
            <div class="katalog-empty">
                <i class="ph ph-package"></i>
                <h3>Belum ada data Produk</h3>
                <p>Katalog produk untuk jurusan ini belum tersedia.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection