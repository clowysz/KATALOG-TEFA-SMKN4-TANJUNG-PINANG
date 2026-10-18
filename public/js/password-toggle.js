/*
|--------------------------------------------------------------------------
| Toggle tampil/sembunyi password
|--------------------------------------------------------------------------
| Pakai: <i class="ph ph-eye toggle-eye" data-toggle-password="#idInput"></i>
*/
document.addEventListener("DOMContentLoaded", function () {
    document
        .querySelectorAll("[data-toggle-password]")
        .forEach(function (tombol) {
            const input = document.querySelector(tombol.dataset.togglePassword);

            if (!input) return;

            tombol.addEventListener("click", function () {
                const sedangTersembunyi =
                    input.getAttribute("type") === "password";

                input.setAttribute(
                    "type",
                    sedangTersembunyi ? "text" : "password",
                );

                tombol.classList.toggle("ph-eye", !sedangTersembunyi);
                tombol.classList.toggle("ph-eye-slash", sedangTersembunyi);
            });
        });
});
