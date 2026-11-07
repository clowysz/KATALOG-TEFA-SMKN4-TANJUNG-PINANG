document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formLoginPembeli");
  const email = document.getElementById("emailLoginPembeli");
  const password = document.getElementById("passwordPembeli");

  if (!form || !email || !password || !window.FormValidasi) return;

  const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  FormValidasi.pasang(form, [
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
      cek: function () {
        if (password.value === "") {
          return "Password wajib diisi.";
        }

        return "";
      },
    },
  ]);
});
