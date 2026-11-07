(function () {
  "use strict";

  const modal = document.getElementById("logoutModal");

  if (!modal) {
    return;
  }

  function openLogoutModal() {
    modal.classList.add("active");
  }

  function closeLogoutModal() {
    modal.classList.remove("active");
  }

  window.openLogoutModal = openLogoutModal;
  window.closeLogoutModal = closeLogoutModal;

  document.addEventListener("click", function (event) {
    if (event.target.closest("[data-logout-open]")) {
      event.preventDefault();
      openLogoutModal();
      return;
    }

    if (event.target.closest("[data-logout-close]") || event.target === modal) {
      closeLogoutModal();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.classList.contains("active")) {
      closeLogoutModal();
    }
  });
})();
