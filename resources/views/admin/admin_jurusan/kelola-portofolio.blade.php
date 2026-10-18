@extends('admin.layouts.app-jurusan')

@section('title', 'Kelola Portofolio')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/kelola-jurusan.css') }}?v=4">
@endsection

@section('content')

<div class="header-action">

    <div>
        <h2>Kelola Portofolio</h2>
        <p>Kelola daftar karya dan proyek jurusan Anda</p>
    </div>

    <div>
        <input
            type="text"
            id="searchPorto"
            class="search-input"
            placeholder="Cari portofolio..."
        >

        <button
            type="button"
            data-open-tambah
            class="btn-jurusan-primary"
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
    <div class="modal-box modal-box-form">

        <div class="modal-title" id="modalPortoTitle">
            Tambah Portofolio
        </div>

        <form id="formPorto" enctype="multipart/form-data">

            <input type="hidden" id="portoId">

            <label for="portoTitle" class="detail-label">
                Judul Portofolio
            </label>

            <input
                type="text"
                name="judul"
                id="portoTitle"
                class="form-control"
                required
            >

            <label for="portoDesc" class="detail-label">
                Deskripsi Singkat
            </label>

            <textarea
                name="deskripsi"
                id="portoDesc"
                class="form-control"
                rows="3"
                required
            ></textarea>

            <label for="portoYear" class="detail-label">
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

            <label for="portoImg" class="detail-label">
                Upload Gambar Portofolio
            </label>

            <input
                type="file"
                name="gambar[]"
                id="portoImg"
                class="form-control form-file-input"
                accept="image/*"
                multiple
                required
            >

            <div id="imagePreviewContainer" class="upload-preview"></div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="btn-outline"
                    data-close-modal="modalAddPorto"
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


<!-- MODAL HAPUS PORTOFOLIO -->
<div id="modalDeletePorto" class="modal-overlay">
    <div class="modal-box">

        <div class="modal-title">
            Hapus Portofolio?
        </div>

        <div class="modal-desc">
            Data portofolio yang dihapus tidak dapat dikembalikan.
        </div>

        <input type="hidden" id="deletePortoId">

        <div class="modal-actions">

            <button
                type="button"
                class="btn-outline"
                data-close-modal="modalDeletePorto"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmDeletePorto"
                class="btn-jurusan-danger"
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
<script src="{{ asset('js/form-helper-jurusan.js') }}"></script>
<script src="{{ asset('js/kelola-portofolio-form-jurusan.js') }}"></script>
@endsection