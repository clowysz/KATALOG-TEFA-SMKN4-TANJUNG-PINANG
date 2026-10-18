@extends('admin.layouts.app-jurusan')

@section('title', 'Dashboard Jurusan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-jurusan.css') }}?v=1">
@endsection

@section('content')

<div class="dashboard-header">
    <h2>
        Dashboard {{ $jurusan->nama_jurusan ?? 'Jurusan' }}
    </h2>

    <p>
        Ringkasan data dan aktivitas jurusan
        {{ $jurusan->nama_jurusan ?? '' }}
    </p>
</div>

@if(!$jurusan)

    <div class="tefa-card dashboard-empty-card">
        <h3 class="dashboard-empty-title">
            Jurusan belum ditemukan
        </h3>

        <p class="dashboard-empty-text">
            Akun Admin Jurusan ini belum memiliki penugasan jurusan.
        </p>
    </div>

@else

    @php
        $persenProduk = $totalPesananJurusan > 0
            ? ($totalPesananProduk / $totalPesananJurusan) * 100
            : 0;

        $persenJasa = $totalPesananJurusan > 0
            ? ($totalPesananJasa / $totalPesananJurusan) * 100
            : 0;
    @endphp


    <!-- =========================
         RINGKASAN
    ========================== -->
    <div class="summary-grid">

        <div class="tefa-card summary-card summary-card--produk">
            <div class="summary-icon">
                <i class="ph ph-package"></i>
            </div>

            <div class="summary-info">
                <p class="summary-label">Total Produk</p>
                <h2 class="summary-value">{{ $totalProduk }}</h2>
            </div>
        </div>


        <div class="tefa-card summary-card summary-card--jasa">
            <div class="summary-icon">
                <i class="ph ph-wrench"></i>
            </div>

            <div class="summary-info">
                <p class="summary-label">Total Jasa</p>
                <h2 class="summary-value">{{ $totalJasa }}</h2>
            </div>
        </div>


        <div class="tefa-card summary-card summary-card--portofolio">
            <div class="summary-icon">
                <i class="ph ph-folder-open"></i>
            </div>

            <div class="summary-info">
                <p class="summary-label">Total Portofolio</p>
                <h2 class="summary-value">{{ $totalPortfolio }}</h2>
            </div>
        </div>


        <div class="tefa-card summary-card summary-card--pesanan">
            <div class="summary-icon">
                <i class="ph ph-shopping-cart"></i>
            </div>

            <div class="summary-info">
                <p class="summary-label">Total Pesanan</p>
                <h2 class="summary-value">{{ $totalPesananJurusan }}</h2>
            </div>
        </div>

    </div>


    <!-- =========================
         PRODUK/JASA TERBANYAK DIPESAN
    ========================== -->
    <div class="dashboard-list-card">

        <div class="dashboard-card-head">
            <h3 class="dashboard-card-title">
                <i class="ph ph-chart-line-up"></i>
                Produk/Jasa dengan Pesanan Terbanyak
            </h3>

            <span class="dashboard-card-note">
                Berdasarkan data pesanan
            </span>
        </div>


        @forelse($produkTerlaris as $index => $item)

            @php
                $gambar = $item->gambars->first();
                $rankClass = $index < 3 ? 'rank-circle--' . ($index + 1) : '';
            @endphp

            <div class="rank-item">

                <div class="rank-left">

                    <div class="rank-circle {{ $rankClass }}">
                        {{ $index + 1 }}
                    </div>

                    @if($gambar)

                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            class="list-item-img"
                            alt="{{ $item->nama_produk_jasa }}"
                        >

                    @else

                        <div class="list-item-img list-item-img--placeholder">
                            <i class="{{ $item->jenis === 'produk' ? 'ph ph-package' : 'ph ph-wrench' }}"></i>
                        </div>

                    @endif

                    <div class="list-item-text">
                        <div class="list-item-title">
                            {{ $item->nama_produk_jasa }}
                        </div>

                        <div class="list-item-subtitle">
                            {{ ucfirst($item->jenis) }}
                        </div>
                    </div>

                </div>

                <span class="badge-pesanan">
                    {{ $item->pesanans_count }} pesanan
                </span>

            </div>

        @empty

            <div class="dashboard-empty-box">
                <div class="dashboard-empty-icon">
                    <i class="ph ph-shopping-cart"></i>
                </div>

                <p>Belum ada pesanan untuk produk atau jasa jurusan.</p>
            </div>

        @endforelse

    </div>


    <!-- =========================
         PERFORMA PESANAN
    ========================== -->
    <div class="dashboard-list-card">

        <h3 class="dashboard-card-title dashboard-card-title--spaced">
            <i class="ph ph-chart-donut"></i>
            Performa Pesanan
        </h3>

        <div class="performa-grid">

            <!-- Grafik -->
            <div class="performa-chart">
                <div class="performa-chart-box">

                    <div class="performa-canvas">
                        <canvas
                            id="chartJenisPesanan"
                            data-produk="{{ $totalPesananProduk }}"
                            data-jasa="{{ $totalPesananJasa }}"
                        ></canvas>
                    </div>

                    <div class="performa-total">
                        {{ $totalPesananJurusan }}
                    </div>

                    <div class="performa-total-label">
                        Total Pesanan
                    </div>

                </div>
            </div>


            <!-- Bar -->
            <div>

                <div class="performa-item">

                    <div class="performa-item-head">
                        <span class="performa-item-name performa-item-name--produk">
                            <i class="ph ph-package"></i>
                            Produk
                        </span>

                        <span class="performa-item-count">
                            {{ $totalPesananProduk }} pesanan
                        </span>
                    </div>

                    <div class="progress-bar-bg">
                        <div
                            class="progress-fill progress-fill--produk"
                            style="width: {{ $persenProduk }}%;"
                        ></div>
                    </div>

                    <div class="performa-item-note">
                        {{ number_format($persenProduk, 1) }}%
                        dari seluruh pesanan
                    </div>

                </div>


                <div class="performa-item">

                    <div class="performa-item-head">
                        <span class="performa-item-name performa-item-name--jasa">
                            <i class="ph ph-wrench"></i>
                            Jasa
                        </span>

                        <span class="performa-item-count">
                            {{ $totalPesananJasa }} pesanan
                        </span>
                    </div>

                    <div class="progress-bar-bg">
                        <div
                            class="progress-fill progress-fill--jasa"
                            style="width: {{ $persenJasa }}%;"
                        ></div>
                    </div>

                    <div class="performa-item-note">
                        {{ number_format($persenJasa, 1) }}%
                        dari seluruh pesanan
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         RINGKASAN PRODUK/JASA
    ========================== -->
    <div class="dashboard-list-card">

        <div class="dashboard-card-head">
            <h3 class="dashboard-card-title">
                <i class="ph ph-list-bullets"></i>
                Ringkasan Produk & Jasa
            </h3>

            <span class="dashboard-card-note">
                Data katalog jurusan
            </span>
        </div>


        @forelse($produkTerlaris as $item)

            <div class="ringkasan-item">

                <div class="ringkasan-info">
                    <div class="ringkasan-name">
                        {{ $item->nama_produk_jasa }}
                    </div>

                    <div class="ringkasan-meta">
                        {{ ucfirst($item->jenis) }}

                        @if($item->harga !== null)
                            · Rp{{ number_format($item->harga, 0, ',', '.') }}
                        @endif
                    </div>
                </div>

                <div class="ringkasan-count">
                    {{ $item->pesanans_count }} pesanan
                </div>

            </div>

        @empty

            <div class="dashboard-empty-box dashboard-empty-box--sm">
                Belum ada produk atau jasa yang memiliki pesanan.
            </div>

        @endforelse

    </div>

@endif

@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard-jurusan.js') }}"></script>
@endsection