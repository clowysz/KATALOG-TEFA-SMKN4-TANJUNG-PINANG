/* =========================================================
   FORM KELOLA PORTOFOLIO - ADMIN JURUSAN

   Urutan script di blade:
   1. kelola-portofolio.js
   2. form-helper-jurusan.js
   3. kelola-portofolio-form-jurusan.js (file ini)
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formPorto");

    if (!form) {
        return;
    }

    const title = document.getElementById("portoTitle");
    const desc = document.getElementById("portoDesc");
    const year = document.getElementById("portoYear");

    const TAHUN_MINIMAL = 2000;

    // ------------------------------------------------------
    // Validasi "wajib diisi" - bahasa Indonesia
    // ------------------------------------------------------
    JurusanForm.requiredMessage(title, "Judul portofolio wajib diisi.");
    JurusanForm.requiredMessage(desc, "Deskripsi singkat wajib diisi.");

    // ------------------------------------------------------
    // Tahun: hanya angka, wajib 4 digit, rentang 2000 - tahun ini
    // ------------------------------------------------------
    if (year) {
        year.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "");
            this.setCustomValidity("");
        });

        year.addEventListener("invalid", function () {
            if (this.validity.valueMissing) {
                this.setCustomValidity("Tahun / periode wajib diisi.");
            } else if (this.validity.patternMismatch) {
                this.setCustomValidity(
                    "Tahun harus terdiri dari 4 angka, contoh: 2026.",
                );
            }
        });

        // Fase capture: berjalan sebelum handler submit milik kelola-portofolio.js
        form.addEventListener(
            "submit",
            function (event) {
                const tahun = parseInt(year.value, 10);
                const tahunSekarang = new Date().getFullYear();

                if (tahun < TAHUN_MINIMAL || tahun > tahunSekarang) {
                    event.preventDefault();
                    event.stopImmediatePropagation();

                    year.setCustomValidity(
                        "Tahun harus antara " +
                            TAHUN_MINIMAL +
                            " sampai " +
                            tahunSekarang +
                            ".",
                    );
                    year.reportValidity();
                    return;
                }

                year.setCustomValidity("");
            },
            true,
        );
    }

    // ------------------------------------------------------
    // Upload & preview gambar
    // ------------------------------------------------------
    JurusanForm.initImageUploader({
        form: form,
        input: document.getElementById("portoImg"),
        preview: document.getElementById("imagePreviewContainer"),
        idInput: document.getElementById("portoId"),
        modalId: "modalAddPorto",
        closeFn: "closePortoModal",
        emptyMessage: "Minimal satu gambar wajib diunggah.",
    });
});
