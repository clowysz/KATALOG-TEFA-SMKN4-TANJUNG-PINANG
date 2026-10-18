/* =========================================================
   DETAIL AKUN - ADMIN JURUSAN
   Nonaktifkan (dengan konfirmasi) & aktifkan akun.

   Data dibaca dari atribut pada #akunDetail di blade:
   - data-akun-id     : id akun
   - data-status-url  : alamat route perubahan status
   Token CSRF diambil dari <meta name="csrf-token"> di layout.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const root = document.getElementById("akunDetail");

  if (!root) {
    return;
  }

  const accountId = Number(root.dataset.akunId);
  const statusUrl = root.dataset.statusUrl;

  const csrfMeta = document.querySelector('meta[name="csrf-token"]');
  const csrfToken = csrfMeta ? csrfMeta.getAttribute("content") : "";

  const statusModal = document.getElementById("statusModal");
  const btnNonaktifkan = document.getElementById("btnNonaktifkan");
  const btnAktifkan = document.getElementById("btnAktifkan");
  const btnCloseStatusModal = document.getElementById("btnCloseStatusModal");
  const btnConfirmStatus = document.getElementById("btnConfirmStatus");

  // ------------------------------------------------------
  // Modal konfirmasi
  // ------------------------------------------------------
  function openModal() {
    if (statusModal) {
      statusModal.classList.add("active");
    }
  }

  function closeModal() {
    if (statusModal) {
      statusModal.classList.remove("active");
    }
  }

  // ------------------------------------------------------
  // Kirim perubahan status
  // ------------------------------------------------------
  async function ubahStatus(status, pesanGagal, pesanError) {
    try {
      const response = await fetch(statusUrl, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": csrfToken,
          Accept: "application/json",
        },
        body: JSON.stringify({
          id: accountId,
          status: status,
        }),
      });

      const data = await response.json();

      if (data.success) {
        window.location.reload();
        return;
      }

      alert(data.message ?? pesanGagal);
    } catch (error) {
      console.error(error);

      alert(pesanError);
    }
  }

  // ------------------------------------------------------
  // Tombol
  // ------------------------------------------------------
  if (btnNonaktifkan) {
    btnNonaktifkan.addEventListener("click", openModal);
  }

  if (btnCloseStatusModal) {
    btnCloseStatusModal.addEventListener("click", closeModal);
  }

  if (btnConfirmStatus) {
    btnConfirmStatus.addEventListener("click", function () {
      ubahStatus(
        "tidak_aktif",
        "Gagal mengubah status akun.",
        "Terjadi kesalahan saat mengubah status akun.",
      );
    });
  }

  if (btnAktifkan) {
    btnAktifkan.addEventListener("click", function () {
      ubahStatus(
        "aktif",
        "Gagal mengaktifkan akun.",
        "Terjadi kesalahan saat mengaktifkan akun.",
      );
    });
  }

  // Klik area gelap menutup modal
  if (statusModal) {
    statusModal.addEventListener("click", function (event) {
      if (event.target === statusModal) {
        closeModal();
      }
    });
  }
});
