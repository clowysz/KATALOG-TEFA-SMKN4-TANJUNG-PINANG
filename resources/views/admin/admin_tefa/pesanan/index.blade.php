@extends('admin.layouts.app')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="page-header">
    <h2>Kelola Pesanan</h2>
    <p>Daftar seluruh pesanan masuk Teaching Factory</p>
</div>

<div class="tefa-card">
    <!-- Area Filter & Search -->
    <div class="filter-bar">
        <input type="text" id="searchInput" class="search-input" placeholder="Cari pesanan, nama pembeli...">
        
        <select id="filterStatus" class="filter-select">
            <option value="Semua">Semua Status</option>
            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
            <option value="Dikonfirmasi">Dikonfirmasi</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
            <option value="Dibatalkan">Dibatalkan</option>
        </select>

        <select id="filterJurusan" class="filter-select">
            <option value="Semua">Semua Jurusan</option>
            <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
            <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
            <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
            <option value="Animasi">Animasi</option>
            <option value="GIM">GIM</option>
            <option value="Produk Suara Program Televisi">Produk Suara Program Televisi</option>
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
                <!-- Data Simulasi -->
                <tr>
                    <td class="col-id">ORD-001</td>
                    <td class="col-nama">Budi Santoso</td>
                    <td class="col-produk">Website UMKM</td>
                    <td class="col-jurusan">Rekayasa Perangkat Lunak</td>
                    <td>26 Agu 2026</td>
                    <td class="col-status"><span class="badge badge-pending">Menunggu Konfirmasi</span></td>
                    <td><a href="/pesanan/detail" class="btn-outline">Lihat Detail</a></td>
                </tr>
                <tr>
                    <td class="col-id">ORD-002</td>
                    <td class="col-nama">CV Maju Jaya</td>
                    <td class="col-produk">Desain Poster</td>
                    <td class="col-jurusan">Desain Komunikasi Visual</td>
                    <td>25 Agu 2026</td>
                    <td class="col-status"><span class="badge badge-processing">Diproses</span></td>
                    <td><a href="#" class="btn-outline">Lihat Detail</a></td>
                </tr>
                <tr>
                    <td class="col-id">ORD-003</td>
                    <td class="col-nama">Siti Aminah</td>
                    <td class="col-produk">Animasi 3D</td>
                    <td class="col-jurusan">Animasi</td>
                    <td>24 Agu 2026</td>
                    <td class="col-status"><span class="badge badge-done">Selesai</span></td>
                    <td><a href="#" class="btn-outline">Lihat Detail</a></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Empty State (Sembunyi secara default) -->
    <div id="emptyState" style="display: none; text-align: center; padding: 40px;">
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">Belum Ada Pesanan</h3>
        <p style="color: #6c757d;">Tidak ada pesanan yang sesuai dengan filter.</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/pesanan.js') }}"></script>
@endsection