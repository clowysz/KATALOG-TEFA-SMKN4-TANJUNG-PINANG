@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/riwayat-detail.css') }}">
@endpush

@section('content')

@php
    $statusLabels=[
        'menunggu konfirmasi'=>'Menunggu Konfirmasi',
        'konfirmasi'=>'Dikonfirmasi',
        'diproses'=>'Diproses',
        'selesai'=>'Selesai',
        'dibatalkan'=>'Dibatalkan',
    ];

    $statusIcons=[
        'menunggu konfirmasi'=>'clock',
        'konfirmasi'=>'check-circle',
        'diproses'=>'spinner-gap',
        'selesai'=>'check-circle',
        'dibatalkan'=>'x-circle',
    ];

    $produk=$pesanan->produkJasa;
    $gambar=$produk?->gambars?->first();

    $progressTerakhir=$pesanan->progressPengerjaan
        ->sortByDesc('tanggal_update')
        ->first();

    $progressSaatIni=$progressTerakhir
        ? $progressTerakhir->persentase_progress
        : ($pesanan->status==='selesai' ? 100 : 0);
@endphp

<div class="rd-page">

    <!-- HEADER -->
    <div class="rd-header">

        <div class="rd-container">

            <a
                href="{{ route('pembeli.riwayat') }}"
                class="rd-back-btn"
            >
                <i class="ph ph-arrow-left"></i>
                Kembali ke Riwayat Pemesanan
            </a>

            <div class="rd-title-area">

                <div class="rd-title-icon">
                    <i class="ph ph-receipt"></i>
                </div>

                <div>

                    <h1>Detail Pesanan</h1>

                    <p>
                        Informasi lengkap mengenai pesanan Anda.
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- BODY -->
    <div class="rd-body">

        <div class="rd-container">


            <!-- INFORMASI STATUS -->
            <div class="rd-card rd-flex-between">

                <div>

                    <div class="rd-label">
                        No. Pesanan
                    </div>

                    <div class="rd-order-id">
                        #{{ str_pad($pesanan->id_pesanan,5,'0',STR_PAD_LEFT) }}
                    </div>

                    <div class="rd-date">

                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}

                    </div>

                </div>


                <div class="rd-status-box warning">

                    <div class="rd-status-title">

                        <i class="ph ph-{{ $statusIcons[$pesanan->status] ?? 'info' }}"></i>

                        {{ $statusLabels[$pesanan->status] ?? $pesanan->status }}

                    </div>

                    <div class="rd-status-est">

                        Progress saat ini: {{ $progressSaatIni }}%

                    </div>

                </div>

            </div>


            <!-- PRODUK / JASA -->
            <div class="rd-card rd-product">

                @if($gambar)

                    <img
                        src="{{ asset('storage/'.$gambar->path_gambar) }}"
                        alt="{{ $produk?->nama_produk_jasa }}"
                    >

                @else

                    <div
                        style="width:100%;max-width:400px;min-height:220px;background:#E2E8F0;display:flex;align-items:center;justify-content:center;border-radius:12px;"
                    >
                        <i
                            class="ph ph-image"
                            style="font-size:60px;color:#94A3B8;"
                        ></i>
                    </div>

                @endif


                <div class="rd-product-info">

                    <span class="rd-badge">
                        {{ strtoupper($produk?->jenis ?? 'PRODUK') }}
                    </span>

                    <h2>
                        {{ $produk?->nama_produk_jasa ?? 'Produk/Jasa' }}
                    </h2>

                    <p>
                        {{ $produk?->deskripsi ?? 'Deskripsi produk atau jasa tidak tersedia.' }}
                    </p>

                    <div class="rd-price">
                        Rp {{ number_format($pesanan->total_harga,0,',','.') }}
                    </div>

                    <div class="rd-qty">
                        Jumlah: {{ $pesanan->jumlah }}
                    </div>

                </div>

            </div>


            <!-- STATUS PESANAN -->
            <div class="rd-card">

                <h3 class="rd-card-title">
                    Status Pesanan
                </h3>

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

                        @if(!$loop->last)
                            <div class="rd-line active"></div>
                        @endif

                    @empty

                        <div class="rd-step active">

                            <div class="rd-icon">

                                <i class="ph ph-check"></i>

                            </div>

                            <div class="rd-text">

                                {{ $statusLabels[$pesanan->status] ?? $pesanan->status }}

                                <br>

                                <span>
                                    Belum ada riwayat perubahan status.
                                </span>

                            </div>

                        </div>

                    @endforelse

                </div>

            </div>


            <!-- PROGRESS PENGERJAAN -->
            <div class="rd-card">

                <h3 class="rd-card-title">
                    Progress Pengerjaan
                </h3>

                <div style="margin-bottom:20px;">

                    <div
                        style="display:flex;justify-content:space-between;margin-bottom:8px;"
                    >

                        <strong>
                            Progress
                        </strong>

                        <strong>
                            {{ $progressSaatIni }}%
                        </strong>

                    </div>

                    <div
                        style="width:100%;height:12px;background:#E2E8F0;border-radius:20px;overflow:hidden;"
                    >

                        <div
                            style="width:{{ min(100,max(0,$progressSaatIni)) }}%;height:100%;background:#1E3A8A;border-radius:20px;"
                        ></div>

                    </div>

                </div>


                @if($pesanan->progressPengerjaan->count())

                    <div>

                        @foreach($pesanan->progressPengerjaan->sortByDesc('tanggal_update') as $progress)

                            <div
                                style="padding:14px 0;border-bottom:1px solid #E2E8F0;"
                            >

                                <div
                                    style="display:flex;justify-content:space-between;gap:15px;"
                                >

                                    <strong>
                                        {{ $progress->persentase_progress }}%
                                    </strong>

                                    <span
                                        style="font-size:13px;color:#64748B;"
                                    >
                                        {{ \Carbon\Carbon::parse($progress->tanggal_update)->translatedFormat('d F Y, H:i') }}
                                    </span>

                                </div>

                                @if($progress->keterangan_progress)

                                    <div
                                        style="margin-top:6px;color:#64748B;font-size:14px;"
                                    >
                                        {{ $progress->keterangan_progress }}
                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>

                @else

                    <p style="color:#64748B;margin:0;">
                        Belum ada update progress pengerjaan.
                    </p>

                @endif

            </div>


            <!-- TAHAPAN PENGERJAAN -->
