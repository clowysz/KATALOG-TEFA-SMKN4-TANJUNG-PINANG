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
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        "
    >

        <!-- CARD 1: TOTAL PRODUK -->
        <div
            class="tefa-card"
            style="
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
            "
        >

            <div
                style="
                    background-color: #1E3A8A;
                    min-width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 26px;
                    color: #FFFFFF;
                "
            >
                <i class="ph ph-package"></i>
            </div>

            <div
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                "
            >
                <p
                    style="
                        color: var(--text-muted);
                        font-size: 13px;
                        font-weight: 500;
                        margin: 0 0 4px 0;
                    "
                >
                    Total Produk
                </p>

                <h2
                    style="
                        color: #1E3A8A;
                        font-size: 24px;
                        font-weight: 700;
                        margin: 0;
                        line-height: 1;
                    "
                >
                    {{ $totalProduk }}
                </h2>
            </div>

        </div>


        <!-- CARD 2: TOTAL JASA -->
        <div
            class="tefa-card"
            style="
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
            "
        >

            <div
                style="
                    background-color: #573911;
                    min-width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 26px;
                    color: #FFFFFF;
                "
            >
                <i class="ph ph-wrench"></i>
            </div>

            <div
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                "
            >
                <p
                    style="
                        color: var(--text-muted);
                        font-size: 13px;
                        font-weight: 500;
                        margin: 0 0 4px 0;
                    "
                >
                    Total Jasa
                </p>

                <h2
                    style="
                        color: #573911;
                        font-size: 24px;
                        font-weight: 700;
                        margin: 0;
                        line-height: 1;
                    "
                >
                    {{ $totalJasa }}
                </h2>
            </div>

        </div>


        <!-- CARD 3: TOTAL PORTOFOLIO -->
        <div
            class="tefa-card"
            style="
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
            "
        >

            <div
                style="
                    background-color: #002F56;
                    min-width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 26px;
                    color: #FFFFFF;
                "
            >
                <i class="ph ph-folder-open"></i>
            </div>

            <div
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                "
            >
                <p
                    style="
                        color: var(--text-muted);
                        font-size: 13px;
                        font-weight: 500;
                        margin: 0 0 4px 0;
                    "
                >
                    Total Portofolio
                </p>

                <h2
                    style="
                        color: #002F56;
                        font-size: 24px;
                        font-weight: 700;
                        margin: 0;
                        line-height: 1;
                    "
                >
                    {{ $totalPortfolio }}
                </h2>
            </div>

        </div>


        <!-- CARD 4: TOTAL PESANAN -->
        <div
            class="tefa-card"
            style="
                padding: 20px;
                display: flex;
                align-items: center;
                gap: 16px;
            "
        >

            <div
                style="
                    background-color: #470D4F;
                    min-width: 56px;
                    height: 56px;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 26px;
                    color: #FFFFFF;
                "
            >
                <i class="ph ph-shopping-cart"></i>
            </div>

            <div
                style="
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                "
            >
                <p
                    style="
                        color: var(--text-muted);
                        font-size: 13px;
                        font-weight: 500;
                        margin: 0 0 4px 0;
                    "
                >
                    Total Pesanan
                </p>

                <h2
                    style="
                        color: #470D4F;
                        font-size: 24px;
                        font-weight: 700;
                        margin: 0;
                        line-height: 1;
                    "
                >
                    {{ $totalPesananJurusan }}
                </h2>
            </div>

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
                <i
                    class="ph ph-chart-line-up"
                    style="
                        color: #1E3A8A;
                        margin-right: 6px;
                    "
                ></i>
                Produk/Jasa dengan Pesanan Terbanyak
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
                        0 => '#1E3A8A',
                        1 => '#573911',
                        2 => '#002F56',
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
                                    background: #EBF3F9;
                                    color: #1E3A8A;
                                    font-size: 22px;
                                "
                            >
                                <i
                                    class="{{ $item->jenis === 'produk' ? 'ph ph-package' : 'ph ph-wrench' }}"
                                ></i>
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
                            background: #EBF3F9;
                            color: #1E3A8A;
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

                <div
                    style="
                        font-size: 42px;
                        margin-bottom: 12px;
                        color: #1E3A8A;
                    "
                >
                    <i class="ph ph-shopping-cart"></i>
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
            <i
                class="ph ph-chart-donut"
                style="
                    color: #1E3A8A;
                    margin-right: 6px;
                "
            ></i>
            Performa Pesanan
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
                            color: #1E3A8A;
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
                            <i
                                class="ph ph-package"
                                style="
                                    color: #1E3A8A;
                                    margin-right: 5px;
                                "
                            ></i>
                            Produk
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
                                background-color: #1E3A8A;
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
                            <i
                                class="ph ph-wrench"
                                style="
                                    color: #573911;
                                    margin-right: 5px;
                                "
                            ></i>
                            Jasa
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
                                background-color: #573911;
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
                <i
                    class="ph ph-list-bullets"
                    style="
                        color: #1E3A8A;
                        margin-right: 6px;
                    "
                ></i>
                Ringkasan Produk & Jasa
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
                            color: #1E3A8A;
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
                    '#1E3A8A',
                    '#573911'
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