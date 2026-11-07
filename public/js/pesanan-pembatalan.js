/* =========================================================
   KELOLA PESANAN ADMIN TEFA - DAFTAR PERMINTAAN PEMBATALAN

   Dipakai oleh: admin/admin_tefa/pesanan/index.blade.php

   Fitur:
   - Tombol Tampilkan / Sembunyikan daftar permintaan pembatalan
   - Pencarian dan filter jurusan pada daftar tersebut
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const toggleButton = document.getElementById("toggleCancellationList");
  const cancellationList = document.getElementById("cancellationList");
  const mainPesananContent = document.getElementById("mainPesananContent");

  // Daftar permintaan pembatalan hanya ada jika ada permintaan.
  if (!cancellationList) {
    return;
  }

  // ==========================================
  // TOMBOL TAMPILKAN / SEMBUNYIKAN
  // ==========================================
  if (toggleButton && mainPesananContent) {
    toggleButton.addEventListener("click", function () {
      const sedangTerbuka = !cancellationList.hidden;

      cancellationList.hidden = sedangTerbuka;
      mainPesananContent.hidden = !sedangTerbuka;

      toggleButton.textContent = sedangTerbuka ? "Tampilkan" : "Sembunyikan";

      toggleButton.setAttribute(
        "aria-expanded",
        sedangTerbuka ? "false" : "true",
      );
    });
  }

  // ==========================================
  // FILTER PERMINTAAN PEMBATALAN
  // ==========================================
  const searchInput = document.getElementById("searchCancellation");
  const filterJurusan = document.getElementById("filterCancellationJurusan");
  const emptyMessage = document.getElementById("emptyCancellation");
  const rows = cancellationList.querySelectorAll("tr.cancellation-row");

  // Menyamakan teks: tanpa aksen, huruf kecil, spasi tunggal.
  function normalisasi(teks) {
    return (teks || "")
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .trim()
      .toLowerCase()
      .replace(/\s+/g, " ");
  }

  const aliasJurusan = {
    rpl: ["rekayasa perangkat lunak", "rpl"],
    tkj: ["teknik komputer dan jaringan", "tkj"],
    dkv: ["desain komunikasi visual", "dkv"],
    animasi: ["animasi"],
    gim: ["pengembangan gim", "gim"],
    pspt: ["produksi dan siaran program televisi", "pspt"],
  };

  function filterPermintaanPembatalan() {
    const keyword = normalisasi(searchInput?.value);
    const pilihan = normalisasi(filterJurusan?.value || "semua");
    const aliasTerpilih = aliasJurusan[pilihan] || [];

    let jumlahTampil = 0;

    rows.forEach(function (row) {
      const nomor = normalisasi(row.dataset.id);
      const nama = normalisasi(row.dataset.nama);
      const produk = normalisasi(row.dataset.produk);
      const jurusan = normalisasi(row.dataset.jurusan);

      const cocokPencarian =
        nomor.includes(keyword) ||
        nama.includes(keyword) ||
        produk.includes(keyword) ||
        jurusan.includes(keyword);

      const cocokJurusan =
        pilihan === "semua" || aliasTerpilih.includes(jurusan);

      const tampilkan = cocokPencarian && cocokJurusan;

      // Disembunyikan lewat atribut hidden (diatur di CSS),
      // sehingga tampilan tabel/kartu tidak rusak.
      row.hidden = !tampilkan;

      if (tampilkan) {
        jumlahTampil++;
      }
    });

    if (emptyMessage) {
      emptyMessage.hidden = jumlahTampil > 0;
    }
  }

  if (searchInput) {
    searchInput.addEventListener("input", filterPermintaanPembatalan);
  }

  if (filterJurusan) {
    filterJurusan.addEventListener("change", filterPermintaanPembatalan);
  }

  filterPermintaanPembatalan();
});
