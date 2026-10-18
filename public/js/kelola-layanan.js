/* =========================================================
   KELOLA PRODUK & KELOLA JASA - ADMIN JURUSAN

   Satu file untuk dua halaman. Jenis halaman dideteksi dari
   container: #kelolaProdukContainer (produk) atau
   #kelolaJasaContainer (jasa).

   Atribut di blade:
   - data-open-tambah        : membuka modal tambah
   - data-close-modal="id"   : menutup modal
========================================================= */

// =========================================================
// MODAL (global: dibungkus oleh form-helper-jurusan.js)
// =========================================================

function openLayananModal(id) {
  const modal = document.getElementById(id);

  if (modal) {
    modal.classList.add("active");
  }
}

function closeLayananModal(id) {
  const modal = document.getElementById(id);

  if (modal) {
    modal.classList.remove("active");
  }
}

// =========================================================
// UTILITAS HALAMAN
// =========================================================

function getCsrfToken() {
  const meta = document.querySelector('meta[name="csrf-token"]');

  if (!meta) {
    console.error("CSRF token tidak ditemukan.");
    return "";
  }

  return meta.getAttribute("content");
}

function showLayananToast(message, success = true) {
  const toast = document.getElementById("toastNotif");

  if (!toast) {
    return;
  }

  toast.textContent = message;
  toast.classList.toggle("is-error", !success);
  toast.classList.add("show");

  setTimeout(function () {
    toast.classList.remove("show");
  }, 3000);
}

function isHalamanProduk() {
  return document.getElementById("kelolaProdukContainer") !== null;
}

function getTipeLayanan() {
  return isHalamanProduk() ? "Produk" : "Jasa";
}

function getJenisLayanan() {
  return isHalamanProduk() ? "produk" : "jasa";
}

function escapeHtml(text) {
  const div = document.createElement("div");

  div.textContent = text ?? "";

  return div.innerHTML;
}

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

function shortDescription(text, length = 60) {
  if (!text) {
    return "";
  }

  return text.length <= length ? text : text.substring(0, length) + "...";
}

// =========================================================
// MODAL TAMBAH
// =========================================================

function openTambahModal() {
  const form = document.getElementById("formLayanan");

  if (form) {
    form.reset();
  }

  const formId = document.getElementById("formId");

  if (formId) {
    formId.value = "";
  }

  const modalTitle = document.getElementById("modalFormTitle");

  if (modalTitle) {
    modalTitle.textContent = `Tambah ${getTipeLayanan()}`;
  }

  const formImg = document.getElementById("formImg");

  if (formImg) {
    formImg.setAttribute("required", "true");
    formImg.value = "";
  }

  const preview = document.getElementById("imagePreviewContainer");

  if (preview) {
    preview.innerHTML = "";
  }

  window.uploadedFiles = [];

  openLayananModal("modalAdd");
}

