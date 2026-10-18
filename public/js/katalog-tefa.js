/* =========================================================
   KATALOG TEFA (admin_tefa/katalog-gabungan)

   1. Menyesuaikan jumlah item per halaman dengan lebar layar
        - Desktop / tablet (> 768px) : 4 kolom x 4 baris = 16 item
        - Mobile (<= 768px)          : 3 kolom x 5 baris = 15 item
      Supaya baris terakhir selalu penuh dan tidak ada ruang kosong.

   2. Filter: dropdown jenis & jurusan langsung memuat ulang daftar
      saat diganti (kolom pencarian dikirim lewat tombol Cari / Enter)

   3. Memilih card untuk dijadikan PDF
        - Pilihan TERSIMPAN saat pindah halaman (pagination),
          jadi pilihan di halaman 1 tidak hilang di halaman 2.
        - "Pilih Semua" memilih SEMUA item hasil query di SEMUA halaman
          (jika ada filter: hanya item yang sesuai filter).

   Script ini dimuat sebelum kontennya (agar penyesuaian per halaman
   berjalan cepat), dan membawa nilai dari server lewat atribut:
        <script src="..."
                data-per-page="16"
                data-all-ids='[1,2,3,...]'></script>
========================================================= */

(function () {
  "use strict";

  const PER_PAGE_DESKTOP = 16;
  const PER_PAGE_MOBILE = 15;
  const STORAGE_KEY = "katalogTefaSelected";

  // Harus dibaca saat script dijalankan pertama kali
  const scriptTag = document.currentScript;
  const currentPerPage = parseInt(scriptTag.dataset.perPage, 10);
  const allIds = parseIdList(scriptTag.dataset.allIds);
  const mobileQuery = window.matchMedia("(max-width: 768px)");

  // ==========================================================
  // BANTUAN
  // ==========================================================

  // Ubah teks JSON "[1,2,3]" menjadi array string ["1","2","3"]
  function parseIdList(text) {
    try {
      const parsed = JSON.parse(text || "[]");

      return Array.isArray(parsed) ? parsed.map(String) : [];
    } catch (error) {
      return [];
    }
  }

  // ==========================================================
  // 1. JUMLAH ITEM PER HALAMAN
  // ==========================================================

  function syncPerPage() {
    const desired = mobileQuery.matches ? PER_PAGE_MOBILE : PER_PAGE_DESKTOP;

    if (desired === currentPerPage) {
      return false;
    }

    const url = new URL(window.location.href);
    url.searchParams.set("per_page", desired);
    url.searchParams.set("page", 1);

    window.location.replace(url.toString());

    return true;
  }

  // Jika halaman sedang dialihkan, tidak perlu menyiapkan fitur lain
  if (syncPerPage()) {
    return;
  }

  if (mobileQuery.addEventListener) {
    mobileQuery.addEventListener("change", syncPerPage);
  } else if (mobileQuery.addListener) {
    mobileQuery.addListener(syncPerPage);
  }

  // ==========================================================
  // 3. PILIH CARD UNTUK PDF
  // ==========================================================

  // Pilihan disimpan di sessionStorage (per tab) agar bertahan
  // saat pindah halaman pagination.
  function loadSelected() {
    try {
      return new Set(parseIdList(sessionStorage.getItem(STORAGE_KEY)));
    } catch (error) {
      return new Set();
    }
  }

  function saveSelected(selectedItems) {
    try {
      sessionStorage.setItem(
        STORAGE_KEY,
        JSON.stringify(Array.from(selectedItems)),
      );
    } catch (error) {
      // Penyimpanan tidak tersedia: pilihan hanya berlaku di halaman ini
    }
  }

  // ==========================================================
  // FILTER
  // ==========================================================

  function initFilter() {
    document.querySelectorAll("[data-auto-submit]").forEach(function (field) {
      field.addEventListener("change", function () {
        field.form.submit();
      });
    });
  }

  function initSelection() {
    const selectedItems = loadSelected();

    const cards = document.querySelectorAll(".katalog-card[data-id]");
    const selectedCount = document.getElementById("selected-count");
    const selectAllButton = document.getElementById("btn-select-all");
    const generateButton = document.getElementById("btn-generate-pdf");
    const selectedInputs = document.getElementById("selected-inputs");
    const pdfForm = document.getElementById("pdf-form");

    // Apakah SEMUA item hasil query (di semua halaman) sudah dipilih?
    function isAllSelected() {
      return (
        allIds.length > 0 &&
        allIds.every(function (id) {
          return selectedItems.has(id);
        })
      );
    }

    function updateSelectedUI() {
      selectedCount.textContent = selectedItems.size;
      generateButton.disabled = selectedItems.size === 0;

      // Tandai card yang tampil di halaman ini
      cards.forEach(function (card) {
        card.classList.toggle("selected", selectedItems.has(card.dataset.id));
      });

      selectAllButton.textContent = isAllSelected()
        ? "Batalkan Semua"
        : "Pilih Semua";

      // Input tersembunyi berisi SEMUA pilihan (bukan hanya halaman ini)
      selectedInputs.innerHTML = "";

      selectedItems.forEach(function (id) {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "produk_jasa_ids[]";
        input.value = id;
        selectedInputs.appendChild(input);
      });

      saveSelected(selectedItems);
    }

    cards.forEach(function (card) {
      card.addEventListener("click", function (event) {
        // Klik pada tombol "Lihat Detail" tidak memilih card
        if (event.target.closest(".btn-detail")) {
          return;
        }

        const id = card.dataset.id;

        if (selectedItems.has(id)) {
          selectedItems.delete(id);
        } else {
          selectedItems.add(id);
        }

        updateSelectedUI();
      });
    });

    // Pilih / batalkan SEMUA item hasil query di semua halaman
    selectAllButton.addEventListener("click", function () {
      if (allIds.length === 0) {
        return;
      }

      const batalkan = isAllSelected();

      allIds.forEach(function (id) {
        if (batalkan) {
          selectedItems.delete(id);
        } else {
          selectedItems.add(id);
        }
      });

      updateSelectedUI();
    });

    pdfForm.addEventListener("submit", function (event) {
      if (selectedItems.size === 0) {
        event.preventDefault();
        alert("Silakan pilih minimal satu produk atau jasa.");
      }
    });

    updateSelectedUI();
  }

  document.addEventListener("DOMContentLoaded", function () {
    initFilter();
    initSelection();
  });
})();
