/* =========================================================
   GALERI DETAIL KATALOG (admin_tefa/katalog-detail)

   Pemicu di blade (tanpa onclick inline):
   - data-gallery-nav="prev|next" : gambar sebelumnya / berikutnya
   - data-gallery-go="N"          : lompat ke gambar ke-N (dot, thumbnail)
   - data-gallery-close           : tutup lightbox
========================================================= */

(function () {
    "use strict";

    let currentIndex = 0;

    // ==========================================================
    // GALERI
    // ==========================================================

    function getImages() {
        return document.querySelectorAll(".admin-gallery-image");
    }

    function updateGallery() {
        const images = getImages();
        const dots = document.querySelectorAll(".admin-gallery-dot");
        const thumbs = document.querySelectorAll(".admin-gallery-thumb");

        if (!images.length) {
            return;
        }

        images.forEach(function (image, index) {
            image.classList.toggle("active", index === currentIndex);
        });

        dots.forEach(function (dot, index) {
            dot.classList.toggle("active", index === currentIndex);
        });

        thumbs.forEach(function (thumb, index) {
            thumb.classList.toggle("active", index === currentIndex);
        });

        const activeThumb = document.querySelector(
            ".admin-gallery-thumb.active",
        );

        if (activeThumb) {
            activeThumb.scrollIntoView({
                behavior: "smooth",
                block: "nearest",
                inline: "center",
            });
        }
    }

    function showNext() {
        const images = getImages();

        if (images.length <= 1) {
            return;
        }

        currentIndex++;

        if (currentIndex >= images.length) {
            currentIndex = 0;
        }

        updateGallery();
    }

    function showPrev() {
        const images = getImages();

        if (images.length <= 1) {
            return;
        }

        currentIndex--;

        if (currentIndex < 0) {
            currentIndex = images.length - 1;
        }

        updateGallery();
    }

    function showAt(index) {
        const images = getImages();

        if (index < 0 || index >= images.length) {
            return;
        }

        currentIndex = index;
        updateGallery();
    }

    // ==========================================================
    // LIGHTBOX
    // ==========================================================

    function openLightbox(src) {
        const modal = document.getElementById("adminGalleryLightbox");
        const image = document.getElementById("adminLightboxImage");

        if (!modal || !image) {
            return;
        }

        image.src = src;
        modal.classList.add("active");
    }

    function closeLightbox() {
        const modal = document.getElementById("adminGalleryLightbox");

        if (!modal) {
            return;
        }

        modal.classList.remove("active");
    }

    // ==========================================================
    // SWIPE DI LAYAR SENTUH
    // ==========================================================

    function initSwipe() {
        const mainImage = document.querySelector(".admin-main-image");

        if (!mainImage) {
            return;
        }

        let startX = 0;
        let startY = 0;

        mainImage.addEventListener(
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

        mainImage.addEventListener(
            "touchend",
            function (event) {
                if (!event.changedTouches.length) {
                    return;
                }

                const diffX = startX - event.changedTouches[0].clientX;
                const diffY = startY - event.changedTouches[0].clientY;

                if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
                    if (diffX > 0) {
                        showNext();
                    } else {
                        showPrev();
                    }
                }
            },
            { passive: true },
        );
    }

    // ==========================================================
    // INISIALISASI
    // ==========================================================

    document.addEventListener("DOMContentLoaded", function () {
        updateGallery();
        initSwipe();

        // Klik gambar utama -> buka lightbox
        getImages().forEach(function (image) {
            image.addEventListener("click", function () {
                openLightbox(this.src);
            });
        });

        // Tombol panah, dot, thumbnail, dan tombol tutup lightbox
        document.addEventListener("click", function (event) {
            const nav = event.target.closest("[data-gallery-nav]");

            if (nav) {
                if (nav.dataset.galleryNav === "next") {
                    showNext();
                } else {
                    showPrev();
                }
                return;
            }

            const go = event.target.closest("[data-gallery-go]");

            if (go) {
                showAt(parseInt(go.dataset.galleryGo, 10));
                return;
            }

            if (event.target.closest("[data-gallery-close]")) {
                closeLightbox();
            }
        });

        // Tutup lightbox dengan tombol Esc
        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });

        // Tutup lightbox saat klik area gelap
        const modal = document.getElementById("adminGalleryLightbox");

        if (modal) {
            modal.addEventListener("click", function (event) {
                if (event.target === modal) {
                    closeLightbox();
                }
            });
        }
    });
})();
