function toggleDrawer() {
  const navDrawer = document.getElementById("navDrawer");
  const overlay = document.getElementById("overlay");

  if (!navDrawer || !overlay) {
    return;
  }

  navDrawer.classList.toggle("open");
  overlay.classList.toggle("active");

  document.body.classList.toggle(
    "drawer-open",
    navDrawer.classList.contains("open"),
  );
}

document.addEventListener("click", function (event) {
  if (event.target.closest("[data-drawer-toggle]")) {
    toggleDrawer();
  }
});

document.addEventListener("keydown", function (event) {
  if (event.key !== "Escape") {
    return;
  }

  const navDrawer = document.getElementById("navDrawer");

  if (navDrawer && navDrawer.classList.contains("open")) {
    toggleDrawer();
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const togglePassword = document.getElementById("togglePassword");
  const passwordInput = document.getElementById("password");

  if (togglePassword && passwordInput) {
    togglePassword.addEventListener("change", function () {
      passwordInput.type = this.checked ? "text" : "password";
    });
  }
});
