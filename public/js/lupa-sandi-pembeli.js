/*
|--------------------------------------------------------------------------
| Validasi email pada form lupa sandi
|--------------------------------------------------------------------------
*/
document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.getElementById("email");

    if (!emailInput) return;

    function validateEmail() {
        const value = emailInput.value.trim();

        if (value === "") {
            emailInput.setCustomValidity("Email wajib diisi.");
            return;
        }

        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!emailPattern.test(value)) {
            emailInput.setCustomValidity(
                "Silakan masukkan alamat email yang valid. Contoh: nama@email.com.",
            );
            return;
        }

        emailInput.setCustomValidity("");
    }

    emailInput.addEventListener("invalid", validateEmail);
    emailInput.addEventListener("input", validateEmail);
});
