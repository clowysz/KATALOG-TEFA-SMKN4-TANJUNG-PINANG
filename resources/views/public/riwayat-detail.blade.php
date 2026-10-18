@extends('public.layouts')

@section('title', 'Detail Pesanan')

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

    $statusIcons = [
        'menunggu konfirmasi' => 'clock',
        'konfirmasi'          => 'check-circle',
        'diproses'            => 'spinner-gap',
        'selesai'             => 'check-circle',
        'dibatalkan'          => 'x-circle',
    ];

    $produk = $pesanan->produkJasa;
    $gambar = $produk?->gambars?->first();

    $progressTerakhir = $pesanan->progressPengerjaan
        ->sortByDesc('tanggal_update')
        ->first();

    $progressSaatIni = $progressTerakhir
        ? $progressTerakhir->persentase_progress
        : ($pesanan->status === 'selesai' ? 100 : 0);
@endphp

<div class="rd-page">

    <!-- HEADER -->
    <div class="rd-header">

        <div class="rd-container">

            <a href="{{ route('pembeli.riwayat') }}" class="rw-back-btn">
                <i class="ph ph-arrow-left"></i>
                Kembali ke Riwayat Pemesanan
            </a>

            <div class="rd-title-area">

                <div class="rd-title-icon">
                    <i class="ph ph-receipt"></i>
                </div>

                <div>
                    <h1>Detail Pesanan</h1>

                    <p>Informasi lengkap mengenai pesanan Anda.</p>
                </div>

            </div>

        </div>

    </div>


    <!-- BODY -->
    <div class="rd-body">

        <div class="rd-container">


            <!-- RINGKASAN: NOMOR PESANAN + STATUS -->
            <div class="rd-card rd-summary">

                <div>
                    <div class="rd-label">No. Pesanan</div>

                    <div class="rd-order-id">
                        #{{ str_pad($pesanan->id_pesanan, 5, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="rd-date">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}
                    </div>
                </div>

                <div class="rd-status-box">

                    <div class="rd-status-title">
                        <i class="ph ph-{{ $statusIcons[$pesanan->status] ?? 'info' }}"></i>
                        {{ $statusLabels[$pesanan->status] ?? $pesanan->status }}
                    </div>

                    <div class="rd-status-note">
                        Progress saat ini: {{ $progressSaatIni }}%
                    </div>

                </div>

            </div>


            <!-- PRODUK / JASA -->
            <div class="rd-card rd-product">

                @if($gambar)

                    <img
                        src="{{ asset('storage/' . $gambar->path_gambar) }}"
                        alt="{{ $produk?->nama_produk_jasa }}"
                    >

                @else

                    <div class="rd-noimg">
                        <i class="ph ph-image"></i>
                    </div>

                @endif


                <div class="rd-product-info">

                    <span class="rd-badge">
                        {{ strtoupper($produk?->jenis ?? 'PRODUK') }}
                    </span>

                    <h2>{{ $produk?->nama_produk_jasa ?? 'Produk/Jasa' }}</h2>

                    <p>
                        {{ $produk?->deskripsi ?? 'Deskripsi produk atau jasa tidak tersedia.' }}
                    </p>

                    <div class="rd-price">
                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>

                    <div class="rd-qty">Jumlah: {{ $pesanan->jumlah }}</div>

                </div>

            </div>


            <!-- STATUS PESANAN -->
            <div class="rd-card">

                <h3 class="rd-card-title">Status Pesanan</h3>

                <div class="rd-timeline">

                    @forelse($pesanan->riwayatStatus->sortBy('tanggal_update') as $riwayat)

                        <div class="rd-step active">

                            <div class="rd-icon">
                                <i class="ph ph-check"></i>
                            </div>

                            <div class="rd-text">

                                {{ $statusLabels[$riwayat->status] ?? $riwayat->status }}

                                <br>

                                <span>
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_update)->translatedFormat('d F Y') }}

                                    <br>

                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_update)->format('H:i') }}

                                    @if($riwayat->keterangan)
                                        <br>
                                        {{ $riwayat->keterangan }}
                                    @endif
                                </span>

                            </div>

                        </div>

                        @unless($loop->last)
                            <div class="rd-line active"></div>
                        @endunless

                    @empty

                        <div class="rd-step active">

                            <div class="rd-icon">
                                <i class="ph ph-check"></i>
                            </div>

                            <div class="rd-text">

                                {{ $statusLabels[$pesanan->status] ?? $pesanan->status }}

                                <br>

                                <span>Belum ada riwayat perubahan status.</span>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- PROGRESS PENGERJAAN -->
            <div class="rd-card">

                <h3 class="rd-card-title">Progress Pengerjaan</h3>

                <div class="rd-progress-block">

                    <div class="rd-progress-head">
                        <strong>Progress</strong>
                        <strong>{{ $progressSaatIni }}%</strong>
                    </div>

                    <div class="rd-bar">
                        <div
                            class="rd-bar-fill"
                            style="width: {{ min(100, max(0, $progressSaatIni)) }}%;"
                        ></div>
                    </div>

                </div>


                @forelse($pesanan->progressPengerjaan->sortByDesc('tanggal_update') as $progress)

                    <div class="rd-log-item">

                        <div class="rd-log-head">

                            <strong>{{ $progress->persentase_progress }}%</strong>

                            <span class="rd-log-date">
                                {{ \Carbon\Carbon::parse($progress->tanggal_update)->translatedFormat('d F Y, H:i') }}
                            </span>

                        </div>

                        @if($progress->keterangan_progress)
                            <div class="rd-log-note">
                                {{ $progress->keterangan_progress }}
                            </div>
                        @endif

                    </div>

                @empty

                    <p class="rd-empty-text">
                        Belum ada update progress pengerjaan.
                    </p>

                @endforelse

            </div>


            <!-- TAHAPAN PENGERJAAN -->
            @if($pesanan->tahapanPengerjaan->count())

                <div class="rd-card">

                    <h3 class="rd-card-title">Tahapan Pengerjaan</h3>

                    @foreach($pesanan->tahapanPengerjaan->sortBy('urutan') as $tahapan)

                        <div class="rd-stage">

                            <div class="rd-stage-head">

                                <div class="rd-stage-name">

                                    <div class="rd-stage-num">
                                        {{ $loop->iteration }}
                                    </div>

                                    <strong>{{ $tahapan->nama_tahapan }}</strong>

                                </div>

                                <strong>{{ $tahapan->persentase_progress }}%</strong>

                            </div>


                            <div class="rd-stage-body">

                                <div class="rd-stage-meta">
                                    <span>{{ $tahapan->status }}</span>
                                    <span>Progress</span>
                                </div>

                                <div class="rd-bar rd-bar--sm">
                                    <div
                                        class="rd-bar-fill"
                                        style="width: {{ min(100, max(0, $tahapan->persentase_progress)) }}%;"
                                    ></div>
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif


            <!-- INFORMASI PEMESAN & DETAIL PESANAN -->
            <div class="rd-grid">


                <!-- PEMESAN -->
                <div class="rd-card">

                    <h3 class="rd-card-title">Informasi Pemesan</h3>

                    <div class="rd-info-row">
                        <i class="ph ph-user"></i>
                        <span>Nama Lengkap</span>
                        <strong>{{ $pesanan->pembeli?->nama ?? '-' }}</strong>
                    </div>

                    <div class="rd-info-row">
                        <i class="ph ph-phone"></i>
                        <span>No. WhatsApp</span>
                        <strong>{{ $pesanan->pembeli?->nomor_hp ?? '-' }}</strong>
                    </div>

                    <div class="rd-info-row">
                        <i class="ph ph-envelope"></i>
                        <span>Email</span>
                        <strong>{{ $pesanan->pembeli?->email ?? '-' }}</strong>
                    </div>

                </div>


                <!-- DETAIL PESANAN -->
                <div class="rd-card">

                    <h3 class="rd-card-title">Detail Pesanan</h3>

                    <div class="rd-info-row">
                        <i class="ph ph-receipt"></i>
                        <span>Produk / Jasa</span>
                        <strong>{{ $produk?->nama_produk_jasa ?? '-' }}</strong>
                    </div>

                    <div class="rd-info-row">
                        <i class="ph ph-tag"></i>
                        <span>Harga Satuan</span>
                        <strong>
                            Rp {{ number_format($produk?->harga ?? 0, 0, ',', '.') }}{{ $produk?->satuan_harga ? '/' . $produk->satuan_harga : '' }}
                        </strong>
                    </div>

                    <div class="rd-info-row">
                        <i class="ph ph-package"></i>
                        <span>Jumlah</span>
                        <strong>{{ $pesanan->jumlah }}</strong>
                    </div>

                    <div class="rd-divider"></div>

                    <div class="rd-info-row rd-info-row--total">
                        <span>Total</span>
                        <strong>
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </strong>
                    </div>

                </div>

            </div>


            <!-- CATATAN -->
            @if($pesanan->catatan)

                <div class="rd-card">

                    <h3 class="rd-card-title">
                        <i class="ph ph-chat-circle-text"></i>
                        Catatan Pesanan
                    </h3>

                    <div class="rd-notes">
                        {{ $pesanan->catatan }}
                    </div>

                </div>

            @endif


        </div>

    </div>

</div>

@endsection