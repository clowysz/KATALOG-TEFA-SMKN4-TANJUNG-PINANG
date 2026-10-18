@extends('admin.layouts.app-produser')

@section('title', 'Detail Produk/Jasa')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/katalog-detail-produser.css') }}">
@endpush

@section('content')
@php
    $jenisLabel = $produkJasa->jenis === 'jasa' ? 'Jasa' : 'Produk';

    $urls = $produkJasa->gambars
        ->filter(fn ($g) => $g && $g->path_gambar)
        ->map(fn ($g) => asset('storage/' . $g->path_gambar))
        ->values()
        ->all();

    if (count($urls) === 0) {
        $urls = ['https://placehold.co/800x600/E2E8F0/1E3A8A?text=' . urlencode($jenisLabel)];
    }

    $jumlahPesanan = $produkJasa->pesanans->count();
@endphp

<div class="detail-page-wrapper">

    {{-- ================= TOMBOL KEMBALI ================= --}}
    <a href="{{ route('admin.produser.katalog') }}" class="btn-level-2">
        <i class="ph ph-arrow-left"></i>
        <span>Kembali ke Katalog</span>
    </a>

    {{-- ================= CONTAINER ATAS: GALERI & INFO ================= --}}
    <div class="detail-top-card">

        <div class="detail-gallery">
            <div class="admin-product-gallery"
                 id="adminGallery"
                 data-images="{{ json_encode($urls) }}"
                 data-alt="{{ $produkJasa->nama_produk_jasa }}">

                <div class="admin-main-image" id="adminMainImage"></div>
                <div class="admin-gallery-thumbnails" id="adminThumbnails" hidden></div>
            </div>
        </div>

        <div class="detail-info">
            <div class="detail-badge">{{ strtoupper($jenisLabel) }}</div>

            <h1 class="detail-title">{{ $produkJasa->nama_produk_jasa }}</h1>

            <div class="price-box">
                <div class="price-label">HARGA</div>
                <div class="detail-price">
                    Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}{{ $produkJasa->satuan_harga ? '/' . $produkJasa->satuan_harga : '' }}
                </div>
            </div>
        </div>

    </div>

    {{-- ================= META CARDS ================= --}}
    <div class="detail-meta-cards">

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-tag"></i></div>
            <div>
                <span class="meta-label">JENIS</span>
                <span class="meta-value">{{ $jenisLabel }}</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-shopping-cart"></i></div>
            <div>
                <span class="meta-label">JUMLAH PESANAN</span>
                <span class="meta-value">{{ $jumlahPesanan }}</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-buildings"></i></div>
            <div>
                <span class="meta-label">JURUSAN</span>
                <span class="meta-value">{{ $produkJasa->jurusan->nama_jurusan ?? '-' }}</span>
            </div>
        </div>

    </div>

    {{-- ================= DESKRIPSI ================= --}}
    <div class="detail-card">
        <h2 class="detail-section-title">DESKRIPSI</h2>
        <div class="detail-text">{{ $produkJasa->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
    </div>

    {{-- ================= PESANAN TERKAIT ================= --}}
    <div class="detail-card">
        <h2 class="detail-section-title">
            PESANAN TERKAIT
            <span class="detail-count">{{ $jumlahPesanan }}</span>
        </h2>

        <div class="order-table-wrap">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Jumlah</th>
                        <th>Status Pengerjaan</th>
                        <th>Status Pesanan</th>
                        <th class="cell-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($produkJasa->pesanans as $pesanan)
                        @php
                            $progressTerakhir = $pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                            $persentase = $progressTerakhir->persentase_progress ?? 0;
                        @endphp

                        <tr class="order-row">
                            <td class="cell-id" data-label="Order ID">
                                <div class="order-id">#{{ $pesanan->id_pesanan }}</div>

                                @if($pesanan->tanggal_pesan)
                                    <div class="order-date">
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>

                            <td data-label="Jumlah">{{ $pesanan->jumlah }} item</td>

                            <td data-label="Status Pengerjaan">
                                <div class="order-progress">
                                    <div class="order-progress-head">
                                        <span>Progress</span>
                                        <strong>{{ $persentase }}%</strong>
                                    </div>

                                    <div class="order-progress-bar">
                                        {{-- Style inline hanya untuk lebar bar (nilai dari data) --}}
                                        <div class="order-progress-fill" style="width: {{ $persentase }}%;"></div>
                                    </div>
                                </div>
                            </td>

                            <td data-label="Status Pesanan">
                                <span class="order-status">{{ ucfirst($pesanan->status) }}</span>
                            </td>

                            <td class="cell-center cell-action">
                                <a href="{{ route('admin.produser.pesanan.detail', $pesanan->id_pesanan) }}"
                                   class="prod-btn prod-btn-primary prod-btn-small">
                                    <i class="ph ph-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="order-empty">
                                    <i class="ph ph-receipt"></i>
                                    <p>Belum ada pesanan untuk produk/jasa ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================= LIGHTBOX ================= --}}
<div class="admin-gallery-lightbox" id="adminGalleryLightbox">
    <button type="button"
            class="admin-lightbox-close"
            data-lightbox-close
            aria-label="Tutup pratinjau">&times;</button>

    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Pratinjau gambar">
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/katalog-detail-produser.js') }}"></script>
@endpush