/* =========================================================
   DAFTAR AKUN - ADMIN JURUSAN
   Pencarian (nama / email) + filter status + filter produk/jasa.

   Data tiap baris dibaca dari atribut pada <tr class="akun-row">:
   data-nama, data-email, data-status, data-layanan
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("searchAkun");
  const filterStatus = document.getElementById("filterStatus");
  const filterLayanan = document.getElementById("filterLayanan");

  const rows = document.querySelectorAll(".akun-row");
  const emptyAkun = document.getElementById("emptyAkun");
  const emptyAkunRow = document.getElementById("emptyAkunRow");

  if (!searchInput || !filterStatus || !filterLayanan) {
    return;
  }

  function filterAkun() {
    const search = searchInput.value.toLowerCase().trim();
    const status = filterStatus.value.toLowerCase();
    const layanan = filterLayanan.value.toLowerCase();

    let jumlahTampil = 0;

    rows.forEach(function (row) {
      const nama = row.dataset.nama || "";
      const email = row.dataset.email || "";
      const rowStatus = row.dataset.status || "";
      const dataLayanan = row.dataset.layanan || "";

      const cocokSearch = nama.includes(search) || email.includes(search);
      const cocokStatus = status === "semua" || rowStatus === status;
      const cocokLayanan = layanan === "semua" || dataLayanan.includes(layanan);

      const tampil = cocokSearch && cocokStatus && cocokLayanan;

      row.style.display = tampil ? "" : "none";

      if (tampil) {
        jumlahTampil++;
      }
    });

    if (emptyAkunRow) {
      emptyAkunRow.style.display = "none";
    }

    emptyAkun.style.display =
      jumlahTampil === 0 && rows.length > 0 ? "block" : "none";
  }

  searchInput.addEventListener("input", filterAkun);
  filterStatus.addEventListener("change", filterAkun);
  filterLayanan.addEventListener("change", filterAkun);
});
