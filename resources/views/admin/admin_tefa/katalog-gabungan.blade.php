@extends('admin.layouts.app')

@section('title', 'Katalog Gabungan')

@section('content')
<style>
    .katalog-container {
        padding: 24px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .katalog-header {
        margin-bottom: 28px;
    }

    .katalog-header h3 {
        font-size: 24px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 6px 0;
    }

    .katalog-header p {
        font-size: 14px;
        color: #64748B;
        margin: 0;
    }

    /* GRID LAYOUT */
    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
    }

    /* CARD STYLE */
    .katalog-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
    }

    .katalog-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.08);
    }

    /* IMAGE SECTION */
    .card-img-wrapper {
        position: relative;
        width: 100%;
        height: 190px;
        background: #F8FAFC;
        overflow: hidden;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-img-wrapper .no-img {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94A3B8;
        font-size: 32px;
    }

    /* BADGE ON IMAGE */
    .badge-jenis {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #1E3A8A;
        color: #FFFFFF;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .badge-jenis.jasa {
        background: #0284C7;
    }

    /* CARD BODY */
    .card-body-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-title {
        font-size: 18px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 6px 0;
        line-height: 1.3;
    }

    .card-jurusan {
        font-size: 13px;
        color: #64748B;
        margin: 0 0 18px 0;
    }

    .card-price {
        font-size: 20px;
        font-weight: 800;
        color: #1E40AF;
        margin-bottom: 18px;
        margin-top: auto;
    }

    /* PILL BUTTON */
    .btn-detail {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: #F1F5F9;
        color: #1E40AF;
        padding: 12px;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .btn-detail:hover {
        background: #E2E8F0;
        color: #1D4ED8;
    }

    /* EMPTY STATE */
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px solid #E2E8F0;
        color: #64748B;
    }

    /* CUSTOM PAGINATION CONTAINER */
    .pagination-wrapper {
        margin-top: 40px;
        padding-top: 24px;
        border-top: 1px solid #E2E8F0;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .pagination-info {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
        margin: 0;
        text-align: center;
    }

    .custom-pagination {
        display: flex;
        gap: 6px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        justify-content: center;
    }

    .custom-pagination .page-item {
        margin: 0;
    }

    .custom-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 38px;
        height: 38px;
        padding: 0 10px;
        border-radius: 10px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }

    .custom-pagination .page-item.active .page-link {
        background: #1E40AF;
        color: #FFFFFF;
        border-color: #1E40AF;
        box-shadow: 0 4px 10px rgba(30, 64, 175, 0.25);
    }

    .custom-pagination .page-link:hover:not(.active) {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #1E40AF;
    }

    .custom-pagination .page-item.disabled .page-link {
        background: #F8FAFC;
        color: #CBD5E1;
        border-color: #E2E8F0;
        cursor: not-allowed;
    }
</style>

<div class="katalog-container">
    <div class="katalog-header">
        <h3>Katalog Gabungan Tefa</h3>
        <p>Seluruh produk dan jasa dari semua jurusan.</p>
    </div>

    <div class="katalog-grid">
        @forelse($katalog as $item)
            <div class="katalog-card">
                <div class="card-img-wrapper">
                    @if($item->gambars && $item->gambars->first())
                        <img src="{{ asset('storage/'.$item->gambars->first()->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}">
                    @else
                        <div class="no-img">
                            <i class="ph ph-image"></i>
                        </div>
                    @endif
                    <span class="badge-jenis {{ strtolower($item->jenis) }}">{{ strtoupper($item->jenis) }}</span>
                </div>

                <div class="card-body-content">
                    <h4 class="card-title">{{ $item->nama_produk_jasa }}</h4>
                    <p class="card-jurusan">{{ $item->jurusan->nama_jurusan ?? 'Semua Jurusan' }}</p>
                    
<div class="card-price">
    Rp{{ number_format($item->harga, 0, ',', '.') }}{{ $item->satuan_harga ? '/' . $item->satuan_harga : '' }}
</div>
                    <a href="{{ route('admin.tefa.katalog_detail', $item->id_produk_jasa) }}" class="btn-detail">
    Lihat Selengkapnya <i class="ph ph-caret-right"></i>
</a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="ph ph-squares-four" style="font-size: 48px; color: #CBD5E1; margin-bottom: 12px; display: block;"></i>
                <p style="font-weight: 600; margin: 0;">Belum ada produk atau jasa yang tersedia.</p>
            </div>
        @endforelse
    </div>

    <!-- NAVBAR PAGINATION KUSTOM 2 MODE (SATU-SATU & PALING AWAL/AKHIR) -->
    @if($katalog->hasPages())
    <div class="pagination-wrapper">
        <p class="pagination-info">
            Menampilkan {{ $katalog->firstItem() }} sampai {{ $katalog->lastItem() }} dari {{ $katalog->total() }} hasil
        </p>

        <ul class="custom-pagination">
            {{-- 1. TOMBOL PALING AWAL (<<) --}}
            @if($katalog->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $katalog->url(1) }}" title="Halaman Pertama">&laquo;&laquo;</a></li>
            @endif

            {{-- 2. TOMBOL MUNDUR 1 HALAMAN (<) --}}
            @if($katalog->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&lsaquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $katalog->previousPageUrl() }}" title="Halaman Sebelumnya">&lsaquo;</a></li>
            @endif

            {{-- 3. NOMOR-NOMOR HALAMAN --}}
            @foreach(range(1, $katalog->lastPage()) as $page)
                @if($page == $katalog->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $katalog->url($page) }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- 4. TOMBOL MAJU 1 HALAMAN (>) --}}
            @if($katalog->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $katalog->nextPageUrl() }}" title="Halaman Selanjutnya">&rsaquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&rsaquo;</span></li>
            @endif

            {{-- 5. TOMBOL PALING AKHIR (>>) --}}
            @if($katalog->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $katalog->url($katalog->lastPage()) }}" title="Halaman Terakhir">&raquo;&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;&raquo;</span></li>
            @endif
        </ul>
    </div>
    @endif
</div>
@endsection