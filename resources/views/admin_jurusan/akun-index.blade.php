@extends('layouts.app-jurusan')

@section('title', 'Daftar Akun')

@section('content')
<div class="header-action">
    <div>
        <h2>Daftar Akun</h2>
        <p>Kelola Admin Produser untuk mengelola produk dan jasa</p>
    </div>
    <a href="/jurusan-admin/akun/tambah" class="btn-primary" style="text-decoration: none; width: auto;">+ Tambah Akun</a>
</div>

<div class="tefa-card" style="padding: 24px;">
    <div class="filter-bar" style="margin-bottom: 24px;">
        <input type="text" id="searchAkun" class="search-input" placeholder="Cari nama, email..." style="margin-bottom: 0;">
        
        <select id="filterStatus" class="filter-select" style="margin-bottom: 0;">
            <option value="Semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>

        <select id="filterLayanan" class="filter-select" style="margin-bottom: 0;">
            <option value="Semua">Semua Produk/Jasa</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table-modern">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggung Jawab</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="akunTableBody">
                <!-- Data dari Figma akan dimuat di sini oleh JS -->
            </tbody>
        </table>
    </div>
    
    <div id="emptyAkun" style="display: none; text-align: center; padding: 40px;">
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">Belum Ada Akun</h3>
        <p style="color: #6c757d;">Tidak ada akun yang sesuai dengan pencarian Anda.</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun-jurusan.js') }}"></script>
@endsection