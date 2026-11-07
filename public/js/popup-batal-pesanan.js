/* =========================================================
   POPUP PEMBATALAN PESANAN (PEMBELI)

   Dipakai oleh: resources/views/public/popup/batal-pesanan.blade.php
   Dimuat otomatis dari partial tersebut lewat @push('js').

   Fitur:
   - Membuka popup dari tombol .rw-btn-cancel
   - Memilih alasan (atau menulis alasan lainnya)
   - Mengirim permintaan pembatalan tanpa refresh halaman
   - Memperbarui baris pesanan di tabel riwayat jika langsung dibatalkan
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("cancelModal");

  if (!modal || modal.dataset.initialized === "true") {
    return;
  }

  modal.dataset.initialized = "true";

  const form = document.getElementById("cancelOrderForm");
  const closeBtn = document.getElementById("cancelModalClose");
  const body = document.getElementById("cancelModalBody");
  const footer = document.getElementById("cancelModalFooter");
  const message = document.getElementById("cancelModalMessage");
  const title = document.getElementById("cancelModalTitle");
  const otherReason = document.getElementById("cancelReasonOther");
  const submitBtn = document.getElementById("cancelModalSubmit");

  let previousFocus = null;

  // Menampilkan pesan di popup.
  function showMessage(text, type) {
    message.textContent = text;
    message.className = "cancel-modal-message";

    if (type) {
      message.classList.add(type);
    }
  }

  // Mengembalikan popup ke kondisi awal.
  function resetModal() {
    form.reset();

    otherReason.hidden = true;
    otherReason.required = false;

    body.hidden = false;
    footer.hidden = false;

    title.textContent = "Batalkan Pesanan";

    message.textContent = "";
    message.className = "cancel-modal-message";

    submitBtn.disabled = false;
    submitBtn.textContent = "Oke, Ajukan Pembatalan";
  }

  // Membuka popup sesuai pesanan yang dipilih.
  function openModal(button) {
    resetModal();

    form.action = button.dataset.cancelUrl;
    previousFocus = button;

    modal.hidden = false;
    document.body.style.overflow = "hidden";

    closeBtn.focus();
  }

  // Menutup popup.
  function closeModal() {
    modal.hidden = true;
    document.body.style.overflow = "";

    resetModal();

    if (previousFocus && previousFocus.isConnected) {
      previousFocus.focus();
    }
  }

  // Memperbarui baris pesanan di tabel setelah pesanan langsung dibatalkan.
  function updateBarisPesanan(pesananId) {
    const barisPesanan = pesananId
      ? document.getElementById("pesanan-" + pesananId)
      : null;

    if (!barisPesanan) {
      return;
    }

    const kolomStatus = barisPesanan.querySelector('[data-label="Status"]');

    if (kolomStatus) {
      kolomStatus.innerHTML =
        '<span class="rw-badge rw-badge--cancel">' +
        '<i class="ph ph-x-circle"></i>Dibatalkan' +
        "</span>";
    }

    const kolomProgress = barisPesanan.querySelector('[data-label="Progress"]');

    if (kolomProgress) {
      kolomProgress.innerHTML =
        "<div>" +
        '<div class="rw-text-main">-</div>' +
        '<div class="rw-text-sub">Pesanan dibatalkan</div>' +
        "</div>";
    }

    const tombolBatal = barisPesanan.querySelector(".rw-btn-cancel");

    if (tombolBatal) {
      tombolBatal.remove();
    }
  }

  // Tombol Batalkan Pesanan.
  document.querySelectorAll(".rw-btn-cancel").forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();
      openModal(button);
    });
  });

  // Tombol silang.
  closeBtn.addEventListener("click", closeModal);

  // Tutup ketika area luar popup diklik.
  modal.addEventListener("click", function (event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  // Tutup menggunakan tombol Escape.
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && !modal.hidden) {
      closeModal();
    }
  });

  // Menampilkan kolom tulis jika memilih "Alasan lainnya".
  form
    .querySelectorAll('input[name="alasan_pilihan"]')
    .forEach(function (radio) {
      radio.addEventListener("change", function () {
        if (!radio.checked) {
          return;
        }

        const isOther = radio.value === "lainnya";

        otherReason.hidden = !isOther;
        otherReason.required = isOther;

        if (isOther) {
          otherReason.focus();
        } else {
          otherReason.value = "";
        }
      });
    });

  // Mengirim permintaan pembatalan tanpa refresh halaman.
  form.addEventListener("submit", async function (event) {
    event.preventDefault();

    const selected = form.querySelector('input[name="alasan_pilihan"]:checked');

    if (!selected) {
      showMessage("Silakan pilih alasan pembatalan terlebih dahulu.", "error");
      return;
    }

    let alasan = selected.value;

    if (alasan === "lainnya") {
      alasan = otherReason.value.trim();

      if (!alasan) {
        showMessage("Silakan tuliskan alasan pembatalan kamu.", "error");
        otherReason.focus();
        return;
      }
    }

    submitBtn.disabled = true;
    submitBtn.textContent = "Mengirim...";

    showMessage("", "");

    try {
      const csrfToken = form.querySelector('[name="_token"]')?.value;

      if (!csrfToken) {
        throw new Error("Token keamanan tidak ditemukan.");
      }

      const response = await fetch(form.action, {
        method: "POST",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          "X-Requested-With": "XMLHttpRequest",
          "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({ alasan: alasan }),
      });

      const result = await response.json();

      // Menangani pembatalan yang gagal.
      if (!response.ok || !result.success) {
        const errorText =
          result.message ||
          Object.values(result.errors || {}).flat()[0] ||
          "Pembatalan gagal diproses. Silakan coba lagi.";

        showMessage(errorText, "error");

        submitBtn.disabled = false;
        submitBtn.textContent = "Coba Lagi";

        return;
      }

      // Memperbarui tabel jika pesanan langsung dibatalkan.
      if (result.message === "Pesanan berhasil dibatalkan.") {
        const pesananId = form.action.match(
          /riwayat-pesanan\/(\d+)\/batalkan/,
        )?.[1];

        updateBarisPesanan(pesananId);
      }

      // Menyembunyikan formulir dan menampilkan hasilnya.
      body.hidden = true;
      footer.hidden = true;

      title.textContent = "Pembatalan Pesanan";

      showMessage(result.message || "Permintaan berhasil dikirim.", "success");
    } catch (error) {
      console.error("Kesalahan pembatalan:", error);

      showMessage(
        "Terjadi masalah koneksi atau respons server tidak valid. Silakan coba lagi.",
        "error",
      );

      submitBtn.disabled = false;
      submitBtn.textContent = "Coba Lagi";
    }
  });
});
