/*
|--------------------------------------------------------------------------
| Validasi form buat sandi baru
|--------------------------------------------------------------------------
| Toggle mata password ditangani oleh password-toggle.js
*/
document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const confirmInput = document.getElementById("password_confirmation");

    // KONFIRMASI SANDI
    function checkConfirmation() {
        if (!confirmInput || !passwordInput) return;

        if (confirmInput.value === "") {
            confirmInput.setCustomValidity("Konfirmasi sandi wajib diisi.");
            return;
        }

        if (confirmInput.value !== passwordInput.value) {
            confirmInput.setCustomValidity(
                "Konfirmasi sandi tidak sama dengan sandi baru.",
            );
            return;
        }

        confirmInput.setCustomValidity("");
    }

    // SANDI BARU
    if (passwordInput) {
        passwordInput.addEventListener("invalid", function () {
            if (this.validity.valueMissing) {
                this.setCustomValidity("Sandi baru wajib diisi.");
            } else {
                this.setCustomValidity("");
            }
        });

        passwordInput.addEventListener("input", function () {
            this.setCustomValidity("");
            checkConfirmation();
        });
    }

    if (confirmInput) {
        confirmInput.addEventListener("invalid", checkConfirmation);
        confirmInput.addEventListener("input", checkConfirmation);
    }
});
