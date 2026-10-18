/* =========================================================
   DETAIL PRODUK/JASA PRODUSER
   Tugas file ini: galeri gambar (panah, titik, thumbnail, swipe)
   dan lightbox.

   Data dari Blade dikirim lewat atribut di #adminGallery:
     data-images -> daftar URL gambar (JSON)
     data-alt    -> teks alternatif gambar
========================================================= */
(function () {
    "use strict";

    function init() {
        var root = document.getElementById("adminGallery");
        var main = document.getElementById("adminMainImage");
        var thumbs = document.getElementById("adminThumbnails");
        var lightbox = document.getElementById("adminGalleryLightbox");
        var lightboxImage = document.getElementById("adminLightboxImage");

        if (!root || !main || !thumbs) {
            return;
        }

        var urls = [];

        try {
            urls = JSON.parse(root.dataset.images || "[]");
        } catch (error) {
            urls = [];
        }

        var altText = root.dataset.alt || "";
        var index = 0;

        /* ---------- Helper ---------- */

        function images() {
            return main.querySelectorAll(".admin-gallery-image");
        }

        function update() {
            var imgs = images();

            if (!imgs.length) {
                return;
            }

            imgs.forEach(function (el, i) {
                el.classList.toggle("active", i === index);
            });

            document
                .querySelectorAll(".admin-gallery-dot, .admin-gallery-thumb")
                .forEach(function (el) {
                    el.classList.toggle(
                        "active",
                        Number(el.dataset.index) === index,
                    );
                });

            var activeThumb = thumbs.querySelector(
                ".admin-gallery-thumb.active",
            );

            if (activeThumb && activeThumb.scrollIntoView) {
                activeThumb.scrollIntoView({
                    behavior: "smooth",
                    block: "nearest",
                    inline: "center",
                });
            }
        }

        function go(next) {
            var total = images().length;

            if (total <= 1) {
                return;
            }

            index = (next + total) % total;
            update();
        }

        function createButton(className, label, text) {
            var btn = document.createElement("button");

            btn.type = "button";
            btn.className = className;
            btn.setAttribute("aria-label", label);

            if (text) {
                btn.textContent = text;
            }

            return btn;
        }

        /* ---------- Lightbox ---------- */

        function openLightbox(src) {
            if (!lightbox || !lightboxImage) {
                return;
            }

            lightboxImage.src = src;
            lightbox.classList.add("active");
        }

        function closeLightbox() {
            if (lightbox) {
                lightbox.classList.remove("active");
            }
        }

        /* ---------- Bangun galeri ---------- */

        function build() {
            main.innerHTML = "";
            thumbs.innerHTML = "";
            index = 0;

            urls.forEach(function (url, i) {
                var img = document.createElement("img");

                img.src = url;
                img.alt = altText;
                img.className =
                    "admin-gallery-image" + (i === 0 ? " active" : "");

                img.addEventListener("click", function () {
                    openLightbox(this.src);
                });

                main.appendChild(img);
            });

            if (urls.length <= 1) {
                thumbs.hidden = true;
                return;
            }

            var prev = createButton(
                "admin-gallery-arrow admin-gallery-prev",
                "Gambar sebelumnya",
                "\u2039",
            );
            var next = createButton(
                "admin-gallery-arrow admin-gallery-next",
                "Gambar berikutnya",
                "\u203A",
            );
            var dots = document.createElement("div");

            dots.className = "admin-gallery-dots";

            prev.addEventListener("click", function () {
                go(index - 1);
            });
            next.addEventListener("click", function () {
                go(index + 1);
            });

            urls.forEach(function (url, i) {
                var dot = createButton(
                    "admin-gallery-dot" + (i === 0 ? " active" : ""),
                    "Gambar " + (i + 1),
                );
                var thumb = createButton(
                    "admin-gallery-thumb" + (i === 0 ? " active" : ""),
                    "Lihat gambar " + (i + 1),
                );
                var thumbImg = document.createElement("img");

                dot.dataset.index = i;
                thumb.dataset.index = i;

                dot.addEventListener("click", function () {
                    go(i);
                });
                thumb.addEventListener("click", function () {
                    go(i);
                });

                thumbImg.src = url;
                thumbImg.alt = "Gambar " + (i + 1);

                thumb.appendChild(thumbImg);
                dots.appendChild(dot);
                thumbs.appendChild(thumb);
            });

            main.appendChild(prev);
            main.appendChild(next);
            main.appendChild(dots);

            thumbs.hidden = false;
        }

        /* ---------- Swipe di layar sentuh ---------- */

        var startX = 0;
        var startY = 0;

        main.addEventListener(
            "touchstart",
            function (event) {
                if (!event.touches.length) {
                    return;
                }

                startX = event.touches[0].clientX;
                startY = event.touches[0].clientY;
            },
            { passive: true },
        );

        main.addEventListener(
            "touchend",
            function (event) {
                if (!event.changedTouches.length) {
                    return;
                }

                var diffX = startX - event.changedTouches[0].clientX;
                var diffY = startY - event.changedTouches[0].clientY;

                if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
                    go(diffX > 0 ? index + 1 : index - 1);
                }
            },
            { passive: true },
        );

        /* ---------- Event lain ---------- */

        document.addEventListener("click", function (event) {
            if (
                event.target.closest("[data-lightbox-close]") ||
                event.target === lightbox
            ) {
                closeLightbox();
            }
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                closeLightbox();
            } else if (event.key === "ArrowLeft") {
                go(index - 1);
            } else if (event.key === "ArrowRight") {
                go(index + 1);
            }
        });

        build();
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", init);
    } else {
        init();
    }
})();
