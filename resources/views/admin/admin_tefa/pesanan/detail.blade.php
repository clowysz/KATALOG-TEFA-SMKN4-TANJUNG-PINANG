@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<style>
    .detail-pesanan-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 20px;
    }

    /* =========================
       HEADER
       ========================= */

    .detail-pesanan-header {
        margin-bottom: 24px;
    }

    .btn-back-pesanan {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #1E3A8A;
        border-radius: 8px;
        color: #1E3A8A;
        background: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 20px;
        transition: all 0.2s ease;
    }

    .btn-back-pesanan:hover {
        background: #1E3A8A;
        color: #fff;
    }

    .detail-pesanan-title {
        margin: 0 0 6px;
        color: #1E2D3D;
        font-size: 24px;
        font-weight: 700;
    }

    .detail-pesanan-subtitle {
        margin: 0;
        color: #64748B;
        font-size: 14px;
    }


    /* =========================
       GRID
       ========================= */

    .detail-pesanan-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .detail-pesanan-grid-full {
        grid-column: 1 / -1;
    }


    /* =========================
       CARD
       ========================= */

    .detail-pesanan-card {
        background: #fff;
        padding: 26px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .detail-card-title {
        margin: 0 0 20px;
        color: #1E3A8A;
        font-size: 18px;
        font-weight: 700;
        padding-bottom: 14px;
        border-bottom: 1px solid #E2E8F0;
    }


    /* =========================
       DETAIL INFORMATION
       ========================= */

    .detail-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0 28px;
    }

    .detail-info-item {
        padding: 14px 0;
        border-bottom: 1px solid #F1F5F9;
        min-width: 0;
    }

    .detail-info-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        display: block;
        margin-bottom: 6px;
        color: #64748B;
        font-size: 13px;
        font-weight: 600;
    }

    .detail-value {
        color: #1E293B;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.5;
        word-break: break-word;
    }


    /* =========================
       STATUS
       ========================= */

    .badge-status-pesanan {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 20px;
        background: #E0E7FF;
        color: #3730A3;
        font-size: 12px;
        font-weight: 700;
    }


    /* =========================
       CATATAN
       ========================= */

    .catatan-pesanan {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #E2E8F0;
    }

    .catatan-content {
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
        font-weight: 400;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 14px 16px;
    }


    /* =========================
       ALERT
       ========================= */

    .detail-pesanan-alert {
        background: #ECFDF5;
        color: #166534;
        border: 1px solid #BBF7D0;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }


    /* =========================
       UPDATE STATUS
       ========================= */

    .status-card {
        margin-top: 20px;
    }

    .status-form-group {
        margin-top: 4px;
    }

    .status-form-label {
        display: block;
        margin-bottom: 8px;
        color: #1E2D3D;
        font-size: 14px;
        font-weight: 600;
    }

    .status-select {
        width: 100%;
        max-width: 360px;
        padding: 11px 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        background: #fff;
        color: #334155;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        box-sizing: border-box;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .status-select:focus {
        border-color: #3B698F;
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
    }

    .status-form-actions {
        margin-top: 20px;
    }

    .btn-save-status {
        background: #1e3a8ad9;
        color: #fff;
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-save-status:hover,
    .btn-save-status:focus {
        background: #1E3A8A;
        color: #fff;
    }

    .btn-save-status:active {
        background: #172E6F;
    }


    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 768px) {

        .detail-pesanan-container {
            padding: 15px;
        }

        .detail-pesanan-grid {
            grid-template-columns: 1fr;
        }

        .detail-pesanan-card {
            padding: 22px 20px;
        }

        .detail-info-grid {
            grid-template-columns: 1fr;
        }

        .detail-pesanan-title {
            font-size: 22px;
        }

        .status-select {
            max-width: 100%;
        }

        .btn-save-status {
            width: 100%;
        }
    }
</style>


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