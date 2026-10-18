/*
|--------------------------------------------------------------------------
| Galeri detail portofolio (publik)
|--------------------------------------------------------------------------
| Klik thumbnail (.thumb-item) untuk mengganti gambar utama.
*/
document.addEventListener("DOMContentLoaded", function () {
    const mainImage = document.getElementById("mainPortfolioImage");

    if (!mainImage) return;

    document.querySelectorAll(".thumb-item").forEach(function (thumb) {
        thumb.addEventListener("click", function () {
            mainImage.src = this.src;

            document.querySelectorAll(".thumb-item").forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");
        });
    });
});
