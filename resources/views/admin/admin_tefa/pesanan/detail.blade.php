@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/pesanan-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="detail-pesanan-container">

    {{-- =========================
         HEADER
         ========================= --}}

    <div class="detail-pesanan-header">

        <a
            href="{{ route('pesanan.index') }}"
            class="btn-back-pesanan"
        >
            &larr; Kembali ke Kelola Pesanan
        </a>

        <h2 class="detail-pesanan-title">
            Detail Pesanan #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
        </h2>

        <p class="detail-pesanan-subtitle">
            Informasi lengkap dan pembaruan status pesanan
        </p>

    </div>


    {{-- PESAN HASIL UPDATE STATUS --}}
    @if(session('success'))
        <div class="pesanan-alert pesanan-alert-success">
            <i class="ph ph-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="pesanan-alert pesanan-alert-error">
            <i class="ph ph-warning-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="pesanan-alert pesanan-alert-error">
            <i class="ph ph-warning-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif


    {{-- =========================
         INFORMASI PESANAN
         ========================= --}}

    <div class="detail-pesanan-grid">

        <div class="detail-pesanan-card">

            <h3 class="detail-card-title">
                Informasi Pesanan
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nomor Pesanan
                    </span>

                    <div class="detail-value">
                        #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Tanggal Pesanan
                    </span>

                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y, H:i') }}
                        WIB
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Status Saat Ini
                    </span>

                    <div class="detail-value">

                        <span class="badge-status-pesanan">
                            {{ ucfirst($pesanan->status) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             INFORMASI PEMBELI
             ========================= --}}

        <div class="detail-pesanan-card">

            <h3 class="detail-card-title">
                Informasi Pembeli
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nama Lengkap
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->nama ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Email
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->email ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Nomor Telepon
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->nomor_hp ?? '-' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             INFORMASI PRODUK / JASA
             ========================= --}}

        <div class="detail-pesanan-card detail-pesanan-grid-full">

            <h3 class="detail-card-title">
                Informasi Produk / Jasa
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nama Produk/Jasa
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->produkJasa->nama_produk_jasa ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jurusan
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->produkJasa->jurusan->nama_jurusan ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jenis
                    </span>

                    <div class="detail-value">
                        {{ strtoupper($pesanan->produkJasa->jenis ?? '-') }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Harga Satuan
                    </span>

                    <div class="detail-value">
                        Rp{{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jumlah Pesanan
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->jumlah }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Total Harga
                    </span>

                    <div class="detail-value">
                        Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>

                </div>

            </div>


            {{-- Catatan --}}
            <div class="catatan-pesanan">

                <span class="detail-label">
                    Catatan / Kebutuhan Pembeli
                </span>

                <div class="catatan-content">

                    @if($pesanan->catatan)

                        {{ $pesanan->catatan }}

                    @else

                        Tidak ada catatan dari pembeli.

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- =========================
         UPDATE STATUS
         ========================= --}}

    <div class="detail-pesanan-card status-card">

        <h3 class="detail-card-title">
            Update Status Pesanan
        </h3>


        @if($pesanan->status === 'diproses')

            <div class="detail-pesanan-alert">
                Pesanan sudah diteruskan ke Admin Produser untuk dikerjakan.
            </div>

        @endif


        <form
            action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
            method="POST"
        >

            @csrf

            <div class="status-form-group">

                <label
                    for="statusSelect"
                    class="status-form-label"
                >
                    Ubah Status Menjadi:
                </label>

                <select
                    id="statusSelect"
                    name="status"
                    class="status-select"
                    required
                >

                    <option
                        value="menunggu konfirmasi"
                        {{ $pesanan->status == 'menunggu konfirmasi' ? 'selected' : '' }}
                    >
                        Menunggu Konfirmasi
                    </option>

                    <option
                        value="konfirmasi"
                        {{ $pesanan->status == 'konfirmasi' ? 'selected' : '' }}
                    >
                        Konfirmasi
                    </option>

                    <option
                        value="diproses"
                        {{ $pesanan->status == 'diproses' ? 'selected' : '' }}
                    >
                        Diproses
                    </option>

                    <option
                        value="selesai"
                        {{ $pesanan->status == 'selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>

                    <option
                        value="dibatalkan"
                        {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}
                    >
                        Dibatalkan
                    </option>

                </select>

            </div>


            <div class="status-form-actions">

                <button
                    type="submit"
                    class="btn-save-status"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection