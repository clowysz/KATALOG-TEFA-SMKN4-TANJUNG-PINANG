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
                    @forelse($riwayats ?? [] as $item)
                        <!-- Template Baris Data Riwayat -->
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
                    @empty
                        <!-- Empty State Tabel Riwayat -->
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 60px 20px; background: white;">
                                <i class="ph ph-receipt" style="font-size: 48px; color: #94A3B8; margin-bottom: 16px; display: inline-block;"></i>
                                <h3 style="font-size: 16px; font-weight: 600; color: #1E2D3D; margin-bottom: 8px;">Belum ada data pesanan</h3>
                                <p style="font-size: 14px; color: #64748B; margin: 0;">Anda belum melakukan pemesanan produk atau jasa apapun.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection