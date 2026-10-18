/* =========================================================
   FORM KELOLA PRODUK & KELOLA JASA - ADMIN JURUSAN

   Jenis halaman dibaca dari data-jenis pada <form id="formLayanan">:
   data-jenis="produk" atau data-jenis="jasa".

   Urutan script di blade:
   1. kelola-layanan.js
   2. form-helper-jurusan.js
   3. kelola-layanan-form-jurusan.js (file ini)
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formLayanan");

    if (!form) {
        return;
    }

    const jenis = form.dataset.jenis === "jasa" ? "jasa" : "produk";

    // ------------------------------------------------------
    // Validasi "wajib diisi" - bahasa Indonesia
    // ------------------------------------------------------
    JurusanForm.requiredMessage(
        document.getElementById("formName"),
        "Nama " + jenis + " wajib diisi.",
    );

    JurusanForm.requiredMessage(
        document.getElementById("formDesc"),
        "Deskripsi " + jenis + " wajib diisi.",
    );

    JurusanForm.requiredMessage(
        document.getElementById("formPrice"),
        "Harga wajib diisi.",
    );

    // ------------------------------------------------------
    // Upload & preview gambar
    // ------------------------------------------------------
    JurusanForm.initImageUploader({
        form: form,
        input: document.getElementById("formImg"),
        preview: document.getElementById("imagePreviewContainer"),
        idInput: document.getElementById("formId"),
        modalId: "modalAdd",
        closeFn: "closeLayananModal",
        emptyMessage: "Minimal satu gambar " + jenis + " wajib diunggah.",
        fit: jenis === "jasa" ? "contain" : "cover",
    });
});
