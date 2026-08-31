@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Portofolio')

@section('content')
<div class="header-action" style="align-items: center;">
    <div>
        <h2>Kelola Portofolio</h2>
        <p>Kelola daftar karya dan proyek Rekayasa Perangkat Lunak</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <input type="text" id="searchPorto" class="search-input" placeholder="Cari portofolio..." style="width: 250px; margin-bottom: 0;">
        <button onclick="openPortoModal('modalAddPorto')" class="btn-primary" style="width: auto; background-color: #5F9275;">+ Tambah Portofolio</button>
    </div>
</div>

<div id="portoContainer" class="portfolio-grid">
    <!-- Card Portofolio akan dimuat oleh JS -->
</div>

<!-- MODAL TAMBAH/EDIT PORTOFOLIO -->
<div id="modalAddPorto" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-title" id="modalPortoTitle">Tambah Portofolio</div>
        <form id="formPorto">
            <input type="hidden" id="portoId">
            <label class="detail-label">Judul Portofolio</label>
            <input type="text" id="portoTitle" class="form-control" required>
            
            <label class="detail-label">Deskripsi Singkat</label>
            <textarea id="portoDesc" class="form-control" rows="3" required></textarea>
            
            <label class="detail-label">Tahun / Periode</label>
            <input type="text" id="portoYear" class="form-control" placeholder="Contoh: 2026" required>
            
            <label class="detail-label">Link URL Gambar (Unsplash)</label>
            <input type="url" id="portoImg" class="form-control" placeholder="https://..." required>
            
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closePortoModal('modalAddPorto')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto; background-color: #5F9275;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PORTOFOLIO -->
<div id="modalDeletePorto" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Hapus Portofolio?</div>
        <div class="modal-desc">Data portofolio yang dihapus tidak dapat dikembalikan.</div>
        <input type="hidden" id="deletePortoId">
        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closePortoModal('modalDeletePorto')">Batal</button>
            <button type="button" id="btnConfirmDeletePorto" class="btn-primary" style="width: auto; background-color: #dc3545;">Hapus</button>
        </div>
    </div>
</div>

<div id="toastPorto" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/kelola-portofolio.js') }}"></script>
@endsection