@extends('public.layouts')

@section('title', 'Katalog Produk & Jasa')

@push('css')
<link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/katalog-pembeli.css') }}">
@endpush

@section('content')
<div id="katalog-section" class="katalog-page">
    <div class="katalog-page-inner">

        <!-- HEADER TEXT -->
        <div class="katalog-page-head">
            <h3 class="katalog-page-title">Katalog Produk &amp; Jasa TEFA</h3>
            <p class="katalog-page-sub">Temukan karya dan layanan profesional dari seluruh jurusan SMKN 4 Tanjungpinang.</p>
        </div>

        <!-- AREA FILTER & DROPDOWN -->
        <div class="filter-area">

            <!-- Filter Jenis (Produk/Jasa) -->
            <div class="filter-btn-group">
                <a href="{{ route('public.katalog', ['jenis' => 'semua', 'jurusan' => $id_jurusan, 'keyword' => $keyword]) }}"
                   class="filter-btn {{ $jenis == 'semua' ? 'active' : '' }}">Semua</a>

                <a href="{{ route('public.katalog', ['jenis' => 'produk', 'jurusan' => $id_jurusan, 'keyword' => $keyword]) }}"
                   class="filter-btn {{ $jenis == 'produk' ? 'active' : '' }}">Produk</a>

                <a href="{{ route('public.katalog', ['jenis' => 'jasa', 'jurusan' => $id_jurusan, 'keyword' => $keyword]) }}"
                   class="filter-btn {{ $jenis == 'jasa' ? 'active' : '' }}">Jasa</a>
            </div>

            <!-- Dropdown Filter Jurusan -->
            <div class="jurusan-select-wrapper">
                <form action="{{ route('public.katalog') }}" method="GET" id="form-filter-jurusan">
                    <input type="hidden" name="jenis" value="{{ $jenis }}">
                    <input type="hidden" name="keyword" value="{{ $keyword }}">

                    <select name="jurusan" class="jurusan-select" aria-label="Filter jurusan">
                        <option value="semua">Semua Jurusan</option>
                        @foreach($daftarJurusan as $jrs)
                            <option value="{{ $jrs->id_jurusan }}" {{ $id_jurusan == $jrs->id_jurusan ? 'selected' : '' }}>
                                {{ $jrs->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    <i class="ph ph-caret-down jurusan-select-icon"></i>
                </form>
            </div>

        </div>

        <!-- GRID KATALOG -->
        <div class="katalog-grid" id="katalog-grid">
            @forelse($katalog as $item)
@php
    $gambar = $item->gambars->first();
    $slug = $item->jurusan->slug ?? null;
    $isProduk = $item->jenis === 'produk';

    $detailRoute = $slug
        ? ($isProduk
            ? url('/jurusan/'.$slug.'/produk/detail/'.$item->id_produk_jasa)
            : url('/jurusan/'.$slug.'/jasa/detail/'.$item->id_produk_jasa))
        : '#';

    if ($detailRoute !== '#') {
        $detailRoute .= '?' . http_build_query([
            'from' => 'katalog',
            'back' => request()->getRequestUri(),
        ]);
    }
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

                        <a href="{{ $detailRoute }}" class="k-card-btn">
                            Lihat Detail
                        </a>
                    </div>
                </div>

            @empty
                <!-- EMPTY STATE -->
                <div class="katalog-empty">
                    <i class="ph ph-magnifying-glass"></i>

                    <h3>Tidak Ada Hasil</h3>

                    <p>Belum ada produk atau jasa yang tersedia pada filter ini.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION PUBLIK -->
        @if($katalog->hasPages() || $katalog->total() > 0)
        @php
            $halamanAktif = $katalog->currentPage();
            $halamanAkhir = $katalog->lastPage();

            // Tampilkan: halaman 1, halaman terakhir, dan 1 halaman di kiri/kanan halaman aktif
            $daftarHalaman = collect(range(1, $halamanAkhir))
                ->filter(fn ($p) => $p === 1 || $p === $halamanAkhir || abs($p - $halamanAktif) <= 1)
                ->values();

            $halamanSebelumnya = null;
        @endphp
        <div class="pagination-wrapper">
            <p class="pagination-info">
                Menampilkan {{ $katalog->firstItem() }} sampai {{ $katalog->lastItem() }} dari {{ $katalog->total() }} hasil
            </p>

            <ul class="custom-pagination">
                {{-- 1. TOMBOL PALING AWAL (<<) --}}
                @if($katalog->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $katalog->url(1) }}#katalog-grid" title="Halaman Pertama">&laquo;&laquo;</a></li>
                @endif

                {{-- 2. TOMBOL MUNDUR 1 HALAMAN (<) --}}
                @if($katalog->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $katalog->previousPageUrl() }}#katalog-grid" title="Halaman Sebelumnya">&lsaquo;</a></li>
                @endif

                {{-- 3. NOMOR HALAMAN (dengan titik-titik jika ada yang dilewati) --}}
                @foreach($daftarHalaman as $page)
                    @if($halamanSebelumnya !== null && $page - $halamanSebelumnya > 1)
                        <li class="page-item disabled"><span class="page-link page-dots">&hellip;</span></li>
                    @endif

                    @if($page == $halamanAktif)
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $katalog->url($page) }}#katalog-grid">{{ $page }}</a></li>
                    @endif

                    @php $halamanSebelumnya = $page; @endphp
                @endforeach

                {{-- 4. TOMBOL MAJU 1 HALAMAN (>) --}}
                @if($katalog->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $katalog->nextPageUrl() }}#katalog-grid" title="Halaman Selanjutnya">&rsaquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
                @endif

                {{-- 5. TOMBOL PALING AKHIR (>>) --}}
                @if($katalog->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $katalog->url($katalog->lastPage()) }}#katalog-grid" title="Halaman Terakhir">&raquo;&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;&raquo;</span></li>
                @endif
            </ul>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/katalog-pembeli.js') }}"></script>
@endpush