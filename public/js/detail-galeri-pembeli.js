/*
|--------------------------------------------------------------------------
| Galeri gambar halaman detail produk & jasa (publik)
|--------------------------------------------------------------------------
| Markup yang dibutuhkan:
| - #carouselTrack                    : track slide
| - [data-slide-dir="1|-1"]           : tombol prev/next
| - [data-slide-index="N"]            : dot & thumbnail
| - .detail-gallery[data-lightbox]    : aktifkan preview gambar besar
*/
(function () {
    let currentIndex = 0;

    function getSlides() {
        const track = document.getElementById("carouselTrack");
        return track ? Array.from(track.children) : [];
    }

    function updateCarousel() {
        const track = document.getElementById("carouselTrack");
        const slides = getSlides();

        if (!track || slides.length === 0) return;

        const slideWidth = slides[0].getBoundingClientRect().width;

        track.style.transform =
            "translateX(-" + currentIndex * slideWidth + "px)";

        // Dots
        document.querySelectorAll(".carousel-dot").forEach(function (dot, idx) {
            dot.classList.toggle("active", idx === currentIndex);
        });

        // Thumbnail aktif
        document.querySelectorAll(".thumb-item").forEach(function (thumb, idx) {
            thumb.classList.toggle("active", idx === currentIndex);
        });
    }

    function moveSlide(direction) {
        const slides = getSlides();
        if (slides.length === 0) return;

        currentIndex += direction;

        if (currentIndex >= slides.length) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = slides.length - 1;
        }

        updateCarousel();
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    // Klik tombol prev/next, dot, dan thumbnail
    document.addEventListener("click", function (event) {
        const tombol = event.target.closest("[data-slide-dir]");

        if (tombol) {
            moveSlide(parseInt(tombol.dataset.slideDir, 10));
            return;
        }

        const target = event.target.closest("[data-slide-index]");

        if (target) {
            goToSlide(parseInt(target.dataset.slideIndex, 10));
        }
    });

    window.addEventListener("resize", updateCarousel);

    document.addEventListener("DOMContentLoaded", function () {
        // Geser dengan jari (swipe) di layar sentuh
        const box = document.querySelector(".carousel-track-container");

        if (box) {
            let startX = 0;
            let startY = 0;
            let tracking = false;

            box.addEventListener(
                "touchstart",
                function (e) {
                    const t = e.touches[0];
                    startX = t.clientX;
                    startY = t.clientY;
                    tracking = true;
                },
                { passive: true },
            );

            box.addEventListener(
                "touchend",
                function (e) {
                    if (!tracking) return;
                    tracking = false;

                    const t = e.changedTouches[0];
                    const dx = t.clientX - startX;
                    const dy = t.clientY - startY;

                    if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                        moveSlide(dx < 0 ? 1 : -1);
                    }
                },
                { passive: true },
            );
        }

        // Lightbox foto (hanya jika diaktifkan lewat data-lightbox)
        const galeri = document.querySelector(".detail-gallery");

        if (!galeri || galeri.dataset.lightbox !== "true") return;

        const modal = document.createElement("div");
        modal.className = "image-lightbox-modal";
        modal.innerHTML =
            '<button class="lightbox-close" aria-label="Tutup">&times;</button>' +
            '<img class="lightbox-content" src="" alt="Preview Besar">';

        document.body.appendChild(modal);

        const lightboxImg = modal.querySelector(".lightbox-content");
        const closeBtn = modal.querySelector(".lightbox-close");

        document
            .querySelectorAll(".carousel-slide img")
            .forEach(function (img) {
                img.addEventListener("click", function () {
                    lightboxImg.src = this.src;
                    modal.classList.add("active");
                });
            });

        closeBtn.addEventListener("click", function () {
            modal.classList.remove("active");
        });

        modal.addEventListener("click", function (e) {
            if (e.target === modal) {
                modal.classList.remove("active");
            }
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                modal.classList.remove("active");
            }
        });
    });
})();
