@extends('admin.layouts.app')

@section('title','Daftar Akun')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/akun-tefa.css') }}?v=2">
@endpush

@section('content')

<div class="header-action page-header akun-page-header">

    <div>
        <h2 class="akun-page-title">
            Daftar Akun
        </h2>

        <p class="akun-page-subtitle">
            Kelola akses pengguna internal TEFA
        </p>
    </div>


    <a
        href="{{ route('akun.create') }}"
        class="btn-primary btn-tambah-akun"
    >
        + Tambah Akun
    </a>

</div>


@if(session('success'))

<div class="alert-custom alert-success">
    {{ session('success') }}
</div>

@endif


<div class="tefa-card">

    <!-- Area Filter & Search -->
    <div class="filter-bar">

        <input
            type="text"
            id="searchAkun"
            class="search-input"
            placeholder="Cari nama, email..."
        >


        <select
            id="filterRole"
            class="filter-select"
        >
            <option value="Semua">
                Semua Role
            </option>

            <option value="admin_tefa">
                Admin TEFA
            </option>

            <option value="admin_jurusan">
                Admin Jurusan
            </option>
        </select>


        <select
            id="filterStatusAkun"
            class="filter-select"
        >
            <option value="Semua">
                Semua Status
            </option>

            <option value="aktif">
                Aktif
            </option>

            <option value="tidak_aktif">
                Tidak Aktif
            </option>
        </select>

    </div>


    <!-- Tabel Akun (di layar kecil tampil sebagai kartu) -->
    <div class="table-responsive">

        <table
            class="tefa-table akun-table"
            id="akunTable"
        >

            <thead>

                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>

            </thead>


            <tbody>

                @forelse($akuns as $akun)

                <tr class="akun-row">

                    <td class="col-nama" data-label="Nama Pengguna">
                        {{ $akun->nama }}
                    </td>


                    <td class="col-email" data-label="Email">
                        {{ $akun->email }}
                    </td>


                    <td
                        class="col-role"
                        data-label="Role"
                        data-role="{{ $akun->role }}"
                    >

                        @if($akun->role === 'admin_tefa')

                            Admin TEFA

                        @else

                            Admin Jurusan

                        @endif

                    </td>


                    <td class="col-jurusan" data-label="Jurusan">

                        {{ $akun->jurusanDipegang->nama_jurusan ?? '-' }}

                    </td>


                    <td
                        class="col-status"
                        data-label="Status"
                        data-status="{{ $akun->status }}"
                    >

                        @if($akun->status === 'aktif')

                            <span class="badge badge-active">
                                Aktif
                            </span>

                        @else

                            <span class="badge badge-inactive">
                                Tidak Aktif
                            </span>

                        @endif

                    </td>


                    <td class="col-aksi" data-label="Aksi">

                        <a
                            href="{{ route('akun.show',$akun->id) }}"
                            class="btn-outline btn-lihat-detail"
                        >
                            Lihat Detail
                        </a>

                    </td>

                </tr>

                @empty

                <tr class="akun-empty-row">

                    <td
                        colspan="6"
                        class="akun-empty"
                    >

                        <h3 class="akun-empty-title">
                            Belum Ada Akun
                        </h3>

                        <p class="akun-empty-text">
                            Data akun saat ini masih kosong atau belum
                            ditambahkan ke dalam database.
                        </p>

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- Pesan ketika hasil filter/pencarian kosong (ditampilkan oleh akun.js) -->
    <div
        id="emptyAkun"
        class="akun-empty-filter"
        style="display:none;"
    >

        <h3 class="akun-empty-title">
            Akun Tidak Ditemukan
        </h3>

        <p class="akun-empty-text">
            Tidak ada akun yang sesuai dengan pencarian atau filter.
        </p>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/akun-index.js') }}"></script>

@endsection