@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/pesanan-tefa.css') }}?v=2">
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

    
{{-- NOTIFIKASI PERMINTAAN PEMBATALAN --}}
@if($jumlahPermintaanPembatalan > 0)
    <div class="cancellation-notification">
        <div class="cancellation-notification-message">
            <i class="ph ph-hourglass"></i>

            <span>
                Ada <strong>{{ $jumlahPermintaanPembatalan }}
                permintaan pembatalan</strong> dari pembeli
                yang menunggu keputusan Admin TEFA.
                Buka daftar untuk memeriksanya.
            </span>
        </div>

        <button
            type="button"
            id="toggleCancellationList"
            class="btn-toggle-cancellation"
            aria-expanded="false"
            aria-controls="cancellationList"
        >
            Tampilkan
        </button>
    </div>

    {{-- DAFTAR KHUSUS PERMINTAAN PEMBATALAN --}}
    <div id="cancellationList" class="cancellation-list" hidden>
        <div class="cancellation-list-heading">
            <h3>Daftar Permintaan Pembatalan</h3>

            <span>
                {{ $jumlahPermintaanPembatalan }} permintaan menunggu
            </span>
        </div>

        
<div class="cancellation-filter-bar">

    <input
        type="text"
        id="searchCancellation"
        class="search-input"
        placeholder="Cari nomor pesanan, pembeli, produk..."
    >

    <select id="filterCancellationJurusan" class="filter-select">
    <option value="semua">Semua Jurusan</option>
    <option value="rpl">Rekayasa Perangkat Lunak</option>
    <option value="tkj">Teknik Komputer dan Jaringan</option>
    <option value="dkv">Desain Komunikasi Visual</option>
    <option value="animasi">Animasi</option>
    <option value="gim">Gim</option>
    <option value="pspt">Produksi dan Siaran Program Televisi</option>
    </select>

</div>


        <div class="table-responsive">
           <table class="tefa-table cancellation-pesanan-table">
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
    @foreach($permintaanPembatalan as $permintaan)
        @php
            $pesananBatal = $permintaan->pesanan;
        @endphp

        @if($pesananBatal)
            <tr
                class="cancellation-row"
                data-id="ORD-{{ $pesananBatal->id_pesanan }}"
                data-nama="{{ strtolower($pesananBatal->pembeli?->nama ?? '') }}"
                data-produk="{{ strtolower($pesananBatal->produkJasa?->nama_produk_jasa ?? '') }}"
                data-jurusan="{{ strtolower($pesananBatal->produkJasa?->jurusan?->nama_jurusan ?? '') }}"
            >
                <td data-label="No. Pesanan">
                    #ORD-{{ str_pad($pesananBatal->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                </td>

                <td data-label="Nama Pembeli">
                    {{ $pesananBatal->pembeli?->nama ?? 'Data belum tersedia' }}
                </td>

                <td data-label="Produk/Jasa">
                    {{ $pesananBatal->produkJasa?->nama_produk_jasa ?? 'Data belum tersedia' }}
                </td>

                <td data-label="Jurusan">
                    {{ $pesananBatal->produkJasa?->jurusan?->nama_jurusan ?? 'Data belum tersedia' }}
                </td>

                <td data-label="Jumlah">
                    {{ $pesananBatal->jumlah }}
                </td>

                <td data-label="Total Harga">
                    Rp{{ number_format($pesananBatal->total_harga, 0, ',', '.') }}
                </td>

                <td data-label="Tanggal">
                    {{ \Carbon\Carbon::parse($pesananBatal->tanggal_pesan)->format('d M Y') }}
                </td>

                <td data-label="Status">
                    <span class="cancellation-badge pending">
                        Permintaan Pembatalan
                    </span>
                </td>

                <td data-label="Aksi">
                    <a
                        href="{{ route('pesanan.detail', $pesananBatal->id_pesanan) }}"
                        class="btn-detail-pesanan"
                    >
                        Detail
                    </a>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>

            </table>
            <p id="emptyCancellation" class="pesanan-empty-filter" hidden>
            Tidak ada permintaan pembatalan yang sesuai.
            </p>
        </div>
    </div>
