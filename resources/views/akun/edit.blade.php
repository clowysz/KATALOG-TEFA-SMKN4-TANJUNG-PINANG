@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')
<div class="page-header">
    <a href="/akun/detail" class="btn-outline" style="margin-bottom: 16px;">← Batal dan Kembali</a>
    <h2>Edit Akun</h2>
    <p>Perbarui informasi pengguna</p>
</div>

<div class="tefa-card" style="max-width: 600px;">
    <form id="formEditAkun" action="/akun/detail">
        <label for="nama" class="detail-label">Nama Pengguna</label>
        <input type="text" id="nama" class="form-control" value="Guru RPL" required>

        <label for="email" class="detail-label">Email</label>
        <input type="email" id="email" class="form-control" value="rpl@smkn4.sch.id" required>

        <label for="role" class="detail-label">Role</label>
        <select id="role" class="form-control" required>
            <option value="Admin TEFA">Admin TEFA</option>
            <option value="Admin Jurusan" selected>Admin Jurusan</option>
        </select>

        <div id="jurusanContainer">
            <label for="jurusan" class="detail-label">Jurusan</label>
            <select id="jurusan" class="form-control" required>
                <option value="Rekayasa Perangkat Lunak" selected>Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
                <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
            </select>
        </div>
        <span id="helpTextJurusan" class="help-text">Pilih jurusan yang menjadi tanggung jawab akun ini.</span>

        <label for="status" class="detail-label" style="margin-top: 16px;">Status Akun</label>
        <select id="status" class="form-control" required>
            <option value="Aktif" selected>Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>

        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <a href="/akun/detail" class="btn-outline" style="text-align:center; padding: 10px 16px;">Batal</a>
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection