@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')

<style>
    .page-header {
        margin-top: 3px;
        margin-bottom: 24px;
    }

    .page-header h2 {
        font-size: 20px;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 0;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* =========================
       TOMBOL UPDATE & DETAIL
       ========================= */

    .btn-update-pesanan,
    .btn-detail-pesanan {
        display: inline-block;
        text-decoration: none;
        padding: 8px 14px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        color: #1E3A8A;
        background: #F8FAFC;
        font-weight: 600;
        font-size: 13px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-update-pesanan:hover,
    .btn-detail-pesanan:hover {
        background: #E2E8F0;
        color: #1E293B;
        border-color: #CBD5E1;
    }

    .btn-update-pesanan:active,
    .btn-detail-pesanan:active {
        background: #CBD5E1;
    }

    /* =========================
       STATUS SELECT
       ========================= */

    .status-update-form {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .status-update-select {
        padding: 8px 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        background: #fff;
        color: #334155;
        font-size: 13px;
        outline: none;
        cursor: pointer;
    }

    .status-update-select:focus {
        border-color: #3B698F;
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
    }
    /* =========================
   ALERT
   ========================= */

.pesanan-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 20px;
    font-size: 14px;
    line-height: 1.5;
}

.pesanan-alert i {
    font-size: 18px;
    flex-shrink: 0;
    margin-top: 1px;
}

.pesanan-alert-success {
    background: #ecfdf5;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.pesanan-alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

    /* =========================
       RESPONSIVE
       ========================= */

    @media (max-width: 768px) {
        .status-update-form {
            flex-direction: column;
            align-items: stretch;
        }

        .status-update-select,
        .btn-update-pesanan,
        .btn-detail-pesanan {
            width: 100%;
            box-sizing: border-box;
            text-align: center;
        }
    }

    /* Mengecilkan teks seluruh isi tabel */
.tefa-table th,
.tefa-table td {
    font-size: 15px;
}
</style>


<div class="page-header">

    <h2>
        Kelola Pesanan
    </h2>

    <p>
        Daftar seluruh pesanan Teaching Factory
    </p>

</div>


<div class="tefa-card">

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


    <!-- Tabel Pesanan -->
    <div class="table-responsive">

        <table
            class="tefa-table"
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

                        <td class="col-id">
                            #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                        </td>


                        <td class="col-nama">
                            {{ $pesanan->pembeli?->nama ?? 'Data belum tersedia' }}
                        </td>


                        <td class="col-produk">
                            {{ $pesanan->produkJasa?->nama_produk_jasa ?? 'Data belum tersedia' }}
                        </td>


                        <td class="col-jurusan">
                            {{ $pesanan->produkJasa?->jurusan?->nama_jurusan ?? 'Data belum tersedia' }}
                        </td>


                        <td>
                            {{ $pesanan->jumlah }}
                        </td>


                        <td>
                            Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </td>


                        <td>
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}
                        </td>


                        <td class="col-status">

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


                                <button
                                    type="submit"
                                    class="btn-update-pesanan"
                                >
                                    Update
                                </button>

                            </form>

                        </td>


                        <td>

                            <a
                                href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}"
                                class="btn-detail-pesanan"
                            >
                                Detail
                            </a>

                        </td>

                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="9"
                            style="text-align:center;padding:60px 20px;"
                        >

                            <h3
                                style="
                                    color:#1e293b;
                                    margin-bottom:8px;
                                    font-size:18px;
                                "
                            >
                                Belum Ada Pesanan
                            </h3>


                            <p
                                style="
                                    color:#64748b;
                                    font-size:14px;
                                "
                            >
                                Belum ada pesanan masuk ke TEFA SMKN 4
                                Tanjungpinang saat ini.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pesan ketika hasil filter/pencarian kosong -->
    <div
        id="emptyPesanan"
        style="
            display:none;
            text-align:center;
            padding:40px 20px;
        "
    >

        <h3
            style="
                color:#1e293b;
                margin-bottom:8px;
                font-size:18px;
            "
        >
            Pesanan Tidak Ditemukan
        </h3>


        <p
            style="
                color:#64748b;
                font-size:14px;
            "
        >
            Tidak ada pesanan yang sesuai dengan pencarian atau filter.
        </p>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/pesanan.js') }}"></script>

@endsection