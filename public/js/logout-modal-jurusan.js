/* =========================================================
   MODAL LOGOUT - ADMIN JURUSAN

   Pemakaian di blade:
   - data-logout-open  -> membuka modal
   - data-logout-close -> menutup modal
   Klik area gelap di luar kotak & tombol Esc juga menutup modal.
========================================================= */

(function () {
    "use strict";

    const modal = document.getElementById("logoutModal");

    if (!modal) {
        return;
    }

    function openLogoutModal() {
        modal.classList.add("active");
    }

    function closeLogoutModal() {
        modal.classList.remove("active");
    }

    // Tetap tersedia global untuk halaman yang masih memakai onclick lama
    window.openLogoutModal = openLogoutModal;
    window.closeLogoutModal = closeLogoutModal;

    document.addEventListener("click", function (event) {
        if (event.target.closest("[data-logout-open]")) {
            event.preventDefault();
            openLogoutModal();
            return;
        }

        if (
            event.target.closest("[data-logout-close]") ||
            event.target === modal
        ) {
            closeLogoutModal();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.classList.contains("active")) {
            closeLogoutModal();
        }
    });
})();
