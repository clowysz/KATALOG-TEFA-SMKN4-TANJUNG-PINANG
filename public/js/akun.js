document.addEventListener('DOMContentLoaded', function () {

    // =========================================================
    // LOGIKA HALAMAN DAFTAR AKUN
    // =========================================================

    const searchAkun = document.getElementById('searchAkun');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatusAkun');
    const akunTable = document.getElementById('akunTable');
    const emptyAkun = document.getElementById('emptyAkun');

    if (akunTable) {

        const tableRows = akunTable.querySelectorAll('tbody tr');

        function filterAkunTable() {

            // =========================
            // Ambil nilai filter
            // =========================

            const searchTerm = searchAkun
                ? searchAkun.value.toLowerCase().trim()
                : '';

            const roleTerm = filterRole
                ? filterRole.value
                : 'Semua';

            const statusTerm = filterStatus
                ? filterStatus.value
                : 'Semua';


            let visibleCount = 0;


            // =========================
            // Periksa setiap baris akun
            // =========================

            tableRows.forEach(row => {

                // Lewati baris "Belum Ada Akun"
                if (row.querySelector('td[colspan="6"]')) {
                    return;
                }


                // =========================
                // Ambil data akun
                // =========================

                const namaElement = row.querySelector('.col-nama');
                const emailElement = row.querySelector('.col-email');
                const roleElement = row.querySelector('.col-role');

                const nama = namaElement
                    ? namaElement.textContent.toLowerCase().trim()
                    : '';

                const email = emailElement
                    ? emailElement.textContent.toLowerCase().trim()
                    : '';

                const role = roleElement
                    ? roleElement.textContent.trim()
                    : '';


                // =========================
                // AMBIL STATUS
                // =========================

                const statusElement = row.querySelector(
                    'td:nth-child(5) .badge'
                );

                const status = statusElement
                    ? statusElement.textContent.trim()
                    : '';


                // =========================
                // FILTER PENCARIAN
                // =========================

                const matchSearch =
                    nama.includes(searchTerm) ||
                    email.includes(searchTerm);


                // =========================
                // FILTER ROLE
                // =========================

                const matchRole =
                    roleTerm === 'Semua' ||
                    role === roleTerm;


                // =========================
                // FILTER STATUS
                // =========================

                const matchStatus =
                    statusTerm === 'Semua' ||
                    status === statusTerm;


                // =========================
                // TAMPILKAN / SEMBUNYIKAN
                // =========================

                if (
                    matchSearch &&
                    matchRole &&
                    matchStatus
                ) {

                    row.style.display = '';
                    visibleCount++;

                } else {

                    row.style.display = 'none';

                }

            });


            // =========================
            // JIKA TIDAK ADA DATA
            // =========================

            if (visibleCount === 0) {

                if (emptyAkun) {
                    emptyAkun.style.display = 'block';
                }

                akunTable.style.display = 'none';

            } else {

                if (emptyAkun) {
                    emptyAkun.style.display = 'none';
                }

                akunTable.style.display = 'table';

            }

        }


        // =====================================================
        // EVENT SEARCH
        // =====================================================

        if (searchAkun) {

            searchAkun.addEventListener(
                'input',
                filterAkunTable
            );

        }


        // =====================================================
        // EVENT FILTER ROLE
        // =====================================================

        if (filterRole) {

            filterRole.addEventListener(
                'change',
                filterAkunTable
            );

        }


        // =====================================================
        // EVENT FILTER STATUS
        // =====================================================

        if (filterStatus) {

            filterStatus.addEventListener(
                'change',
                filterAkunTable
            );

        }


        // Jalankan filter pertama kali
        filterAkunTable();

    }



    // =========================================================
    // LOGIKA HALAMAN TAMBAH AKUN
    // =========================================================

    const roleSelect = document.getElementById('role');
    const jurusanContainer = document.getElementById('jurusanContainer');
    const jurusanSelect = document.getElementById('jurusan');
    const helpText = document.getElementById('helpTextJurusan');


    if (
        roleSelect &&
        jurusanContainer
    ) {

        function updateJurusan() {

            // =================================================
            // JIKA ROLE = ADMIN TEFA
            // =================================================

            if (roleSelect.value === 'Admin TEFA') {

                jurusanContainer.style.display = 'none';

                if (jurusanSelect) {

                    jurusanSelect.required = false;
                    jurusanSelect.value = '';

                }

                if (helpText) {

                    helpText.textContent =
                        'Admin TEFA tidak terikat pada jurusan tertentu.';

                }

            }


            // =================================================
            // JIKA ROLE = ADMIN JURUSAN
            // =================================================

            else if (
                roleSelect.value === 'Admin Jurusan'
            ) {

                jurusanContainer.style.display = 'block';

                if (jurusanSelect) {

                    jurusanSelect.required = true;

                }

                if (helpText) {

                    helpText.textContent =
                        'Pilih jurusan yang menjadi tanggung jawab akun ini.';

                }

            }


            // =================================================
            // JIKA BELUM MEMILIH ROLE
            // =================================================

            else {

                jurusanContainer.style.display = 'none';

                if (jurusanSelect) {

                    jurusanSelect.required = false;

                }

                if (helpText) {

                    helpText.textContent =
                        'Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.';

                }

            }

        }


        // Jalankan ketika role berubah
        roleSelect.addEventListener(
            'change',
            updateJurusan
        );


        // Jalankan ketika halaman pertama kali dibuka
        updateJurusan();

    }

});