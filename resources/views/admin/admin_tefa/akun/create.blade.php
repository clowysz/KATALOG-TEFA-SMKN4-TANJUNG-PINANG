@extends('admin.layouts.app')

@section('title', 'Tambah Akun')

@section('content')
<div class="page-header">
    <a href="/akun" class="btn-outline" style="margin-bottom: 16px;">← Kembali ke Daftar Akun</a>
    <h2>Tambah Akun Baru</h2>
    <p>Tambahkan admin baru untuk mengelola TEFA</p>
</div>

<div class="tefa-card" style="max-width: 600px;">
    <form id="formTambahAkun">
        <label for="nama" class="detail-label">Nama Pengguna</label>
        <input type="text" id="nama" class="form-control" placeholder="Masukkan nama" required>

        <label for="email" class="detail-label">Email</label>
        <input type="email" id="email" class="form-control" placeholder="Masukkan email" required>

        <label for="password" class="detail-label">Password</label>
        <input type="password" id="password" class="form-control" placeholder="Masukkan password" required>

        <label for="role" class="detail-label">Role</label>
        <select id="role" class="form-control" required>
            <option value="" disabled selected>Pilih Role...</option>
            <option value="Admin TEFA">Admin TEFA</option>
            <option value="Admin Jurusan">Admin Jurusan</option>
        </select>

        <!-- Area Jurusan (Disembunyikan secara default menggunakan CSS inline) -->
        <div id="jurusanContainer" style="display: none;">
            <label for="jurusan" class="detail-label">Jurusan</label>
            <select id="jurusan" class="form-control">
                <option value="" disabled selected>Pilih Jurusan...</option>
                <option value="Rekayasa Perangkat Lunak">Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                <option value="Animasi">Animasi</option>
                <option value="GIM">GIM</option>
                <option value="Produk Suara Program Televisi">Produk Suara Program Televisi</option>
            </select>
        </div>
        
        <!-- Teks panduan yang akan berubah-ubah -->
        <span id="helpTextJurusan" class="help-text">Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.</span>

        <button type="submit" class="btn-primary" style="margin-top: 16px;">Tambah Akun</button>
    </form>
</div>

<!-- Toast Notification -->
<div id="toastSuccess" class="toast-notification">
    ✓ Akun berhasil ditambahkan.
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection