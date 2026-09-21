@extends('admin.layouts.app-jurusan')

@section('title', 'Dashboard Jurusan')

@section('content')

<div style="margin-bottom: 24px;">
    <h2 style="margin-bottom: 6px;">
        Dashboard {{ $jurusan->nama_jurusan ?? 'Jurusan' }}
    </h2>

    <p style="color: var(--text-muted); font-size: 14px; margin: 0;">
        Ringkasan data dan aktivitas jurusan
        {{ $jurusan->nama_jurusan ?? '' }}
    </p>
</div>

@if(!$jurusan)

    <div class="tefa-card" style="padding: 30px;">
        <h3 style="color: #dc3545; margin-bottom: 8px;">
            Jurusan belum ditemukan
        </h3>

        <p style="color: var(--text-muted); margin: 0;">
            Akun Admin Jurusan ini belum memiliki penugasan jurusan.
        </p>
    </div>

@else

    <!-- SUMMARY -->
    <div
        class="summary-grid"
        style="
            grid-template-columns: repeat(4, 1fr);
            margin-bottom: 24px;
        "
    >

        <div class="tefa-card" style="padding: 24px;">
            <div style="font-size: 24px; margin-bottom: 12px;">📦</div>

            <h2
                style="
                    color: var(--primary);
                    font-size: 28px;
                    margin-bottom: 4px;
                "
            >
                {{ $totalProduk }}
            </h2>

            <p style="color: var(--text-muted); font-size: 13px; margin: 0;">
                Total Produk
            </p>
        </div>


        <div class="tefa-card" style="padding: 24px;">
            <div style="font-size: 24px; margin-bottom: 12px;">🔧</div>

            <h2
                style="
                    color: var(--accent-rpl);
                    font-size: 28px;
                    margin-bottom: 4px;
                "
            >
                {{ $totalJasa }}
            </h2>

            <p style="color: var(--text-muted); font-size: 13px; margin: 0;">
                Total Jasa
            </p>
        </div>


        <div class="tefa-card" style="padding: 24px;">
            <div style="font-size: 24px; margin-bottom: 12px;">📁</div>

            <h2
                style="
                    color: #5F9275;
                    font-size: 28px;
                    margin-bottom: 4px;
                "
            >
                {{ $totalPortfolio }}
            </h2>

            <p style="color: var(--text-muted); font-size: 13px; margin: 0;">
                Total Portofolio
            </p>
        </div>


        <div class="tefa-card" style="padding: 24px;">
            <div style="font-size: 24px; margin-bottom: 12px;">🛒</div>

            <h2
                style="
                    color: #8A5F92;
                    font-size: 28px;
                    margin-bottom: 4px;
                "
            >
                {{ $totalPesananJurusan }}
            </h2>

            <p style="color: var(--text-muted); font-size: 13px; margin: 0;">
                Total Pesanan
            </p>
        </div>

    </div>


    <!-- PRODUK/JASA TERBANYAK DIPESAN -->
    <div class="dashboard-list-card">

        <div
            style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            "
        >
            <h3
                style="
                    font-size: 16px;
                    color: var(--text-dark);
                    margin: 0;
                "
            >
                📈 Produk/Jasa dengan Pesanan Terbanyak
            </h3>

            <span
                style="
                    font-size: 12px;
                    color: var(--text-muted);
                "
            >
                Berdasarkan data pesanan
            </span>
        </div>


        @if($produkTerlaris->count() > 0)

            @foreach($produkTerlaris as $index => $item)

                @php
                    $gambar = $item->gambars->first();

                    $rankColors = [
                        0 => '#E5B95C',
                        1 => '#A8A8A8',
                        2 => '#B9825A',
                    ];

                    $rankColor = $rankColors[$index] ?? '#CBD5E1';
                @endphp

                <div
                    class="rank-item"
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        gap: 16px;
                    "
                >

                    <div
                        class="rank-left"
                        style="
                            display: flex;
                            align-items: center;
                            gap: 12px;
                        "
                    >

                        <div
                            class="rank-circle"
                            style="
                                background: {{ $rankColor }};
                                color: white;
                            "
                        >
                            {{ $index + 1 }}
                        </div>


                        @if($gambar)

                            <img
                                src="{{ asset('storage/' . $gambar->path_gambar) }}"
                                class="list-item-img"
                                alt="{{ $item->nama_produk_jasa }}"
                            >

                        @else

                            <div
                                class="list-item-img"
                                style="
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    background: #F1F5F9;
                                    font-size: 22px;
                                "
                            >
                                {{ $item->jenis === 'produk' ? '📦' : '🔧' }}
                            </div>

                        @endif


                        <div>

                            <div class="list-item-title">
                                {{ $item->nama_produk_jasa }}
                            </div>

                            <div class="list-item-subtitle">
                                {{ ucfirst($item->jenis) }}
                            </div>

                        </div>

                    </div>


                    <span
                        class="catalog-stats"
                        style="
                            background: #f0f7ff;
                            white-space: nowrap;
                        "
                    >
                        {{ $item->pesanans_count }} pesanan
                    </span>

                </div>

            @endforeach

        @else

            <div
                style="
                    text-align: center;
                    padding: 40px 20px;
                    color: var(--text-muted);
                "
            >
                <div style="font-size: 42px; margin-bottom: 12px;">
                    🛒
                </div>

                <p style="margin: 0;">
                    Belum ada pesanan untuk produk atau jasa jurusan.
                </p>
            </div>

        @endif

    </div>


    <!-- PERFORMA PESANAN -->
    <div class="dashboard-list-card">

        <h3
            style="
                font-size: 16px;
                color: var(--text-dark);
                margin-bottom: 24px;
            "
        >
            📊 Performa Pesanan
        </h3>


        <div
            style="
                display: grid;
                grid-template-columns: 1fr 2fr;
                gap: 40px;
                align-items: center;
            "
        >

            <!-- CHART -->
            <div
                style="
                    display: flex;
                    justify-content: center;
                    align-items: center;
                "
            >

                <div style="text-align: center; width: 180px;">

                    <div
                        style="
                            position: relative;
                            width: 160px;
                            height: 160px;
                            margin: 0 auto 12px auto;
                        "
                    >
                        <canvas id="chartJenisPesanan"></canvas>
                    </div>

                    <div
                        style="
                            font-weight: 700;
                            color: var(--primary);
                            font-size: 16px;
                        "
                    >
                        {{ $totalPesananJurusan }}
                    </div>

                    <div
                        style="
                            font-size: 11px;
                            color: var(--text-muted);
                        "
                    >
                        Total Pesanan
                    </div>

                </div>

            </div>


            <!-- BAR PRODUK -->
            <div>

                @php
                    $persenProduk = $totalPesananJurusan > 0
                        ? ($totalPesananProduk / $totalPesananJurusan) * 100
                        : 0;

                    $persenJasa = $totalPesananJurusan > 0
                        ? ($totalPesananJasa / $totalPesananJurusan) * 100
                        : 0;
                @endphp


                <div style="margin-bottom: 24px;">

                    <div
                        style="
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 8px;
                        "
                    >

                        <span style="font-weight: 600;">
                            📦 Produk
                        </span>

                        <span
                            style="
                                color: var(--text-muted);
                                font-size: 13px;
                            "
                        >
                            {{ $totalPesananProduk }} pesanan
                        </span>

                    </div>


                    <div class="progress-bar-bg">

                        <div
                            class="progress-fill-blue"
                            style="
                                width: {{ $persenProduk }}%;
                            "
                        ></div>

                    </div>


                    <div
                        style="
                            font-size: 11px;
                            color: var(--text-muted);
                            margin-top: 5px;
                        "
                    >
                        {{ number_format($persenProduk, 1) }}%
                        dari seluruh pesanan
                    </div>

                </div>


                <!-- BAR JASA -->
                <div>

                    <div
                        style="
                            display: flex;
                            justify-content: space-between;
                            margin-bottom: 8px;
                        "
                    >

                        <span style="font-weight: 600;">
                            🔧 Jasa
                        </span>

                        <span
                            style="
                                color: var(--text-muted);
                                font-size: 13px;
                            "
                        >
                            {{ $totalPesananJasa }} pesanan
                        </span>

                    </div>


                    <div class="progress-bar-bg">

                        <div
                            class="progress-fill-blue"
                            style="
                                width: {{ $persenJasa }}%;
                                background-color: var(--accent-rpl);
                            "
                        ></div>

                    </div>


                    <div
                        style="
                            font-size: 11px;
                            color: var(--text-muted);
                            margin-top: 5px;
                        "
                    >
                        {{ number_format($persenJasa, 1) }}%
                        dari seluruh pesanan
                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- RINGKASAN PRODUK/JASA -->
    <div class="dashboard-list-card">

        <div
            style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 16px;
            "
        >

            <h3
                style="
                    font-size: 16px;
                    color: var(--text-dark);
                    margin: 0;
                "
            >
                📋 Ringkasan Produk & Jasa
            </h3>

            <span
                style="
                    font-size: 12px;
                    color: var(--text-muted);
                "
            >
                Data katalog jurusan
            </span>

        </div>


        @if($produkTerlaris->count() > 0)

            @foreach($produkTerlaris as $item)

                <div
                    style="
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        padding: 14px 0;
                        border-bottom: 1px solid #f0f0f0;
                    "
                >

                    <div>

                        <div
                            style="
                                font-weight: 600;
                                color: var(--text-dark);
                                margin-bottom: 4px;
                            "
                        >
                            {{ $item->nama_produk_jasa }}
                        </div>

                        <div
                            style="
                                font-size: 12px;
                                color: var(--text-muted);
                            "
                        >
                            {{ ucfirst($item->jenis) }}

                            @if($item->harga !== null)
                                · Rp{{ number_format($item->harga, 0, ',', '.') }}
                            @endif
                        </div>

                    </div>


                    <div
                        style="
                            font-size: 13px;
                            font-weight: 600;
                            color: var(--primary);
                        "
                    >
                        {{ $item->pesanans_count }} pesanan
                    </div>

                </div>

            @endforeach

        @else

            <div
                style="
                    text-align: center;
                    padding: 30px 20px;
                    color: var(--text-muted);
                "
            >
                Belum ada produk atau jasa yang memiliki pesanan.
            </div>

        @endif

    </div>

@endif

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const chartElement =
        document.getElementById('chartJenisPesanan');

    if (!chartElement) {
        return;
    }

    const totalProduk =
        {{ $totalPesananProduk }};

    const totalJasa =
        {{ $totalPesananJasa }};

    new Chart(chartElement, {

        type: 'doughnut',

        data: {
            labels: [
                'Produk',
                'Jasa'
            ],

            datasets: [{
                data: [
                    totalProduk,
                    totalJasa
                ],

                backgroundColor: [
                    '#3B698F',
                    '#D8893D'
                ],

                borderWidth: 0
            }]
        },

        options: {
            cutout: '72%',
            responsive: true,
            maintainAspectRatio: false,

            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                },

                tooltip: {
                    callbacks: {
                        label: function (context) {

                            const value =
                                context.raw || 0;

                            const total =
                                totalProduk + totalJasa;

                            const percentage =
                                total > 0
                                    ? ((value / total) * 100).toFixed(1)
                                    : 0;

                            return context.label +
                                ': ' +
                                value +
                                ' pesanan (' +
                                percentage +
                                '%)';
                        }
                    }
                }
            }
        }

    });

});
</script>

@endsection