@endif

{{-- PEMBUNGKUS HALAMAN SEMUA PESANAN --}}
<div id="mainPesananContent">

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
            <option value="permintaan pembatalan">
            Permintaan Pembatalan
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

        @if(
            $pesanan->permintaanPembatalan &&
            $pesanan->permintaanPembatalan->status_permintaan === 'menunggu'
        )
            <div class="cancellation-table-notice">
                <span class="cancellation-badge pending">
                    Pembatalan diajukan
                </span>
            </div>
        @else
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
                >
                    Update
                </button>
            </form>
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
    {{-- AKHIR PEMBUNGKUS HALAMAN SEMUA PESANAN --}}

</div>
{{-- AKHIR TEFA CARD --}}

@endsection




@section('scripts')

<script src="{{ asset('js/pesanan.js') }}?v=3"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggleCancellationList');
    const cancellationList = document.getElementById('cancellationList');
    const mainPesananContent = document.getElementById('mainPesananContent');

    // ==========================================
    // TOMBOL TAMPILKAN / SEMBUNYIKAN
    // ==========================================
    if (toggleButton && cancellationList && mainPesananContent) {
        toggleButton.addEventListener('click', function () {
            const sedangTerbuka = !cancellationList.hidden;

            cancellationList.hidden = sedangTerbuka;
            mainPesananContent.hidden = !sedangTerbuka;

            toggleButton.textContent = sedangTerbuka
                ? 'Tampilkan'
                : 'Sembunyikan';

            toggleButton.setAttribute(
                'aria-expanded',
                sedangTerbuka ? 'false' : 'true'
            );
        });
    }

    // ==========================================
    // FILTER PERMINTAAN PEMBATALAN
    // ==========================================
    const searchInput = document.getElementById('searchCancellation');
    const filterJurusan = document.getElementById('filterCancellationJurusan');
    const rows = document.querySelectorAll(
        '#cancellationList tr.cancellation-row'
    );
    const emptyMessage = document.getElementById('emptyCancellation');

    function normalisasi(teks) {
        return (teks || '')
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .trim()
            .toLowerCase()
            .replace(/\s+/g, ' ');
    }

    const aliasJurusan = {
        rpl: ['rekayasa perangkat lunak', 'rpl'],
        tkj: ['teknik komputer dan jaringan', 'tkj'],
        dkv: ['desain komunikasi visual', 'dkv'],
        animasi: ['animasi'],
       gim: ['pengembangan gim','gim'],
        pspt: [
            'produksi dan siaran program televisi',
            'pspt'
        ]
    };

    function filterPermintaanPembatalan() {
        const keyword = normalisasi(searchInput?.value);
        const pilihan = normalisasi(filterJurusan?.value || 'semua');

        let jumlahTampil = 0;

        rows.forEach(function (row) {
            const nomor = normalisasi(row.dataset.id);
            const nama = normalisasi(row.dataset.nama);
            const produk = normalisasi(row.dataset.produk);
            const jurusan = normalisasi(row.dataset.jurusan);

            const cocokPencarian =
                nomor.includes(keyword) ||
                nama.includes(keyword) ||
                produk.includes(keyword) ||
                jurusan.includes(keyword);

            const aliasTerpilih = aliasJurusan[pilihan] || [];

            const cocokJurusan =
                pilihan === 'semua' ||
                aliasTerpilih.includes(jurusan);

            const tampilkan = cocokPencarian && cocokJurusan;

            // Paksa perubahan display agar mengalahkan CSS !important.
            row.style.setProperty(
                'display',
                tampilkan ? 'table-row' : 'none',
                'important'
            );

            if (tampilkan) {
                jumlahTampil++;
            }
        });

        if (emptyMessage) {
            emptyMessage.hidden = jumlahTampil > 0;
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterPermintaanPembatalan);
    }

    if (filterJurusan) {
        filterJurusan.addEventListener('change', filterPermintaanPembatalan);
    }

    filterPermintaanPembatalan();
});
</script>

@endsection
