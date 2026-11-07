(function () {
  "use strict";

  const PER_PAGE_DESKTOP = 16;
  const PER_PAGE_MOBILE = 15;
  const STORAGE_KEY = "katalogTefaSelected";

  const scriptTag = document.currentScript;
  const currentPerPage = parseInt(scriptTag.dataset.perPage, 10);
  const allIds = parseIdList(scriptTag.dataset.allIds);
  const mobileQuery = window.matchMedia("(max-width: 768px)");

  function parseIdList(text) {
    try {
      const parsed = JSON.parse(text || "[]");

      return Array.isArray(parsed) ? parsed.map(String) : [];
    } catch (error) {
      return [];
    }
  }

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

  if (syncPerPage()) {
    return;
  }

  if (mobileQuery.addEventListener) {
    mobileQuery.addEventListener("change", syncPerPage);
  } else if (mobileQuery.addListener) {
    mobileQuery.addListener(syncPerPage);
  }

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
    } catch (error) {}
  }

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

      cards.forEach(function (card) {
        card.classList.toggle("selected", selectedItems.has(card.dataset.id));
      });

      selectAllButton.textContent = isAllSelected()
        ? "Batalkan Semua"
        : "Pilih Semua";

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
      }
    });

    updateSelectedUI();
  }

  document.addEventListener("DOMContentLoaded", function () {
    initFilter();
    initSelection();
  });
})();
