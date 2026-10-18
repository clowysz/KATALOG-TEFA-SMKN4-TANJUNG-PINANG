@extends('public.layouts')

@section('title', 'Hasil Pencarian')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/katalog=pembeli.css') }}">
@endpush

@section('content')
<div class="pencarian-page">
    <div class="katalog-page-inner">

        <!-- HEADER PENCARIAN -->
        <div class="pencarian-head">
            <h2 class="pencarian-title">
                Hasil Pencarian
            </h2>

            <p class="pencarian-sub">
                @if($keyword)
                    Menampilkan hasil untuk kata kunci:
                    <strong>"{{ $keyword }}"</strong>
                @else
                    Menampilkan seluruh produk dan jasa yang tersedia.
                @endif
            </p>
        </div>

        <!-- HASIL PENCARIAN -->
        <div class="katalog-grid">
            @forelse($results as $item)
                @php
                    $gambar = $item->gambars->first();
                    $slug = $item->jurusan->slug ?? null;
                    $isProduk = $item->jenis === 'produk';

                    $detailUrl = $slug
                        ? ($isProduk
                            ? url('/jurusan/'.$slug.'/produk/detail/'.$item->id_produk_jasa)
                            : url('/jurusan/'.$slug.'/jasa/detail/'.$item->id_produk_jasa))
                        : '#';
                @endphp

                <div class="k-card">
                    <div class="k-card-img">
                        <span class="k-badge">
                            {{ strtoupper($item->jenis) }}
                        </span>

                        @if($gambar)
                            <img src="{{ asset('storage/'.$gambar->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}" loading="lazy">
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

                        <a href="{{ $detailUrl }}" class="k-card-btn">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            @empty
                <!-- EMPTY STATE -->
                <div class="katalog-empty">
                    <i class="ph ph-magnifying-glass"></i>

                    <h3>Pencarian tidak ditemukan</h3>

                    <p>Tidak ada produk atau jasa yang cocok dengan kata kunci tersebut.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection