@extends('public.layouts')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')
<div style="padding:60px 5% 100px;min-height:70vh;background:#F8FAFC;">
    <div style="max-width:1200px;margin:0 auto;">

        <!-- HEADER PENCARIAN -->
        <div style="margin-bottom:40px;border-bottom:1px solid #E2E8F0;padding-bottom:20px;">
            <h2 style="font-size:24px;color:#1E3A8A;font-weight:700;font-family:'Poppins',sans-serif;margin-bottom:8px;">
                Hasil Pencarian
            </h2>

            <p style="color:#64748B;font-size:15px;margin:0;">
                @if($keyword)
                    Menampilkan hasil untuk kata kunci:
                    <strong style="color:#1E2D3D;">"{{ $keyword }}"</strong>
                @else
                    Menampilkan seluruh produk dan jasa yang tersedia.
                @endif
            </p>
        </div>

        <!-- HASIL PENCARIAN -->
        <div class="katalog-grid">
            @forelse($results as $item)
                @php
                    $gambar=$item->gambars->first();
                    $slug=$item->jurusan->slug??null;
                    $isProduk=$item->jenis==='produk';

                    $detailUrl=$slug
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
                            <img src="{{ asset('storage/'.$gambar->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#E2E8F0;color:#64748B;">
                                <i class="ph ph-image" style="font-size:48px;"></i>
                            </div>
                        @endif
                    </div>

                    <div class="k-card-body">
                        <div class="k-card-title">
                            {{ $item->nama_produk_jasa }}
                        </div>

                        <div class="k-card-desc">
                            {{ \Illuminate\Support\Str::limit($item->deskripsi,90) }}
                        </div>

                        <div class="k-card-price">
                            Rp{{ number_format($item->harga,0,',','.') }}
                        </div>

                        <a href="{{ $detailUrl }}" class="k-card-btn">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            @empty
                <!-- EMPTY STATE -->
                <div style="grid-column:1/-1;text-align:center;padding:60px 20px;background:white;border-radius:12px;border:1px dashed #CBD5E1;margin-top:20px;">
                    <i class="ph ph-magnifying-glass" style="font-size:48px;color:#94A3B8;margin-bottom:16px;"></i>

                    <h3 style="font-size:18px;font-weight:600;color:#1E2D3D;margin-bottom:8px;">
                        Pencarian tidak ditemukan
                    </h3>

                    <p style="font-size:14px;color:#64748B;margin:0;">
                        Tidak ada produk atau jasa yang cocok dengan kata kunci tersebut.
                    </p>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection