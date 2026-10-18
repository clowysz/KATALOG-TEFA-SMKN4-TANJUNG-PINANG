/* =========================================================
   KATALOG PRODUK & JASA - ADMIN JURUSAN

   Catatan statistik:
   Pencarian, filter, dan tombol "Lihat Detail" di sisi admin
   TIDAK menambah jumlah_pencarian / jumlah_tampilan.
   Statistik itu hanya dihitung dari halaman publik.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const produkContainer = document.getElementById("produkContainer");
  const jasaContainer = document.getElementById("jasaContainer");

  const produkSection = document.getElementById("produkSection");
  const jasaSection = document.getElementById("jasaSection");

  const searchInput = document.getElementById("searchKatalog");

  const loading = document.getElementById("katalogLoading");
  const content = document.getElementById("katalogContent");
  const emptyState = document.getElementById("katalogEmpty");
  const errorState = document.getElementById("katalogError");

  const filterButtons = document.querySelectorAll(".katalog-filter-btn");

  let semuaProduk = [];
  let semuaJasa = [];
  let filterAktif = "semua";

  // =========================================================
  // UTILITAS
  // =========================================================

  function formatRupiah(value) {
    if (value === null || value === undefined || value === "") {
      return "Rp0";
    }

    const number = Number(value);

    if (isNaN(number)) {
      return value;
    }

    return "Rp" + new Intl.NumberFormat("id-ID").format(number);
  }

  function escapeHtml(text) {
    const div = document.createElement("div");

    div.textContent = text ?? "";

    return div.innerHTML;
  }

  function getImageUrl(item, jenis) {
    if (item.gambars && item.gambars.length > 0) {
      return "/storage/" + item.gambars[0].path_gambar;
    }

    return (
      "https://placehold.co/600x400/E2E8F0/1E3A8A?text=" +
      encodeURIComponent(jenis)
    );
  }

  function getDescription(text) {
    if (!text) {
      return "Tidak ada deskripsi.";
    }

    return text.length > 80 ? text.substring(0, 80) + "..." : text;
  }

  function getFilteredData(data, keyword) {
    const search = keyword.toLowerCase().trim();

    return data.filter(function (item) {
      return (item.nama_produk_jasa || "").toLowerCase().includes(search);
    });
  }

  // =========================================================
  // RENDER KARTU
  // =========================================================

  function renderEmptySection(container, jenis) {
    const icon =
      jenis.toLowerCase() === "produk" ? "ph-package" : "ph-briefcase";

    container.innerHTML = `
            <div class="katalog-empty-box">
                <div class="katalog-empty-icon">
                    <i class="ph ${icon}"></i>
                </div>

                <h3 class="katalog-empty-title">
                    Tidak ada ${jenis.toLowerCase()} ditemukan.
                </h3>

                <p class="katalog-empty-text">
                    Coba gunakan kata kunci pencarian lain.
                </p>
            </div>
        `;
  }

  function createCard(item, jenis) {
    const card = document.createElement("div");

    card.className = "catalog-card";

    const jumlahPesanan = item.pesanans_count || 0;

    const satuanHarga = item.satuan_harga
      ? "/" + escapeHtml(item.satuan_harga)
      : "";

    const jurusan =
      item.jurusan && item.jurusan.nama_jurusan
        ? item.jurusan.nama_jurusan
        : "";

    card.innerHTML = `
            <div class="catalog-img-wrapper">
                <img
                    src="${getImageUrl(item, jenis)}"
                    alt="${escapeHtml(item.nama_produk_jasa)}"
                    class="catalog-img"
                >

                <span class="catalog-stats">
                    <i class="ph ph-shopping-cart"></i>
                    ${jumlahPesanan} pesanan
                </span>

                <span class="catalog-badge">
                    ${escapeHtml(String(jenis).toUpperCase())}
                </span>
            </div>

            <div class="catalog-content">
                <div class="catalog-title">
                    ${escapeHtml(item.nama_produk_jasa)}
                </div>

                ${
                  jurusan
                    ? `<div class="catalog-jurusan">${escapeHtml(jurusan)}</div>`
                    : ""
                }

                <div class="catalog-desc">
                    ${escapeHtml(getDescription(item.deskripsi))}
                </div>

                <div class="catalog-price">
                    ${formatRupiah(item.harga)}${satuanHarga}
                </div>

                <button
                    type="button"
                    class="btn-lihat-detail"
                    data-id="${item.id_produk_jasa}"
                >
                    Lihat Detail
                </button>
            </div>
        `;

    return card;
  }

  function renderCards(data, container, jenis) {
    if (!container) {
      return;
    }

    container.innerHTML = "";

    if (data.length === 0) {
      renderEmptySection(container, jenis);
      return;
    }

    data.forEach(function (item) {
      container.appendChild(createCard(item, jenis));
    });
  }

  // Tombol detail (event delegation)
  function bindDetailButtons(container) {
    if (!container) {
      return;
    }

    container.addEventListener("click", function (event) {
      const button = event.target.closest(".btn-lihat-detail");

      if (!button) {
        return;
      }

      window.location.href =
        "/jurusan-admin/katalog/detail?id_produk_jasa=" +
        encodeURIComponent(button.dataset.id);
    });
  }

  // =========================================================
  // RENDER KATALOG (sesuai filter jenis & kata kunci)
  // =========================================================

  function renderKatalog(keyword = "") {
    let produkFiltered = [];
    let jasaFiltered = [];

    if (filterAktif === "semua" || filterAktif === "produk") {
      produkFiltered = getFilteredData(semuaProduk, keyword);
    }

    if (filterAktif === "semua" || filterAktif === "jasa") {
      jasaFiltered = getFilteredData(semuaJasa, keyword);
    }

    // Seksi produk
    if (filterAktif === "jasa") {
      produkSection.style.display = "none";
    } else {
      produkSection.style.display = "block";
      renderCards(produkFiltered, produkContainer, "Produk");
    }

    // Seksi jasa
    if (filterAktif === "produk") {
      jasaSection.style.display = "none";
    } else {
      jasaSection.style.display = "block";
      renderCards(jasaFiltered, jasaContainer, "Jasa");
    }

    // Kosong total
    if (produkFiltered.length === 0 && jasaFiltered.length === 0) {
      produkSection.style.display = "none";
      jasaSection.style.display = "none";

      emptyState.style.display = "block";
    } else {
      emptyState.style.display = "none";
    }
  }

  // =========================================================
  // AMBIL DATA
  // =========================================================

  function fetchJenis(jenis) {
    return fetch("/jurusan-admin/produk?jenis=" + jenis, {
      method: "GET",
      headers: { Accept: "application/json" },
    });
  }

  async function loadKatalog() {
    try {
      const [responseProduk, responseJasa] = await Promise.all([
        fetchJenis("produk"),
        fetchJenis("jasa"),
      ]);

      if (!responseProduk.ok || !responseJasa.ok) {
        throw new Error("Gagal mengambil data katalog.");
      }

      const resultProduk = await responseProduk.json();
      const resultJasa = await responseJasa.json();

      semuaProduk = resultProduk.data || [];
      semuaJasa = resultJasa.data || [];

      loading.style.display = "none";

      // Database kosong
      if (semuaProduk.length === 0 && semuaJasa.length === 0) {
        content.style.display = "none";
        emptyState.style.display = "block";
        return;
      }

      content.style.display = "block";

      renderKatalog(searchInput ? searchInput.value : "");
    } catch (error) {
      console.error(error);

      loading.style.display = "none";
      content.style.display = "none";
      emptyState.style.display = "none";
      errorState.style.display = "block";
    }
  }

  // =========================================================
  // PENCARIAN & FILTER
  // =========================================================

  if (searchInput) {
    searchInput.addEventListener("input", function () {
      renderKatalog(this.value);
    });
  }

  filterButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      filterAktif = this.getAttribute("data-filter");

      filterButtons.forEach(function (filterButton) {
        filterButton.classList.remove("active");
      });

      this.classList.add("active");

      renderKatalog(searchInput ? searchInput.value : "");
    });
  });

  // =========================================================
  // MULAI
  // =========================================================

  bindDetailButtons(produkContainer);
  bindDetailButtons(jasaContainer);

  loadKatalog();
});
