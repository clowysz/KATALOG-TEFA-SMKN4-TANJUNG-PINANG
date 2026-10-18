/*
|--------------------------------------------------------------------------
| Accordion FAQ publik
|--------------------------------------------------------------------------
| Hanya satu item terbuka dalam satu waktu. Bisa dibuka dengan klik
| atau keyboard (Enter / Spasi).
*/
(function () {
    function toggleFaq(header) {
        const item = header.closest(".faq-item");
        if (!item) return;

        const sedangAktif = item.classList.contains("active");

        // Tutup semua FAQ
        document.querySelectorAll(".faq-item").forEach(function (el) {
            el.classList.remove("active");

            const h = el.querySelector(".faq-header");
            if (h) h.setAttribute("aria-expanded", "false");
        });

        // Jika sebelumnya belum terbuka, buka FAQ yang diklik
        if (!sedangAktif) {
            item.classList.add("active");
            header.setAttribute("aria-expanded", "true");
        }
    }

    document.addEventListener("click", function (event) {
        const header = event.target.closest(".faq-header");
        if (header) toggleFaq(header);
    });

    document.addEventListener("keydown", function (event) {
        const header = event.target.closest
            ? event.target.closest(".faq-header")
            : null;

        if (header && (event.key === "Enter" || event.key === " ")) {
            event.preventDefault();
            toggleFaq(header);
        }
    });
})();
