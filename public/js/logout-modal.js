/* =========================================================
   MODAL LOGOUT (layout admin Tefa)

   Pemicu di blade:
   - data-logout-open  : membuka modal
   - data-logout-close : menutup modal
========================================================= */

(function () {
    "use strict";

    const modal = document.getElementById("logoutModal");

    if (!modal) {
        return;
    }

    function openModal() {
        modal.style.display = "flex";
    }

    function closeModal() {
        modal.style.display = "none";
    }

    document.addEventListener("click", function (event) {
        if (event.target.closest("[data-logout-open]")) {
            openModal();
            return;
        }

        // Tombol Batal, atau klik di area gelap di luar kotak modal
        if (
            event.target.closest("[data-logout-close]") ||
            event.target === modal
        ) {
            closeModal();
        }
    });

    // Tutup modal dengan tombol Esc
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeModal();
        }
    });
})();
