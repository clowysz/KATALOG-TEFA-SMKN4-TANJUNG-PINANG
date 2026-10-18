@extends('admin.layouts.app-produser')

@section('title', 'Dashboard')

@push('styles')
    {{-- pesanan-produser.css dipakai ulang untuk tabel pesanan --}}
    <link rel="stylesheet" href="{{ asset('css/pesanan-produser.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-produser.css') }}">
@endpush

@section('content')
<div class="page-intro dashboard-intro">
    <h2 class="page-intro-title">Dashboard</h2>
    <p class="page-intro-desc">Pantau pesanan yang berkaitan dengan produk atau jasa yang menjadi tanggung jawab Anda.</p>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="stat-grid">

    <div class="tefa-card stat-card">
        <div>
            <div class="stat-label">Produk/Jasa Saya</div>
            <div class="stat-value">{{ $totalProdukSaya }}</div>
        </div>
        <div class="stat-icon">
            <i class="ph ph-package"></i>
        </div>
    </div>

    <div class="tefa-card stat-card">
        <div>
            <div class="stat-label">Pesanan Masuk</div>
            <div class="stat-value">{{ $totalPesananMasuk }}</div>
        </div>
        <div class="stat-icon">
            <i class="ph ph-receipt"></i>
        </div>
    </div>

</div>

{{-- ================= PESANAN TERKAIT ================= --}}
<div class="tefa-card order-card dashboard-card">

    <div class="dashboard-card-header">
        <div>
            <h3 class="dashboard-card-title">Pesanan Terkait</h3>
            <p class="dashboard-card-desc">Pesanan yang sedang diproses untuk produk/jasa Anda.</p>
        </div>

        <a href="{{ route('admin.produser.pesanan') }}" class="prod-btn prod-btn-primary">
            Lihat Semua Pesanan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-modern order-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Produk/Jasa</th>
                    <th>Jumlah</th>
                    <th>Status Pengerjaan</th>
                    <th>Status Pesanan</th>
                    <th class="cell-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pesananMasuk as $pesanan)
                    @php
                        $progressTerakhir = $pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                        $persentase = $progressTerakhir->persentase_progress ?? 0;
                    @endphp

                    <tr class="order-row">
                        <td class="cell-id" data-label="Order ID">
                            <div class="order-id">#{{ $pesanan->id_pesanan }}</div>

                            @if($pesanan->tanggal_pesan)
                                <div class="order-sub">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                                </div>
                            @endif
                        </td>

                        <td data-label="Produk/Jasa">
                            <div>
                                <div class="order-strong">
                                    {{ $pesanan->produkJasa->nama_produk_jasa ?? '-' }}
                                </div>

                                @if($pesanan->produkJasa)
                                    <div class="order-sub">{{ ucfirst($pesanan->produkJasa->jenis) }}</div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Jumlah">
                            <span class="order-strong">{{ $pesanan->jumlah }} item</span>
                        </td>

                        <td data-label="Status Pengerjaan">
                            <div class="progress-wrap">
                                <div class="progress-head">
                                    <span class="progress-label">Progress</span>
                                    <span class="progress-percent">{{ $persentase }}%</span>
                                </div>

                                <div class="progress-track">
                                    {{-- Style inline hanya untuk lebar bar (nilai dari data) --}}
                                    <div class="progress-fill" style="width: {{ $persentase }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status Pesanan">
                            <span class="status-pill">{{ ucfirst($pesanan->status) }}</span>
                        </td>

                        <td class="cell-center cell-action">
                            <a href="{{ route('admin.produser.pesanan.detail', $pesanan->id_pesanan) }}"
                               class="prod-btn prod-btn-primary prod-btn-small">
                                <i class="ph ph-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="6" class="empty-cell">
                            <i class="ph ph-receipt empty-cell-icon"></i>
                            <p class="empty-cell-text">Belum ada pesanan yang sedang diproses untuk produk atau jasa Anda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection