@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <h2>Dashboard</h2>
    <p>Ringkasan Performa TEFA</p>
</div>

<!-- 5 Summary Cards -->
<div class="summary-grid">

    <div class="tefa-card summary-card summary-total">
        <div class="summary-icon">
            <i class="ph ph-package"></i>
        </div>

        <div class="summary-info">
            <p>Total Pesanan</p>

            <h3>
                {{ $totalPesanan }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card summary-menunggu">
        <div class="summary-icon">
            <i class="ph ph-hourglass"></i>
        </div>

        <div class="summary-info">
            <p>Menunggu Konfirmasi</p>

            <h3>
                {{ $menungguKonfirmasi }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card summary-konfirmasi">
        <div class="summary-icon">
            <i class="ph ph-clipboard-text"></i>
        </div>

        <div class="summary-info">
            <p>Dikonfirmasi</p>

            <h3>
                {{ $dikonfirmasi }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card summary-proses">
        <div class="summary-icon">
            <i class="ph ph-gear"></i>
        </div>

        <div class="summary-info">
            <p>Sedang Diproses</p>

            <h3>
                {{ $sedangDiproses }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card summary-selesai">
        <div class="summary-icon">
            <i class="ph ph-check-circle"></i>
        </div>

        <div class="summary-info">
            <p>Selesai</p>

            <h3>
                {{ $selesai }}
            </h3>
        </div>
    </div>

</div>


<!-- Produk Terlaris -->
<div class="performance-grid">

    <div class="tefa-card">

        <div class="perf-header">
            <div class="perf-icon">
                <i class="ph ph-shopping-cart"></i>
            </div>

            <h3>Produk Terlaris</h3>
        </div>


        @if($produkTerlaris->count() > 0)

            <ul class="perf-list">

                @foreach($produkTerlaris as $produk)

                    <li class="perf-item">

                        <span>
                            {{ $produk->nama_produk_jasa }}
                        </span>

                        <span class="perf-badge">
                            {{ $produk->pesanans_count }} pesanan
                        </span>

                    </li>

                @endforeach

            </ul>

        @else

            <p class="perf-empty">
                Belum ada data produk atau jasa yang dipesan.
            </p>

        @endif

    </div>

</div>


<!-- Bottom Section -->
<div class="bottom-grid">

    <!-- Pesanan Terbaru -->
    <div class="tefa-card">

        <h3 class="card-title">
            Pesanan Terbaru
        </h3>


        @if($pesananTerbaru->count() > 0)

            @foreach($pesananTerbaru as $pesanan)

                <div class="recent-order-item">

                    @php
                        $gambar = $pesanan->produkJasa?->gambars?->first();
                    @endphp


                    @if($gambar)

                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            alt="{{ $pesanan->produkJasa->nama_produk_jasa }}"
                            class="recent-img"
                        >

                    @else

                        <div
                            class="recent-img recent-img-placeholder"
                        >
                            <i class="ph ph-package"></i>
                        </div>

                    @endif


                    <div class="recent-info">

                        <h4>
                            {{ $pesanan->produkJasa?->nama_produk_jasa ?? 'Produk/Jasa' }}
                        </h4>


                        <p>

                            {{ $pesanan->produkJasa?->jurusan?->nama_jurusan ?? 'Jurusan' }}

                            -

                            {{ $pesanan->tanggal_pesan
                                ? \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d M Y, H:i')
                                : '-' }}

                        </p>

                    </div>

                </div>

            @endforeach

        @else

            <div class="dashboard-empty">
                Belum ada pesanan.
            </div>

        @endif

    </div>


    <!-- Grafik Pesanan Berdasarkan Jurusan -->
    <div class="tefa-card">

        <h3 class="card-title">
            Pesanan Berdasarkan Jurusan
        </h3>


        @if(count($chartLabels) > 0)

            <div class="chart-wrap">
                <canvas
                    id="jurusanChart"
                    data-labels="{{ json_encode($chartLabels) }}"
                    data-values="{{ json_encode($chartData) }}"
                ></canvas>
            </div>

        @else

            <div class="dashboard-empty dashboard-empty-lg">
                Belum ada data jurusan.
            </div>

        @endif

    </div>

</div>

@endsection


@section('scripts')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Dashboard JavaScript -->
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection