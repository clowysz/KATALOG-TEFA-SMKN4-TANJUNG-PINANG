(function () {
  "use strict";

  const modal = document.getElementById("logoutModal");

  if (!modal) {
    return;
  }

  function openModal() {
    modal.style.display = "flex";
  }

  function closeModal() {
    modal.style.display = "none";
  }

  document.addEventListener("click", function (event) {
    if (event.target.closest("[data-logout-open]")) {
      openModal();
      return;
    }

    if (event.target.closest("[data-logout-close]") || event.target === modal) {
      closeModal();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeModal();
    }
  });
})();
