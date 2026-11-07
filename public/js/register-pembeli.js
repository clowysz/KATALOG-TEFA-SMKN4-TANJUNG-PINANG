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

  nomorHp.addEventListener("input", function () {
    nomorHp.value = nomorHp.value.replace(/[^0-9]/g, "");
  });

  FormValidasi.pasang(form, [
    {
      input: nama,
      cek: function () {
        if (nama.value.trim() === "") {
          return "Nama lengkap wajib diisi.";
        }

        return "";
      },
    },

    {
      input: nomorHp,
      cek: function () {
        if (nomorHp.value.trim() === "") {
          return "Nomor telepon wajib diisi.";
        }

        return "";
      },
    },

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
