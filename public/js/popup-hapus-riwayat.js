let formHapusRiwayat = null;

function bukaPopupHapus(button) {
    formHapusRiwayat = button.closest('.rw-delete-form');

    const popup = document.getElementById('popupHapusRiwayat');

    if (!formHapusRiwayat || !popup) {
        console.error('Form atau popup hapus tidak ditemukan!');
        return;
    }

    popup.classList.add('active');
}

function tutupPopupHapus() {
    const popup = document.getElementById('popupHapusRiwayat');

    if (popup) {
        popup.classList.remove('active');
    }

    formHapusRiwayat = null;
}

function konfirmasiHapusRiwayat() {
    if (formHapusRiwayat) {
        formHapusRiwayat.submit();
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const popup = document.getElementById('popupHapusRiwayat');

    if (!popup) return;

    popup.addEventListener('click', function (event) {
        if (event.target === popup) {
            tutupPopupHapus();
        }
    });
});