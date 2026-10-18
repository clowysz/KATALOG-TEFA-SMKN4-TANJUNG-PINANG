@extends('public.layouts')

@section('title', 'Riwayat Pemesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/riwayat-pembeli.css') }}">
@endpush

@section('content')

@php
    $statusLabels = [
        'menunggu konfirmasi' => 'Menunggu Konfirmasi',
        'konfirmasi'          => 'Dikonfirmasi',
        'diproses'            => 'Diproses',
        'selesai'             => 'Selesai',
        'dibatalkan'          => 'Dibatalkan',
    ];

    // Status lain (konfirmasi, diproses) memakai ikon & warna "progress"
    $statusIcons = [
        'menunggu konfirmasi' => 'clock',
        'selesai'             => 'check-circle',
        'dibatalkan'          => 'x-circle',
    ];

    $badgeClasses = [
        'selesai'    => 'rw-badge--done',
        'dibatalkan' => 'rw-badge--cancel',
    ];

    $tabs = [
        ''           => 'Semua Pesanan',
        'konfirmasi' => 'Dikonfirmasi',
        'diproses'   => 'Diproses',
        'selesai'    => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];
@endphp

<div class="rw-page">

    <!-- Gelembung dekorasi -->
    <div class="bubble" style="width:150px;height:150px;top:-50px;right:-50px;animation-duration:8s;"></div>
    <div class="bubble" style="width:80px;height:80px;top:20%;left:5%;animation-duration:6s;"></div>

    <div class="rw-back-wrap">
        <a href="/profil-pembeli" class="rw-back-btn">
            <i class="ph ph-arrow-left"></i>
            Kembali ke Profil
        </a>
    </div>

    <div class="rw-heading">
        <h2>
            <i class="ph ph-receipt"></i>
            Riwayat Pemesanan
        </h2>

        <p>
            Berikut adalah daftar riwayat pemesanan produk dan jasa yang pernah Anda pesan.
        </p>
    </div>

    <div class="rw-card">

        <!-- FILTER -->
        <div class="rw-tools">

            <div class="rw-tabs">
                @foreach($tabs as $tabStatus => $tabLabel)
                    <a
                        href="{{ $tabStatus !== '' ? route('pembeli.riwayat', ['status' => $tabStatus]) : route('pembeli.riwayat') }}"
                        class="rw-tab {{ (string) $status === (string) $tabStatus ? 'active' : '' }}"
                    >
                        {{ $tabLabel }}
                    </a>
                @endforeach
            </div>

            <form
                action="{{ route('pembeli.riwayat') }}"
                method="GET"
                class="rw-search"
            >
                @if($status)
                    <input type="hidden" name="status" value="{{ $status }}">
                @endif

                <i class="ph ph-magnifying-glass"></i>

                <input
                    type="text"
                    name="keyword"
                    placeholder="Cari pesanan..."
                    value="{{ $keyword }}"
                >
            </form>

        </div>


        <!-- TABEL PESANAN (jadi kartu di layar sempit) -->
        <div class="rw-table-wrapper">

            <table class="rw-table">

                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($riwayats as $item)

                        @php
                            $produk = $item->produkJasa;

                            $progressTerakhir = $item->progressPengerjaan
                                ->sortByDesc('tanggal_update')
                                ->first();
                        @endphp

                        <tr>

                            <!-- PRODUK / JASA -->
                            <td data-label="Pesanan">
                                <div class="rw-item">

                                    <div class="rw-item-icon">
                                        <i class="ph {{ $produk?->jenis === 'jasa' ? 'ph-wrench' : 'ph-package' }}"></i>
                                    </div>

                                    <div class="rw-item-text">
                                        <h4>{{ $produk?->nama_produk_jasa ?? 'Produk/Jasa' }}</h4>

                                        <p>
                                            {{ $produk?->jurusan?->nama_jurusan ?? '-' }}
                                            <br>
                                            #{{ str_pad($item->id_pesanan, 5, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>

                                </div>
                            </td>

                            <!-- TANGGAL -->
                            <td data-label="Tanggal">
                                <div>
                                    <div class="rw-text-main">
                                        <i class="ph ph-calendar-blank"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal_pesan)->translatedFormat('d F Y') }}
                                    </div>

                                    <div class="rw-text-sub">
                                        <i class="ph ph-package"></i>
                                        Qty: {{ $item->jumlah }}
                                    </div>
                                </div>
                            </td>

                            <!-- TOTAL -->
                            <td class="rw-price" data-label="Total">
                                Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                            </td>

                            <!-- STATUS -->
                            <td data-label="Status">
                                <span class="rw-badge {{ $badgeClasses[$item->status] ?? 'rw-badge--progress' }}">
                                    <i class="ph ph-{{ $statusIcons[$item->status] ?? 'spinner-gap' }}"></i>
                                    {{ $statusLabels[$item->status] ?? $item->status }}
                                </span>
                            </td>

                            <!-- PROGRESS -->
                            <td data-label="Progress">
                                <div>
                                    @if($progressTerakhir)

                                        <div class="rw-text-main">{{ $progressTerakhir->persentase_progress }}%</div>
                                        <div class="rw-text-sub">Progress pengerjaan</div>

                                    @elseif($item->status === 'selesai')

                                        <div class="rw-text-main">100%</div>
                                        <div class="rw-text-sub">Selesai</div>

                                    @else

                                        <div class="rw-text-main">Belum tersedia</div>
                                        <div class="rw-text-sub">Menunggu proses</div>

                                    @endif
                                </div>
                            </td>

                            <!-- AKSI -->
                            <td class="rw-action" data-label="Aksi">
                                <a
                                    href="{{ route('pembeli.riwayat.detail', $item->id_pesanan) }}"
                                    class="rw-btn-detail"
                                >
                                    Detail Pesanan
                                    <i class="ph ph-caret-right"></i>
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr class="rw-empty-row">
                            <td colspan="6" class="rw-empty">

                                <i class="ph ph-receipt"></i>

                                <h3>Belum ada data pesanan</h3>

                                <p>
                                    Anda belum memiliki pesanan yang sesuai dengan pencarian atau filter.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection