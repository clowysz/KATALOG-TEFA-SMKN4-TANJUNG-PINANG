@extends('admin.layouts.app-produser')

@section('title', 'Pesanan Terkait')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pesanan-produser.css') }}">
@endpush

@section('content')
<div class="page-intro">
    <h2 class="page-intro-title">Pesanan Terkait</h2>
    <p class="page-intro-desc">Daftar semua pesanan untuk produk dan jasa yang Anda tangani.</p>
</div>

<div class="tefa-card order-card">

    <div class="search-box">
        <i class="ph ph-magnifying-glass search-box-icon"></i>
        <input type="text"
               id="searchPesanan"
               class="form-control"
               placeholder="Cari produk, jasa, atau pesanan..."
               aria-label="Cari pesanan">
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

            <tbody id="allOrderTable">
                @forelse($pesanans as $pesanan)
                    @php
                        $progressTerakhir = $pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                        $persentase = $progressTerakhir->persentase_progress ?? 0;
                        $statusPesanan = $pesanan->status;
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
                                    <div class="order-sub">
                                        {{ ucfirst($pesanan->produkJasa->jenis) }}
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td data-label="Jumlah">
                            <div class="order-strong">{{ $pesanan->jumlah }} item</div>
                        </td>

                        <td data-label="Status Pengerjaan">
                            <div class="progress-wrap">
                                <div class="progress-head">
                                    <span class="progress-label">Progress</span>
                                    <span class="progress-percent">{{ $persentase }}%</span>
                                </div>

                                <div class="progress-track">
                                    {{-- Satu-satunya style inline: lebar bar berasal dari data --}}
                                    <div class="progress-fill" style="width: {{ $persentase }}%;"></div>
                                </div>
                            </div>
                        </td>

                        <td data-label="Status Pesanan">
                            <span class="status-pill">{{ ucfirst($statusPesanan) }}</span>
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
                    <tr id="emptyOrderRow" class="empty-row">
                        <td colspan="6" class="empty-cell">
                            <i class="ph ph-receipt empty-cell-icon"></i>
                            <p class="empty-cell-text">Belum ada pesanan yang terkait dengan produk atau jasa Anda.</p>
                        </td>
                    </tr>
                @endforelse

                {{-- Ditampilkan oleh JS saat pencarian tidak menemukan hasil --}}
                <tr id="noResultRow" class="empty-row" hidden>
                    <td colspan="6" class="empty-cell">
                        <i class="ph ph-magnifying-glass empty-cell-icon"></i>
                        <p class="empty-cell-text">Tidak ada pesanan yang cocok dengan pencarian Anda.</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pesanan-produser.js') }}"></script>
@endpush