/* =========================================================
   DAFTAR AKUN (admin_tefa/akun/index)

   Pencarian dan filter tabel / kartu akun (role & status).
   Baris disembunyikan dengan style.display = 'none', dan
   ditampilkan kembali dengan style.display = ''.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const searchAkun = document.getElementById("searchAkun");
    const filterRole = document.getElementById("filterRole");
    const filterStatus = document.getElementById("filterStatusAkun");
    const akunTable = document.getElementById("akunTable");
    const emptyAkun = document.getElementById("emptyAkun");

    if (!akunTable) {
        return;
    }

    const tableRows = akunTable.querySelectorAll("tbody tr");

    function filterAkunTable() {
        const searchTerm = searchAkun
            ? searchAkun.value.toLowerCase().trim()
            : "";

        const roleTerm = filterRole ? filterRole.value : "Semua";

        const statusTerm = filterStatus ? filterStatus.value : "Semua";

        let visibleCount = 0;

        tableRows.forEach(function (row) {
            const namaElement = row.querySelector(".col-nama");
            const emailElement = row.querySelector(".col-email");
            const roleElement = row.querySelector(".col-role");
            const statusElement = row.querySelector(".col-status");

            const nama = namaElement
                ? namaElement.textContent.toLowerCase().trim()
                : "";

            const email = emailElement
                ? emailElement.textContent.toLowerCase().trim()
                : "";

            const role = roleElement ? roleElement.dataset.role : "";

            const status = statusElement ? statusElement.dataset.status : "";

            const matchSearch =
                nama.includes(searchTerm) || email.includes(searchTerm);

            const matchRole = roleTerm === "Semua" || role === roleTerm;

            const matchStatus = statusTerm === "Semua" || status === statusTerm;

            if (matchSearch && matchRole && matchStatus) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        if (emptyAkun) {
            emptyAkun.style.display = visibleCount === 0 ? "block" : "none";
        }
    }

    if (searchAkun) {
        searchAkun.addEventListener("input", filterAkunTable);
    }

    if (filterRole) {
        filterRole.addEventListener("change", filterAkunTable);
    }

    if (filterStatus) {
        filterStatus.addEventListener("change", filterAkunTable);
    }
});
