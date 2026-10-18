/* =========================================================
   FORM AKUN (dipakai halaman Tambah Akun dan Edit Akun)

   - Menampilkan / menyembunyikan pilihan jurusan sesuai role
   - Pesan validasi: nama, email, password, role, jurusan, status

   Elemen yang tidak ada di salah satu halaman (misalnya password
   di halaman edit) otomatis dilewati.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const namaInput = document.getElementById("nama");
  const emailInput = document.getElementById("email");
  const passwordInput = document.getElementById("password");

  const roleSelect = document.getElementById("role");
  const jurusanSelect = document.getElementById("id_jurusan");
  const jurusanContainer = document.getElementById("jurusanContainer");
  const helpText = document.getElementById("helpTextJurusan");

  const statusSelect = document.getElementById("status");

  // ==========================================================
  // JURUSAN: TAMPIL / SEMBUNYI SESUAI ROLE
  // ==========================================================

  function updateJurusan() {
    if (!roleSelect || !jurusanSelect) {
      return;
    }

    if (roleSelect.value === "admin_jurusan") {
      if (jurusanContainer) {
        jurusanContainer.style.display = "block";
      }

      jurusanSelect.disabled = false;
      jurusanSelect.required = true;

      if (helpText) {
        helpText.textContent =
          "Pilih jurusan yang menjadi tanggung jawab akun ini. " +
          'Jurusan bertanda "admin sebelumnya nonaktif" akan dialihkan ke akun ini.';
      }

      return;
    }

    if (jurusanContainer) {
      jurusanContainer.style.display = "none";
    }

    jurusanSelect.disabled = true;
    jurusanSelect.required = false;
    jurusanSelect.value = "";
    jurusanSelect.setCustomValidity("");

    if (helpText) {
      helpText.textContent =
        roleSelect.value === "admin_tefa"
          ? "Admin TEFA tidak terikat pada jurusan tertentu."
          : "Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.";
    }
  }

  // ==========================================================
  // ROLE
  // ==========================================================

  if (roleSelect) {
    roleSelect.addEventListener("invalid", function () {
      this.setCustomValidity(
        this.validity.valueMissing ? "Role wajib dipilih." : "",
      );
    });

    roleSelect.addEventListener("change", function () {
      this.setCustomValidity("");

      updateJurusan();
    });

    updateJurusan();
  }

  // ==========================================================
  // JURUSAN
  // ==========================================================

  if (jurusanSelect) {
    jurusanSelect.addEventListener("invalid", function () {
      const wajibDipilih =
        roleSelect &&
        roleSelect.value === "admin_jurusan" &&
        this.validity.valueMissing;

      this.setCustomValidity(
        wajibDipilih ? "Jurusan wajib dipilih untuk Admin Jurusan." : "",
      );
    });

    jurusanSelect.addEventListener("change", function () {
      this.setCustomValidity("");
    });
  }

  // ==========================================================
  // NAMA
  // ==========================================================

  if (namaInput) {
    namaInput.addEventListener("invalid", function () {
      this.setCustomValidity(
        this.validity.valueMissing ? "Nama pengguna wajib diisi." : "",
      );
    });

    namaInput.addEventListener("input", function () {
      this.setCustomValidity("");
    });
  }

  // ==========================================================
  // EMAIL
  // ==========================================================

  if (emailInput) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function validateEmail() {
      const value = emailInput.value.trim();

      if (value === "") {
        emailInput.setCustomValidity("Email wajib diisi.");

        return;
      }

      if (!emailPattern.test(value)) {
        emailInput.setCustomValidity(
          "Silakan masukkan alamat email yang valid. Contoh: nama@email.com.",
        );

        return;
      }

      emailInput.setCustomValidity("");
    }

    emailInput.addEventListener("invalid", validateEmail);
    emailInput.addEventListener("input", validateEmail);
  }

  // ==========================================================
  // PASSWORD (hanya ada di halaman Tambah Akun)
  // ==========================================================

  if (passwordInput) {
    passwordInput.addEventListener("invalid", function () {
      if (this.validity.valueMissing) {
        this.setCustomValidity("Password wajib diisi.");
      } else if (this.validity.tooShort) {
        this.setCustomValidity("Password harus memiliki minimal 6 karakter.");
      } else {
        this.setCustomValidity("");
      }
    });

    passwordInput.addEventListener("input", function () {
      if (this.value.length === 0) {
        this.setCustomValidity("Password wajib diisi.");
      } else if (this.value.length < 6) {
        this.setCustomValidity("Password harus memiliki minimal 6 karakter.");
      } else {
        this.setCustomValidity("");
      }
    });
  }

  // ==========================================================
  // STATUS
  // ==========================================================

  if (statusSelect) {
    statusSelect.addEventListener("invalid", function () {
      this.setCustomValidity(
        this.validity.valueMissing ? "Status akun wajib dipilih." : "",
      );
    });

    statusSelect.addEventListener("change", function () {
      this.setCustomValidity("");
    });
  }
});
