document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("formTambahAkun");
  const passwordInput = document.getElementById("password");
  const toggleButton = document.getElementById("togglePassBtn");

  if (toggleButton && passwordInput) {
    toggleButton.addEventListener("click", function () {
      const isHidden = passwordInput.type === "password";

      passwordInput.type = isHidden ? "text" : "password";
      toggleButton.classList.toggle("is-visible", isHidden);
    });
  }

  AkunValidasi.nama(document.getElementById("nama"));
  AkunValidasi.email(document.getElementById("email"));
  AkunValidasi.password(passwordInput);
  AkunValidasi.layananMinimal(form);
});
