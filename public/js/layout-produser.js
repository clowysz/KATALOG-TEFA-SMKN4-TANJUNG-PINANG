/* =========================================================
   LAYOUT ADMIN PRODUSER
   Tugas file ini: drawer (menu), modal generik, tombol Escape.
   Cara pakai di Blade (tanpa onclick inline):
     data-drawer-toggle        -> buka/tutup drawer
     data-modal-open="idModal" -> buka modal
     data-modal-close="idModal"-> tutup modal
========================================================= */
(function () {
    "use strict";

    var drawer = document.getElementById("navDrawer");
    var overlay = document.getElementById("overlay");

    /* ---------- DRAWER ---------- */

    function setDrawer(open) {
        if (!drawer || !overlay) {
            return;
        }

        drawer.classList.toggle("open", open);
        overlay.classList.toggle("active", open);
        document.body.classList.toggle("drawer-open", open);
    }

    function toggleDrawer() {
        setDrawer(!(drawer && drawer.classList.contains("open")));
    }

    /* ---------- MODAL ---------- */

    function openModal(id) {
        var modal = document.getElementById(id);

        if (modal) {
            modal.classList.add("active");
        }
    }

    function closeModal(id) {
        var modal = document.getElementById(id);

        if (modal) {
            modal.classList.remove("active");
        }
    }

    /* Kompatibel dengan halaman produser lain yang masih memanggil fungsi ini */
    if (typeof window.toggleDrawer !== "function") {
        window.toggleDrawer = toggleDrawer;
    }

    window.openModal = openModal;
    window.closeModal = closeModal;

    /* ---------- EVENT ---------- */

    document.addEventListener("click", function (event) {
        var drawerBtn = event.target.closest("[data-drawer-toggle]");
        var openBtn = event.target.closest("[data-modal-open]");
        var closeBtn = event.target.closest("[data-modal-close]");

        if (drawerBtn) {
            toggleDrawer();
            return;
        }

        if (openBtn) {
            setDrawer(false);
            openModal(openBtn.dataset.modalOpen);
            return;
        }

        if (closeBtn) {
            closeModal(closeBtn.dataset.modalClose);
            return;
        }

        /* Klik area gelap modal */
        if (event.target.classList.contains("modal-overlay")) {
            event.target.classList.remove("active");
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key !== "Escape") {
            return;
        }

        setDrawer(false);

        document
            .querySelectorAll(".modal-overlay.active")
            .forEach(function (modal) {
                modal.classList.remove("active");
            });
    });
})();
