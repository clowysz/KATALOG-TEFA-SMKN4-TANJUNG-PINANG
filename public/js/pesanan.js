
document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterJurusan = document.getElementById('filterJurusan');

    const table = document.getElementById('pesananTable');
    const emptyState = document.getElementById('emptyState');

    const tableRows = document.querySelectorAll(
        '#pesananTable tbody tr'
    );


    function filterTable() {

        // =========================
        // NILAI FILTER
        // =========================

        const searchTerm =
            searchInput.value
                .toLowerCase()
                .trim();

        const statusTerm =
            filterStatus.value
                .toLowerCase()
                .trim();

        const jurusanTerm =
            filterJurusan.value
                .toLowerCase()
                .trim();


        let visibleCount = 0;


        // =========================
        // LOOP DATA PESANAN
        // =========================

        tableRows.forEach(row => {

            // Lewati baris kosong
            if (!row.querySelector('.col-id')) {
                return;
            }


            // =========================
            // AMBIL DATA PESANAN
            // =========================

            const id =
                row.querySelector('.col-id')
                    .textContent
                    .toLowerCase()
                    .trim();


            const nama =
                row.querySelector('.col-nama')
                    .textContent
                    .toLowerCase()
                    .trim();


            const produk =
                row.querySelector('.col-produk')
                    .textContent
                    .toLowerCase()
                    .trim();


            const jurusan =
                row.querySelector('.col-jurusan')
                    .textContent
                    .toLowerCase()
                    .trim();


            // =========================
            // AMBIL STATUS
            // =========================

            const statusSelect =
                row.querySelector('.col-status select');


            let status = '';

            if (statusSelect) {

                status =
                    statusSelect.value
                        .toLowerCase()
                        .trim();

            } else {

                status =
                    row.querySelector('.col-status')
                        ?.textContent
                        .toLowerCase()
                        .trim() || '';

            }


            // =========================
            // SEARCH
            // =========================

            const matchSearch =
                searchTerm === '' ||

                id.includes(searchTerm) ||

                nama.includes(searchTerm) ||

                produk.includes(searchTerm) ||

                jurusan.includes(searchTerm) ||

                status.includes(searchTerm);


            // =========================
            // FILTER STATUS
            // =========================

            const matchStatus =
                statusTerm === 'semua' ||

                status === statusTerm;


            // =========================
            // FILTER JURUSAN
            //
            // Database:
            // RPL
            // TKJ
            // DKV
            // ANIMASI
            // GIM
            // PSPT
            // =========================

            const matchJurusan =
                jurusanTerm === 'semua' ||

                jurusan === jurusanTerm;


            // =========================
            // HASIL FILTER
            // =========================

            if (
                matchSearch &&
                matchStatus &&
                matchJurusan
            ) {

                row.style.display = '';

                visibleCount++;

            } else {

                row.style.display = 'none';

            }

        });


        // =========================
        // EMPTY STATE
        // =========================

        if (visibleCount === 0) {

            emptyState.style.display = 'block';

            table.style.display = 'none';

        } else {

            emptyState.style.display = 'none';

            table.style.display = 'table';

        }

    }


    // =========================
    // SEARCH
    // =========================

    if (searchInput) {

        searchInput.addEventListener(
            'keyup',
            filterTable
        );

        searchInput.addEventListener(
            'input',
            filterTable
        );

    }


    // =========================
    // FILTER STATUS
    // =========================

    if (filterStatus) {

        filterStatus.addEventListener(
            'change',
            filterTable
        );

    }


    // =========================
    // FILTER JURUSAN
    // =========================

    if (filterJurusan) {

        filterJurusan.addEventListener(
            'change',
            filterTable
        );

    }


    // =========================
    // JALANKAN SAAT HALAMAN DIBUKA
    // =========================

    filterTable();

});
