/* =========================================================
   VALIDASI FORM AKUN - ADMIN JURUSAN

   Dipakai oleh halaman Tambah Akun & Edit Akun.
   Pesan validasi berbahasa Indonesia.

   - AkunValidasi.nama(input)
   - AkunValidasi.email(input)
   - AkunValidasi.password(input)
   - AkunValidasi.layananMinimal(form)
========================================================= */

window.AkunValidasi = (function () {
  "use strict";

  const EMAIL_PATTERN = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // ------------------------------------------------------
  // Nama
  // ------------------------------------------------------
  function nama(input) {
    if (!input) {
      return;
    }

    input.addEventListener("invalid", function () {
      this.setCustomValidity(
        this.validity.valueMissing ? "Nama pengguna wajib diisi." : "",
      );
    });

    input.addEventListener("input", function () {
      this.setCustomValidity("");
    });
  }

  // ------------------------------------------------------
  // Email
  // ------------------------------------------------------
  function email(input) {
    if (!input) {
      return;
    }

    function validate() {
      const value = input.value.trim();

      if (value === "") {
        input.setCustomValidity("Email wajib diisi.");
        return;
      }

      if (!EMAIL_PATTERN.test(value)) {
        input.setCustomValidity(
          "Silakan masukkan alamat email yang valid. Contoh: nama@email.com.",
        );
        return;
      }

      input.setCustomValidity("");
    }

    input.addEventListener("invalid", validate);
    input.addEventListener("input", validate);
  }

  // ------------------------------------------------------
  // Password (minimal 6 karakter)
  // ------------------------------------------------------
  function password(input) {
    if (!input) {
      return;
    }

    input.addEventListener("invalid", function () {
      if (this.validity.valueMissing) {
        this.setCustomValidity("Password wajib diisi.");
      } else if (this.validity.tooShort) {
        this.setCustomValidity("Password harus memiliki minimal 6 karakter.");
      } else {
        this.setCustomValidity("");
      }
    });

    input.addEventListener("input", function () {
      if (this.value.length === 0) {
        this.setCustomValidity("Password wajib diisi.");
      } else if (this.value.length < 6) {
        this.setCustomValidity("Password harus memiliki minimal 6 karakter.");
      } else {
        this.setCustomValidity("");
      }
    });
  }

  // ------------------------------------------------------
  // Produk / jasa: minimal satu harus dipilih
  // ------------------------------------------------------
  function layananMinimal(form) {
    if (!form) {
      return;
    }

    const checkboxes = form.querySelectorAll('input[name="layanan[]"]');

    if (checkboxes.length === 0) {
      return;
    }

    function jumlahDipilih() {
      return form.querySelectorAll('input[name="layanan[]"]:checked').length;
    }

    form.addEventListener("submit", function (event) {
      if (jumlahDipilih() === 0) {
        event.preventDefault();

        checkboxes[0].setCustomValidity(
          "Pilih minimal satu produk/jasa yang menjadi tanggung jawab Admin Produser.",
        );
        checkboxes[0].reportValidity();
      } else {
        checkboxes[0].setCustomValidity("");
      }
    });

    checkboxes.forEach(function (checkbox) {
      checkbox.addEventListener("change", function () {
        if (jumlahDipilih() > 0) {
          checkboxes[0].setCustomValidity("");
        }
      });
    });
  }

  return {
    nama: nama,
    email: email,
    password: password,
    layananMinimal: layananMinimal,
  };
})();
