@extends('admin.layouts.app-produser')

@section('title', 'Detail Pesanan')

@section('content')

@php
    $tahapanList = $pesanan->tahapanPengerjaan->sortBy('urutan')->values();
    $bolehKelola = $pesanan->status === 'diproses';

    $statusClass = match(strtolower($pesanan->status)) {
        'selesai' => 'badge-soft-green',
        'diproses' => 'badge-soft-blue',
        'menunggu konfirmasi' => 'badge-soft-yellow',
        'dikonfirmasi', 'konfirmasi' => 'badge-soft-blue',
        'dibatalkan' => 'badge-soft-gray',
        default => 'badge-soft-gray',
    };
@endphp

<style>
    /* =========================================================
       DETAIL PESANAN - CUSTOM UI
       Tidak membutuhkan Bootstrap
    ========================================================= */

    #produserOrderPage {
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
        padding: 28px;
        box-sizing: border-box;
    }

    .detail-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .detail-page-title h3 {
        margin: 0 0 6px;
        font-size: 25px;
        font-weight: 700;
        color: var(--prod-text-main);
    }

    .detail-page-title p {
        margin: 0;
        color: var(--prod-text-sec);
        font-size: 14px;
    }

    .prod-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        border: 1px solid transparent;
        border-radius: 9px;
        padding: 10px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: .2s ease;
        font-family: inherit;
    }

    .prod-btn-primary {
        background: var(--primary);
        color: white;
    }

    .prod-btn-primary:hover {
        opacity: .9;
        color: white;
    }

    .prod-btn-secondary {
        background: white;
        color: var(--prod-text-main);
        border-color: var(--prod-border);
    }

    .prod-btn-secondary:hover {
        background: #F8FAFC;
    }

    .prod-btn-danger {
        background: var(--prod-error);
        color: white;
    }

    .prod-btn-success {
        background: var(--prod-success);
        color: white;
    }

    .prod-btn-small {
        padding: 7px 10px;
        font-size: 12px;
    }

    /* ALERT */

    .prod-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 13px;
    }

    .prod-alert-success {
        background: var(--prod-success-bg);
        color: #166534;
        border: 1px solid #BBF7D0;
    }

    .prod-alert-warning {
        background: #FFFBEB;
        color: #92400E;
        border: 1px solid #FDE68A;
    }

    .prod-alert-danger {
        background: var(--prod-error-bg);
        color: #991B1B;
        border: 1px solid #FECACA;
    }

    /* =========================================================
       HERO
    ========================================================= */

    .order-hero-card {
        border-radius: 14px;
        border: 1px solid var(--prod-border);
        background: white;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 4px 10px rgba(0,0,0,.03);
    }

    .order-hero-top {
        background: var(--primary);
        padding: 26px 28px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    .order-hero-main {
        min-width: 0;
        flex: 1;
    }

    .order-hero-badges {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .hero-badge-dark {
        background: rgba(0,0,0,.22);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .hero-badge-light {
        background: white;
        color: var(--primary);
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .order-hero-name {
        margin: 0 0 9px;
        font-size: 24px;
        font-weight: 700;
        line-height: 1.3;
        color: white;
    }

    .order-hero-meta {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        color: rgba(255,255,255,.88);
        font-size: 13px;
    }

    .order-hero-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .order-hero-total {
        min-width: 210px;
        text-align: right;
    }

    .order-hero-total-label {
        font-size: 12px;
        color: rgba(255,255,255,.75);
        margin-bottom: 5px;
    }

    .order-hero-total-value {
        font-size: 25px;
        font-weight: 700;
        color: white;
    }

    .order-hero-total-item {
        font-size: 12px;
        color: rgba(255,255,255,.75);
        margin-top: 3px;
    }

    .order-hero-bottom {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        padding: 20px 26px;
        gap: 16px;
        background: white;
        border-top: 1px solid var(--prod-border);
        width: 100%;
        box-sizing: border-box;
    }

    .hero-stat {
        min-width: 0;
    }

    .hero-stat-label {
        font-size: 10px;
        color: var(--prod-text-sec);
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: .5px;
        margin-bottom: 6px;
    }

    .hero-stat-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--prod-text-main);
        word-break: break-word;
    }

    /* =========================================================
       CONTENT CARD
    ========================================================= */

    .prod-card {
        background: white;
        border: 1px solid var(--prod-border);
        border-radius: 14px;
        box-shadow: 0 2px 5px rgba(0,0,0,.025);
        overflow: hidden;
    }

    .prod-card-body {
        padding: 24px;
    }

    .prod-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 20px;
    }

    .prod-section-title {
        margin: 0 0 5px;
        font-size: 17px;
        font-weight: 700;
        color: var(--prod-text-main);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .prod-section-title i {
        color: var(--primary);
    }

    .prod-section-desc {
        margin: 0;
        font-size: 13px;
        color: var(--prod-text-sec);
    }

    /* =========================================================
       INFO PESANAN
    ========================================================= */

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px 30px;
    }

    .detail-label {
        font-size: 11px;
        color: var(--prod-text-sec);
        margin-bottom: 5px;
    }

    .detail-value {
        font-size: 14px;
        font-weight: 600;
        color: var(--prod-text-main);
    }

    .buyer-note {
        font-size: 14px;
        color: var(--prod-text-sec);
        line-height: 1.7;
        white-space: pre-line;
    }

    .empty-note {
        color: #94A3B8;
        font-size: 13px;
    }

    /* =========================================================
       LAYOUT 8 : 4
    ========================================================= */

    .two-column {
        display: grid;
        grid-template-columns: minmax(0, 2fr) minmax(280px, 1fr);
        gap: 24px;
        margin-bottom: 24px;
    }

    /* =========================================================
       STEPPER
    ========================================================= */

    .stepper-container {
        display: flex;
        flex-direction: column;
        position: relative;
        margin-top: 10px;
    }

    .stepper-item {
        display: flex;
        gap: 15px;
        padding: 15px;
        position: relative;
        border-radius: 12px;
        transition: all .2s ease;
        border: 1px solid transparent;
    }

    .stepper-item:hover {
        background: #F8FAFC;
    }

    .stepper-line {
        position: absolute;
        left: 30px;
        top: 47px;
        bottom: -15px;
        width: 2px;
        background: var(--prod-border);
        z-index: 1;
    }

    .stepper-item:last-child .stepper-line {
        display: none;
    }

    .stepper-circle {
        width: 32px;
        height: 32px;
        min-width: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
        font-size: 13px;
        font-weight: 700;
        position: relative;
    }

    .stepper-circle.selesai {
        background: var(--prod-success);
        color: white;
    }

    .stepper-circle.proses {
        background: var(--primary);
        color: white;
    }

    .stepper-circle.belum {
        background: white;
        color: var(--prod-text-sec);
        border: 2px solid var(--prod-border);
    }

    .stepper-content {
        flex: 1;
        min-width: 0;
    }

    .stepper-top {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .stepper-name {
        margin: 0 0 6px;
        font-size: 14px;
        font-weight: 700;
        color: var(--prod-text-main);
    }

    .stepper-status {
        display: inline-block;
        font-size: 11px;
        color: var(--prod-text-sec);
        background: #F8FAFC;
        border: 1px solid var(--prod-border);
        padding: 4px 9px;
        border-radius: 20px;
    }

    .stepper-percent {
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
        white-space: nowrap;
    }

    .mini-progress-bg {
        width: 100%;
        height: 6px;
        background: #E2E8F0;
        border-radius: 4px;
        overflow: hidden;
        margin: 12px 0 0;
    }

    .mini-progress-fill {
        height: 100%;
        background: var(--primary);
        border-radius: 4px;
        transition: width .3s ease;
    }

    /* =========================================================
       PROGRESS FORM
    ========================================================= */

    .progress-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 600;
        color: var(--prod-text-main);
    }

    .custom-input,
    .custom-select {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid var(--prod-border);
        border-radius: 9px;
        background: white;
        color: var(--prod-text-main);
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: .2s;
    }

    .custom-input:focus,
    .custom-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(32,69,110,.08);
    }

    .range-wrapper {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .range-slider {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        height: 6px;
        background: #E2E8F0;
        border-radius: 4px;
        outline: none;
        transition: background .1s;
        margin-top: 8px;
    }

    .range-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 17px;
        height: 17px;
        border-radius: 50%;
        background: var(--primary);
        cursor: pointer;
        border: 2px solid white;
        box-shadow: 0 2px 4px rgba(0,0,0,.2);
    }

    .range-slider::-moz-range-thumb {
        width: 17px;
        height: 17px;
        border-radius: 50%;
        background: var(--primary);
        cursor: pointer;
        border: 2px solid white;
    }

    .range-value {
        min-width: 45px;
        font-size: 14px;
        font-weight: 700;
        color: var(--primary);
    }

    /* =========================================================
       TIMELINE RIWAYAT
    ========================================================= */

    .history-list {
        position: relative;
    }

    .history-item {
        display: flex;
        gap: 15px;
        position: relative;
        padding-bottom: 22px;
    }

    .history-item:last-child {
        padding-bottom: 0;
    }

    .history-marker-wrap {
        width: 18px;
        min-width: 18px;
        position: relative;
        display: flex;
        justify-content: center;
    }

    .history-marker {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--primary);
        margin-top: 5px;
        position: relative;
        z-index: 2;
    }

    .history-line {
        position: absolute;
        top: 15px;
        bottom: -8px;
        width: 1px;
        background: var(--prod-border);
    }

    .history-item:last-child .history-line {
        display: none;
    }

    .history-content {
        flex: 1;
        display: flex;
        justify-content: space-between;
        gap: 20px;
    }

    .history-percent {
        font-size: 15px;
        font-weight: 700;
        color: var(--prod-text-main);
        margin-bottom: 3px;
    }

    .history-description {
        font-size: 13px;
        color: var(--prod-text-sec);
        margin-bottom: 4px;
    }

    .history-user {
        font-size: 11px;
        color: #94A3B8;
    }

    .history-date {
        text-align: right;
        font-size: 11px;
        color: #94A3B8;
        white-space: nowrap;
    }

    /* =========================================================
       SELECTED STAGE
    ========================================================= */

    .selected-stage-box {
        background: #F0F7FF;
        border: 1px solid #BAE6FD;
        color: var(--primary);
        padding: 12px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* =========================================================
       MODAL CUSTOM
    ========================================================= */

    .prod-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15,23,42,.48);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 99999;
    }

    .prod-modal-overlay.active {
        display: flex;
    }

    .prod-modal {
        width: 100%;
        max-width: 760px;
        max-height: 90vh;
        overflow-y: auto;
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 45px rgba(0,0,0,.18);
        animation: prodModalIn .18s ease-out;
    }

    .prod-modal.small {
        max-width: 520px;
    }

    @keyframes prodModalIn {
        from {
            opacity: 0;
            transform: translateY(8px) scale(.98);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .prod-modal-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 20px;
        padding: 20px 22px;
        border-bottom: 1px solid var(--prod-border);
    }

    .prod-modal-title {
        margin: 0 0 4px;
        font-size: 17px;
        font-weight: 700;
        color: var(--prod-text-main);
    }

    .prod-modal-subtitle {
        margin: 0;
        font-size: 12px;
        color: var(--prod-text-sec);
    }

    .prod-modal-close {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 8px;
        background: #F8FAFC;
        color: var(--prod-text-sec);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .prod-modal-close:hover {
        background: #F1F5F9;
    }

    .prod-modal-body {
        padding: 22px;
    }

    .prod-modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 22px;
        border-top: 1px solid var(--prod-border);
    }

    .stage-table {
        width: 100%;
        border-collapse: collapse;
    }

    .stage-table th {
        padding: 10px 8px;
        text-align: left;
        font-size: 11px;
        color: var(--prod-text-sec);
        border-bottom: 1px solid var(--prod-border);
    }

    .stage-table td {
        padding: 12px 8px;
        font-size: 13px;
        color: var(--prod-text-main);
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }

    .stage-table tr:last-child td {
        border-bottom: 0;
    }

    .stage-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 5px;
    }

    .icon-btn {
        width: 31px;
        height: 31px;
        border: 1px solid var(--prod-border);
        background: white;
        color: var(--prod-text-sec);
        border-radius: 7px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .icon-btn:hover {
        background: #F8FAFC;
        color: var(--primary);
    }

    .icon-btn.danger:hover {
        color: var(--prod-error);
        border-color: #FECACA;
        background: var(--prod-error-bg);
    }

    .modal-empty {
        text-align: center;
        padding: 30px 10px;
        color: var(--prod-text-sec);
        font-size: 13px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 900px) {
        #produserOrderPage {
            padding: 20px;
        }

        .order-hero-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-hero-total {
            text-align: left;
        }

        .order-hero-bottom {
            grid-template-columns: repeat(2, 1fr);
        }

        .two-column {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 650px) {
        #produserOrderPage {
            padding: 15px;
        }

        .detail-page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .order-hero-top {
            padding: 21px;
        }

        .order-hero-name {
            font-size: 20px;
        }

        .order-hero-bottom {
            grid-template-columns: 1fr 1fr;
            padding: 17px;
        }

        .prod-card-body {
            padding: 18px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .progress-layout {
            grid-template-columns: 1fr;
        }

        .prod-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .stepper-top {
            flex-direction: column;
            gap: 7px;
        }

        .history-content {
            flex-direction: column;
            gap: 6px;
        }

        .history-date {
            text-align: left;
        }

        .stage-table {
            min-width: 650px;
        }

        .table-scroll {
            overflow-x: auto;
        }

        .prod-modal {
            max-height: 94vh;
        }
    }
</style>


<div id="produserOrderPage">

    {{-- HEADER --}}
    <div class="detail-page-header">

        <div class="detail-page-title">
            <h3>Detail Pesanan</h3>
            <p>Kelola pengerjaan pesanan dan tahapan pekerjaan.</p>
        </div>

        <a href="{{ route('admin.produser.pesanan') }}"
           class="prod-btn prod-btn-secondary">
            <i class="ph ph-arrow-left"></i>
            Kembali
        </a>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="prod-alert prod-alert-success">
            <i class="ph ph-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif


    {{-- ERRORS --}}
    @if($errors->any())
        <div class="prod-alert prod-alert-danger">

            <i class="ph ph-warning-circle"></i>

            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>

        </div>
    @endif


    {{-- =====================================================
         HERO PESANAN
    ====================================================== --}}

    <div class="order-hero-card">

<div class="order-hero-top-v2">

            <div class="order-hero-main">

                <div class="order-hero-badges">

                    <span class="hero-badge-dark">
                        #{{ $pesanan->id_pesanan }}
                    </span>

                    <span class="hero-badge-light">
                        {{ ucfirst($pesanan->status) }}
                    </span>

                </div>

                <h1 class="order-hero-name">
                    {{ $pesanan->produkJasa->nama_produk_jasa ?? 'Produk/Jasa' }}
                </h1>

                <div class="order-hero-meta">

                    <span>
                        <i class="ph ph-tag"></i>
                        {{ ucfirst($pesanan->produkJasa->jenis ?? '-') }}
                    </span>

                    @if($pesanan->produkJasa?->jurusan)
                        <span>
                            <i class="ph ph-buildings"></i>
                            {{ $pesanan->produkJasa->jurusan->nama_jurusan }}
                        </span>
                    @endif

                </div>

            </div>


            <div class="order-hero-total">

                <div class="order-hero-total-label">
                    Total Pesanan
                </div>

                <div class="order-hero-total-value">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>

                <div class="order-hero-total-item">
                    {{ $pesanan->jumlah }} item
                </div>

            </div>

        </div>


        <div class="order-hero-bottom">

            <div class="hero-stat">
                <div class="hero-stat-label">Tanggal Pesanan</div>
                <div class="hero-stat-value">
                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}
                </div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Harga Satuan</div>
                <div class="hero-stat-value">
                    Rp {{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Jumlah</div>
                <div class="hero-stat-value">
                    {{ $pesanan->jumlah }} item
                </div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Status</div>
                <div class="hero-stat-value">
                    {{ ucfirst($pesanan->status) }}
                </div>
            </div>

        </div>

    </div>


    {{-- =====================================================
         INFORMASI + CATATAN
    ====================================================== --}}

    <div class="two-column">

        <div class="prod-card">

            <div class="prod-card-body">

                <div class="prod-card-header">

                    <div>
                        <h4 class="prod-section-title">
                            <i class="ph ph-info"></i>
                            Informasi Pesanan
                        </h4>

                        <p class="prod-section-desc">
                            Informasi lengkap mengenai pesanan.
                        </p>
                    </div>

                </div>


                <div class="detail-grid">

                    <div>
                        <div class="detail-label">Tanggal Pesanan</div>

                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Harga Satuan</div>

                        <div class="detail-value">
                            Rp {{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Jumlah</div>

                        <div class="detail-value">
                            {{ $pesanan->jumlah }} item
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Total Harga</div>

                        <div class="detail-value">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>


        <div class="prod-card">

            <div class="prod-card-body">

                <h4 class="prod-section-title">
                    <i class="ph ph-note"></i>
                    Catatan Pembeli
                </h4>

                @if($pesanan->catatan)

                    <div class="buyer-note">
                        {{ $pesanan->catatan }}
                    </div>

                @else

                    <div class="empty-note">
                        Tidak ada catatan dari pembeli.
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =====================================================
         TAHAPAN PENGERJAAN
    ====================================================== --}}

    <div class="prod-card" style="margin-bottom:24px;">

        <div class="prod-card-body">

            <div class="prod-card-header">

                <div>
                    <h4 class="prod-section-title">
                        <i class="ph ph-list-numbers"></i>
                        Tahapan Pengerjaan
                    </h4>

                    <p class="prod-section-desc">
                        Atur tahapan pekerjaan pesanan ini.
                    </p>
                </div>


                @if($bolehKelola)

                    <button type="button"
                            class="prod-btn prod-btn-primary"
                            onclick="openModalTahapan()">

                        <i class="ph ph-list-plus"></i>
                        Kelola Tahapan

                    </button>

                @endif

            </div>


            @if(!$bolehKelola)

                <div class="prod-alert prod-alert-warning">

                    <i class="ph ph-info"></i>

                    <span>
                        Tahapan dan progress dapat dikelola setelah pesanan
                        berstatus <strong>diproses</strong>.
                    </span>

                </div>

            @endif


            @if($tahapanList->count())

                <div class="stepper-container">

                    @foreach($tahapanList as $index => $tahapan)

                        @php
                            $statusTahap = strtolower($tahapan->status);

                            if ($statusTahap === 'selesai') {
                                $circleClass = 'selesai';
                            } elseif (
                                $statusTahap === 'sedang dikerjakan' ||
                                $tahapan->persentase_progress > 0
                            ) {
                                $circleClass = 'proses';
                            } else {
                                $circleClass = 'belum';
                            }
                        @endphp

                        <div class="stepper-item">

                            @if(!$loop->last)
                                <div class="stepper-line"></div>
                            @endif

                            <div class="stepper-circle {{ $circleClass }}">
                                {{ $index + 1 }}
                            </div>


                            <div class="stepper-content">

                                <div class="stepper-top">

                                    <div>

                                        <h5 class="stepper-name">
                                            {{ $tahapan->nama_tahapan }}
                                        </h5>

                                        <span class="stepper-status">
                                            {{ $tahapan->status }}
                                        </span>

                                    </div>

                                    <div class="stepper-percent">
                                        {{ $tahapan->persentase_progress }}%
                                    </div>

                                </div>


                                <div class="mini-progress-bg">

                                    <div class="mini-progress-fill"
                                         style="width: {{ $tahapan->persentase_progress }}%;">
                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div style="
                    text-align:center;
                    padding:45px 20px;
                    color:var(--prod-text-sec);
                ">

                    <i class="ph ph-list-dashes"
                       style="font-size:48px;color:#CBD5E1;">
                    </i>

                    <p style="
                        margin:14px 0 5px;
                        font-size:14px;
                        font-weight:600;
                        color:var(--prod-text-main);
                    ">
                        Belum ada tahapan pengerjaan
                    </p>

                    @if($bolehKelola)

                        <p style="font-size:12px;margin:0 0 16px;">
                            Tambahkan tahapan agar proses pengerjaan
                            dapat dipantau.
                        </p>

                        <button type="button"
                                class="prod-btn prod-btn-primary"
                                onclick="openModalTahapan()">

                            <i class="ph ph-plus"></i>
                            Tambah Tahapan

                        </button>

                    @else

                        <p style="font-size:12px;margin:0;">
                            Tahapan belum dapat dibuat sebelum pesanan diproses.
                        </p>

                    @endif

                </div>

            @endif

        </div>

    </div>


    {{-- =====================================================
         PERBARUI PROGRESS
    ====================================================== --}}

    @if($bolehKelola)

        <div class="prod-card" style="margin-bottom:24px;">

            <div class="prod-card-body">

                <div class="prod-card-header">

                    <div>
                        <h4 class="prod-section-title">
                            <i class="ph ph-chart-line-up"></i>
                            Perbarui Progress
                        </h4>

                        <p class="prod-section-desc">
                            Catat perkembangan pengerjaan pesanan.
                        </p>
                    </div>

                </div>


                <form action="{{ route('produser.updateProgress', $pesanan->id_pesanan) }}"
                      method="POST">

                    @csrf

                    <div class="progress-layout">

                        <div class="form-group">

                            <label class="form-label-custom">
                                Progress Pengerjaan
                            </label>

                            <div class="range-wrapper">

                                <input
                                    type="range"
                                    class="range-slider"
                                    name="persentase_progress"
                                    id="updateProgress"
                                    min="0"
                                    max="100"
                                    value="0"
                                    oninput="
                                        document.getElementById('progressValue').innerText =
                                        this.value + '%';
                                    "
                                >

                                <span id="progressValue"
                                      class="range-value">
                                    0%
                                </span>

                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-label-custom">
                                Keterangan Progress
                            </label>

                            <input
                                type="text"
                                name="keterangan_progress"
                                class="custom-input"
                                maxlength="255"
                                placeholder="Contoh: Tahap desain sudah selesai."
                                required
                            >

                        </div>

                    </div>


                    <div style="margin-top:20px;">

                        <button type="submit"
                                class="prod-btn prod-btn-primary">

                            <i class="ph ph-floppy-disk"></i>
                            Simpan Progress

                        </button>

                    </div>

                </form>

            </div>

        </div>

    @endif


    {{-- =====================================================
         RIWAYAT PROGRESS
    ====================================================== --}}

    <div class="prod-card">

        <div class="prod-card-body">

            <div class="prod-card-header">

                <div>
                    <h4 class="prod-section-title">
                        <i class="ph ph-clock-counter-clockwise"></i>
                        Riwayat Progress
                    </h4>

                    <p class="prod-section-desc">
                        Riwayat perkembangan pengerjaan pesanan.
                    </p>
                </div>

            </div>


            @if($pesanan->progressPengerjaan->count())

                <div class="history-list">

                    @foreach($pesanan->progressPengerjaan->sortByDesc('tanggal_update') as $progress)

                        <div class="history-item">

                            <div class="history-marker-wrap">

                                <div class="history-marker"></div>

                                @if(!$loop->last)
                                    <div class="history-line"></div>
                                @endif

                            </div>


                            <div class="history-content">

                                <div>

                                    <div class="history-percent">
                                        {{ $progress->persentase_progress }}%
                                    </div>

                                    <div class="history-description">
                                        {{ $progress->keterangan_progress }}
                                    </div>

                                    <div class="history-user">
                                        Oleh:
                                        {{ $progress->pelaksana->nama ?? '-' }}
                                    </div>

                                </div>


                                <div class="history-date">

                                    {{ \Carbon\Carbon::parse($progress->tanggal_update)->translatedFormat('d M Y') }}

                                    <br>

                                    {{ \Carbon\Carbon::parse($progress->tanggal_update)->format('H:i') }}

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div style="
                    text-align:center;
                    padding:30px 10px;
                    color:var(--prod-text-sec);
                ">

                    <i class="ph ph-clock"
                       style="font-size:40px;color:#CBD5E1;">
                    </i>

                    <p style="
                        margin:10px 0 0;
                        font-size:13px;
                    ">
                        Belum ada riwayat progress.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>


{{-- =========================================================
     MODAL KELOLA TAHAPAN
========================================================= --}}

@if($bolehKelola)

    <div id="modalKelolaTahapan"
         class="prod-modal-overlay">

        <div class="prod-modal">

            <div class="prod-modal-header">

                <div>

                    <h3 class="prod-modal-title">
                        Kelola Tahapan Pengerjaan
                    </h3>

                    <p class="prod-modal-subtitle">
                        Tambah, ubah, hapus, atau atur urutan tahapan.
                    </p>

                </div>

                <button type="button"
                        class="prod-modal-close"
                        onclick="closeModalTahapan()">

                    <i class="ph ph-x"></i>

                </button>

            </div>


            <div class="prod-modal-body">

                <div style="
                    display:flex;
                    justify-content:flex-end;
                    margin-bottom:15px;
                ">

                    <button type="button"
                            class="prod-btn prod-btn-primary"
                            onclick="openFormTambahTahap()">

                        <i class="ph ph-plus"></i>
                        Tambah Tahapan

                    </button>

                </div>


                @if($tahapanList->count())

                    <div class="table-scroll">

                        <table class="stage-table">

                            <thead>

                                <tr>
                                    <th width="60">No.</th>
                                    <th>Tahapan</th>
                                    <th>Status</th>
                                    <th width="90">Progress</th>
                                    <th width="170">Aksi</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach($tahapanList as $index => $tahapan)

                                    <tr>

                                        <td>
                                            <strong>
                                                {{ $index + 1 }}
                                            </strong>
                                        </td>

                                        <td>
                                            <strong>
                                                {{ $tahapan->nama_tahapan }}
                                            </strong>
                                        </td>

                                        <td>
                                            <span class="stepper-status">
                                                {{ $tahapan->status }}
                                            </span>
                                        </td>

                                        <td>
                                            {{ $tahapan->persentase_progress }}%
                                        </td>

                                        <td>

                                            <div class="stage-actions">

                                                @if($index > 0)

                                                    <button
                                                        type="button"
                                                        class="icon-btn"
                                                        title="Naik"
                                                        onclick="reorderTahapan({{ $tahapan->id }}, 'up')">

                                                        <i class="ph ph-caret-up"></i>

                                                    </button>

                                                @endif


                                                @if($index < $tahapanList->count() - 1)

                                                    <button
                                                        type="button"
                                                        class="icon-btn"
                                                        title="Turun"
                                                        onclick="reorderTahapan({{ $tahapan->id }}, 'down')">

                                                        <i class="ph ph-caret-down"></i>

                                                    </button>

                                                @endif


                                                <button
                                                    type="button"
                                                    class="icon-btn"
                                                    title="Edit"
                                                    onclick="openEditTahap(
                                                        {{ $tahapan->id }},
                                                        @js($tahapan->nama_tahapan),
                                                        @js($tahapan->status),
                                                        {{ $tahapan->persentase_progress }}
                                                    )">

                                                    <i class="ph ph-pencil-simple"></i>

                                                </button>


                                                <form
                                                    action="{{ route('produser.tahapan.destroy', [
                                                        $pesanan->id_pesanan,
                                                        $tahapan->id
                                                    ]) }}"
                                                    method="POST"
                                                    style="margin:0;"
                                                    onsubmit="return confirm('Hapus tahapan ini?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="icon-btn danger"
                                                        title="Hapus">

                                                        <i class="ph ph-trash"></i>

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="modal-empty">
                        Belum ada tahapan.
                    </div>

                @endif

            </div>

        </div>

    </div>


    {{-- =====================================================
         MODAL TAMBAH / EDIT TAHAPAN
    ====================================================== --}}

    <div id="modalFormTahap"
         class="prod-modal-overlay">

        <div class="prod-modal small">

            <div class="prod-modal-header">

                <div>

                    <h3 class="prod-modal-title"
                        id="modalFormTahapTitle">

                        Tambah Tahapan

                    </h3>

                    <p class="prod-modal-subtitle">
                        Isi informasi tahapan pengerjaan.
                    </p>

                </div>

                <button type="button"
                        class="prod-modal-close"
                        onclick="closeModalFormTahap()">

                    <i class="ph ph-x"></i>

                </button>

            </div>


            <form
                id="formSimpanTahap"
                action="{{ route('produser.tahapan.store', $pesanan->id_pesanan) }}"
                method="POST">
                @csrf

                <div id="methodContainer"></div>


                <div class="prod-modal-body">

                    <div class="form-group"
                         style="margin-bottom:18px;">

                        <label class="form-label-custom">
                            Nama Tahapan
                        </label>

                        <input
                            type="text"
                            name="nama_tahapan"
                            id="inputNamaTahap"
                            class="custom-input"
                            maxlength="255"
                            placeholder="Contoh: Analisis Kebutuhan"
                            required
                        >

                    </div>


                    <div class="form-group"
                         style="margin-bottom:18px;">

                        <label class="form-label-custom">
                            Status
                        </label>

                        <select
                            name="status"
                            id="inputStatusTahap"
                            class="custom-select"
                            required>

                            <option value="Belum Dimulai">
                                Belum Dimulai
                            </option>

                            <option value="Sedang Dikerjakan">
                                Sedang Dikerjakan
                            </option>

                            <option value="Dalam Revisi">
                                Dalam Revisi
                            </option>

                            <option value="Selesai">
                                Selesai
                            </option>

                        </select>

                    </div>


                    <div class="form-group">

                        <label class="form-label-custom">
                            Progress
                        </label>

                        <div class="range-wrapper">

                            <input
                                type="range"
                                name="persentase_progress"
                                id="inputProgressTahap"
                                class="range-slider"
                                min="0"
                                max="100"
                                value="0"
                                oninput="
                                    document.getElementById('tahapProgressValue').innerText =
                                    this.value + '%';
                                "
                            >

                            <span
                                id="tahapProgressValue"
                                class="range-value">

                                0%

                            </span>

                        </div>

                    </div>

                </div>


                <div class="prod-modal-footer">

                    <button
                        type="button"
                        class="prod-btn prod-btn-secondary"
                        onclick="closeModalFormTahap()">

                        Batal

                    </button>

                    <button
                        type="submit"
                        class="prod-btn prod-btn-primary"
                        onclick="document.getElementById('formSimpanTahap').submit();">
                      
                        <i class="ph ph-floppy-disk"></i>
                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- FORM REORDER --}}
    <form
        id="formReorderTahapan"
        action="{{ route('produser.tahapan.reorder', $pesanan->id_pesanan) }}"
        method="POST"
        style="display:none;">

        @csrf

        <div id="reorderInputs"></div>

    </form>

