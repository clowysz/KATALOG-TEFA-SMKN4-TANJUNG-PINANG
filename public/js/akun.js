document.addEventListener("DOMContentLoaded", function () {

    // ==========================================================
    // FILTER DAFTAR AKUN
    // ==========================================================

    const searchAkun = document.getElementById('searchAkun');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatusAkun');
    const akunTable = document.getElementById('akunTable');
    const emptyAkun = document.getElementById('emptyAkun');

    if (akunTable) {

        const tableRows = akunTable.querySelectorAll('tbody tr');

        function filterAkunTable() {

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

            tableRows.forEach(row => {

                const namaElement = row.querySelector('.col-nama');
                const emailElement = row.querySelector('.col-email');
                const roleElement = row.querySelector('.col-role');
                const statusElement = row.querySelector('.col-status');

                const nama = namaElement
                    ? namaElement.textContent.toLowerCase().trim()
                    : '';

                const email = emailElement
                    ? emailElement.textContent.toLowerCase().trim()
                    : '';

                const role = roleElement
                    ? roleElement.dataset.role
                    : '';

                const status = statusElement
                    ? statusElement.dataset.status
                    : '';

                const matchSearch =
                    nama.includes(searchTerm) ||
                    email.includes(searchTerm);

                const matchRole =
                    roleTerm === 'Semua' ||
                    role === roleTerm;

                const matchStatus =
                    statusTerm === 'Semua' ||
                    status === statusTerm;

                if (matchSearch && matchRole && matchStatus) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (emptyAkun) {
                emptyAkun.style.display =
                    visibleCount === 0 ? 'block' : 'none';
            }
        }

        if (searchAkun) {
            searchAkun.addEventListener('keyup', filterAkunTable);
        }

        if (filterRole) {
            filterRole.addEventListener('change', filterAkunTable);
        }

        if (filterStatus) {
            filterStatus.addEventListener('change', filterAkunTable);
        }
    }


    // ==========================================================
    // FORM TAMBAH AKUN
    // ==========================================================

    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    const roleSelect = document.getElementById('role');
    const jurusanSelect = document.getElementById('id_jurusan');
    const jurusanContainer = document.getElementById('jurusanContainer');
    const helpText = document.getElementById('helpTextJurusan');

    const statusSelect = document.getElementById('status');


    // ==========================================================
    // JURUSAN
    // ==========================================================

    function updateJurusan() {

        if (!roleSelect || !jurusanSelect) {
            return;
        }

        if (roleSelect.value === 'admin_jurusan') {

            if (jurusanContainer) {
                jurusanContainer.style.display = 'block';
            }

            jurusanSelect.disabled = false;
            jurusanSelect.required = true;

            if (helpText) {
                helpText.textContent =
                    'Pilih jurusan yang menjadi tanggung jawab akun ini.';
            }

        } else {

            if (jurusanContainer) {
                jurusanContainer.style.display = 'none';
            }

            jurusanSelect.disabled = true;
            jurusanSelect.required = false;
            jurusanSelect.value = '';
            jurusanSelect.setCustomValidity('');

            if (roleSelect.value === 'admin_tefa') {

                if (helpText) {
                    helpText.textContent =
                        'Admin TEFA tidak terikat pada jurusan tertentu.';
                }

            } else {

                if (helpText) {
                    helpText.textContent =
                        'Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.';
                }
            }
        }
    }

    if (roleSelect) {
        roleSelect.addEventListener('change', function () {

            this.setCustomValidity('');

            updateJurusan();
        });

        updateJurusan();
    }


    // ==========================================================
    // NAMA
    // ==========================================================

    if (namaInput) {

        namaInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Nama pengguna wajib diisi.'
                );

            } else {

                this.setCustomValidity('');
            }
        });

        namaInput.addEventListener('input', function () {

            this.setCustomValidity('');
        });
    }


    // ==========================================================
    // EMAIL
    // ==========================================================

    if (emailInput) {

        function validateEmail() {

            const value = emailInput.value.trim();

            if (value === '') {

                emailInput.setCustomValidity(
                    'Email wajib diisi.'
                );

                return;
            }

            const emailPattern =
                /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(value)) {

                emailInput.setCustomValidity(
                    'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
                );

                return;
            }

            emailInput.setCustomValidity('');
        }

        emailInput.addEventListener('invalid', function () {
            validateEmail();
        });

        emailInput.addEventListener('input', function () {
            validateEmail();
        });
    }


    // ==========================================================
    // PASSWORD
    // ==========================================================

    if (passwordInput) {

        passwordInput.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Password wajib diisi.'
                );

            } else if (this.validity.tooShort) {

                this.setCustomValidity(
                    'Password harus memiliki minimal 6 karakter.'
                );

            } else {

                this.setCustomValidity('');
            }
        });

        passwordInput.addEventListener('input', function () {

            if (this.value.length === 0) {

                this.setCustomValidity(
                    'Password wajib diisi.'
                );

            } else if (this.value.length < 6) {

                this.setCustomValidity(
                    'Password harus memiliki minimal 6 karakter.'
                );

            } else {

                this.setCustomValidity('');
            }
        });
    }


    // ==========================================================
    // ROLE
    // ==========================================================

    if (roleSelect) {

        roleSelect.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Role wajib dipilih.'
                );

            } else {

                this.setCustomValidity('');
            }
        });

        roleSelect.addEventListener('change', function () {

            this.setCustomValidity('');

            updateJurusan();
        });
    }


    // ==========================================================
    // JURUSAN
    // ==========================================================

    if (jurusanSelect) {

        jurusanSelect.addEventListener('invalid', function () {

            if (
                roleSelect &&
                roleSelect.value === 'admin_jurusan' &&
                this.validity.valueMissing
            ) {

                this.setCustomValidity(
                    'Jurusan wajib dipilih untuk Admin Jurusan.'
                );

            } else {

                this.setCustomValidity('');
            }
        });

        jurusanSelect.addEventListener('change', function () {

            this.setCustomValidity('');
        });
    }


    // ==========================================================
    // STATUS
    // ==========================================================

    if (statusSelect) {

        statusSelect.addEventListener('invalid', function () {

            if (this.validity.valueMissing) {

                this.setCustomValidity(
                    'Status akun wajib dipilih.'
                );

            } else {

                this.setCustomValidity('');
            }
        });

        statusSelect.addEventListener('change', function () {

            this.setCustomValidity('');
        });
    }

});