// =========================================================
// HALAMAN SIAP
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
  const tipeLayanan = getTipeLayanan();
  const jenisLayanan = getJenisLayanan();

  const container = document.getElementById(
    isHalamanProduk() ? "kelolaProdukContainer" : "kelolaJasaContainer",
  );

  const searchInput = document.getElementById("searchItem");
  const form = document.getElementById("formLayanan");
  const formImg = document.getElementById("formImg");
  const previewContainer = document.getElementById("imagePreviewContainer");

  let dataItems = [];

  // ------------------------------------------------------
  // Tombol buka / tutup modal (lewat atribut data-*)
  // closeLayananModal dipanggil lewat nama global supaya
  // versi yang dibungkus form-helper-jurusan.js ikut berjalan.
  // ------------------------------------------------------
  document.addEventListener("click", function (event) {
    if (event.target.closest("[data-open-tambah]")) {
      openTambahModal();
      return;
    }

    const closeButton = event.target.closest("[data-close-modal]");

    if (closeButton) {
      closeLayananModal(closeButton.dataset.closeModal);
    }
  });

  // ------------------------------------------------------
  // Tampilan kosong / error di dalam grid
  // ------------------------------------------------------
  function stateHtml(icon, title, text) {
    return `
            <div class="grid-state">
                <div class="grid-state-icon">
                    <i class="ph ${icon}"></i>
                </div>
                <h3 class="grid-state-title">${title}</h3>
                <p class="grid-state-text">${text}</p>
            </div>
        `;
  }

  // ------------------------------------------------------
  // Gambar
  // ------------------------------------------------------
  function getImageUrl(item) {
    if (item.gambars && item.gambars.length > 0) {
      return "/storage/" + item.gambars[0].path_gambar;
    }

    return (
      "https://placehold.co/600x400/E2E8F0/1E3A8A?text=" +
      encodeURIComponent(tipeLayanan)
    );
  }

  // ------------------------------------------------------
  // Ambil data
  // ------------------------------------------------------
  async function loadData() {
    if (!container) {
      return;
    }

    try {
      const response = await fetch(
        `/jurusan-admin/produk?jenis=${jenisLayanan}`,
        {
          method: "GET",
          headers: { Accept: "application/json" },
        },
      );

      if (!response.ok) {
        throw new Error("Gagal mengambil data.");
      }

      const result = await response.json();

      dataItems = result.data || [];

      renderCards(searchInput ? searchInput.value : "");
    } catch (error) {
      console.error(error);

      container.innerHTML = stateHtml(
        "ph-warning",
        `Gagal memuat ${tipeLayanan.toLowerCase()}`,
        "Silakan refresh halaman dan coba lagi.",
      );
    }
  }

  // ------------------------------------------------------
  // Render kartu
  // ------------------------------------------------------
  function renderCards(filterText = "") {
    if (!container) {
      return;
    }

    container.innerHTML = "";

    const keyword = filterText.toLowerCase().trim();

    const filteredData = dataItems.filter(function (item) {
      return (item.nama_produk_jasa || "").toLowerCase().includes(keyword);
    });

    if (filteredData.length === 0) {
      container.innerHTML = stateHtml(
        "ph-package",
        `Tidak ada ${tipeLayanan.toLowerCase()} ditemukan.`,
        "Coba gunakan kata kunci pencarian yang lain.",
      );

      return;
    }

    filteredData.forEach(function (item) {
      const card = document.createElement("div");

      card.className = "catalog-card";

      const satuanHarga = item.satuan_harga ? `/${item.satuan_harga}` : "";
      const harga = formatRupiah(item.harga) + satuanHarga;
      const pesanan = item.pesanans_count || 0;
      const nama = escapeHtml(item.nama_produk_jasa);

      card.innerHTML = `
                <img
                    src="${getImageUrl(item)}"
                    alt="${nama}"
                    class="catalog-img"
                >

                <div class="catalog-content">
                    <div class="catalog-title">${nama}</div>

                    <div class="catalog-desc">
                        ${escapeHtml(shortDescription(item.deskripsi))}
                    </div>

                    <div class="catalog-meta">
                        <span class="catalog-price">${escapeHtml(harga)}</span>
                        <span class="catalog-stats">${pesanan} pesanan</span>
                    </div>

                    <div class="catalog-actions">
                        <button
                            type="button"
                            class="btn-outline btn-edit"
                            data-id="${item.id_produk_jasa}"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            class="btn-outline btn-delete"
                            data-id="${item.id_produk_jasa}"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            `;

      container.appendChild(card);
    });
  }

  // ------------------------------------------------------
  // Edit & hapus (event delegation pada container)
  // ------------------------------------------------------
  function renderOldImages(item) {
    if (!previewContainer) {
      return;
    }

    previewContainer.innerHTML = "";

    if (!item.gambars || item.gambars.length === 0) {
      previewContainer.innerHTML =
        '<div class="upload-preview-empty">Belum ada gambar.</div>';
      return;
    }

    item.gambars.forEach(function (gambar) {
      const wrapper = document.createElement("div");
      wrapper.className = "upload-preview-item";

      const img = document.createElement("img");
      img.className = "upload-preview-img";
      img.alt = "Gambar lama";
      img.src = "/storage/" + gambar.path_gambar;

      wrapper.appendChild(img);
      previewContainer.appendChild(wrapper);
    });
  }

  function openEditModal(id) {
    const item = dataItems.find(function (data) {
      return String(data.id_produk_jasa) === String(id);
    });

    if (!item) {
      return;
    }

    document.getElementById("formId").value = item.id_produk_jasa;
    document.getElementById("formName").value = item.nama_produk_jasa;
    document.getElementById("formDesc").value = item.deskripsi;
    document.getElementById("formPrice").value = item.harga;

    const formUnit = document.getElementById("formUnit");

    if (formUnit) {
      formUnit.value = item.satuan_harga || "";
    }

    if (formImg) {
      formImg.removeAttribute("required");
      formImg.value = "";
    }

    renderOldImages(item);

    window.uploadedFiles = [];

    document.getElementById("modalFormTitle").textContent =
      `Edit ${tipeLayanan}`;

    openLayananModal("modalAdd");
  }

  if (container) {
    container.addEventListener("click", function (event) {
      const editButton = event.target.closest(".btn-edit");
      const deleteButton = event.target.closest(".btn-delete");

      if (editButton) {
        openEditModal(editButton.dataset.id);
        return;
      }

      if (deleteButton) {
        document.getElementById("deleteId").value = deleteButton.dataset.id;

        openLayananModal("modalDelete");
      }
    });
  }

  // ------------------------------------------------------
  // Pencarian
  // ------------------------------------------------------
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      renderCards(this.value);
    });
  }

  // ------------------------------------------------------
  // Simpan (tambah / edit)
  // ------------------------------------------------------
  if (form) {
    form.addEventListener("submit", async function (event) {
      event.preventDefault();

      const id = document.getElementById("formId").value;
      const isEdit = id !== "";
      const csrf = getCsrfToken();

      if (!csrf) {
        showLayananToast("Token keamanan tidak ditemukan.", false);
        return;
      }

      try {
        const formData = new FormData();

        formData.append(
          "nama_produk_jasa",
          document.getElementById("formName").value,
        );
        formData.append("jenis", jenisLayanan);
        formData.append("deskripsi", document.getElementById("formDesc").value);

        const harga = document
          .getElementById("formPrice")
          .value.replace(/[^0-9]/g, "");

        formData.append("harga", harga);

        const satuanHarga =
          document.getElementById("formUnit")?.value.trim() || "";

        formData.append("satuan_harga", satuanHarga);
        formData.append("_token", csrf);

        window.uploadedFiles.forEach(function (file) {
          formData.append("gambar[]", file);
        });

        if (isEdit) {
          formData.append("_method", "PUT");
        }

        const url = isEdit
          ? `/jurusan-admin/produk/${id}`
          : "/jurusan-admin/produk";

        const response = await fetch(url, {
          method: "POST",
          headers: { Accept: "application/json" },
          body: formData,
        });

        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message || "Gagal menyimpan data.");
        }

        showLayananToast(result.message || "Data berhasil disimpan.");

        closeLayananModal("modalAdd");

        await loadData();
      } catch (error) {
        console.error(error);

        showLayananToast(error.message || "Terjadi kesalahan.", false);
      }
    });
  }

  // ------------------------------------------------------
  // Konfirmasi hapus
  // ------------------------------------------------------
  const btnConfirmDelete = document.getElementById("btnConfirmDelete");

  if (btnConfirmDelete) {
    btnConfirmDelete.addEventListener("click", async function () {
      const id = document.getElementById("deleteId").value;
      const csrf = getCsrfToken();

      if (!csrf) {
        showLayananToast("Token keamanan tidak ditemukan.", false);
        return;
      }

      try {
        const formData = new FormData();

        formData.append("_token", csrf);
        formData.append("_method", "DELETE");

        const response = await fetch(`/jurusan-admin/produk/${id}`, {
          method: "POST",
          headers: { Accept: "application/json" },
          body: formData,
        });

        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message || "Gagal menghapus data.");
        }

        showLayananToast(result.message || "Data berhasil dihapus.");

        closeLayananModal("modalDelete");

        await loadData();
      } catch (error) {
        console.error(error);

        showLayananToast(error.message || "Terjadi kesalahan.", false);
      }
    });
  }

  loadData();
});
