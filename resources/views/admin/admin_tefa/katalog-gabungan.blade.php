@extends('admin.layouts.app')

@section('title', 'Katalog')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/katalog-tefa.css') }}?v=3">
    <link rel="stylesheet" href="{{ asset('css/kontak-tefa.css') }}?v=4">
@endpush

@section('content')

{{-- Menyesuaikan jumlah item per halaman (16 desktop / 15 mobile) dan logika pilih item untuk PDF.
     Dimuat di awal konten agar penyesuaian per halaman berjalan cepat.
     data-all-ids = ID seluruh item hasil query (semua halaman) untuk tombol "Pilih Semua". --}}
<script
    src="{{ asset('js/katalog-tefa.js') }}?v=4"
    data-per-page="{{ (int) $katalog->perPage() }}"
    data-all-ids="{{ $semuaId->values()->toJson() }}"
></script>

<div class="katalog-container">
    
    <div class="katalog-header">
        <h3>Katalog TEFA</h3>
        <p>Seluruh produk dan jasa dari semua jurusan.</p>
    </div>

    
    @if(session('sukses'))
        <div class="katalog-sukses">
            {{ session('sukses') }}
        </div>
    @endif

    
    @if($errors->has('produk_jasa_ids'))
        <div class="katalog-alert">
            {{ $errors->first('produk_jasa_ids') }}
        </div>
    @endif

    
    <form
        action="{{ route('admin.tefa.katalog_gabungan') }}"
        method="GET"
        class="katalog-filter"
    >
        <input type="hidden" name="per_page" value="{{ $katalog->perPage() }}">

        <div class="katalog-filter-search">
            <i class="ph ph-magnifying-glass"></i>

            <input
                type="search"
                name="keyword"
                value="{{ $keyword }}"
                placeholder="Cari produk atau jasa..."
                aria-label="Cari produk atau jasa"
            >
        </div>

        <select
            name="jenis"
            class="katalog-filter-select"
            aria-label="Filter jenis"
            data-auto-submit
        >
            <option value="semua" {{ $jenis === 'semua' ? 'selected' : '' }}>
                Semua Jenis
            </option>

            <option value="produk" {{ $jenis === 'produk' ? 'selected' : '' }}>
                Produk
            </option>

            <option value="jasa" {{ $jenis === 'jasa' ? 'selected' : '' }}>
                Jasa
            </option>
        </select>

        <select
            name="jurusan"
            class="katalog-filter-select"
            aria-label="Filter jurusan"
            data-auto-submit
        >
            <option value="semua" {{ $idJurusan === 'semua' ? 'selected' : '' }}>
                Semua Jurusan
            </option>

            @foreach($daftarJurusan as $jurusan)
                <option
                    value="{{ $jurusan->id_jurusan }}"
                    {{ $idJurusan === (int) $jurusan->id_jurusan ? 'selected' : '' }}
                >
                    {{ $jurusan->nama_jurusan }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn-filter-cari">
            <i class="ph ph-magnifying-glass"></i>
            Cari
        </button>

        @if($adaFilter)
            <a
                href="{{ route('admin.tefa.katalog_gabungan') }}"
                class="btn-filter-reset"
            >
                Reset
            </a>
        @endif
    </form>

    
    <div class="kontak-ringkas">
        <div class="kontak-ringkas-info">
            <div class="kontak-icon">
                <i class="ph ph-phone"></i>
            </div>

            <div class="kontak-teks">
                <span class="kontak-label">Nomor di PDF katalog</span>
                <strong class="kontak-nomor">{{ $nomorPdf }}</strong>
            </div>
        </div>

        <button type="button" class="btn-kontak-ubah" data-kontak-buka>
            <i class="ph ph-pencil-simple"></i>
            Ubah
        </button>
    </div>

    
    <div class="katalog-toolbar">
        <div class="toolbar-left">
            <div class="selected-info">
                <i class="ph ph-check-circle"></i>
                <span>
                    <span id="selected-count">0</span> item dipilih
                </span>
            </div>

            <button type="button" class="btn-select-all" id="btn-select-all">
                Pilih Semua
            </button>
        </div>

        <form action="{{ route('admin.tefa.katalog_pdf') }}" method="POST" id="pdf-form">
            @csrf
            <div id="selected-inputs"></div>

            <button type="submit" class="btn-generate-pdf" id="btn-generate-pdf" disabled>
                <i class="ph ph-file-pdf"></i>
                Generate PDF
            </button>
        </form>
    </div>

    
    <div class="katalog-grid">
        @forelse($katalog as $item)
            <div class="katalog-card" data-id="{{ $item->id_produk_jasa }}">
                
                <div class="card-check">
                    <i class="ph ph-check"></i>
                </div>

                
                <div class="card-img-wrapper">
                    @if($item->gambars && $item->gambars->first())
                        <img src="{{ asset('storage/' . $item->gambars->first()->path_gambar) }}" alt="{{ $item->nama_produk_jasa }}" loading="lazy">
                    @else
                        <div class="no-img">
                            <i class="ph ph-image"></i>
                        </div>
                    @endif

                    
                    <span class="badge-jenis">
                        {{ strtoupper($item->jenis) }}
                    </span>
                </div>

                
                <div class="card-body-content">
                    <h4 class="card-title">
                        {{ $item->nama_produk_jasa }}
                    </h4>

                    <p class="card-jurusan">
                        {{ $item->jurusan->nama_jurusan ?? 'Semua Jurusan' }}
                    </p>

                    <p class="card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}
                    </p>

                    <div class="card-price">
                        Rp{{ number_format($item->harga, 0, ',', '.') }}{{ $item->satuan_harga ? '/' . $item->satuan_harga : '' }}
                    </div>

                    
                    <a href="{{ route('admin.tefa.katalog_detail', $item->id_produk_jasa) }}" class="btn-detail">
                        <span class="d-full">Lihat Detail</span>
                        <span class="d-short">Detail</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="ph ph-squares-four"></i>
                <p>
                    {{ $adaFilter
                        ? 'Tidak ada produk atau jasa yang sesuai dengan pencarian atau filter.'
                        : 'Belum ada produk atau jasa yang tersedia.' }}
                </p>
            </div>
        @endforelse
    </div>

    
    @if($katalog->hasPages())
        <div class="pagination-wrapper">
            <p class="pagination-info">
                Menampilkan {{ $katalog->firstItem() }} sampai {{ $katalog->lastItem() }} dari {{ $katalog->total() }} hasil
            </p>

            <ul class="custom-pagination">
                
                @if($katalog->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $katalog->url(1) }}" title="Halaman Pertama">&laquo;&laquo;</a>
                    </li>
                @endif

                
                @if($katalog->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&lsaquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $katalog->previousPageUrl() }}" title="Halaman Sebelumnya">&lsaquo;</a>
                    </li>
                @endif

                
                @foreach(range(1, $katalog->lastPage()) as $page)
                    @php
                        $far = abs($page - $katalog->currentPage()) > 1
                            && $page != 1
                            && $page != $katalog->lastPage();
                    @endphp

                    @if($page == $katalog->currentPage())
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item {{ $far ? 'page-far' : '' }}">
                            <a class="page-link" href="{{ $katalog->url($page) }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                
                @if($katalog->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $katalog->nextPageUrl() }}" title="Halaman Selanjutnya">&rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&rsaquo;</span>
                    </li>
                @endif

                
                @if($katalog->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $katalog->url($katalog->lastPage()) }}" title="Halaman Terakhir">&raquo;&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;&raquo;</span>
                    </li>
                @endif
            </ul>
        </div>
    @endif
