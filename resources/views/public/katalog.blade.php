@extends('public.layouts')

@section('title', 'Katalog Produk & Jasa')

@section('content')
<style>
    .katalog-pub-section {
        padding: 40px 0 80px 0;
        background-color: #F8FAFC;
        min-height: 85vh;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .katalog-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .katalog-header-title {
        font-size: 28px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 6px 0;
    }

    .katalog-header-subtitle {
        font-size: 15px;
        color: #64748B;
        margin: 0 0 28px 0;
    }

    /* AREA FILTER */
    .filter-area {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }

    @media (min-width: 768px) {
        .filter-area {
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
    }

    .filter-btn-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 8px 24px;
        border-radius: 30px;
        border: 1px solid #CBD5E1;
        background: #FFFFFF;
        color: #475569;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .filter-btn.active, .filter-btn:hover {
        background: #1E40AF;
        color: #FFFFFF;
        border-color: #1E40AF;
    }

    /* DROPDOWN JURUSAN */
    .jurusan-select-wrapper {
        position: relative;
        min-width: 240px;
    }

    .jurusan-select {
        width: 100%;
        padding: 10px 16px;
        padding-right: 40px;
        border-radius: 14px;
        border: 1px solid #CBD5E1;
        background-color: #FFFFFF;
        color: #0F172A;
        font-weight: 700;
        font-size: 14px;
        appearance: none;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        transition: all 0.2s ease;
    }

    .jurusan-select:focus {
        outline: none;
        border-color: #1E40AF;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .jurusan-select-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #64748B;
        pointer-events: none;
        font-size: 18px;
    }

    /* GRID KATALOG */
    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 24px;
    }

    /* CARD STYLE */
    .card-katalog {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-katalog:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.08);
    }

    .card-img-box {
        position: relative;
        width: 100%;
        height: 190px;
        background: #F1F5F9;
        overflow: hidden;
    }

    .card-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-tipe {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 5px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        color: #FFFFFF;
        background: #0284C7;
        box-shadow: 0 2px 6px rgba(0,0,0,0.15);
    }

    .badge-tipe.produk {
        background: #1E40AF;
    }

    .card-katalog-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .item-title {
        font-size: 17px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 6px 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .item-jurusan {
        font-size: 13px;
        color: #64748B;
        margin: 0 0 16px 0;
    }

    .item-price {
        font-size: 19px;
        font-weight: 800;
        color: #1E40AF;
        margin-top: auto;
        margin-bottom: 16px;
    }

    .btn-detail-pub {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #F8FAFC;
        color: #1E40AF;
        padding: 12px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid #E2E8F0;
        width: 100%;
        box-sizing: border-box;
    }

    .btn-detail-pub:hover {
        background: #1E40AF;
        color: #FFFFFF;
        border-color: #1E40AF;
    }

    /* STATE KOSONG */
    .empty-state-box {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: #FFFFFF;
        border-radius: 20px;
        border: 1px dashed #CBD5E1;
        margin-top: 10px;
    }

    /* PAGINATION STYLING */
    .pagination-wrapper {
        margin-top: 48px;
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

    .custom-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 42px;
        height: 42px;
        padding: 0 12px;
        border-radius: 12px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #475569;
        font-weight: 700;
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

<div class="katalog-pub-section">
    <div class="katalog-container">
        
        <!-- HEADER TEXT -->
        <div>
            <h3 class="katalog-header-title">Katalog Produk & Jasa TEFA</h3>
            <p class="katalog-header-subtitle">Temukan karya dan layanan profesional dari seluruh jurusan SMKN 4 Tanjungpinang.</p>
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
                    
                    <select name="jurusan" class="jurusan-select" onchange="document.getElementById('form-filter-jurusan').submit();">
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
        <div class="katalog-grid">
            @forelse($katalog as $item)
                @php
                    $slugJurusan = $item->jurusan->slug ?? 'rpl';
                    $detailRoute = $item->jenis == 'produk' 
                        ? route('produk.detail', ['slug' => $slugJurusan, 'id' => $item->id_produk_jasa])
                        : route('jasa.detail', ['slug' => $slugJurusan, 'id' => $item->id_produk_jasa]);
                @endphp

                <div class="card-katalog">
                    <div class="card-img-box">
                        @if($item->gambars && $item->gambars->first())
                            <img src="{{ asset('storage/'.$item->gambars->first()->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}">
                        @else
                            <div style="display:flex; align-items:center; justify-content:center; height:100%; color:#94A3B8;">
                                <i class="ph ph-image" style="font-size: 36px;"></i>
                            </div>
                        @endif
                        <span class="badge-tipe {{ strtolower($item->jenis) }}">{{ strtoupper($item->jenis) }}</span>
                    </div>

                    <div class="card-katalog-body">
                        <h5 class="item-title">{{ $item->nama_produk_jasa }}</h5>
                        <p class="item-jurusan">{{ $item->jurusan->nama_jurusan ?? 'SMKN 4 Tanjungpinang' }}</p>

                        <div class="item-price">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </div>

                        <a href="{{ $detailRoute }}" class="btn-detail-pub">
                            Lihat Selengkapnya <i class="ph ph-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="empty-state-box">
                    <i class="ph ph-magnifying-glass" style="font-size: 48px; color: #94A3B8; display: block; margin-bottom: 12px;"></i>
                    <p style="font-size: 16px; font-weight: 700; color: #334155; margin: 0 0 4px 0;">Tidak Ada Hasil</p>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Belum ada produk atau jasa yang tersedia pada filter ini.</p>
                </div>
            @endforelse
        </div>

        <!-- PAGINATION PUBLIK 2 MODE -->
        @if($katalog->hasPages() || $katalog->total() > 0)
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
</div>
@endsection