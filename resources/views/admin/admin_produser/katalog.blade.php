@extends('admin.layouts.app-produser')

@section('title', 'Produk/Jasa Saya')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/katalog-produser.css') }}?v={{ filemtime(public_path('css/katalog-produser.css')) }}">
@endpush

@section('content')
<div class="page-intro">
    <h2 class="page-intro-title">Produk/Jasa Saya</h2>
    <p class="page-intro-desc">Daftar layanan yang menjadi tanggung jawab pengelolaan Anda.</p>
</div>

<div class="search-box">
    <i class="ph ph-magnifying-glass search-box-icon"></i>
    <input type="text"
           id="searchKatalogProduser"
           class="form-control"
           placeholder="Cari nama produk atau jasa..."
           aria-label="Cari produk atau jasa">
</div>

<div id="katalogContainer" class="katalog-grid">
    @forelse($produkJasas as $produk)
        @php
            $gambar = $produk->gambars->first();
            $jumlahPesanan = $produk->pesanans->count();
        @endphp

        <div class="katalog-item tefa-card katalog-card">

            <div class="katalog-thumb">
                @if($gambar)
                    <img src="{{ asset('storage/'.$gambar->path_gambar) }}"
                         alt="{{ $produk->nama_produk_jasa }}">
                @else
                    <div class="katalog-thumb-empty">
                        <i class="ph ph-image"></i>
                    </div>
                @endif

                <span class="katalog-type-badge">{{ ucfirst($produk->jenis) }}</span>
            </div>

            <div class="katalog-body">

                <div class="katalog-jurusan">{{ $produk->jurusan->nama_jurusan ?? '-' }}</div>

                <h3 class="katalog-title">{{ $produk->nama_produk_jasa }}</h3>

                <p class="katalog-desc">
                    {{ \Illuminate\Support\Str::limit($produk->deskripsi, 100) }}
                </p>

                <div class="katalog-meta">
                    <div>
                        <div class="katalog-meta-label">Harga</div>
                        <div class="katalog-price">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}{{ $produk->satuan_harga ? '/' . $produk->satuan_harga : '' }}
                        </div>
                    </div>

                    <div class="katalog-meta-right">
                        <div class="katalog-meta-label">Pesanan</div>
                        <div class="katalog-count">{{ $jumlahPesanan }}</div>
                    </div>
                </div>

                <a href="{{ route('admin.produser.katalog.detail', $produk->id_produk_jasa) }}"
                   class="prod-btn prod-btn-primary katalog-btn">
                    <i class="ph ph-eye"></i>
                    Lihat Detail
                </a>

            </div>
        </div>
    @empty
        <div class="katalog-empty prod-empty">
            <i class="ph ph-folder-open prod-empty-icon"></i>
            <h3 class="katalog-empty-title">Belum Ada Produk/Jasa</h3>
            <p class="prod-empty-text">Belum ada produk atau jasa yang ditugaskan kepada Anda.</p>
        </div>
    @endforelse

    {{-- Ditampilkan oleh JS saat pencarian tidak menemukan hasil --}}
    <div id="katalogNoResult" class="katalog-empty prod-empty" hidden>
        <i class="ph ph-magnifying-glass prod-empty-icon"></i>
        <h3 class="katalog-empty-title">Tidak Ditemukan</h3>
        <p class="prod-empty-text">Tidak ada produk atau jasa yang cocok dengan pencarian Anda.</p>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/katalog-produser.js') }}"></script>
@endpush