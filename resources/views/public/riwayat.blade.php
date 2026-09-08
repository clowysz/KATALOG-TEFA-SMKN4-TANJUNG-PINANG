@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-pembeli.css') }}">
@endpush

@section('content')
<div class="page-wrapper-blue">
    <!-- Gelembung Dekorasi -->
    <div class="bubble" style="width: 150px; height: 150px; top: -50px; right: -50px; animation-duration: 8s;"></div>
    <div class="bubble" style="width: 80px; height: 80px; top: 20%; left: 5%; animation-duration: 6s;"></div>

    <div style="width: 100%; max-width: 1200px; z-index: 10;">
        <a href="/" class="btn-back-white" style="margin-bottom: 20px;">
            <i class="ph ph-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="riwayat-top-text">
        <h2><i class="ph ph-receipt"></i> Riwayat Pemesanan</h2>
        <p>Berikut adalah daftar riwayat pemesanan produk dan jasa yang pernah Anda pesan.</p>
    </div>

    <div class="r-card">
        <!-- Area Tab & Pencarian -->
        <div class="r-tools">
            <div class="r-tabs">
                <a href="#" class="r-tab active">Semua Pesanan</a>
                <a href="#" class="r-tab">Diproses</a>
                <a href="#" class="r-tab">Sedang Dikerjakan</a>
                <a href="#" class="r-tab">Selesai</a>
                <a href="#" class="r-tab">Dibatalkan</a>
            </div>
            <div class="r-search-group">
                <div class="r-search">
                    <i class="ph ph-magnifying-glass" style="color:#94A3B8"></i>
                    <input type="text" placeholder="Cari pesanan...">
                </div>
                <button class="btn-filter"><i class="ph ph-funnel"></i> Filter</button>
            </div>
        </div>

        <!-- Area Tabel -->
        <div class="r-table-wrapper">
            <table class="r-table">
                <thead>
                    <tr>
                        <th>Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Estimasi / Selesai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris 1 -->
                    <tr>
                        <td>
                            <div class="r-item">
                                <div class="r-item-icon"><i class="ph ph-code"></i></div>
                                <div class="r-item-text">
                                    <h4>Website Education</h4>
                                    <p>Rekayasa Perangkat Lunak<br>#RPL250825-001</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="r-text-main"><i class="ph ph-calendar-blank"></i> 25 Agustus 2026</div>
                            <div class="r-text-sub"><i class="ph ph-clock"></i> Qty: 1</div>
                        </td>
                        <td class="r-price">Rp 1.000.000</td>
                        <td><span class="s-badge s-kerja"><i class="ph ph-spinner-gap"></i> Sedang Dikerjakan</span></td>
                        <td>
                            <div class="r-text-main">Estimasi</div>
                            <div class="r-text-sub">7 - 14 Hari</div>
                        </td>
                        <td><a href="/riwayat-pesanan/detail" class="btn-detail-r">Detail Pesanan <i class="ph ph-caret-right"></i></a></td>
                    </tr>

                    <!-- Baris 2 -->
                    <tr>
                        <td>
                            <div class="r-item">
                                <div class="r-item-icon" style="background: #0284C7;"><i class="ph ph-squares-four"></i></div>
                                <div class="r-item-text">
                                    <h4>Aplikasi Dashboard</h4>
                                    <p>Rekayasa Perangkat Lunak<br>#RPL250810-002</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="r-text-main"><i class="ph ph-calendar-blank"></i> 10 Agustus 2026</div>
                            <div class="r-text-sub"><i class="ph ph-clock"></i> Qty: 1</div>
                        </td>
                        <td class="r-price">Rp 1.500.000</td>
                        <td><span class="s-badge s-proses"><i class="ph ph-arrows-clockwise"></i> Diproses</span></td>
                        <td>
                            <div class="r-text-main">Estimasi</div>
                            <div class="r-text-sub">3 - 7 Hari</div>
                        </td>
                        <td><a href="/riwayat-pesanan/detail" class="btn-detail-r">Detail Pesanan <i class="ph ph-caret-right"></i></a></td>
                    </tr>

                    <!-- Baris 3 -->
                    <tr>
                        <td>
                            <div class="r-item">
                                <div class="r-item-icon" style="background: #16A34A;"><i class="ph ph-device-mobile"></i></div>
                                <div class="r-item-text">
                                    <h4>Aplikasi Mobile Kasir</h4>
                                    <p>Rekayasa Perangkat Lunak<br>#RPL250801-003</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="r-text-main"><i class="ph ph-calendar-blank"></i> 01 Agustus 2026</div>
                            <div class="r-text-sub"><i class="ph ph-clock"></i> Qty: 1</div>
                        </td>
                        <td class="r-price">Rp 2.250.000</td>
                        <td><span class="s-badge s-selesai"><i class="ph ph-check-circle"></i> Selesai</span></td>
                        <td>
                            <div class="r-text-main">Selesai pada</div>
                            <div class="r-text-sub">12 Agustus 2026</div>
                        </td>
                        <td><a href="/riwayat-pesanan/detail" class="btn-detail-r">Detail Pesanan <i class="ph ph-caret-right"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection