@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/pesanan-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="page-header">

    <h2>
        Kelola Pesanan
    </h2>

    <p>
        Daftar seluruh pesanan Teaching Factory
    </p>

</div>


<div class="tefa-card">

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


    <!-- Area Filter & Search -->
    <div class="filter-bar">

        <input
            type="text"
            id="searchInput"
            class="search-input"
            placeholder="Cari pesanan, nama pembeli..."
        >


        <select
            id="filterStatus"
            class="filter-select"
        >
            <option value="Semua">
                Semua Status
            </option>

            <option value="menunggu konfirmasi">
                Menunggu Konfirmasi
            </option>

            <option value="konfirmasi">
                Konfirmasi
            </option>

            <option value="diproses">
                Diproses
            </option>

            <option value="selesai">
                Selesai
            </option>

            <option value="dibatalkan">
                Dibatalkan
            </option>
        </select>


        <select
            id="filterJurusan"
            class="filter-select"
        >
            <option value="Semua">
                Semua Jurusan
            </option>

            <option value="RPL">
                Rekayasa Perangkat Lunak
            </option>

            <option value="TKJ">
                Teknik Komputer dan Jaringan
            </option>

            <option value="DKV">
                Desain Komunikasi Visual
            </option>

            <option value="Animasi">
                Animasi
            </option>

            <option value="GIM">
                GIM
            </option>

            <option value="PSPT">
                Produksi dan Siaran Program Televisi
            </option>
        </select>

    </div>


    <!-- Tabel Pesanan (di layar kecil tampil sebagai kartu) -->
    <div class="table-responsive">

        <table
            class="tefa-table pesanan-table"
            id="pesananTable"
        >

            <thead>

                <tr>
                    <th>No. Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Produk/Jasa</th>
                    <th>Jurusan</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @forelse($pesanans ?? [] as $pesanan)

                    <tr
                        class="pesanan-row"
                        data-nama="{{ strtolower($pesanan->pembeli?->nama ?? '') }}"
                        data-produk="{{ strtolower($pesanan->produkJasa?->nama_produk_jasa ?? '') }}"
                        data-jurusan="{{ strtolower($pesanan->produkJasa?->jurusan?->nama_jurusan ?? '') }}"
                        data-status="{{ strtolower($pesanan->status ?? '') }}"
                    >

                        <td class="col-id" data-label="No. Pesanan">
                            #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                        </td>


                        <td class="col-nama" data-label="Nama Pembeli">
                            {{ $pesanan->pembeli?->nama ?? 'Data belum tersedia' }}
                        </td>


                        <td class="col-produk" data-label="Produk/Jasa">
                            {{ $pesanan->produkJasa?->nama_produk_jasa ?? 'Data belum tersedia' }}
                        </td>


                        <td class="col-jurusan" data-label="Jurusan">
                            {{ $pesanan->produkJasa?->jurusan?->nama_jurusan ?? 'Data belum tersedia' }}
                        </td>


                        <td data-label="Jumlah">
                            {{ $pesanan->jumlah }}
                        </td>


                        <td data-label="Total Harga">
                            Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>


                        <td data-label="Tanggal">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                        </td>


                    
<td class="col-status" data-label="Status">
    <div class="status-cell-content">
        <form
            action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
            method="POST"
            class="status-update-form"
        >
            @csrf

            <select
                name="status"
                class="status-update-select"
                required
                @disabled(
                    $pesanan->permintaanPembatalan &&
                    $pesanan->permintaanPembatalan->status_permintaan === 'menunggu'
                )
            >
                <option value="menunggu konfirmasi"
                    {{ $pesanan->status === 'menunggu konfirmasi' ? 'selected' : '' }}>
                    Menunggu Konfirmasi
                </option>
                <option value="konfirmasi"
                    {{ $pesanan->status === 'konfirmasi' ? 'selected' : '' }}>
                    Konfirmasi
                </option>
                <option value="diproses"
                    {{ $pesanan->status === 'diproses' ? 'selected' : '' }}>
                    Diproses
                </option>
                <option value="selesai"
                    {{ $pesanan->status === 'selesai' ? 'selected' : '' }}>
                    Selesai
                </option>
                <option value="dibatalkan"
                    {{ $pesanan->status === 'dibatalkan' ? 'selected' : '' }}>
                    Dibatalkan
                </option>
            </select>

            <button
                type="submit"
                class="btn-update-pesanan"
                @disabled(
                    $pesanan->permintaanPembatalan &&
                    $pesanan->permintaanPembatalan->status_permintaan === 'menunggu'
                )
            >
                Update
            </button>
        </form>

        @if(
            $pesanan->permintaanPembatalan &&
            $pesanan->permintaanPembatalan->status_permintaan === 'menunggu'
        )
            <div class="cancellation-table-notice">
                <span class="cancellation-badge pending">
                    Pembatalan diajukan
                </span>
                <p>Menunggu keputusan Admin TEFA</p>
            </div>
        @endif
    </div>
</td>

                        <td class="col-aksi" data-label="Aksi">

                            <a
                                href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}"
                                class="btn-detail-pesanan"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>


                @empty

                    <tr class="pesanan-empty-row">

                        <td
                            colspan="9"
                            class="pesanan-empty"
                        >

                            <h3 class="pesanan-empty-title">
                                Belum Ada Pesanan
                            </h3>

                            <p class="pesanan-empty-text">
                                Belum ada pesanan masuk ke TEFA SMKN 4
                                Tanjungpinang saat ini.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pesan ketika hasil filter/pencarian kosong (ditampilkan oleh pesanan.js) -->
    <div
        id="emptyPesanan"
        class="pesanan-empty-filter"
        style="display:none;"
    >

        <h3 class="pesanan-empty-title">
            Pesanan Tidak Ditemukan
        </h3>

        <p class="pesanan-empty-text">
            Tidak ada pesanan yang sesuai dengan pencarian atau filter.
        </p>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/pesanan.js') }}"></script>

@endsection 