</div>

<!-- =========================================================
     POP-UP UBAH NOMOR PDF
     Terbuka otomatis bila server menolak nomor (agar pesan error terlihat).
========================================================== -->
<div
    class="kontak-modal {{ $errors->has('nomor_pdf') ? 'active' : '' }}"
    id="kontak-modal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="kontak-modal-judul"
>
    <div class="kontak-modal-box">
        <form
            action="{{ route('admin.tefa.katalog_nomor_pdf') }}"
            method="POST"
            id="kontak-form"
            novalidate
        >
            @csrf
            @method('PUT')

            <div class="kontak-modal-kepala">
                <h3 id="kontak-modal-judul">Ubah Nomor di PDF</h3>

                <button
                    type="button"
                    class="kontak-modal-tutup"
                    data-kontak-tutup
                    aria-label="Tutup"
                >
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <p class="kontak-modal-desc">
                Nomor ini tampil di footer setiap halaman PDF katalog.
            </p>

            <div class="kontak-group">
                <label for="nomor-pdf">Nomor telepon</label>

                <input
                    type="tel"
                    name="nomor_pdf"
                    id="nomor-pdf"
                    class="{{ $errors->has('nomor_pdf') ? 'is-invalid' : '' }}"
                    value="{{ old('nomor_pdf', $nomorPdf) }}"
                    data-awal="{{ $nomorPdf }}"
                    inputmode="tel"
                    autocomplete="off"
                    maxlength="20"
                    placeholder="Contoh: 0896-5362-8650"
                >

                <p class="kontak-error" role="alert">{{ $errors->first('nomor_pdf') }}</p>
            </div>

            <div class="kontak-modal-aksi">
                <button type="button" class="btn-kontak-batal" data-kontak-tutup>
                    Batal
                </button>

                <button type="submit" class="btn-kontak-simpan">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/kontak-tefa.js') }}?v=3" defer></script>

@endsection