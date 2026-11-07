/*
|--------------------------------------------------------------------------
| Halaman katalog publik
|--------------------------------------------------------------------------
| - Submit otomatis saat dropdown jurusan diganti
| - Mengingat posisi scroll saat pindah halaman pagination
*/

// Matikan autoscroll otomatis dari browser saat reload
if ("scrollRestoration" in history) {
  history.scrollRestoration = "manual";
}

document.addEventListener("DOMContentLoaded", function () {
  const selectJurusan = document.querySelector(
    '#form-filter-jurusan select[name="jurusan"]',
  );

  if (selectJurusan) {
    selectJurusan.addEventListener("change", function () {
      document.getElementById("form-filter-jurusan").submit();
    });
  }

  const savedScrollPos = sessionStorage.getItem("katalogScrollPos");

  if (savedScrollPos !== null) {
    setTimeout(function () {
      window.scrollTo({
        top: parseInt(savedScrollPos, 10),
        behavior: "instant",
      });
      sessionStorage.removeItem("katalogScrollPos");
    }, 10);
  }

  document
    .querySelectorAll(".custom-pagination .page-link")
    .forEach(function (link) {
      link.addEventListener("click", function () {
        sessionStorage.setItem("katalogScrollPos", window.scrollY);
      });
    });
});
