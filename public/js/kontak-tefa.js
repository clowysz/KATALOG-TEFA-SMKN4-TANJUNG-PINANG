(function () {
  "use strict";

  const REGEX_NOMOR = /^628\d{8,11}$/;

  const PESAN = {
    kosong: "Nomor wajib diisi.",
    tidakValid:
      "Nomor tidak valid. Gunakan nomor HP Indonesia, contoh: 0896-5362-8650.",
    belumBerubah: "Nomor belum diubah.",
  };

  function ambilAngka(teks) {
    return teks.replace(/\D+/g, "");
  }

  function bersihkan(teks) {
    return teks.replace(/[^\d+\-\s]/g, "");
  }

  function normalisasi(teks) {
    const angka = ambilAngka(teks);

    if (angka.startsWith("62")) {
      return angka;
    }

    if (angka.startsWith("0")) {
      return "62" + angka.slice(1);
    }

    if (angka.startsWith("8")) {
      return "62" + angka;
    }

    return angka;
  }

  document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("kontak-form");

    if (!form) {
      return;
    }

    const input = form.querySelector("input[data-awal]");
    const pesanError = form.querySelector(".kontak-error");

    if (!input || !pesanError) {
      return;
    }

    const nomorAwal = input.dataset.awal || "";

    function tampilkanError(teks) {
      pesanError.textContent = teks;
      input.classList.add("is-invalid");
      input.setAttribute("aria-invalid", "true");
    }

    function hapusError() {
      pesanError.textContent = "";
      input.classList.remove("is-invalid");
      input.removeAttribute("aria-invalid");
    }

    function periksaNomor() {
      const nilai = input.value.trim();

      if (ambilAngka(nilai).length === 0) {
        return PESAN.kosong;
      }

      const nomor = normalisasi(nilai);

      if (!REGEX_NOMOR.test(nomor)) {
        return PESAN.tidakValid;
      }

      if (nomor === normalisasi(nomorAwal)) {
        return PESAN.belumBerubah;
      }

      return "";
    }

    input.addEventListener("input", function () {
      input.value = bersihkan(input.value);
      hapusError();
    });

    form.addEventListener("submit", function (event) {
      const pesan = periksaNomor();

      if (pesan !== "") {
        event.preventDefault();
        tampilkanError(pesan);
        input.focus();
      }
    });

    const modal = document.getElementById("kontak-modal");

    if (!modal) {
      return;
    }

    const tombolBuka = document.querySelectorAll("[data-kontak-buka]");
    const tombolTutup = modal.querySelectorAll("[data-kontak-tutup]");
    let pemicu = null;

    function bukaModal(elemenPemicu) {
      pemicu = elemenPemicu || null;

      input.value = nomorAwal;
      hapusError();

      modal.classList.add("active");
      document.body.classList.add("kontak-modal-terbuka");

      input.focus();
      input.select();
    }

    function tutupModal() {
      modal.classList.remove("active");
      document.body.classList.remove("kontak-modal-terbuka");

      if (pemicu) {
        pemicu.focus();
      }
    }

    tombolBuka.forEach(function (tombol) {
      tombol.addEventListener("click", function () {
        bukaModal(tombol);
      });
    });

    tombolTutup.forEach(function (tombol) {
      tombol.addEventListener("click", tutupModal);
    });

    modal.addEventListener("click", function (event) {
      if (event.target === modal) {
        tutupModal();
      }
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape" && modal.classList.contains("active")) {
        tutupModal();
      }
    });

    if (modal.classList.contains("active")) {
      pemicu = tombolBuka[0] || null;
      document.body.classList.add("kontak-modal-terbuka");
      input.focus();
    }
  });
})();
