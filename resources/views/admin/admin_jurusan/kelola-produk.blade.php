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
        
        <!-- Form dengan enctype agar bisa mengirim file foto -->
        <form id="formLayanan" enctype="multipart/form-data">
            <input type="hidden" id="formId">
            <label class="detail-label">Nama Produk</label>
            <input type="text" id="formName" class="form-control" required>
            
            <label class="detail-label">Deskripsi Produk</label>
            <textarea id="formDesc" class="form-control" rows="3" required></textarea>
            
            <label class="detail-label">Harga</label>
            <input type="text" id="formPrice" class="form-control" placeholder="Contoh: Rp 1.500.000" required>
            
            <label class="detail-label">Upload Gambar Produk (Bisa pilih bertahap lebih dari 1 foto)</label>
            <!-- Input file -->
            <input type="file" name="gambar[]" id="formImg" class="form-control" accept="image/*" multiple required style="padding: 10px; cursor: pointer; background: #F8FAFC;">
            
            <!-- Wadah untuk memunculkan preview foto yang ditumpuk -->
            <div id="imagePreviewContainer" style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 12px; margin-bottom: 16px;"></div>
            
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
    // Array penampung seluruh file foto yang dipilih bertahap
    let uploadedFiles = [];

    // Deteksi saat user memilih foto baru
    document.getElementById('formImg').addEventListener('change', function(event) {
        const files = event.target.files;
        
        if (files.length > 0) {
            // Tambahkan file baru ke dalam array tanpa menghapus yang sudah ada
            Array.from(files).forEach(file => {
                uploadedFiles.push(file);
            });

            // Sinkronkan array dengan input HTML agar bisa dikirim ke database
            updateFileInput();
            // Tampilkan foto ke layar
            renderPreviews();
        }
    });

    // Fungsi untuk memasukkan kumpulan file dari array kembali ke <input type="file">
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        uploadedFiles.forEach(file => dataTransfer.items.add(file));
        document.getElementById('formImg').files = dataTransfer.files;
    }

    // Fungsi untuk merender tampilan foto dan tombol Hapus (X)
    function renderPreviews() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        previewContainer.innerHTML = ''; // Bersihkan kontainer sementara

        uploadedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Bungkus luar (agar posisi tombol X bisa diatur)
                const wrapper = document.createElement('div');
                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';

                // Elemen Gambar
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '70px';
                img.style.height = '70px';
                img.style.objectFit = 'cover';
                img.style.borderRadius = '8px';
                img.style.border = '1px solid #CBD5E1';
                img.style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';
                
                // Tombol Hapus (X) warna merah
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

                // Aksi ketika tombol X diklik
                removeBtn.onclick = function() {
                    uploadedFiles.splice(index, 1); // Hapus file dari array berdasarkan urutannya
                    updateFileInput(); // Update input tag file-nya
                    renderPreviews(); // Render ulang tampilannya
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
        });
    }

    // Mereset form secara total saat modal ditutup
    const originalCloseModal = window.closeLayananModal;
    window.closeLayananModal = function(modalId) {
        if(modalId === 'modalAdd') {
            uploadedFiles = []; // Kosongkan array saat modal tertutup
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