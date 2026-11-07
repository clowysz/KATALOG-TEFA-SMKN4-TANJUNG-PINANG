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

    if (
      event.target.closest("[data-faq-delete-close]") ||
      event.target === modal
    ) {
      closeModal();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeModal();
    }
  });
})();
