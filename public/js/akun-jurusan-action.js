function openModal(id) {
    const modal = document.getElementById(id);

    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);

    if (modal) {
        modal.classList.remove('active');
    }
}

document.addEventListener('DOMContentLoaded', function () {

    const urlParams = new URLSearchParams(window.location.search);
    const accountId = urlParams.get('id');

    const toast = document.getElementById('toastAction');

    function showToast(message, type = 'success') {
        if (!toast) {
            return;
        }

        toast.textContent = message;
        toast.style.backgroundColor =
            type === 'error' ? '#dc3545' : '#28a745';

        toast.classList.add('show');

        setTimeout(function () {
            toast.classList.remove('show');
        }, 3000);
    }

    function getCsrfToken() {
        const tokenInput = document.querySelector('input[name="_token"]');

        if (tokenInput) {
            return tokenInput.value;
        }

        const metaToken = document.querySelector(
            'meta[name="csrf-token"]'
        );

        if (metaToken) {
            return metaToken.getAttribute('content');
        }

        return '';
    }

    // =========================================================
    // TOMBOL EDIT
    // =========================================================

    const btnToEdit = document.getElementById('btnToEdit');

    if (btnToEdit && accountId) {
        btnToEdit.addEventListener('click', function () {
            window.location.href =
                `/jurusan-admin/akun/edit?id=${accountId}`;
        });
    }

    // =========================================================
    // TOMBOL HAPUS AKSES
    // =========================================================

    const btnHapusAkses =
        document.getElementById('btnHapusAkses');

    if (btnHapusAkses) {
        btnHapusAkses.addEventListener('click', function () {
            openModal('modalHapus');
        });
    }

    // =========================================================
    // KONFIRMASI HAPUS AKSES
    // =========================================================

    const btnConfirmStatus =
        document.getElementById('btnConfirmStatus');

    if (btnConfirmStatus && accountId) {

        btnConfirmStatus.addEventListener('click', async function () {

            const csrfToken = getCsrfToken();

            if (!csrfToken) {
                showToast('Token keamanan tidak ditemukan.', 'error');
                return;
            }

            btnConfirmStatus.disabled = true;
            btnConfirmStatus.textContent = 'Memproses...';

            try {

                const response = await fetch(
                    '/jurusan-admin/akun/status',
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id: accountId,
                            status: 'tidak_aktif'
                        })
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message ||
                        'Gagal menonaktifkan akun.'
                    );
                }

                closeModal('modalHapus');

                showToast(
                    data.message ||
                    'Akses akun berhasil dihapus.'
                );

                setTimeout(function () {
                    window.location.reload();
                }, 1000);

            } catch (error) {

                showToast(
                    error.message ||
                    'Terjadi kesalahan.',
                    'error'
                );

                btnConfirmStatus.disabled = false;
                btnConfirmStatus.textContent = 'Hapus Akses';
            }

        });

    }

    // =========================================================
    // AKTIFKAN KEMBALI
    // =========================================================

    const btnAktifkan =
        document.getElementById('btnAktifkan');

    if (btnAktifkan && accountId) {

        btnAktifkan.addEventListener('click', async function () {

            const csrfToken = getCsrfToken();

            if (!csrfToken) {
                showToast('Token keamanan tidak ditemukan.', 'error');
                return;
            }

            btnAktifkan.disabled = true;
            btnAktifkan.textContent = 'Memproses...';

            try {

                const response = await fetch(
                    '/jurusan-admin/akun/status',
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            id: accountId,
                            status: 'aktif'
                        })
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message ||
                        'Gagal mengaktifkan akun.'
                    );
                }

                showToast(
                    data.message ||
                    'Akun berhasil diaktifkan kembali.'
                );

                setTimeout(function () {
                    window.location.reload();
                }, 1000);

            } catch (error) {

                showToast(
                    error.message ||
                    'Terjadi kesalahan.',
                    'error'
                );

                btnAktifkan.disabled = false;
                btnAktifkan.textContent = 'Aktifkan Kembali';
            }

        });

    }

    // =========================================================
    // RESET PASSWORD
    // =========================================================

    const formReset =
        document.getElementById('formResetPassword');

    if (formReset && accountId) {

        const toggleModalPass =
            document.getElementById('toggleModalPass');

        const newPass =
            document.getElementById('newPass');

        const confirmPass =
            document.getElementById('confirmPass');

        const errorReset =
            document.getElementById('errorReset');

        // -----------------------------------------------------
        // Tampilkan / sembunyikan password
        // -----------------------------------------------------

        if (
            toggleModalPass &&
            newPass &&
            confirmPass
        ) {

            toggleModalPass.addEventListener(
                'change',
                function () {

                    const type =
                        this.checked
                            ? 'text'
                            : 'password';

                    newPass.type = type;
                    confirmPass.type = type;
                }
            );

        }

        // -----------------------------------------------------
        // Submit reset password
        // -----------------------------------------------------

        formReset.addEventListener(
            'submit',
            async function (event) {

                event.preventDefault();

                if (!newPass || !confirmPass) {
                    return;
                }

                if (
                    newPass.value !==
                    confirmPass.value
                ) {

                    if (errorReset) {
                        errorReset.style.display = 'block';
                    }

                    return;
                }

                if (errorReset) {
                    errorReset.style.display = 'none';
                }

                const csrfToken = getCsrfToken();

                if (!csrfToken) {
                    showToast(
                        'Token keamanan tidak ditemukan.',
                        'error'
                    );
                    return;
                }

                const submitButton =
                    formReset.querySelector(
                        'button[type="submit"]'
                    );

                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent =
                        'Memproses...';
                }

                try {

                    const response = await fetch(
                        '/jurusan-admin/akun/reset-password',
                        {
                            method: 'PUT',
                            headers: {
                                'Content-Type':
                                    'application/json',
                                'Accept':
                                    'application/json',
                                'X-CSRF-TOKEN':
                                    csrfToken
                            },
                            body: JSON.stringify({
                                id: accountId,
                                password: newPass.value,
                                password_confirmation:
                                    confirmPass.value
                            })
                        }
                    );

                    const data =
                        await response.json();

                    if (!response.ok) {
                        throw new Error(
                            data.message ||
                            'Gagal mereset password.'
                        );
                    }

                    closeModal('modalReset');

                    formReset.reset();

                    if (toggleModalPass) {
                        toggleModalPass.checked = false;
                    }

                    if (newPass) {
                        newPass.type = 'password';
                    }

                    if (confirmPass) {
                        confirmPass.type = 'password';
                    }

                    showToast(
                        data.message ||
                        'Password berhasil direset.'
                    );

                } catch (error) {

                    showToast(
                        error.message ||
                        'Terjadi kesalahan.',
                        'error'
                    );

                } finally {

                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.textContent =
                            'Simpan Password';
                    }

                }

            }
        );

    }

    // =========================================================
    // KLIK DI LUAR MODAL
    // =========================================================

    document.addEventListener('click', function (event) {

        const modalHapus =
            document.getElementById('modalHapus');

        const modalReset =
            document.getElementById('modalReset');

        if (
            modalHapus &&
            event.target === modalHapus
        ) {
            closeModal('modalHapus');
        }

        if (
            modalReset &&
            event.target === modalReset
        ) {
            closeModal('modalReset');
        }

    });

});