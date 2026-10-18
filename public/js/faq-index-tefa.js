/* =========================================================
   KELOLA FAQ (admin_tefa/faq/index)

   Modal konfirmasi hapus FAQ.

   Pemicu di blade (tanpa onclick inline):
   - data-faq-delete         : tombol Hapus pada kartu FAQ (buka modal)
   - data-faq-delete-close   : tombol Batal di modal
   - data-faq-delete-submit  : tombol Hapus di modal (kirim form)
========================================================= */

(function () {
  "use strict";

  const modal = document.getElementById("faqDeleteModal");

  if (!modal) {
    return;
  }

  let faqDeleteForm = null;

  function openModal(button) {
    faqDeleteForm = button.closest(".faq-delete-form");

    modal.style.display = "flex";
  }

  function closeModal() {
    modal.style.display = "none";

    faqDeleteForm = null;
  }

  document.addEventListener("click", function (event) {
    const opener = event.target.closest("[data-faq-delete]");

    if (opener) {
      openModal(opener);
      return;
    }

    if (event.target.closest("[data-faq-delete-submit]")) {
      if (faqDeleteForm) {
        faqDeleteForm.submit();
      }

      return;
    }

    // Tombol Batal, atau klik di area gelap di luar kotak modal
    if (
      event.target.closest("[data-faq-delete-close]") ||
      event.target === modal
    ) {
      closeModal();
    }
  });

  // Tutup modal dengan tombol Esc
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeModal();
    }
  });
})();
