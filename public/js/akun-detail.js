/* =========================================================
   DETAIL AKUN (admin_tefa/akun/show)

   1. Menampilkan / menyembunyikan form reset password
   2. Validasi password baru dan konfirmasinya
   3. Modal konfirmasi akses akun

   Pemicu modal di blade (tanpa onclick inline):
   - data-access-open="aktifkan|nonaktifkan" : buka modal
   - data-access-close                       : tutup modal
   - data-access-submit                      : kirim form akses
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    initResetPasswordToggle();
    initPasswordValidation();
    initAccessModal();

    // ==========================================================
    // 1. FORM RESET PASSWORD
    // ==========================================================

    function initResetPasswordToggle() {
        const resetButton = document.getElementById("btnResetPassword");
        const resetForm = document.getElementById("resetPasswordForm");
        const cancelReset = document.getElementById("cancelReset");

        if (!resetForm) {
            return;
        }

        if (resetButton) {
            resetButton.addEventListener("click", function () {
                resetForm.style.display = "block";
            });
        }

        if (cancelReset) {
            cancelReset.addEventListener("click", function () {
                resetForm.style.display = "none";
            });
        }
    }

    // ==========================================================
    // 2. VALIDASI PASSWORD & KONFIRMASI PASSWORD
    // ==========================================================

    function initPasswordValidation() {
        const passwordInput = document.getElementById("password");
        const confirmInput = document.getElementById("password_confirmation");

        const MSG_PASSWORD_REQUIRED = "Password baru wajib diisi.";
        const MSG_PASSWORD_MIN = "Password harus memiliki minimal 6 karakter.";
        const MSG_CONFIRM_REQUIRED = "Konfirmasi password wajib diisi.";
        const MSG_CONFIRM_MIN =
            "Konfirmasi password harus memiliki minimal 6 karakter.";
        const MSG_CONFIRM_MISMATCH = "Konfirmasi password tidak cocok.";

        function validateConfirmation() {
            if (!confirmInput) {
                return;
            }

            if (confirmInput.value.length === 0) {
                confirmInput.setCustomValidity(MSG_CONFIRM_REQUIRED);
            } else if (confirmInput.value.length < 6) {
                confirmInput.setCustomValidity(MSG_CONFIRM_MIN);
            } else if (
                passwordInput &&
                confirmInput.value !== passwordInput.value
            ) {
                confirmInput.setCustomValidity(MSG_CONFIRM_MISMATCH);
            } else {
                confirmInput.setCustomValidity("");
            }
        }

        if (passwordInput) {
            passwordInput.addEventListener("invalid", function () {
                if (this.validity.valueMissing) {
                    this.setCustomValidity(MSG_PASSWORD_REQUIRED);
                } else if (this.validity.tooShort) {
                    this.setCustomValidity(MSG_PASSWORD_MIN);
                } else {
                    this.setCustomValidity("");
                }
            });

            passwordInput.addEventListener("input", function () {
                if (this.value.length === 0) {
                    this.setCustomValidity(MSG_PASSWORD_REQUIRED);
                } else if (this.value.length < 6) {
                    this.setCustomValidity(MSG_PASSWORD_MIN);
                } else {
                    this.setCustomValidity("");
                }

                // Password berubah: cocokkan ulang dengan konfirmasi yang sudah diisi
                if (confirmInput && confirmInput.value.length > 0) {
                    validateConfirmation();
                }
            });
        }

        if (confirmInput) {
            confirmInput.addEventListener("invalid", function () {
                if (this.validity.valueMissing) {
                    this.setCustomValidity(MSG_CONFIRM_REQUIRED);
                } else if (this.validity.tooShort) {
                    this.setCustomValidity(MSG_CONFIRM_MIN);
                } else {
                    this.setCustomValidity("");
                }
            });

            confirmInput.addEventListener("input", validateConfirmation);
        }
    }

    // ==========================================================
    // 3. MODAL KONFIRMASI AKSES
    // ==========================================================

    function initAccessModal() {
        const modal = document.getElementById("accessModal");

        if (!modal) {
            return;
        }

        const title = document.getElementById("accessModalTitle");
        const desc = document.getElementById("accessModalDesc");
        const confirmButton = modal.querySelector(".btn-modal-access-confirm");

        const TEXTS = {
            aktifkan: {
                title: "Aktifkan Akses?",
                desc: "Apakah Anda yakin ingin mengaktifkan kembali akses akun ini?",
                button: "Aktifkan Akses",
                primary: true,
            },
            nonaktifkan: {
                title: "Hapus Akses?",
                desc: "Apakah Anda yakin ingin menonaktifkan akses akun ini?",
                button: "Hapus Akses",
                primary: false,
            },
        };

        let accessActionForm = null;

        function openModal(action) {
            const text = TEXTS[action] || TEXTS.nonaktifkan;

            accessActionForm = document.getElementById("accessActionForm");

            title.textContent = text.title;
            desc.textContent = text.desc;
            confirmButton.textContent = text.button;
            confirmButton.classList.toggle("is-primary", text.primary);

            modal.style.display = "flex";
        }

        function closeModal() {
            modal.style.display = "none";

            accessActionForm = null;
        }

        document.addEventListener("click", function (event) {
            const opener = event.target.closest("[data-access-open]");

            if (opener) {
                openModal(opener.dataset.accessOpen);
                return;
            }

            if (event.target.closest("[data-access-submit]")) {
                if (accessActionForm) {
                    accessActionForm.submit();
                }

                return;
            }

            // Tombol Batal, atau klik di area gelap di luar kotak modal
            if (
                event.target.closest("[data-access-close]") ||
                event.target === modal
            ) {
                closeModal();
            }
        });
    }
});
