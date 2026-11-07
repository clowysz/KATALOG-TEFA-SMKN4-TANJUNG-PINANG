document.addEventListener("DOMContentLoaded", function () {
  const popup = document.getElementById("popupHapusRiwayat");

  if (!popup) {
    return;
  }

  const tombolBatal = document.getElementById("hapusRiwayatBatal");
  const tombolKonfirmasi = document.getElementById("hapusRiwayatKonfirmasi");

  let formAktif = null;
  let fokusSebelumnya = null;

  function bukaPopup(button) {
    formAktif = button.closest(".rw-delete-form");

    if (!formAktif) {
      console.error("Form hapus riwayat tidak ditemukan.");
      return;
    }

    fokusSebelumnya = button;
    tombolKonfirmasi.disabled = false;

    popup.classList.add("active");
    tombolBatal.focus();
  }

  function tutupPopup() {
    popup.classList.remove("active");
    formAktif = null;

    if (fokusSebelumnya && fokusSebelumnya.isConnected) {
      fokusSebelumnya.focus();
    }
  }

  function konfirmasiHapus() {
    if (!formAktif) {
      return;
    }

    tombolKonfirmasi.disabled = true;
    formAktif.submit();
  }

  document.querySelectorAll(".rw-btn-delete").forEach(function (button) {
    button.addEventListener("click", function () {
      bukaPopup(button);
    });
  });

  tombolBatal.addEventListener("click", tutupPopup);
  tombolKonfirmasi.addEventListener("click", konfirmasiHapus);

  popup.addEventListener("click", function (event) {
    if (event.target === popup) {
      tutupPopup();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && popup.classList.contains("active")) {
      tutupPopup();
    }
  });
});
