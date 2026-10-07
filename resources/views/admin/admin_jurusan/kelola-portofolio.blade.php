@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Portofolio')

@section('content')
<style>

    .btn-porto-delete {
    background: #dc3545;
    color: white;
    padding: 10px 16px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
}

.btn-porto-delete:hover {
    background: #B91C1C;
}
    /* Tombol Tambah & Simpan (sama seperti Tambah FAQ) */
    .btn-porto-primary {
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

    .btn-porto-primary:hover {
        background: #1E3A8A;
        color: white;
    }

    /* Tombol Hapus: hover merah */
    /* Tombol Hapus di card portofolio: hover merah */
.btn-delete-porto {
    background: transparent !important;
    color: #dc3545 !important;
    border: 1px solid #dc3545 !important;
    transition: all 0.2s ease;
}

.btn-delete-porto:hover {
    background: #dc3545 !important;
    color: #ffffff !important;
    border-color: #dc3545 !important;
}
</style>
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
    class="btn-porto-primary"
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
    required
    inputmode="numeric"
    maxlength="4"
    pattern="[0-9]{4}"
>

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
    class="btn-porto-primary"
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
    class="btn-porto-delete"
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

    document.addEventListener('DOMContentLoaded', function () {

        // =========================================================
        // DEKLARASI ELEMEN (harus paling atas)
        // =========================================================
        const formPorto        = document.getElementById('formPorto');
        const portoId          = document.getElementById('portoId');
        const portoTitle       = document.getElementById('portoTitle');
        const portoDesc        = document.getElementById('portoDesc');
        const portoYear        = document.getElementById('portoYear');
        const portoImg         = document.getElementById('portoImg');
        const previewContainer = document.getElementById('imagePreviewContainer');


        // =========================================================
        // VALIDASI FORM PORTOFOLIO - BAHASA INDONESIA
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
            formPorto.addEventListener('submit', function (event) {
    const tahun = parseInt(portoYear.value, 10);
    const tahunSekarang = new Date().getFullYear();

    if (tahun < 2000 || tahun > tahunSekarang) {
        event.preventDefault();
        portoYear.setCustomValidity('Tahun harus antara 2000 sampai ' + tahunSekarang + '.');
        portoYear.reportValidity();
    } else {
        portoYear.setCustomValidity('');
    }
});

            element.addEventListener('input', function () {
                this.setCustomValidity('');
            });
        }

        setIndonesianValidation(portoTitle, 'Judul portofolio wajib diisi.');
        setIndonesianValidation(portoDesc,  'Deskripsi singkat wajib diisi.');
        setIndonesianValidation(portoYear,  'Tahun / periode wajib diisi.');

        // kelola-portofolio.js memasang atribut "required" pada input gambar saat mode tambah,
        // jadi validasi bawaan browser yang jalan duluan. Pesannya diganti di sini.
        setIndonesianValidation(portoImg, 'Minimal satu gambar wajib diunggah.');

        // Tahun hanya boleh angka dan wajib 4 digit
portoYear.addEventListener('input', function () {
    this.value = this.value.replace(/[^0-9]/g, '');
});

portoYear.addEventListener('invalid', function () {
    if (this.validity.valueMissing) {
        this.setCustomValidity('Tahun / periode wajib diisi.');
    } else if (this.validity.patternMismatch) {
        this.setCustomValidity('Tahun harus terdiri dari 4 angka, contoh: 2026.');
    } else {
        this.setCustomValidity('');
    }
});

        // Cek manual: gambar wajib hanya di mode tambah (portoId kosong)
        if (formPorto && portoImg) {
            formPorto.addEventListener('submit', function (event) {

                const isAddMode = !portoId || portoId.value === '';

                if (isAddMode && window.uploadedFiles.length === 0) {
                    event.preventDefault();

                    portoImg.setCustomValidity(
                        'Minimal satu gambar wajib diunggah.'
                    );

                    portoImg.reportValidity();
                } else {
                    portoImg.setCustomValidity('');
                }
            });
        }


        // =========================================================
        // UPLOAD & PREVIEW GAMBAR
        // =========================================================
        if (!portoImg) {
            return;
        }

        portoImg.addEventListener('change', function (event) {

            // Hapus pesan validasi setelah gambar dipilih
            this.setCustomValidity('');

            const files = event.target.files;

            if (files.length > 0) {
                Array.from(files).forEach(file => {
                    window.uploadedFiles.push(file);
                });

                updateFileInput();
                renderPreviews();
            }
        });

        function updateFileInput() {
            const dataTransfer = new DataTransfer();

            window.uploadedFiles.forEach(file => {
                dataTransfer.items.add(file);
            });

            portoImg.files = dataTransfer.files;
        }

        function renderPreviews() {

            if (!previewContainer) {
                return;
            }

            previewContainer.innerHTML = '';

            window.uploadedFiles.forEach((file, index) => {
                const reader = new FileReader();

                reader.onload = function (e) {

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

                    removeBtn.innerHTML = '<i class="ph ph-x"></i>';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '-6px';
                    removeBtn.style.right = '-6px';
                    removeBtn.style.background = '#dc2626';
                    removeBtn.style.color = '#ffffff';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.width = '20px';
                    removeBtn.style.height = '20px';
                    removeBtn.style.fontSize = '10px';
                    removeBtn.style.fontWeight = 'bold';
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
        const originalClosePortoModal = window.closePortoModal;

        window.closePortoModal = function (modalId) {

            if (modalId === 'modalAddPorto') {

                window.uploadedFiles = [];

                if (previewContainer) {
                    previewContainer.innerHTML = '';
                }

                portoImg.value = '';
                portoImg.setCustomValidity('');
            }

            if (typeof originalClosePortoModal === 'function') {

                originalClosePortoModal(modalId);

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