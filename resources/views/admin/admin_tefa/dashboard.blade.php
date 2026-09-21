@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <h2>Dashboard</h2>
    <p>Ringkasan Performa TEFA</p>
</div>

<!-- 5 Summary Cards -->
<div class="summary-grid">

    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #3B698F;">📦</div>

        <div class="summary-info">
            <p>Total Pesanan</p>

            <h3 style="color: #3B698F;">
                {{ $totalPesanan }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #D89B4A;">⏳</div>

        <div class="summary-info">
            <p>Menunggu Konfirmasi</p>

            <h3 style="color: #D89B4A;">
                {{ $menungguKonfirmasi }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #5B8FB9;">📋</div>

        <div class="summary-info">
            <p>Dikonfirmasi</p>

            <h3 style="color: #5B8FB9;">
                {{ $dikonfirmasi }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #8067A8;">⚙️</div>

        <div class="summary-info">
            <p>Sedang Diproses</p>

            <h3 style="color: #8067A8;">
                {{ $sedangDiproses }}
            </h3>
        </div>
    </div>


    <div class="tefa-card summary-card">
        <div class="summary-icon" style="background-color: #5F9275;">✅</div>

        <div class="summary-info">
            <p>Selesai</p>

            <h3 style="color: #5F9275;">
                {{ $selesai }}
            </h3>
        </div>
    </div>

</div>


<!-- Produk Terlaris -->
<div class="performance-grid">

    <div class="tefa-card">

        <div class="perf-header">
            <div class="perf-icon">🛒</div>

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

            <p style="color:#64748b;font-size:14px;margin-top:16px;">
                Belum ada data produk atau jasa yang dipesan.
            </p>

        @endif

    </div>

</div>


<!-- Bottom Section -->
<div class="bottom-grid">

    <!-- Pesanan Terbaru -->
    <div class="tefa-card">

        <h3 style="margin-bottom: 16px;">
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
                            class="recent-img"
                            style="
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                background:#EBF3F9;
                                color:#3B698F;
                                font-size:24px;
                            "
                        >
                            📦
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

            <div
                style="
                    padding:30px 0;
                    text-align:center;
                    color:#64748b;
                "
            >
                Belum ada pesanan.
            </div>

        @endif

    </div>


    <!-- Grafik Pesanan Berdasarkan Jurusan -->
    <div class="tefa-card">

        <h3 style="margin-bottom: 16px;">
            Pesanan Berdasarkan Jurusan
        </h3>


        @if(count($chartLabels) > 0)

            <canvas id="jurusanChart"></canvas>

        @else

            <div
                style="
                    padding:40px 20px;
                    text-align:center;
                    color:#64748b;
                "
            >
                Belum ada data jurusan.
            </div>

        @endif

    </div>

</div>

@endsection


@section('scripts')

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Data Grafik dari Controller -->
<script>
    window.jurusanChartLabels = @json($chartLabels);
    window.jurusanChartData = @json($chartData);
</script>


<!-- Dashboard JavaScript -->
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection