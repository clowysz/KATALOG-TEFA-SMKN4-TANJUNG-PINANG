/* =========================================================
   KELOLA PESANAN (admin_tefa/pesanan)

   Pencarian dan filter (status & jurusan) pada tabel / kartu pesanan.
   Baris disembunyikan dengan style.display = 'none', dan
   ditampilkan kembali dengan style.display = ''.
   Pesan "Pesanan Tidak Ditemukan" memakai blok #emptyPesanan
   yang sudah ada di blade.
========================================================= */

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const filterStatus = document.getElementById("filterStatus");
    const filterJurusan = document.getElementById("filterJurusan");
    const table = document.getElementById("pesananTable");
    const emptyPesanan = document.getElementById("emptyPesanan");

    if (!table) {
        return;
    }

    const tableRows = table.querySelectorAll("tbody tr.pesanan-row");

    // Kode pada filter jurusan -> nama jurusan lengkap
    const JURUSAN_MAP = {
        rpl: "rekayasa perangkat lunak",
        tkj: "teknik komputer dan jaringan",
        dkv: "desain komunikasi visual",
        animasi: "animasi",
        gim: "gim",
        pspt: "produksi dan siaran program televisi",
    };

    // Ambil teks sebuah kolom pada satu baris (huruf kecil, tanpa spasi tepi)
    function getText(row, selector) {
        const element = row.querySelector(selector);

        return element ? element.textContent.toLowerCase().trim() : "";
    }

    function filterTable() {
        const searchTerm = searchInput
            ? searchInput.value.toLowerCase().trim()
            : "";

        const statusTerm = filterStatus
            ? filterStatus.value.toLowerCase().trim()
            : "semua";

        const jurusanTerm = filterJurusan
            ? filterJurusan.value.toLowerCase().trim()
            : "semua";

        let visibleCount = 0;

        tableRows.forEach(function (row) {
            const id = getText(row, ".col-id");
            const nama = getText(row, ".col-nama");
            const produk = getText(row, ".col-produk");
            const jurusan = getText(row, ".col-jurusan");

            const statusSelect = row.querySelector(".col-status select");

            const status = statusSelect
                ? statusSelect.value.toLowerCase().trim()
                : "";

            const matchSearch =
                searchTerm === "" ||
                id.includes(searchTerm) ||
                nama.includes(searchTerm) ||
                produk.includes(searchTerm) ||
                jurusan.includes(searchTerm) ||
                status.includes(searchTerm);

            const matchStatus = statusTerm === "semua" || status === statusTerm;

            let matchJurusan = true;

            if (jurusanTerm !== "semua") {
                const namaJurusan = JURUSAN_MAP[jurusanTerm] || jurusanTerm;

                matchJurusan = jurusan.includes(namaJurusan);
            }

            if (matchSearch && matchStatus && matchJurusan) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        if (emptyPesanan) {
            emptyPesanan.style.display =
                visibleCount === 0 && tableRows.length > 0 ? "block" : "none";
        }
    }

    if (searchInput) {
        searchInput.addEventListener("input", filterTable);
    }

    if (filterStatus) {
        filterStatus.addEventListener("change", filterTable);
    }

    if (filterJurusan) {
        filterJurusan.addEventListener("change", filterTable);
    }

    filterTable();
});
