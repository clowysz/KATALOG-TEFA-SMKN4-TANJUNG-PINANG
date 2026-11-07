/* =========================================================
   DETAIL PESANAN PRODUSER
   Tugas file ini:
   - Modal kelola tahapan & modal tambah/edit tahapan
   - Modal konfirmasi hapus tahapan (pengganti confirm browser)
   - Urutan tahapan (drag & drop, disimpan sekali)
   - Tampilan nilai slider
   - Validasi bahasa Indonesia

   Data dari Blade dikirim lewat atribut di #produserOrderPage:
     data-store-url        -> URL simpan tahapan baru
     data-update-base-url  -> URL dasar update tahapan (ditambah /{id})

   Form hapus memakai atribut:
     data-confirm-delete   -> penanda form yang butuh konfirmasi
     data-confirm-name     -> nama tahapan yang ditampilkan di modal
========================================================= */
(function () {
  "use strict";

  function init() {
    var page = document.getElementById("produserOrderPage");

    if (!page) {
      return;
    }

    var storeUrl = page.dataset.storeUrl;
    var updateBaseUrl = page.dataset.updateBaseUrl;

    var modalKelola = document.getElementById("modalKelolaTahapan");
    var modalForm = document.getElementById("modalFormTahap");
    var modalHapus = document.getElementById("modalKonfirmasiHapus");
    var hapusNama = document.getElementById("konfirmasiHapusNama");
    var btnBatalHapus = document.getElementById("btnBatalHapus");
    var btnYakinHapus = document.getElementById("btnYakinHapus");
    var formTahap = document.getElementById("formSimpanTahap");
    var formTitle = document.getElementById("modalFormTahapTitle");
    var methodBox = document.getElementById("methodContainer");
    var inputNama = document.getElementById("inputNamaTahap");
    var inputStatus = document.getElementById("inputStatusTahap");
    var inputProgress = document.getElementById("inputProgressTahap");
    var outputProgress = document.getElementById("tahapProgressValue");

    var pendingDeleteForm = null;

    /* =====================================================
           MODAL
        ===================================================== */

    function openModal(modal) {
      if (!modal) {
        return;
      }

      modal.classList.add("active");
      document.body.classList.add("no-scroll");
    }

    function closeModal(modal) {
      if (!modal) {
        return;
      }

      modal.classList.remove("active");

      if (!document.querySelector(".prod-modal-overlay.active")) {
        document.body.classList.remove("no-scroll");
      }
    }

    function closeKelola() {
      closeModal(modalKelola);
      resetReorder();
    }

    function closeForm() {
      closeModal(modalForm);
    }

    function isHapusOpen() {
      return !!modalHapus && modalHapus.classList.contains("active");
    }

    function fillForm(options) {
      if (!formTahap) {
        return;
      }

      inputNama.setCustomValidity("");
      formTitle.textContent = options.title;
      formTahap.action = options.action;
      methodBox.innerHTML = options.method
        ? '<input type="hidden" name="_method" value="' + options.method + '">'
        : "";

      inputNama.value = options.nama;
      inputStatus.value = options.status;
      inputProgress.value = options.progress;
      outputProgress.textContent = options.progress + "%";
    }

    function openTambah() {
      fillForm({
        title: "Tambah Tahapan",
        action: storeUrl,
        method: "",
        nama: "",
        status: "Belum Dimulai",
        progress: 0,
      });

      closeKelola();
      openModal(modalForm);
    }

    function openEdit(button) {
      fillForm({
        title: "Edit Tahapan",
        action: updateBaseUrl + "/" + button.dataset.id,
        method: "PUT",
        nama: button.dataset.nama,
        status: button.dataset.status,
        progress: button.dataset.progress,
      });

      closeKelola();
      openModal(modalForm);
    }

    /* =====================================================
           KONFIRMASI HAPUS (modal kustom)
        ===================================================== */

    function openHapus(form) {
      if (!modalHapus) {
        return;
      }

      pendingDeleteForm = form;

      if (hapusNama) {
        hapusNama.textContent = form.dataset.confirmName || "ini";
      }

      if (btnYakinHapus) {
        btnYakinHapus.disabled = false;
      }

      openModal(modalHapus);

      if (btnBatalHapus) {
        btnBatalHapus.focus();
      }
    }

    function closeHapus() {
      pendingDeleteForm = null;
      closeModal(modalHapus);
    }

    function confirmHapus() {
      if (!pendingDeleteForm) {
        return;
      }

      var form = pendingDeleteForm;

      if (btnYakinHapus) {
        btnYakinHapus.disabled = true;
      }

      form.submit();
    }

    /* =====================================================
           URUTAN TAHAPAN (drag & drop, disimpan sekali)
        ===================================================== */

    function getStageRows() {
      return Array.prototype.slice.call(
        document.querySelectorAll("#modalKelolaTahapan tbody tr.stage-row"),
      );
    }

    function refreshStageRows() {
      getStageRows().forEach(function (row, i) {
        row.querySelector(".stage-no").textContent = i + 1;
      });
    }

    function currentOrderIds() {
      return getStageRows().map(function (row) {
        return row.dataset.id;
      });
    }

    function toggleReorderUI(changed) {
      var btnSimpan = document.getElementById("btnSimpanUrutan");
      var notice = document.getElementById("reorderNotice");

      if (btnSimpan) {
        btnSimpan.hidden = !changed;
      }

      if (notice) {
        notice.hidden = !changed;
      }
    }

    function resetReorder() {
      var tbody = document.querySelector("#modalKelolaTahapan tbody");

      if (!tbody) {
        return;
      }

      getStageRows()
        .sort(function (a, b) {
          return Number(a.dataset.order) - Number(b.dataset.order);
        })
        .forEach(function (row) {
          tbody.appendChild(row);
        });

      refreshStageRows();
      toggleReorderUI(false);
    }

    function initDragReorder() {
      var tbody = document.querySelector("#modalKelolaTahapan tbody");

      if (!tbody) {
        return;
      }

      var dragRow = null;
      var orderBefore = "";

      function onMove(event) {
        if (!dragRow) {
          return;
        }

        var others = getStageRows().filter(function (row) {
          return row !== dragRow;
        });

        var target = others.find(function (row) {
          var box = row.getBoundingClientRect();
          return event.clientY < box.top + box.height / 2;
        });

        if (target) {
          if (dragRow.nextElementSibling !== target) {
            tbody.insertBefore(dragRow, target);
          }
        } else if (tbody.lastElementChild !== dragRow) {
          tbody.appendChild(dragRow);
        }

        refreshStageRows();
      }

      function onEnd() {
        if (!dragRow) {
          return;
        }

        dragRow.classList.remove("dragging");
        document.body.classList.remove("is-dragging");
        dragRow = null;

        document.removeEventListener("pointermove", onMove);
        document.removeEventListener("pointerup", onEnd);
        document.removeEventListener("pointercancel", onEnd);

        toggleReorderUI(currentOrderIds().join(",") !== orderBefore);
      }

      tbody.querySelectorAll(".drag-handle").forEach(function (handle) {
        handle.addEventListener("pointerdown", function (event) {
          if (event.button !== undefined && event.button !== 0) {
            return;
          }

          event.preventDefault();

          dragRow = handle.closest("tr.stage-row");
          orderBefore = currentOrderIds().join(",");

          dragRow.classList.add("dragging");
          document.body.classList.add("is-dragging");

          document.addEventListener("pointermove", onMove);
          document.addEventListener("pointerup", onEnd);
          document.addEventListener("pointercancel", onEnd);
        });
      });
    }

    function saveReorder() {
      var form = document.getElementById("formReorderTahapan");
      var container = document.getElementById("reorderInputs");

      if (!form || !container) {
        return;
      }

      container.innerHTML = "";

      getStageRows().forEach(function (row) {
        var input = document.createElement("input");

        input.type = "hidden";
        input.name = "urutan[]";
        input.value = row.dataset.id;

        container.appendChild(input);
      });

      form.submit();
    }

    /* =====================================================
           VALIDASI BAHASA INDONESIA
        ===================================================== */

    function setIndonesianValidation(element, message) {
      if (!element) {
        return;
      }

      element.addEventListener("invalid", function () {
        this.setCustomValidity(this.validity.valueMissing ? message : "");
      });

      element.addEventListener("input", function () {
        this.setCustomValidity("");
      });
    }

    function blockBlankInput(form, input, message) {
      if (!form || !input) {
        return;
      }

      form.addEventListener("submit", function (event) {
        if (input.value.trim() === "") {
          event.preventDefault();

          input.value = "";
          input.setCustomValidity(message);
          input.reportValidity();
        }
      });
    }

    var inputKeterangan = document.getElementById("inputKeteranganProgress");
    var formProgress = document.getElementById("formUpdateProgress");

    setIndonesianValidation(inputNama, "Nama tahapan wajib diisi.");
    blockBlankInput(formTahap, inputNama, "Nama tahapan wajib diisi.");

    setIndonesianValidation(
      inputKeterangan,
      "Keterangan progress wajib diisi.",
    );
    blockBlankInput(
      formProgress,
      inputKeterangan,
      "Keterangan progress wajib diisi.",
    );

    /* =====================================================
           EVENT
        ===================================================== */

    document.addEventListener("click", function (event) {
      var trigger = event.target.closest("[data-action]");

      if (trigger) {
        switch (trigger.dataset.action) {
          case "open-kelola":
            openModal(modalKelola);
            break;
          case "close-kelola":
            closeKelola();
            break;
          case "add-tahap":
            openTambah();
            break;
          case "edit-tahap":
            openEdit(trigger);
            break;
          case "close-form":
            closeForm();
            break;
          case "save-reorder":
            saveReorder();
            break;
          case "cancel-hapus":
            closeHapus();
            break;
          case "confirm-hapus":
            confirmHapus();
            break;
        }

        return;
      }

      if (event.target === modalHapus) {
        closeHapus();
      } else if (event.target === modalKelola) {
        closeKelola();
      } else if (event.target === modalForm) {
        closeForm();
      }
    });

    document.addEventListener("input", function (event) {
      var slider = event.target;

      if (!slider.dataset || !slider.dataset.rangeOutput) {
        return;
      }

      var output = document.getElementById(slider.dataset.rangeOutput);

      if (output) {
        output.textContent = slider.value + "%";
      }
    });

    document.addEventListener("submit", function (event) {
      var form = event.target;

      if (!form.hasAttribute || !form.hasAttribute("data-confirm-delete")) {
        return;
      }

      event.preventDefault();
      openHapus(form);
    });

    document.addEventListener("keydown", function (event) {
      if (event.key !== "Escape") {
        return;
      }

      if (isHapusOpen()) {
        closeHapus();
        return;
      }

      closeKelola();
      closeForm();
    });

    refreshStageRows();
    initDragReorder();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
