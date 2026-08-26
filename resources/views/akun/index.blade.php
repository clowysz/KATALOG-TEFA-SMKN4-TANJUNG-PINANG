@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="header-action">
    <div>
        <h2>Daftar Akun</h2>
        <p>Kelola akses pengguna internal TEFA</p>
    </div>
    <!-- Tombol menuju halaman Tambah Akun -->
    <a href="/akun/tambah" class="btn-primary" style="text-decoration: none; width: auto;">+ Tambah Akun</a>
</div>

<div class="tefa-card">
    <!-- Area Filter & Search -->
    <div class="filter-bar">
        <input type="text" id="searchAkun" class="search-input" placeholder="Cari nama, email...">
        
        <select id="filterRole" class="filter-select">
            <option value="Semua">Semua Role</option>
            <option value="Admin TEFA">Admin TEFA</option>
            <option value="Admin Jurusan">Admin Jurusan</option>
        </select>

        <select id="filterStatusAkun" class="filter-select">
            <option value="Semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
    </div>

    <!-- Tabel Akun -->
    <div class="table-responsive">
        <table class="tefa-table" id="akunTable">
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
                <tr>
                    <td class="col-nama">Miftakhul Khoiriyah</td>
                    <td class="col-email">admin@gmail.com</td>
                    <td class="col-role">Admin TEFA</td>
                    <td class="col-jurusan">-</td>
                    <td class="col-status"><span class="badge badge-active">Aktif</span></td>
                    <!-- Tombol 1 Sudah Diperbaiki -->
                    <td><a href="/akun/detail" class="btn-outline btn-lihat-detail">Lihat Detail</a></td>
                </tr>
                <tr>
                    <td class="col-nama">Guru RPL</td>
                    <td class="col-email">rpl@smkn4.sch.id</td>
                    <td class="col-role">Admin Jurusan</td>
                    <td class="col-jurusan">Rekayasa Perangkat Lunak</td>
                    <td class="col-status"><span class="badge badge-active">Aktif</span></td>
                    <!-- Tombol 2 Sudah Diperbaiki -->
                    <td><a href="/akun/detail" class="btn-outline btn-lihat-detail">Lihat Detail</a></td>
                </tr>
                <tr>
                    <td class="col-nama">Mantan Admin</td>
                    <td class="col-email">oldadmin@gmail.com</td>
                    <td class="col-role">Admin TEFA</td>
                    <td class="col-jurusan">-</td>
                    <td class="col-status"><span class="badge badge-inactive">Tidak Aktif</span></td>
                    <!-- Tombol 3 Sudah Diperbaiki -->
                    <td><a href="/akun/detail" class="btn-outline btn-lihat-detail">Lihat Detail</a></td>    
                </tr>
            </tbody>
        </table>
    </div>

    <div id="emptyAkun" style="display: none; text-align: center; padding: 40px;">
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">Belum Ada Akun</h3>
        <p style="color: #6c757d;">Tidak ada akun yang sesuai dengan filter.</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection