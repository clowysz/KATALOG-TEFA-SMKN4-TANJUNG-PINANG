@extends('admin.layouts.app-jurusan')

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
        
        <!-- PERBAIKAN: Tambahkan enctype agar form bisa mengirim file foto ke backend -->
        <form id="formLayanan" enctype="multipart/form-data">
            <input type="hidden" id="formId">
            <label class="detail-label">Nama Produk</label>
            <input type="text" id="formName" class="form-control" required>
            
            <label class="detail-label">Deskripsi Produk</label>
            <textarea id="formDesc" class="form-control" rows="3" required></textarea>
            
            <label class="detail-label">Harga</label>
            <input type="text" id="formPrice" class="form-control" placeholder="Contoh: Rp 1.500.000" required>
            
            <!-- PERBAIKAN: Mengubah input URL menjadi input File Multiple -->
            <label class="detail-label">Upload Gambar Produk (Bisa pilih lebih dari 1 foto)</label>
            <input type="file" id="formImg" class="form-control" accept="image/*" multiple required style="padding: 10px; cursor: pointer; background: #F8FAFC;">
            
            <!-- Wadah untuk memunculkan preview foto yang dipilih -->
            <div id="imagePreviewContainer" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 12px; margin-bottom: 16px;"></div>
            
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
<script>
    // Fitur Preview Multiple Image (Frontend UI)
    document.getElementById('formImg').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = ''; // Bersihkan preview foto sebelumnya

        const files = event.target.files;
        if (files) {
            Array.from(files).forEach(file => {
                // Membaca file dan membuat elemen gambar
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    // Desain kotak thumbnail preview
                    img.style.width = '70px';
                    img.style.height = '70px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '8px';
                    img.style.border = '1px solid #CBD5E1';
                    img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
                    
                    previewContainer.appendChild(img);
                }
                reader.readAsDataURL(file);
            });
        }
    });

    // Modifikasi fungsi close modal untuk mereset input file dan preview
    const originalCloseModal = window.closeLayananModal;
    window.closeLayananModal = function(modalId) {
        if(modalId === 'modalAdd') {
            document.getElementById('imagePreviewContainer').innerHTML = '';
            document.getElementById('formImg').value = '';
        }
        if(typeof originalCloseModal === 'function') {
            originalCloseModal(modalId);
        } else {
            document.getElementById(modalId).style.display = 'none';
        }
    };
</script>
@endsection