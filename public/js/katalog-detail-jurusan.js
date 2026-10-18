/* =========================================================
   DETAIL PRODUK / JASA - ADMIN JURUSAN

   1. Galeri (slider, dots, thumbnail, swipe, lightbox)
   2. Ambil data & tampilkan halaman
========================================================= */

(function () {
    "use strict";

    // ======================================================
    // 1. GALERI
    // ======================================================

    let galleryIndex = 0;

    function galleryImages() {
        return document.querySelectorAll(".admin-gallery-image");
    }

    function galleryUpdate() {
        const images = galleryImages();
        const dots = document.querySelectorAll(".admin-gallery-dot");
        const thumbs = document.querySelectorAll(".admin-gallery-thumb");

        if (!images.length) {
            return;
        }

        images.forEach(function (el, i) {
            el.classList.toggle("active", i === galleryIndex);
        });

        dots.forEach(function (el, i) {
            el.classList.toggle("active", i === galleryIndex);
        });

        thumbs.forEach(function (el, i) {
            el.classList.toggle("active", i === galleryIndex);
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

    function galleryNext() {
        const images = galleryImages();

        if (images.length <= 1) {
            return;
        }

        galleryIndex = (galleryIndex + 1) % images.length;
        galleryUpdate();
    }

    function galleryPrev() {
        const images = galleryImages();

        if (images.length <= 1) {
            return;
        }

        galleryIndex = (galleryIndex - 1 + images.length) % images.length;
        galleryUpdate();
    }

    function galleryGo(index) {
        const images = galleryImages();

        if (index < 0 || index >= images.length) {
            return;
        }

        galleryIndex = index;
        galleryUpdate();
    }

    // ---------- Lightbox ----------

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

        if (modal) {
            modal.classList.remove("active");
        }
    }

    // ---------- Bangun galeri dari data ----------

    function createArrow(direction, label, text, handler) {
        const button = document.createElement("button");

        button.type = "button";
        button.className = "admin-gallery-arrow admin-gallery-" + direction;
        button.setAttribute("aria-label", label);
        button.textContent = text;
        button.addEventListener("click", handler);

        return button;
    }

    function buildGallery(urls, altText) {
        const main = document.getElementById("adminMainImage");
        const thumbs = document.getElementById("adminThumbnails");

        main.innerHTML = "";
        thumbs.innerHTML = "";
        galleryIndex = 0;

        urls.forEach(function (url, index) {
            const img = document.createElement("img");

            img.src = url;
            img.alt = altText;
            img.className =
                "admin-gallery-image" + (index === 0 ? " active" : "");

            img.addEventListener("click", function () {
                openLightbox(this.src);
            });

            main.appendChild(img);
        });

        if (urls.length > 1) {
            const dots = document.createElement("div");
            dots.className = "admin-gallery-dots";

            urls.forEach(function (url, index) {
                const dot = document.createElement("button");

                dot.type = "button";
                dot.className =
                    "admin-gallery-dot" + (index === 0 ? " active" : "");
                dot.setAttribute("aria-label", "Gambar " + (index + 1));
                dot.addEventListener("click", function () {
                    galleryGo(index);
                });
                dots.appendChild(dot);

                const thumb = document.createElement("button");

                thumb.type = "button";
                thumb.className =
                    "admin-gallery-thumb" + (index === 0 ? " active" : "");
                thumb.addEventListener("click", function () {
                    galleryGo(index);
                });

                const thumbImg = document.createElement("img");

                thumbImg.src = url;
                thumbImg.alt = "Gambar " + (index + 1);
                thumb.appendChild(thumbImg);
                thumbs.appendChild(thumb);
            });

            main.appendChild(
                createArrow("prev", "Gambar sebelumnya", "‹", galleryPrev),
            );
            main.appendChild(
                createArrow("next", "Gambar berikutnya", "›", galleryNext),
            );
            main.appendChild(dots);

            thumbs.style.display = "flex";
        } else {
            thumbs.style.display = "none";
        }
    }

    // ---------- Swipe di layar sentuh (dipasang sekali) ----------

    function initSwipe() {
        const main = document.getElementById("adminMainImage");

        let startX = 0;
        let startY = 0;

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

                const diffX = startX - event.changedTouches[0].clientX;
                const diffY = startY - event.changedTouches[0].clientY;

                if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
                    if (diffX > 0) {
                        galleryNext();
                    } else {
                        galleryPrev();
                    }
                }
            },
            { passive: true },
        );
    }

    // ======================================================
    // 2. AMBIL DATA & TAMPILKAN
    // ======================================================

    function formatRupiah(value) {
        if (value === null || value === undefined || value === "") {
            return "Rp0";
        }

        const number = Number(value);

        if (isNaN(number)) {
            return value;
        }

        return "Rp" + new Intl.NumberFormat("id-ID").format(number);
    }

    function setText(id, text) {
        document.getElementById(id).textContent = text;
    }

    function fetchJson(url) {
        return fetch(url, { headers: { Accept: "application/json" } }).then(
            function (response) {
                if (!response.ok) {
                    throw new Error("Gagal mengambil data.");
                }

                return response.json();
            },
        );
    }

    function showItem(item) {
        const jenis = item.jenis === "jasa" ? "Jasa" : "Produk";

        // Galeri
        let urls = [];

        if (item.gambars && item.gambars.length > 0) {
            urls = item.gambars
                .filter(function (g) {
                    return g && g.path_gambar;
                })
                .map(function (g) {
                    return "/storage/" + g.path_gambar;
                });
        }

        if (urls.length === 0) {
            urls = [
                "https://placehold.co/800x600/E2E8F0/1E3A8A?text=" +
                    encodeURIComponent(jenis),
            ];
        }

        buildGallery(urls, item.nama_produk_jasa || jenis);

        // Informasi
        const satuan = item.satuan_harga ? "/" + item.satuan_harga : "";

        setText("detailBadge", jenis.toUpperCase());
        setText("metaJenis", jenis);
        setText("detailTitle", item.nama_produk_jasa || "-");
        setText("detailPrice", formatRupiah(item.harga) + satuan);
        setText("detailDesc", item.deskripsi || "Tidak ada deskripsi.");

        // Statistik
        setText("statPesanan", item.pesanans_count ?? 0);
        setText("statPencarian", item.jumlah_pencarian ?? 0);
        setText("statTampilan", item.jumlah_tampilan ?? 0);
    }

    document.addEventListener("DOMContentLoaded", async function () {
        const params = new URLSearchParams(window.location.search);
        const idProdukJasa = params.get("id_produk_jasa");

        const loading = document.getElementById("detailLoading");
        const error = document.getElementById("detailError");
        const content = document.getElementById("detailContent");
        const lightbox = document.getElementById("adminGalleryLightbox");
        const lightboxClose = document.getElementById("adminLightboxClose");

        // Lightbox: tombol tutup, klik latar & Esc
        if (lightboxClose) {
            lightboxClose.addEventListener("click", closeLightbox);
        }

        if (lightbox) {
            lightbox.addEventListener("click", function (event) {
                if (event.target === lightbox) {
                    closeLightbox();
                }
            });
        }

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                closeLightbox();
            }
        });

        initSwipe();

        if (!idProdukJasa) {
            loading.style.display = "none";
            error.style.display = "block";
            return;
        }

        try {
            const results = await Promise.all([
                fetchJson("/jurusan-admin/produk?jenis=produk"),
                fetchJson("/jurusan-admin/produk?jenis=jasa"),
            ]);

            const semuaData = [
                ...(results[0].data || []),
                ...(results[1].data || []),
            ];

            const item = semuaData.find(function (data) {
                return String(data.id_produk_jasa) === String(idProdukJasa);
            });

            if (!item) {
                throw new Error("Produk/jasa tidak ditemukan.");
            }

            showItem(item);

            loading.style.display = "none";
            content.style.display = "block";
        } catch (err) {
            console.error(err);

            loading.style.display = "none";
            content.style.display = "none";
            error.style.display = "block";
        }
    });
})();
