/* =========================================================
   KELOLA PORTOFOLIO - ADMIN JURUSAN

   Atribut di blade:
   - data-open-tambah        : membuka modal tambah
   - data-close-modal="id"   : menutup modal
========================================================= */

// =========================================================
// MODAL (global: dibungkus oleh form-helper-jurusan.js)
// =========================================================

function openPortoModal(id) {
  const modal = document.getElementById(id);

  if (modal) {
    modal.classList.add("active");
  }
}

function closePortoModal(id) {
  const modal = document.getElementById(id);

  if (modal) {
    modal.classList.remove("active");
  }
}

function openTambahPortoModal() {
  document.getElementById("formPorto").reset();
  document.getElementById("portoId").value = "";
  document.getElementById("modalPortoTitle").textContent = "Tambah Portofolio";
  document.getElementById("portoImg").setAttribute("required", "true");

  window.uploadedFiles = [];

  const previewContainer = document.getElementById("imagePreviewContainer");

  if (previewContainer) {
    previewContainer.innerHTML = "";
  }

  openPortoModal("modalAddPorto");
}

// =========================================================
// HALAMAN SIAP
// =========================================================

document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById("portoContainer");
  const searchInput = document.getElementById("searchPorto");
  const toast = document.getElementById("toastPorto");
  const form = document.getElementById("formPorto");

  let dataPorto = [];

  // ------------------------------------------------------
  // Utilitas
  // ------------------------------------------------------
  function showToast(message, type = "success") {
    if (!toast) {
      return;
    }

    toast.textContent = message;
    toast.classList.toggle("is-error", type === "error");
    toast.classList.add("show");

    setTimeout(function () {
      toast.classList.remove("show");
    }, 3000);
  }

  function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');

    return meta ? meta.getAttribute("content") : "";
  }

  function escapeHtml(text) {
    const div = document.createElement("div");

    div.textContent = text ?? "";

    return div.innerHTML;
  }

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
  // Tombol buka / tutup modal (lewat atribut data-*)
  // closePortoModal dipanggil lewat nama global supaya versi
  // yang dibungkus form-helper-jurusan.js ikut berjalan.
  // ------------------------------------------------------
  document.addEventListener("click", function (event) {
    if (event.target.closest("[data-open-tambah]")) {
      openTambahPortoModal();
      return;
    }

    const closeButton = event.target.closest("[data-close-modal]");

    if (closeButton) {
      closePortoModal(closeButton.dataset.closeModal);
    }
  });

  // ------------------------------------------------------
  // Ambil data (sekali), pencarian memfilter data di browser
  // ------------------------------------------------------
  async function loadPortofolio() {
    try {
      const response = await fetch("/jurusan-admin/portofolio");

      if (!response.ok) {
        throw new Error("Gagal mengambil data portofolio.");
      }

      const result = await response.json();

      dataPorto = result.data || [];

      renderPorto(searchInput ? searchInput.value : "");
    } catch (error) {
      console.error(error);

      container.innerHTML = stateHtml(
        "ph-warning",
        "Gagal memuat portofolio",
        "Silakan coba muat ulang halaman.",
      );
    }
  }

  // ------------------------------------------------------
  // Render kartu
  // ------------------------------------------------------
  function renderPorto(filterText = "") {
    container.innerHTML = "";

    const keyword = filterText.toLowerCase().trim();

    const filteredData = dataPorto.filter(function (item) {
      return (item.judul || "").toLowerCase().includes(keyword);
    });

    if (filteredData.length === 0) {
      container.innerHTML = stateHtml(
        "ph-folder-open",
        "Tidak ada portofolio ditemukan.",
        "Coba gunakan kata kunci pencarian yang lain.",
      );

      return;
    }

    filteredData.forEach(function (item) {
      const card = document.createElement("div");

      card.className = "portfolio-card";

      const gambar =
        item.gambars && item.gambars.length > 0 ? item.gambars[0] : null;

      const imageUrl = gambar
        ? "/storage/" + gambar.path_gambar
        : "https://placehold.co/600x400/E2E8F0/1E3A8A?text=Portofolio";

      const tahun = item.tahun ? item.tahun : "-";

      const deskripsi = item.deskripsi
        ? item.deskripsi.substring(0, 80) +
          (item.deskripsi.length > 80 ? "..." : "")
        : "Tidak ada deskripsi.";

      card.innerHTML = `
                <img
                    src="${imageUrl}"
                    alt="${escapeHtml(item.judul)}"
                    class="portfolio-img"
                >

                <div class="portfolio-content">
                    <h4>${escapeHtml(item.judul)}</h4>

                    <p>${escapeHtml(deskripsi)}</p>

                    <div class="portfolio-meta">
                        <span class="portfolio-badge">
                            ${escapeHtml(tahun)}
                        </span>
                    </div>

                    <div class="catalog-actions">
                        <button
                            type="button"
                            class="btn-outline btn-edit-porto"
                            data-id="${item.id_portfolio}"
                        >
                            Edit
                        </button>

                        <button
                            type="button"
                            class="btn-outline btn-delete-porto"
                            data-id="${item.id_portfolio}"
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
    const previewContainer = document.getElementById("imagePreviewContainer");

    if (!previewContainer) {
      return;
    }

    previewContainer.innerHTML = "";

    if (!item.gambars || item.gambars.length === 0) {
      return;
    }

    item.gambars.forEach(function (gambar) {
      const wrapper = document.createElement("div");
      wrapper.className = "upload-preview-item";

      const image = document.createElement("img");
      image.className = "upload-preview-img";
      image.alt = "Gambar lama";
      image.src = "/storage/" + gambar.path_gambar;

      const label = document.createElement("div");
      label.className = "upload-preview-label";
      label.textContent = "Gambar Lama";

      wrapper.appendChild(image);
      wrapper.appendChild(label);
      previewContainer.appendChild(wrapper);
    });
  }

  function openEditModal(id) {
    const item = dataPorto.find(function (data) {
      return String(data.id_portfolio) === String(id);
    });

    if (!item) {
      return;
    }

    const portoImg = document.getElementById("portoImg");

    document.getElementById("portoId").value = item.id_portfolio;
    document.getElementById("portoTitle").value = item.judul;
    document.getElementById("portoDesc").value = item.deskripsi;
    document.getElementById("portoYear").value = item.tahun || "";

    portoImg.removeAttribute("required");
    portoImg.value = "";

    window.uploadedFiles = [];

    renderOldImages(item);

    document.getElementById("modalPortoTitle").textContent = "Edit Portofolio";

    openPortoModal("modalAddPorto");
  }

  container.addEventListener("click", function (event) {
    const editButton = event.target.closest(".btn-edit-porto");
    const deleteButton = event.target.closest(".btn-delete-porto");

    if (editButton) {
      openEditModal(editButton.dataset.id);
      return;
    }

    if (deleteButton) {
      document.getElementById("deletePortoId").value = deleteButton.dataset.id;

      openPortoModal("modalDeletePorto");
    }
  });

  // ------------------------------------------------------
  // Pencarian
  // ------------------------------------------------------
  if (searchInput) {
    searchInput.addEventListener("keyup", function () {
      renderPorto(this.value);
    });
  }

  // ------------------------------------------------------
  // Simpan (tambah / edit)
  // ------------------------------------------------------
  form.addEventListener("submit", async function (event) {
    event.preventDefault();

    const id = document.getElementById("portoId").value;
    const isEdit = id !== "";

    const formData = new FormData(form);

    if (isEdit) {
      formData.append("_method", "PUT");
    }

    try {
      const url = isEdit
        ? `/jurusan-admin/portofolio/${id}`
        : "/jurusan-admin/portofolio";

      const response = await fetch(url, {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": getCsrfToken(),
          Accept: "application/json",
        },
        body: formData,
      });

      const result = await response.json();

      if (!response.ok) {
        if (result.errors) {
          const firstError = Object.values(result.errors)[0];

          throw new Error(firstError[0]);
        }

        throw new Error(result.message || "Gagal menyimpan portofolio.");
      }

      showToast(
        result.message ||
          (isEdit
            ? "Portofolio berhasil diperbarui."
            : "Portofolio berhasil ditambahkan."),
      );

      window.uploadedFiles = [];

      form.reset();

      document.getElementById("portoId").value = "";
      document.getElementById("imagePreviewContainer").innerHTML = "";

      closePortoModal("modalAddPorto");

      loadPortofolio();
    } catch (error) {
      console.error(error);

      showToast(error.message || "Terjadi kesalahan.", "error");
    }
  });

  // ------------------------------------------------------
  // Konfirmasi hapus
  // ------------------------------------------------------
  document
    .getElementById("btnConfirmDeletePorto")
    .addEventListener("click", async function () {
      const id = document.getElementById("deletePortoId").value;

      if (!id) {
        return;
      }

      try {
        const response = await fetch(`/jurusan-admin/portofolio/${id}`, {
          method: "DELETE",
          headers: {
            "X-CSRF-TOKEN": getCsrfToken(),
            Accept: "application/json",
          },
        });

        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message || "Gagal menghapus portofolio.");
        }

        closePortoModal("modalDeletePorto");

        showToast(result.message || "Portofolio berhasil dihapus.");

        loadPortofolio();
      } catch (error) {
        console.error(error);

        showToast(error.message || "Terjadi kesalahan.", "error");
      }
    });

  loadPortofolio();
});
