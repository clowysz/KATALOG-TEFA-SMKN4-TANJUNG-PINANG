/*
|--------------------------------------------------------------------------
| Validasi form daftar pembeli
|--------------------------------------------------------------------------
| Toggle password ditangani oleh password-toggle.js
*/
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("formDaftarPembeli");
    const nama = document.getElementById("namaPembeli");
    const nomorHp = document.getElementById("nomorHpPembeli");
    const email = document.getElementById("emailDaftarPembeli");
    const password = document.getElementById("passwordDaftar");
    const konfirmasi = document.getElementById("passwordKonfirmasi");

    if (!form || !nama || !nomorHp || !email || !password || !konfirmasi)
        return;

    // NAMA
    function cekNama() {
        if (nama.value.trim() === "") {
            nama.setCustomValidity("Nama lengkap wajib diisi.");
            return false;
        }

        nama.setCustomValidity("");
        return true;
    }

    // NOMOR HP (hanya angka)
    function cekNomorHp() {
        nomorHp.value = nomorHp.value.replace(/[^0-9]/g, "");

        if (nomorHp.value.trim() === "") {
            nomorHp.setCustomValidity("Nomor telepon wajib diisi.");
            return false;
        }

        nomorHp.setCustomValidity("");
        return true;
    }

    // EMAIL
    function cekEmail() {
        const value = email.value.trim();

        if (value === "") {
            email.setCustomValidity("Email wajib diisi.");
            return false;
        }

        const polaEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!polaEmail.test(value)) {
            email.setCustomValidity(
                "Silakan masukkan alamat email yang valid. Contoh: nama@email.com.",
            );
            return false;
        }

        email.setCustomValidity("");
        return true;
    }

    // PASSWORD
    function cekPassword() {
        if (password.value === "") {
            password.setCustomValidity("Password wajib diisi.");
            return false;
        }

        if (password.value.length < 8) {
            password.setCustomValidity(
                "Password harus memiliki minimal 8 karakter.",
            );
            return false;
        }

        password.setCustomValidity("");
        return true;
    }

    // KONFIRMASI PASSWORD
    function cekKonfirmasi() {
        if (konfirmasi.value === "") {
            konfirmasi.setCustomValidity("Konfirmasi password wajib diisi.");
            return false;
        }

        if (konfirmasi.value.length < 8) {
            konfirmasi.setCustomValidity(
                "Konfirmasi password harus memiliki minimal 8 karakter.",
            );
            return false;
        }

        if (konfirmasi.value !== password.value) {
            konfirmasi.setCustomValidity(
                "Konfirmasi password tidak sama dengan password.",
            );
            return false;
        }

        konfirmasi.setCustomValidity("");
        return true;
    }

    // VALIDASI SAAT MENGETIK
    nama.addEventListener("input", cekNama);
    nomorHp.addEventListener("input", cekNomorHp);
    email.addEventListener("input", cekEmail);

    password.addEventListener("input", function () {
        cekPassword();

        if (konfirmasi.value !== "") {
            cekKonfirmasi();
        }
    });

    konfirmasi.addEventListener("input", cekKonfirmasi);

    // SUBMIT FORM
    form.addEventListener("submit", function (event) {
        const namaValid = cekNama();
        const nomorHpValid = cekNomorHp();
        const emailValid = cekEmail();
        const passwordValid = cekPassword();
        const konfirmasiValid = cekKonfirmasi();

        if (!namaValid) {
            event.preventDefault();
            nama.reportValidity();
            return;
        }

        if (!nomorHpValid) {
            event.preventDefault();
            nomorHp.reportValidity();
            return;
        }

        if (!emailValid) {
            event.preventDefault();
            email.reportValidity();
            return;
        }

        if (!passwordValid) {
            event.preventDefault();
            password.reportValidity();
            return;
        }

        if (!konfirmasiValid) {
            event.preventDefault();
            konfirmasi.reportValidity();
            return;
        }
    });
});
