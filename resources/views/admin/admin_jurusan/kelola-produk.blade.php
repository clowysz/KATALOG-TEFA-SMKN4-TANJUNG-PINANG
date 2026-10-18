@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Produk')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/kelola-jurusan.css') }}?v=4">
@endsection

@section('content')

<div class="header-action">

    <div>
        <h2>Kelola Produk</h2>
        <p>Tambah, ubah, atau hapus produk jurusan</p>
    </div>

    <div>
        <input
            type="text"
            id="searchItem"
            class="search-input"
            placeholder="Cari produk..."
        >

        <button
            type="button"
            data-open-tambah
            class="btn-jurusan-primary"
        >
            + Tambah Produk
        </button>
    </div>

</div>

<div id="kelolaProdukContainer" class="catalog-grid"></div>


<!-- Modal Tambah/Edit -->
<div id="modalAdd" class="modal-overlay">
    <div class="modal-box modal-box-form">

        <div class="modal-title" id="modalFormTitle">
            Tambah Produk
        </div>

        <form id="formLayanan" data-jenis="produk" enctype="multipart/form-data">

            <input type="hidden" id="formId">

            <label for="formName" class="detail-label">
                Nama Produk
            </label>

            <input
                type="text"
                id="formName"
                class="form-control"
                required
            >

            <label for="formDesc" class="detail-label">
                Deskripsi Produk
            </label>

            <textarea
                id="formDesc"
                class="form-control"
                rows="3"
                required
            ></textarea>

            <label for="formPrice" class="detail-label">
                Harga
            </label>

            <input
                type="text"
                id="formPrice"
                class="form-control"
                placeholder="Contoh: Rp 1.500.000"
                required
            >

            <label for="formUnit" class="detail-label">
                Satuan Harga <span class="label-optional">(Opsional)</span>
            </label>

            <input
                type="text"
                id="formUnit"
                class="form-control"
                placeholder="Contoh: pcs, meter, titik"
                maxlength="50"
            >

            <label for="formImg" class="detail-label">
                Upload Gambar Produk
            </label>

            <input
                type="file"
                name="gambar[]"
                id="formImg"
                class="form-control form-file-input"
                accept="image/*"
                multiple
            >

            <div id="imagePreviewContainer" class="upload-preview"></div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="btn-outline"
                    data-close-modal="modalAdd"
                >
                    Batal
                </button>

                <button type="submit" class="btn-jurusan-primary">
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
            Hapus Produk?
        </div>

        <div class="modal-desc">
            Data yang dihapus akan hilang dari Katalog dan tidak bisa dikembalikan.
        </div>

        <input type="hidden" id="deleteId">

        <div class="modal-actions">

            <button
                type="button"
                class="btn-outline"
                data-close-modal="modalDelete"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmDelete"
                class="btn-jurusan-danger"
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
<script src="{{ asset('js/form-helper-jurusan.js') }}"></script>
<script src="{{ asset('js/kelola-layanan-form-jurusan.js') }}"></script>
@endsection