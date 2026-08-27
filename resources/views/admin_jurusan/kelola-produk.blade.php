@extends('layouts.app-jurusan')

@section('title', 'Kelola Produk')

@section('content')
<div class="header-action" style="align-items: center;">
    <div>
        <h2>Kelola Produk</h2>
        <p>Tambah, ubah, atau hapus produk jurusan</p>
    </div>
    <div style="display: flex; gap: 12px;">
        <input type="text" id="searchItem" class="search-input" placeholder="Cari produk..." style="width: 250px; margin-bottom: 0;">
        <button onclick="openLayananModal('modalAdd')" class="btn-primary" style="width: auto;">+ Tambah Produk</button>
    </div>
</div>

<div id="kelolaProdukContainer" class="catalog-grid">
    <!-- Card akan dimuat oleh JS -->
</div>

<!-- MODAL TAMBAH/EDIT (Digunakan Bersamaan) -->
<div id="modalAdd" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-title" id="modalFormTitle">Tambah Produk</div>
        <form id="formLayanan">
            <input type="hidden" id="formId">
            <label class="detail-label">Nama Produk</label>
            <input type="text" id="formName" class="form-control" required>
            
            <label class="detail-label">Deskripsi Produk</label>
            <textarea id="formDesc" class="form-control" rows="3" required></textarea>
            
            <label class="detail-label">Harga</label>
            <input type="text" id="formPrice" class="form-control" placeholder="Contoh: Rp 1.500.000" required>
            
            <label class="detail-label">Link URL Gambar (Unsplash)</label>
            <input type="url" id="formImg" class="form-control" placeholder="https://..." required>
            
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeLayananModal('modalAdd')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS -->
<div id="modalDelete" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Hapus Produk?</div>
        <div class="modal-desc">Data yang dihapus akan hilang dari Katalog dan tidak bisa dikembalikan.</div>
        <input type="hidden" id="deleteId">
        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeLayananModal('modalDelete')">Batal</button>
            <button type="button" id="btnConfirmDelete" class="btn-primary" style="width: auto; background-color: #dc3545;">Hapus</button>
        </div>
    </div>
</div>

<div id="toastNotif" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/kelola-layanan.js') }}"></script>
@endsection