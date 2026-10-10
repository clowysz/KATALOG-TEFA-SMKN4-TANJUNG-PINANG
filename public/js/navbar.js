/* =====================================================================
   NAVBAR PUBLIK — hamburger + pencarian
   Taruh di: public/js/navbar.js
   ===================================================================== */
(function () {
    "use strict";

    var BREAKPOINT = 850;

    function init() {
        var toggle = document.getElementById("jurusanNavToggle");
        var pill = toggle ? toggle.closest(".jurusan-nav-pill") : null;

        if (!toggle || !pill) return;

        var icon = toggle.querySelector("i");

        function setOpen(open) {
            pill.classList.toggle("is-open", open);
            toggle.setAttribute("aria-expanded", String(open));
            toggle.setAttribute(
                "aria-label",
                open ? "Tutup menu navigasi" : "Buka menu navigasi",
            );

            if (icon) {
                icon.classList.toggle("ph-list", !open);
                icon.classList.toggle("ph-x", open);
            }
        }

        toggle.addEventListener("click", function () {
            setOpen(!pill.classList.contains("is-open"));
        });

        // Tutup saat salah satu menu diklik
        pill.querySelectorAll(".jurusan-nav-menu a").forEach(function (link) {
            link.addEventListener("click", function () {
                setOpen(false);
            });
        });

        // Tutup saat klik di luar navbar
        document.addEventListener("click", function (event) {
            if (!pill.contains(event.target)) setOpen(false);
        });

        // Tutup dengan tombol Escape
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") setOpen(false);
        });

        // Tutup otomatis saat layar kembali lebar
        window.addEventListener("resize", function () {
            if (window.innerWidth > BREAKPOINT) setOpen(false);
        });

        // Placeholder pencarian lebih pendek di HP/tablet
        var input = pill.querySelector(".jurusan-nav-search input");

        if (input) {
            var fullText = input.getAttribute("placeholder") || "";
            var shortText =
                input.getAttribute("data-placeholder-mobile") || fullText;
            var mq = window.matchMedia("(max-width: " + BREAKPOINT + "px)");

            var applyPlaceholder = function () {
                input.setAttribute(
                    "placeholder",
                    mq.matches ? shortText : fullText,
                );
            };

            applyPlaceholder();

            if (mq.addEventListener) {
                mq.addEventListener("change", applyPlaceholder);
            } else if (mq.addListener) {
                mq.addListener(applyPlaceholder);
            }
        }
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
