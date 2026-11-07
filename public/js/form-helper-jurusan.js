window.uploadedFiles = [];

window.JurusanForm = (function () {
  "use strict";

  function requiredMessage(element, message) {
    if (!element) {
      return;
    }

    element.addEventListener("invalid", function () {
      if (this.validity.valueMissing) {
        this.setCustomValidity(message);
      }
    });

    element.addEventListener("input", function () {
      this.setCustomValidity("");
    });
  }

  function initImageUploader(options) {
    const form = options.form;
    const input = options.input;
    const preview = options.preview;
    const idInput = options.idInput;

    if (!form || !input) {
      return;
    }

    const emptyMessage =
      options.emptyMessage || "Minimal satu gambar wajib diunggah.";

    requiredMessage(input, "Minimal satu gambar wajib diunggah.");

    function syncInput() {
      const dataTransfer = new DataTransfer();

      window.uploadedFiles.forEach(function (file) {
        dataTransfer.items.add(file);
      });

      input.files = dataTransfer.files;
    }

    function renderPreviews() {
      if (!preview) {
        return;
      }

      preview.innerHTML = "";

      window.uploadedFiles.forEach(function (file, index) {
        const item = document.createElement("div");
        item.className = "upload-preview-item";

        const img = document.createElement("img");
        img.className = "upload-preview-img";
        img.alt = file.name;
        img.src = URL.createObjectURL(file);
        img.onload = function () {
          URL.revokeObjectURL(img.src);
        };

        if (options.fit === "contain") {
          img.classList.add("is-contain");
        }

        const removeBtn = document.createElement("button");
        removeBtn.type = "button";
        removeBtn.className = "upload-preview-remove";
        removeBtn.setAttribute("aria-label", "Hapus gambar");
        removeBtn.innerHTML = '<i class="ph ph-x"></i>';
        removeBtn.addEventListener("click", function () {
          window.uploadedFiles.splice(index, 1);
          syncInput();
          renderPreviews();
        });

        item.appendChild(img);
        item.appendChild(removeBtn);
        preview.appendChild(item);
      });
    }

    input.addEventListener("change", function (event) {
      this.setCustomValidity("");

      const files = event.target.files;

      if (!files.length) {
        return;
      }

      Array.from(files).forEach(function (file) {
        window.uploadedFiles.push(file);
      });

      syncInput();
      renderPreviews();
    });

    form.addEventListener(
      "submit",
      function (event) {
        const isAddMode = !idInput || idInput.value === "";

        if (isAddMode && window.uploadedFiles.length === 0) {
          event.preventDefault();
          event.stopImmediatePropagation();

          input.setCustomValidity(emptyMessage);
          input.reportValidity();
          return;
        }

        input.setCustomValidity("");
      },
      true,
    );

    if (options.closeFn && options.modalId) {
      const originalClose = window[options.closeFn];

      window[options.closeFn] = function (modalId) {
        if (modalId === options.modalId) {
          window.uploadedFiles = [];

          if (preview) {
            preview.innerHTML = "";
          }

          input.value = "";
          input.setCustomValidity("");
        }

        if (typeof originalClose === "function") {
          originalClose.apply(this, arguments);
          return;
        }

        const modal = document.getElementById(modalId);

        if (modal) {
          modal.classList.remove("active");
        }
      };
    }
  }

  return {
    requiredMessage: requiredMessage,
    initImageUploader: initImageUploader,
  };
})();
