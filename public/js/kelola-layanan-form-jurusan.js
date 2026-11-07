document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formLayanan");

  if (!form) {
    return;
  }

  const jenis = form.dataset.jenis === "jasa" ? "jasa" : "produk";

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
