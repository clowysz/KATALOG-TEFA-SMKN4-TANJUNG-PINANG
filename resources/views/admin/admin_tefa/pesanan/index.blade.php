@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<style>
    .page-header {
        margin-top: 20px;
        margin-bottom: 24px;
    }

    .page-header p {
        color: #64748b;
        font-size: 15px;
        margin: 0;
    }

    .page-header h2 {
        margin-bottom: 6px;
    }
</style>

<div class="page-header">
    <h2>Kelola Pesanan</h2>
    <p>Daftar seluruh pesanan masuk Teaching Factory</p>
</div>

<div class="tefa-card">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="filter-bar">
        <input
            type="text"
            id="searchInput"
            class="search-input"
            placeholder="Cari pesanan, nama pembeli..."
        >

        <select id="filterStatus" class="filter-select">
            <option value="Semua">Semua Status</option>
            <option value="menunggu konfirmasi">Menunggu Konfirmasi</option>
            <option value="konfirmasi">Konfirmasi</option>
            <option value="diproses">Diproses</option>
            <option value="selesai">Selesai</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>

        <select id="filterJurusan" class="filter-select">
            <option value="Semua">Semua Jurusan</option>
            <option value="RPL">Rekayasa Perangkat Lunak</option>
            <option value="TKJ">Teknik Komputer dan Jaringan</option>
            <option value="DKV">Desain Komunikasi Visual</option>
            <option value="Animasi">Animasi</option>
            <option value="GIM">GIM</option>
            <option value="PSPT">Produksi dan Siaran Program Televisi</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="tefa-table" id="pesananTable">

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
                                style="display: flex; gap: 5px; align-items: center;"
                            >
                                @csrf

                                <select
                                    name="status"
                                    class="filter-select"
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
                                    class="btn-outline"
                                >
                                    Update
                                </button>

                            </form>

                        </td>

                        <td>
                            <a
                                href="{{ route('pesanan.detail', $pesanan->id_pesanan) }}"
                                class="btn-outline"
                                style="text-decoration: none; display: inline-block;"
                            >
                                Detail
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="9"
                            style="text-align: center; padding: 60px 20px;"
                        >
                            <h3
                                style="color: #1e293b; margin-bottom: 8px; font-size: 18px;"
                            >
                                Belum Ada Pesanan
                            </h3>

                            <p
                                style="color: #64748b; font-size: 14px;"
                            >
                                Belum ada pesanan masuk ke TEFA SMKN 4 Tanjungpinang saat ini.
                            </p>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>
@endsection

@section('scripts')
<script src="{{ asset('js/pesanan.js') }}"></script>
@endsection