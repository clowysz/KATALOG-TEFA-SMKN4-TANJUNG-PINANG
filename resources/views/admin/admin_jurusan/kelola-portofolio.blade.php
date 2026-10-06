@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Portofolio')

@section('content')
<div class="header-action" style="align-items: center;">
    <div>
        <h2>Kelola Portofolio</h2>
        <p>Kelola daftar karya dan proyek jurusan Anda</p>
    </div>

    <div style="display: flex; gap: 12px;">
        <input
            type="text"
            id="searchPorto"
            class="search-input"
            placeholder="Cari portofolio..."
            style="width: 250px; margin-bottom: 0;"
        >

        <button
            type="button"
            onclick="openTambahPortoModal()"
            class="btn-primary"
            style="width: auto; background-color: #3B698F;"
        >
            + Tambah Portofolio
        </button>
    </div>
</div>

<div id="portoContainer" class="portfolio-grid">
    <!-- Card portofolio akan dimuat oleh JavaScript -->
</div>

<!-- MODAL TAMBAH / EDIT PORTOFOLIO -->
<div id="modalAddPorto" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">

        <div class="modal-title" id="modalPortoTitle">
            Tambah Portofolio
        </div>

        <form
            id="formPorto"
            enctype="multipart/form-data"
        >
            <input
                type="hidden"
                id="portoId"
            >

            <label class="detail-label">
                Judul Portofolio
            </label>

            <input
                type="text"
                name="judul"
                id="portoTitle"
                class="form-control"
                required
            >

            <label class="detail-label">
                Deskripsi Singkat
            </label>

            <textarea
                name="deskripsi"
                id="portoDesc"
                class="form-control"
                rows="3"
                required
                style="resize: none;"
            ></textarea>

            <label class="detail-label">
                Tahun / Periode
            </label>

            <input
                type="text"
                name="tahun"
                id="portoYear"
                class="form-control"
                placeholder="Contoh: 2026"
                maxlength="4"
                minlength="4"
                pattern="\d{4}"
                oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.setCustomValidity('');"
                oninvalid="this.setCustomValidity('Harap di isi 4 angka')"
                required
            >
            <span id="errorTahun" style="color: #dc2626; font-size: 12px; display: block; margin-top: 4px;"></span>

            <label class="detail-label">
                Upload Gambar Portofolio
            </label>

            <input
                type="file"
                name="gambar[]"
                id="portoImg"
                class="form-control"
                accept="image/*"
                multiple
                required
                style="padding: 10px; cursor: pointer; background: #F8FAFC;"
            >

            <div
                id="imagePreviewContainer"
                style="
                    display: flex;
                    gap: 12px;
                    flex-wrap: wrap;
                    margin-top: 12px;
                    margin-bottom: 16px;
                "
            ></div>

            <div class="modal-actions">
                <button
                    type="button"
                    class="btn-outline"
                    onclick="closePortoModal('modalAddPorto')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-primary"
                    style="width: auto; background-color: #3B698F;"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS PORTOFOLIO -->
<div id="modalDeletePorto" class="modal-overlay">
    <div class="modal-box">

        <div class="modal-title">
            Hapus Portofolio?
        </div>

        <div class="modal-desc">
            Data portofolio yang dihapus tidak dapat dikembalikan.
        </div>

        <input
            type="hidden"
            id="deletePortoId"
        >

        <div class="modal-actions">
            <button
                type="button"
                class="btn-outline"
                onclick="closePortoModal('modalDeletePorto')"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmDeletePorto"
                class="btn-primary"
                style="width: auto; background-color: #dc3545;"
            >
                Hapus
            </button>
        </div>
    </div>
</div>

<div id="toastPorto" class="toast-notification"></div>

@endsection

@section('scripts')

<script src="{{ asset('js/kelola-portofolio.js') }}"></script>

<script>
    window.uploadedFiles = [];

    const portoImg = document.getElementById('portoImg');

    if (portoImg) {
        portoImg.addEventListener('change', function(event) {
            const files = event.target.files;

            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    window.uploadedFiles.push(file);
                });

                updateFileInput();
                renderPreviews();
            }
        });
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();

        window.uploadedFiles.forEach(file => {
            dataTransfer.items.add(file);
        });

        document.getElementById('portoImg').files = dataTransfer.files;
    }

    function renderPreviews() {
        const previewContainer = document.getElementById('imagePreviewContainer');
        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        window.uploadedFiles.forEach((file, index) => {
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
                    window.uploadedFiles.splice(index, 1);
                    updateFileInput();
                    renderPreviews();
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);

                previewContainer.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    }

    // Modal Close Function
    const originalClosePortoModal = window.closePortoModal;

    window.closePortoModal = function(modalId) {
        if (modalId === 'modalAddPorto') {
            window.uploadedFiles = [];

            const previewContainer = document.getElementById('imagePreviewContainer');
            if (previewContainer) previewContainer.innerHTML = '';

            const imgInput = document.getElementById('portoImg');
            if (imgInput) imgInput.value = '';

            const errorSpan = document.getElementById('errorTahun');
            if (errorSpan) errorSpan.innerText = '';
        }

        if (typeof originalClosePortoModal === 'function') {
            originalClosePortoModal(modalId);
        } else {
            const modal = document.getElementById(modalId);
            if (modal) modal.style.display = 'none';
        }
    };


@endsection