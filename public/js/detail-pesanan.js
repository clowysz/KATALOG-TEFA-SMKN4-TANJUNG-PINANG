document.addEventListener("DOMContentLoaded", function () {
  initAlasanPembatalan();
  initModalKonfirmasi();
});

function initAlasanPembatalan() {
  const statusSelect = document.getElementById("statusSelect");
  const alasanGroup = document.getElementById("alasanPembatalanGroup");
  const alasanInput = document.getElementById("alasanPembatalan");

  if (!statusSelect || !alasanGroup || !alasanInput) {
    return;
  }

  const form = alasanInput.form;

  function cekAlasan() {
    if (alasanInput.disabled) {
      alasanInput.setCustomValidity("");
      return true;
    }

    if (alasanInput.value.trim() === "") {
      alasanInput.setCustomValidity("Alasan pembatalan wajib diisi.");
      return false;
    }

    alasanInput.setCustomValidity("");
    return true;
  }

  function toggleAlasan() {
    const batal = statusSelect.value === "dibatalkan";

    alasanGroup.hidden = !batal;
    alasanInput.disabled = !batal;
    alasanInput.required = batal;

    cekAlasan();
  }

  statusSelect.addEventListener("change", toggleAlasan);
  alasanInput.addEventListener("input", cekAlasan);

  if (form) {
    form.addEventListener("submit", function (event) {
      if (!cekAlasan()) {
        event.preventDefault();
        alasanInput.reportValidity();
      }
    });
  }

  toggleAlasan();
}

function initModalKonfirmasi() {
  const modal = document.getElementById("cancellationConfirmModal");

  if (!modal) {
    return;
  }

  const modalBox = modal.querySelector(".cancellation-modal-box");
  const title = document.getElementById("cancellationModalTitle");
  const message = document.getElementById("cancellationModalMessage");
  const confirmButton = document.getElementById("cancellationModalConfirm");
  const cancelButton = document.getElementById("cancellationModalCancel");

  let selectedForm = null;

  function closeModal() {
    modal.classList.remove("show");
    modal.setAttribute("aria-hidden", "true");
    selectedForm = null;
  }

  document
    .querySelectorAll(".cancellation-confirm-form")
    .forEach(function (form) {
      form.addEventListener("submit", function (event) {
        event.preventDefault();

        selectedForm = form;

        const type = form.dataset.confirmType;
        modalBox.classList.remove("is-reject");

        if (type === "approve") {
          title.textContent = "Setujui Pembatalan?";
          message.textContent =
            "Apakah kamu yakin ingin menyetujui pembatalan pesanan ini? Pesanan akan berstatus dibatalkan.";
          confirmButton.textContent = "Ya, Setujui";
        } else {
          title.textContent = "Tolak Permintaan?";
          message.textContent =
            "Apakah kamu yakin ingin menolak permintaan pembatalan ini? Pesanan akan tetap berjalan.";
          confirmButton.textContent = "Ya, Tolak";
          modalBox.classList.add("is-reject");
        }

        modal.classList.add("show");
        modal.setAttribute("aria-hidden", "false");
        confirmButton.focus();
      });
    });

  confirmButton.addEventListener("click", function () {
    if (!selectedForm) {
      return;
    }

    const formToSubmit = selectedForm;
    closeModal();

    HTMLFormElement.prototype.submit.call(formToSubmit);
  });

  cancelButton.addEventListener("click", closeModal);

  modal
    .querySelector(".cancellation-modal-backdrop")
    .addEventListener("click", closeModal);

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.classList.contains("show")) {
      closeModal();
    }
  });
}
