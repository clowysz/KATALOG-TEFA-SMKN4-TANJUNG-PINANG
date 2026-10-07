@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Jasa')

@section('content')
<style>
    /* Tombol Tambah & Simpan (sama seperti Tambah FAQ) */
    .btn-jasa-primary {
        background: #1e3a8ad9;
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        width: auto;
    }

    .btn-jasa-primary:hover {
        background: #1E3A8A;
        color: white;
    }

    /* Tombol Hapus di modal: hover merah */
    .btn-jasa-delete,
    #btnConfirmDelete {
        background: #dc3545 !important;
        color: white !important;
        padding: 10px 16px !important;
        border: none !important;
        border-radius: 8px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        cursor: pointer !important;
        width: auto !important;
    }

    .btn-jasa-delete:hover,
    #btnConfirmDelete:hover {
        background: #B91C1C !important;
        color: white !important;
    }

    /* Tombol Hapus di card: hover merah (inline style dari JS perlu !important) */
    #kelolaJasaContainer .btn-delete {
        background: transparent !important;
        color: #dc3545 !important;
        border: 1px solid #dc3545 !important;
        transition: all 0.2s ease;
    }

    #kelolaJasaContainer .btn-delete:hover {
        background: #dc3545 !important;
        color: #ffffff !important;
    }
</style>

<div class="header-action" style="align-items: center;">
    <div>
        <h2>Kelola Jasa</h2>
        <p>Tambah, ubah, atau hapus jasa jurusan</p>
    </div>

    <div style="display: flex; gap: 12px;">
        <input
            type="text"
            id="searchItem"
            class="search-input"
            placeholder="Cari jasa..."
            style="width: 250px; margin-bottom: 0;"
        >

        <button
    onclick="openLayananModal('modalAdd')"
    class="btn-jasa-primary"
>
    + Tambah Jasa
</button>
    </div>
</div>

<div id="kelolaJasaContainer" class="catalog-grid"></div>

<!-- Modal Tambah/Edit -->
<div id="modalAdd" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">

        <div class="modal-title" id="modalFormTitle">
            Tambah Jasa
        </div>

        <form id="formLayanan" enctype="multipart/form-data">

            <input type="hidden" id="formId">

            <label for="formName" class="detail-label">
                Nama Jasa
            </label>

            <input
                type="text"
                id="formName"
                class="form-control"
                required
            >

            <label for="formDesc" class="detail-label">
                Deskripsi Jasa
            </label>

            <textarea
                id="formDesc"
                class="form-control"
                rows="3"
                required
            ></textarea>

            <label for="formPrice" class="detail-label">
                Harga / Estimasi Biaya
            </label>

            <input
                type="text"
                id="formPrice"
                class="form-control"
                placeholder="Contoh: Rp 500.000"
                required
            >

            <label for="formUnit" class="detail-label">
                Satuan Harga <span style="color:#94A3B8;">(Opsional)</span>
            </label>

            <input
                type="text"
                id="formUnit"
                class="form-control"
                placeholder="Contoh: pcs, meter, titik"
                maxlength="50"
            >

            <label for="formImg" class="detail-label">
                Upload Gambar Jasa
            </label>

            <input
                type="file"
                name="gambar[]"
                id="formImg"
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
                    onclick="closeLayananModal('modalAdd')"
                >
                    Batal
                </button>

                <button
    type="submit"
    class="btn-jasa-primary"
>
    Simpan
</button>

            </div>

        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modalDelete" class="modal-overlay">
    <div class="modal-box">

        <div class="modal-title">
            Hapus Jasa?
        </div>

        <div class="modal-desc">
            Data yang dihapus akan hilang dari Katalog dan tidak bisa dikembalikan.
        </div>

        <input
            type="hidden"
            id="deleteId"
        >

        <div class="modal-actions">

            <button
                type="button"
                class="btn-outline"
                onclick="closeLayananModal('modalDelete')"
            >
                Batal
            </button>

           <button
    type="button"
    id="btnConfirmDelete"
    class="btn-jasa-delete"
>
    Hapus
</button>

        </div>

    </div>
</div>