@endif


<script>

    /* =====================================================
       MODAL
    ====================================================== */

    const modalKelolaTahapan =
        document.getElementById('modalKelolaTahapan');

    const modalFormTahap =
        document.getElementById('modalFormTahap');


    function openModalTahapan() {

        if (modalKelolaTahapan) {
            modalKelolaTahapan.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

    }


    function closeModalTahapan() {

        if (modalKelolaTahapan) {
            modalKelolaTahapan.classList.remove('active');
            document.body.style.overflow = '';
        }

    }


    function openFormTambahTahap() {

        document.getElementById('modalFormTahapTitle').innerText =
            'Tambah Tahapan';

        document.getElementById('formSimpanTahap').action =
            "{{ route('produser.tahapan.store', $pesanan->id_pesanan) }}";

        document.getElementById('methodContainer').innerHTML = '';

        document.getElementById('inputNamaTahap').value = '';

        document.getElementById('inputStatusTahap').value =
            'Belum Dimulai';

        document.getElementById('inputProgressTahap').value = 0;

        document.getElementById('tahapProgressValue').innerText =
            '0%';

        closeModalTahapan();

        setTimeout(function() {

            modalFormTahap.classList.add('active');

            document.body.style.overflow = 'hidden';

        }, 180);

    }


    function closeModalFormTahap() {

        if (modalFormTahap) {

            modalFormTahap.classList.remove('active');

            document.body.style.overflow = '';

        }

    }


    function openEditTahap(
        idTahapan,
        namaTahapan,
        statusTahapan,
        progressTahapan
    ) {

        document.getElementById('modalFormTahapTitle').innerText =
            'Edit Tahapan';

        document.getElementById('formSimpanTahap').action =
            "{{ url('/produser/pesanan/' . $pesanan->id_pesanan . '/tahapan') }}/"
            + idTahapan;

        document.getElementById('methodContainer').innerHTML =
            '<input type="hidden" name="_method" value="PUT">';

        document.getElementById('inputNamaTahap').value =
            namaTahapan;

        document.getElementById('inputStatusTahap').value =
            statusTahapan;

        document.getElementById('inputProgressTahap').value =
            progressTahapan;

        document.getElementById('tahapProgressValue').innerText =
            progressTahapan + '%';

        closeModalTahapan();

        setTimeout(function() {

            modalFormTahap.classList.add('active');

            document.body.style.overflow = 'hidden';

        }, 180);

    }


    /* =====================================================
       REORDER
    ====================================================== */

    function reorderTahapan(idTahapan, arah) {

        const rows = Array.from(
            document.querySelectorAll(
                '#modalKelolaTahapan tbody tr'
            )
        );

        const ids = rows.map(function(row) {

            const button = row.querySelector(
                'button[onclick*="openEditTahap"]'
            );

            if (!button) {
                return null;
            }

            const onclickText =
                button.getAttribute('onclick');

            const match =
                onclickText.match(
                    /openEditTahap\(\s*(\d+)/
                );

            return match
                ? parseInt(match[1])
                : null;

        }).filter(Boolean);


        const index = ids.indexOf(idTahapan);

        if (index === -1) {
            return;
        }


        if (
            arah === 'up' &&
            index > 0
        ) {

            [
                ids[index - 1],
                ids[index]
            ] = [
                ids[index],
                ids[index - 1]
            ];

        }


        if (
            arah === 'down' &&
            index < ids.length - 1
        ) {

            [
                ids[index],
                ids[index + 1]
            ] = [
                ids[index + 1],
                ids[index]
            ];

        }


        const container =
            document.getElementById('reorderInputs');

        container.innerHTML = '';


        ids.forEach(function(id) {

            const input =
                document.createElement('input');

            input.type = 'hidden';

            input.name = 'urutan[]';

            input.value = id;

            container.appendChild(input);

        });


        document
            .getElementById('formReorderTahapan')
            .submit();

    }


    /* =====================================================
       KLIK AREA GELAP MODAL
    ====================================================== */

    if (modalKelolaTahapan) {

        modalKelolaTahapan.addEventListener(
            'click',
            function(event) {

                if (event.target === modalKelolaTahapan) {
                    closeModalTahapan();
                }

            }
        );

    }


    if (modalFormTahap) {

        modalFormTahap.addEventListener(
            'click',
            function(event) {

                if (event.target === modalFormTahap) {
                    closeModalFormTahap();
                }

            }
        );

    }


    /* =====================================================
       ESC UNTUK MENUTUP MODAL
    ====================================================== */

    document.addEventListener(
        'keydown',
        function(event) {

            if (event.key === 'Escape') {

                closeModalTahapan();

                closeModalFormTahap();

            }

        }
    );

</script>

@endsection