/*
|--------------------------------------------------------------------------
| Validasi form daftar pembeli
|--------------------------------------------------------------------------
| Membutuhkan form-validasi.js
| Toggle password ditangani oleh password-toggle.js
*/
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formDaftarPembeli");
  const nama = document.getElementById("namaPembeli");
  const nomorHp = document.getElementById("nomorHpPembeli");
  const email = document.getElementById("emailDaftarPembeli");
  const password = document.getElementById("passwordDaftar");
  const konfirmasi = document.getElementById("passwordKonfirmasi");

  if (
    !form ||
    !nama ||
    !nomorHp ||
    !email ||
    !password ||
    !konfirmasi ||
    !window.FormValidasi
  )
    return;

  const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  // Nomor HP: hanya boleh angka (dipasang sebelum validasi)
  nomorHp.addEventListener("input", function () {
    nomorHp.value = nomorHp.value.replace(/[^0-9]/g, "");
  });

  FormValidasi.pasang(form, [
    // NAMA
    {
      input: nama,
      cek: function () {
        if (nama.value.trim() === "") {
          return "Nama lengkap wajib diisi.";
        }

        return "";
      },
    },

    // NOMOR HP
    {
      input: nomorHp,
      cek: function () {
        if (nomorHp.value.trim() === "") {
          return "Nomor telepon wajib diisi.";
        }

        return "";
      },
    },

    // EMAIL
    {
      input: email,
      cek: function () {
        const value = email.value.trim();

        if (value === "") {
          return "Email wajib diisi.";
        }

        if (!polaEmail.test(value)) {
          return "Silakan masukkan alamat email yang valid. Contoh: nama@email.com.";
        }

        return "";
      },
    },

    // PASSWORD (saat berubah, konfirmasi ikut dicek ulang)
    {
      input: password,
      ulangi: [konfirmasi],
      cek: function () {
        if (password.value === "") {
          return "Sandi wajib diisi.";
        }

        if (password.value.length < 8) {
          return "Sandi harus memiliki minimal 8 karakter.";
        }

        return "";
      },
    },

    // KONFIRMASI PASSWORD
    {
      input: konfirmasi,
      cek: function () {
        if (konfirmasi.value === "") {
          return "Konfirmasi password wajib diisi.";
        }

        if (konfirmasi.value.length < 8) {
          return "Konfirmasi password harus memiliki minimal 8 karakter.";
        }

        if (konfirmasi.value !== password.value) {
          return "Konfirmasi password tidak sama dengan password.";
        }

        return "";
      },
    },
  ]);
});
