/* =========================================================
   EDIT AKUN - ADMIN JURUSAN

   Urutan script di blade:
   1. akun-validasi-jurusan.js
   2. akun-edit-jurusan.js (file ini)
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  AkunValidasi.nama(document.getElementById("nama"));
  AkunValidasi.email(document.getElementById("email"));
  AkunValidasi.layananMinimal(document.getElementById("formEditAkun"));
});