@if($pesanan->tahapanPengerjaan->count())

    <div class="rd-card">

        <h3 class="rd-card-title">
            Tahapan Pengerjaan
        </h3>

        <div>

            @foreach($pesanan->tahapanPengerjaan->sortBy('urutan') as $tahapan)

                <div style="
                    padding:18px 0;
                    border-bottom:1px solid #E2E8F0;
                ">

                    <div style="
                        display:flex;
                        align-items:center;
                        justify-content:space-between;
                        gap:15px;
                    ">

                        <div style="
                            display:flex;
                            align-items:center;
                            gap:12px;
                        ">

                            <div style="
                                width:32px;
                                height:32px;
                                border-radius:50%;
                                background:#1E3A8A;
                                color:white;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                flex-shrink:0;
                                font-weight:700;
                            ">
                                {{ $loop->iteration }}
                            </div>

                            <strong>
                                {{ $tahapan->nama_tahapan }}
                            </strong>

                        </div>

                        <strong>
                            {{ $tahapan->persentase_progress }}%
                        </strong>

                    </div>


                    <div style="
                        margin-top:12px;
                        margin-left:44px;
                    ">

                        <div style="
                            display:flex;
                            justify-content:space-between;
                            margin-bottom:6px;
                            font-size:13px;
                            color:#64748B;
                        ">

                            <span>
                                {{ $tahapan->status }}
                            </span>

                            <span>
                                Progress
                            </span>

                        </div>


                        <div style="
                            width:100%;
                            height:8px;
                            background:#E2E8F0;
                            border-radius:20px;
                            overflow:hidden;
                        ">

                            <div style="
                                width:{{ min(100, max(0, $tahapan->persentase_progress)) }}%;
                                height:100%;
                                background:#1E3A8A;
                                border-radius:20px;
                            "></div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endif


            <!-- GRID INFORMASI -->
            <div class="rd-grid-2">


                <!-- PEMESAN -->
                <div class="rd-card">

                    <h3 class="rd-card-title">
                        Informasi Pemesan
                    </h3>

                    <div class="rd-info-row">

                        <i class="ph ph-user"></i>

                        <span>
                            Nama Lengkap
                        </span>

                        <strong>
                            {{ $pesanan->pembeli?->nama ?? '-' }}
                        </strong>

                    </div>

                    <div class="rd-info-row">

                        <i class="ph ph-phone"></i>

                        <span>
                            No. WhatsApp
                        </span>

                        <strong>
                            {{ $pesanan->pembeli?->nomor_hp ?? '-' }}
                        </strong>

                    </div>

                    <div class="rd-info-row">

                        <i class="ph ph-envelope"></i>

                        <span>
                            Email
                        </span>

                        <strong>
                            {{ $pesanan->pembeli?->email ?? '-' }}
                        </strong>

                    </div>

                </div>


                <!-- DETAIL PESANAN -->
                <div class="rd-card">

                    <h3 class="rd-card-title">
                        Detail Pesanan
                    </h3>

                    <div class="rd-info-row">

                        <i class="ph ph-receipt"></i>

                        <span>
                            Produk / Jasa
                        </span>

                        <strong>
                            {{ $produk?->nama_produk_jasa ?? '-' }}
                        </strong>

                    </div>

                    <div class="rd-info-row">

                        <i class="ph ph-tag"></i>

                        <span>
                            Harga Satuan
                        </span>

                        <strong>
                            Rp {{ number_format($produk?->harga ?? 0,0,',','.') }}
                        </strong>

                    </div>

                    <div class="rd-info-row">

                        <i class="ph ph-package"></i>

                        <span>
                            Jumlah
                        </span>

                        <strong>
                            {{ $pesanan->jumlah }}
                        </strong>

                    </div>

                    <div class="rd-divider"></div>

                    <div class="rd-info-row total">

                        <span>
                            Total
                        </span>

                        <strong>
                            Rp {{ number_format($pesanan->total_harga,0,',','.') }}
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