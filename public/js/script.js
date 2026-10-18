/* =========================================================
   SCRIPT GLOBAL

   1. Navigation drawer (hamburger)
   2. Tampilkan / sembunyikan password di halaman login
========================================================= */

// ==========================================================
// 1. NAVIGATION DRAWER
// ==========================================================

// Tetap global: masih dipakai layout role lain lewat onclick="toggleDrawer()".
// Layout yang sudah dirapikan memakai atribut data-drawer-toggle (lihat bawah).
function toggleDrawer() {
    const navDrawer = document.getElementById("navDrawer");
    const overlay = document.getElementById("overlay");

    // Pastikan elemennya ada sebelum dijalankan
    if (!navDrawer || !overlay) {
        return;
    }

    navDrawer.classList.toggle("open");
    overlay.classList.toggle("active");

    // Kunci scroll halaman saat laci terbuka
    document.body.classList.toggle(
        "drawer-open",
        navDrawer.classList.contains("open"),
    );
}

// Elemen dengan atribut data-drawer-toggle membuka / menutup laci
document.addEventListener("click", function (event) {
    if (event.target.closest("[data-drawer-toggle]")) {
        toggleDrawer();
    }
});

// Tombol Esc menutup laci
document.addEventListener("keydown", function (event) {
    if (event.key !== "Escape") {
        return;
    }

    const navDrawer = document.getElementById("navDrawer");

    if (navDrawer && navDrawer.classList.contains("open")) {
        toggleDrawer();
    }
});

// ==========================================================
// 2. PERLIHATKAN PASSWORD DI HALAMAN LOGIN
// ==========================================================

document.addEventListener("DOMContentLoaded", function () {
    const togglePassword = document.getElementById("togglePassword");
    const passwordInput = document.getElementById("password");

    // Hanya berjalan jika elemennya ada di halaman tersebut
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener("change", function () {
            passwordInput.type = this.checked ? "text" : "password";
        });
    }
});