<div id="toastNotif" class="toast-notification"></div>

@endsection

@section('scripts')

<script src="{{ asset('js/kelola-layanan.js') }}"></script>

<script>
window.uploadedFiles = [];

document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // DEKLARASI ELEMEN (harus paling atas)
    // =========================================================
    const formLayanan      = document.getElementById('formLayanan');
    const formId           = document.getElementById('formId');
    const formName         = document.getElementById('formName');
    const formDesc         = document.getElementById('formDesc');
    const formPrice        = document.getElementById('formPrice');
    const formImg          = document.getElementById('formImg');
    const previewContainer = document.getElementById('imagePreviewContainer');


    // =========================================================
    // VALIDASI FORM JASA - BAHASA INDONESIA
    // =========================================================

    // Helper: pasang pesan custom untuk field required
    function setIndonesianValidation(element, message) {
        if (!element) {
            return;
        }

        element.addEventListener('invalid', function () {
            if (this.validity.valueMissing) {
                this.setCustomValidity(message);
            } else {
                this.setCustomValidity('');
            }
        });

        element.addEventListener('input', function () {
            this.setCustomValidity('');
        });
    }

    setIndonesianValidation(formName,  'Nama jasa wajib diisi.');
    setIndonesianValidation(formDesc,  'Deskripsi jasa wajib diisi.');
    setIndonesianValidation(formPrice, 'Harga wajib diisi.');

    // kelola-layanan.js memasang atribut "required" pada input gambar saat mode tambah,
    // jadi validasi bawaan browser yang jalan duluan. Pesannya diganti di sini.
    setIndonesianValidation(formImg, 'Minimal satu gambar wajib diunggah.');

    // Cek manual: gambar wajib hanya di mode tambah (formId kosong)
    if (formLayanan && formImg) {
        formLayanan.addEventListener('submit', function (event) {

            const isAddMode = !formId || formId.value === '';

            if (isAddMode && window.uploadedFiles.length === 0) {
                event.preventDefault();

                formImg.setCustomValidity(
                    'Minimal satu gambar wajib diunggah.'
                );

                formImg.reportValidity();
            } else {
                formImg.setCustomValidity('');
            }
        });
    }


    // =========================================================
    // UPLOAD & PREVIEW GAMBAR
    // =========================================================
    if (!formImg) return;

    formImg.addEventListener('change', function (event) {

        // Hapus pesan validasi setelah gambar dipilih
        this.setCustomValidity('');

        const files = event.target.files;

        if (!files.length) return;

        Array.from(files).forEach(function (file) {
            window.uploadedFiles.push(file);
        });

        updateFileInput();
        renderPreviews();
    });

    function updateFileInput() {

        const dataTransfer = new DataTransfer();

        window.uploadedFiles.forEach(function (file) {
            dataTransfer.items.add(file);
        });

        formImg.files = dataTransfer.files;
    }

    function renderPreviews() {

        if (!previewContainer) return;

        previewContainer.innerHTML = '';

        window.uploadedFiles.forEach(function (file, index) {

            const reader = new FileReader();

            reader.onload = function (event) {

                const wrapper = document.createElement('div');

                wrapper.style.position = 'relative';
                wrapper.style.display = 'inline-block';

                const img = document.createElement('img');

                img.src = event.target.result;
                img.style.width = '70px';
                img.style.height = '70px';
                img.style.objectFit = 'contain';
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

                removeBtn.onclick = function () {

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


    // =========================================================
    // RESET UPLOAD SAAT MODAL DITUTUP
    // =========================================================
    const originalCloseModal = window.closeLayananModal;

    window.closeLayananModal = function (modalId) {

        if (modalId === 'modalAdd') {

            window.uploadedFiles = [];

            if (previewContainer) {
                previewContainer.innerHTML = '';
            }

            if (formImg) {
                formImg.value = '';
                formImg.setCustomValidity('');
            }
        }

        if (typeof originalCloseModal === 'function') {

            originalCloseModal(modalId);

        } else {

            const modal = document.getElementById(modalId);

            if (modal) {
                modal.classList.remove('active');
            }
        }
    };

});
</script>

@endsection