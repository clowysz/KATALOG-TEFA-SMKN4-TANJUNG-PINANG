<<<<<<< HEAD:resources/views/admin/admin_tefa/pesanan/index.blade.php
@extends('admin.layouts.app')
=======


>>>>>>> 2846f9b (update sistem admin TEFA):resources/views/pesanan/index.blade.php

@section('title', 'Kelola Pesanan')

@section('content')
<div class="page-header">
    <h2>Kelola Pesanan</h2>
    <p>Daftar seluruh pesanan masuk Teaching Factory</p>
</div>

<div class="tefa-card">

    <!-- Pesan berhasil -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pesan error -->
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
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

        <select id="filterStatus" class="filter-select">

    <option value="Semua">Semua Status</option>

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

        <select id="filterJurusan" class="filter-select">
            <option value="Semua">Semua Jurusan</option>
            <option value="RPL">Rekayasa Perangkat Lunak</option>
            <option value="TKJ">Teknik Komputer dan Jaringan</option>
            <option value="DKV">Desain Komunikasi Visual</option>
            <option value="Animasi">Animasi</option>
            <option value="GIM">GIM</option>
            <option value="PSPT">Produk Suara Program Televisi</option>
        </select>

    </div>

    <!-- Tabel Pesanan -->
    <div class="table-responsive">

        <table class="tefa-table" id="pesananTable">

            <thead>
                <tr>
                    <th>No. Pesanan</th>
                    <th>Nama Pembeli</th>
                    <th>Produk/Jasa</th>
                    <th>Jurusan</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($pesanans as $pesanan)

                <tr>

                    <td class="col-id">
                        {{ $pesanan->no_pesanan }}
                    </td>

                    <td class="col-nama">
                        {{ $pesanan->nama_pembeli }}
                    </td>

                    <td class="col-produk">
                        {{ $pesanan->produk_jasa }}
                    </td>

                    <td class="col-jurusan">
                        {{ $pesanan->jurusan }}
                    </td>

                    <td>
                        {{ \Carbon\Carbon::parse($pesanan->tanggal)->format('d M Y') }}
                    </td>

                    <td class="col-status">

                        <form
                            action="{{ route('pesanan.updateStatus', $pesanan->id) }}"
                            method="POST"
                            style="display: flex; gap: 5px; align-items: center;"
                        >

                            @csrf
                            @method('PUT')

            <select
                    name="status"
                    id="modalStatus"
                    class="filter-select"
                    required
                    >
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


                    </td>

                    <td>

                            <button
                                type="submit"
                                class="btn-outline"
                            >
                                Update
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        Belum Ada Pesanan
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- Empty State -->
    <div
        id="emptyState"
        style="display: none; text-align: center; padding: 40px;"
    >
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">
            Belum Ada Pesanan
        </h3>

        <p style="color: #6c757d;">
            Tidak ada pesanan yang sesuai dengan filter.
        </p>
    </div>

</div>


@section('scripts')
<script src="{{ asset('js/pesanan.js') }}"></script>
@endsection
