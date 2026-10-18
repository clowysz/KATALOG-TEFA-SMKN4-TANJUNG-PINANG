@extends('admin.layouts.app-jurusan')

@section('title', 'Produk dan Jasa')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/katalog-jurusan.css') }}?v=5">
@endsection

@section('content')

<div class="katalog-page">

    <div class="page-header">
        <h2 class="katalog-page-title">
            Katalog Produk & Jasa
        </h2>

        <p class="katalog-page-subtitle">
            Etalase layanan Rekayasa Perangkat Lunak dan statistik pesanan
        </p>
    </div>


    <!-- =========================
         SEARCH + FILTER
    ========================== -->

    <div class="katalog-filter-bar">

        <div class="katalog-search">
            <i class="ph ph-magnifying-glass"></i>

            <input
                type="text"
                id="searchKatalog"
                placeholder="Cari nama produk atau jasa..."
            >
        </div>

        <div class="katalog-filter-buttons">

            <button
                type="button"
                class="katalog-filter-btn active"
                data-filter="semua"
            >
                Semua
            </button>

            <button
                type="button"
                class="katalog-filter-btn"
                data-filter="produk"
            >
                Produk
            </button>

            <button
                type="button"
                class="katalog-filter-btn"
                data-filter="jasa"
            >
                Jasa
            </button>

        </div>

    </div>


    <!-- =========================
         LOADING
    ========================== -->

    <div id="katalogLoading" class="katalog-state">

        <div class="katalog-state-spinner">
            <i class="ph ph-spinner-gap"></i>
        </div>

        <h3 class="katalog-state-title">
            Memuat katalog...
        </h3>

    </div>


    <!-- =========================
         CONTENT
    ========================== -->

    <div id="katalogContent" style="display: none;">

        <!-- PRODUK -->
        <div id="produkSection">

            <h3 class="katalog-section-title">
                <i class="ph ph-package icon-produk"></i>
                <span>Daftar Produk</span>
            </h3>

            <div id="produkContainer" class="catalog-grid"></div>

        </div>


        <!-- JASA -->
        <div id="jasaSection">

            <h3 class="katalog-section-title">
                <i class="ph ph-briefcase icon-jasa"></i>
                <span>Daftar Jasa</span>
            </h3>

            <div id="jasaContainer" class="catalog-grid"></div>

        </div>

    </div>


    <!-- =========================
         EMPTY
    ========================== -->

    <div id="katalogEmpty" class="katalog-state" style="display: none;">

        <div class="katalog-state-circle">
            <i class="ph ph-package"></i>
        </div>

        <h3 class="katalog-state-title katalog-state-title-lg">
            Katalog Masih Kosong
        </h3>

        <p class="katalog-state-text">
            Belum ada produk atau jasa yang ditambahkan dari database.
        </p>

    </div>


    <!-- =========================
         ERROR
    ========================== -->

    <div id="katalogError" class="katalog-state" style="display: none;">

        <div class="katalog-state-circle is-error">
            <i class="ph ph-warning"></i>
        </div>

        <h3 class="katalog-state-title">
            Gagal Memuat Katalog
        </h3>

        <p class="katalog-state-text">
            Silakan refresh halaman dan coba lagi.
        </p>

    </div>

</div>

@endsection


@section('scripts')
<script src="{{ asset('js/katalog-jurusan.js') }}"></script>
@endsection