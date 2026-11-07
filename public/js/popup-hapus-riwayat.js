/* =========================================================
   POPUP HAPUS RIWAYAT PESANAN (PEMBELI)

   Dipakai oleh: resources/views/public/riwayat.blade.php

   Tombol sampah (.rw-btn-delete) membuka popup konfirmasi.
   Jika dikonfirmasi, form hapus di baris yang sama dikirim.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const popup = document.getElementById("popupHapusRiwayat");

  if (!popup) {
    return;
  }

  const tombolBatal = document.getElementById("hapusRiwayatBatal");
  const tombolKonfirmasi = document.getElementById("hapusRiwayatKonfirmasi");

  let formAktif = null;
  let fokusSebelumnya = null;

  // Membuka popup untuk baris pesanan yang dipilih.
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

  // Menutup popup tanpa menghapus.
  function tutupPopup() {
    popup.classList.remove("active");
    formAktif = null;

    if (fokusSebelumnya && fokusSebelumnya.isConnected) {
      fokusSebelumnya.focus();
    }
  }

  // Mengirim form hapus setelah dikonfirmasi.
  function konfirmasiHapus() {
    if (!formAktif) {
      return;
    }

    // Cegah klik ganda.
    tombolKonfirmasi.disabled = true;
    formAktif.submit();
  }

  // Tombol sampah pada tiap baris.
  document.querySelectorAll(".rw-btn-delete").forEach(function (button) {
    button.addEventListener("click", function () {
      bukaPopup(button);
    });
  });

  tombolBatal.addEventListener("click", tutupPopup);
  tombolKonfirmasi.addEventListener("click", konfirmasiHapus);

  // Tutup ketika area luar popup diklik.
  popup.addEventListener("click", function (event) {
    if (event.target === popup) {
      tutupPopup();
    }
  });

  // Tutup menggunakan tombol Escape.
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && popup.classList.contains("active")) {
      tutupPopup();
    }
  });
});
