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
        <button onclick="openPortoModal('modalAddPorto')" class="btn-primary" style="width: auto; background-color: #3B698F;">+ Tambah Portofolio</button>
    </div>
</div>

<div id="portoContainer" class="portfolio-grid">
    <!-- Card Portofolio akan dimuat oleh JS -->
</div>

<!-- MODAL TAMBAH/EDIT PORTOFOLIO -->
<div id="modalAddPorto" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-title" id="modalPortoTitle">Tambah Portofolio</div>
        
        <!-- WAJIB: Tambahkan enctype untuk upload file -->
        <form id="formPorto" enctype="multipart/form-data">
            <input type="hidden" id="portoId">
            <label class="detail-label">Judul Portofolio</label>
            <input type="text" id="portoTitle" class="form-control" required>
            
            <label class="detail-label">Deskripsi Singkat</label>
            <textarea id="portoDesc" class="form-control" rows="3" required></textarea>
            
            <label class="detail-label">Tahun / Periode</label>
            <input type="text" id="portoYear" class="form-control" placeholder="Contoh: 2026" required>
            
            <!-- DIUBAH: Dari input URL menjadi input File -->
            <label class="detail-label">Upload Gambar Portofolio (Bisa pilih bertahap lebih dari 1 foto)</label>
            <input type="file" name="gambar[]" id="portoImg" class="form-control" accept="image/*" multiple required style="padding: 10px; cursor: pointer; background: #F8FAFC;">
            
            <!-- Wadah untuk preview gambar -->
            <div id="imagePreviewContainer" style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px; margin-bottom: 16px;"></div>
            
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closePortoModal('modalAddPorto')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto; background-color: #3B698F;">Simpan</button>
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
<script>
    // Array penampung seluruh file foto yang dipilih bertahap
    let uploadedFiles = [];

    // Deteksi saat user memilih foto baru pada input portofolio
    document.getElementById('portoImg').addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length > 0) {
            Array.from(files).forEach(file => {
                uploadedFiles.push(file);
            });

            updateFileInput();
            renderPreviews();
        }
    });

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('portoImg').files = dataTransfer.files;
    }

    function renderPreviews() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = '';

        uploadedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '70px';
                img.style.height = '70px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.border = '1px solid #CBD5E1';
                img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
                
                const removeBtn = document.createElement('span');
                removeBtn.innerHTML = '✖';
                removeBtn.style.position = 'absolute';
                removeBtn.style.top = '-6px';
                removeBtn.style.right = '-6px';
                removeBtn.style.background = '#dc2626';
                removeBtn.style.color = '#ffffff';
                removeBtn.style.borderRadius = '50%';
                removeBtn.style.width = '20px';
                removeBtn.style.height = '20px';
                removeBtn.style.fontSize = '10px';
                removeBtn.style.display = 'flex';
                removeBtn.style.alignItems = 'center';
                removeBtn.style.justifyContent = 'center';
                removeBtn.style.cursor = 'pointer';
                removeBtn.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';

                removeBtn.onclick = function() {
                    uploadedFiles.splice(index, 1);
                    updateFileInput();
                    renderPreviews();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
        });
    }

    // Menyesuaikan fungsi reset form dengan nama modal portofolio (modalAddPorto)
    const originalClosePortoModal = window.closePortoModal;
    window.closePortoModal = function(modalId) {
        if(modalId === 'modalAddPorto') {
            uploadedFiles = []; 
            document.getElementById('imagePreviewContainer').innerHTML = '';
            document.getElementById('portoImg').value = '';
        }
        
        if(typeof originalClosePortoModal === 'function') {
            originalClosePortoModal(modalId);
        } else {
            document.getElementById(modalId).style.display = 'none';
        }
    };
</script>
@endsection