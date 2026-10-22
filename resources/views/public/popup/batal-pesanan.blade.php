
<div class="cancel-modal" id="cancelModal" hidden>
    <div
        class="cancel-modal-dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cancelModalTitle"
    >
        <!-- Header Popup -->
        <div class="cancel-modal-header">
            <h2 id="cancelModalTitle">Batalkan Pesanan</h2>

            <button
                type="button"
                class="cancel-modal-close"
                id="cancelModalClose"
                aria-label="Tutup popup"
            >
                &times;
            </button>
        </div>

        <!-- Form Pembatalan -->
        <form id="cancelOrderForm" method="POST">
            @csrf

            <div class="cancel-modal-body" id="cancelModalBody">
                <p class="cancel-modal-description">
                    Mohon pilih alasan pembatalan pesanan kamu.
                </p>

                <div class="cancel-reason-list">
                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Saya berubah pikiran"
                            required
                        >
                        <span>Saya berubah pikiran</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Salah memilih produk atau jasa"
                        >
                        <span>Salah memilih produk atau jasa</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Ingin mengubah jumlah pesanan"
                        >
                        <span>Ingin mengubah jumlah pesanan</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Menemukan pilihan lain"
                        >
                        <span>Menemukan pilihan lain</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="Waktu pengerjaan terlalu lama"
                        >
                        <span>Waktu pengerjaan terlalu lama</span>
                    </label>

                    <label class="cancel-reason-option">
                        <input
                            type="radio"
                            name="alasan_pilihan"
                            value="lainnya"
                        >
                        <span>Alasan lainnya</span>
                    </label>
                </div>

                <textarea
                    class="cancel-reason-other"
                    id="cancelReasonOther"
                    placeholder="Tuliskan alasan lainnya..."
                    maxlength="2000"
                    hidden
                ></textarea>
            </div>

            <!-- Pesan Berhasil atau Gagal -->
            <p
                class="cancel-modal-message"
                id="cancelModalMessage"
                role="status"
                aria-live="polite"
            ></p>

            <!-- Tombol Kirim -->
            <div class="cancel-modal-footer" id="cancelModalFooter">
                <button
                    type="submit"
                    class="cancel-modal-submit"
                    id="cancelModalSubmit"
                >
                    Oke, Ajukan Pembatalan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('cancelModal');

    if (!modal || modal.dataset.initialized === 'true') {
        return;
    }

    modal.dataset.initialized = 'true';

    const form = document.getElementById('cancelOrderForm');
    const closeBtn = document.getElementById('cancelModalClose');
    const body = document.getElementById('cancelModalBody');
    const footer = document.getElementById('cancelModalFooter');
    const message = document.getElementById('cancelModalMessage');
    const title = document.getElementById('cancelModalTitle');
    const otherReason = document.getElementById('cancelReasonOther');
    const submitBtn = document.getElementById('cancelModalSubmit');

    let previousFocus = null;

    // Menampilkan pesan di popup.
    function showMessage(text, type) {
        message.textContent = text;
        message.className = 'cancel-modal-message';

        if (type) {
            message.classList.add(type);
        }
    }

    // Mengembalikan popup ke kondisi awal.
    function resetModal() {
        form.reset();

        otherReason.hidden = true;
        otherReason.required = false;

        body.hidden = false;
        footer.hidden = false;

        title.textContent = 'Batalkan Pesanan';

        message.textContent = '';
        message.className = 'cancel-modal-message';

        submitBtn.disabled = false;
        submitBtn.textContent = 'Oke, Ajukan Pembatalan';
    }

    // Membuka popup sesuai pesanan yang dipilih.
    function openModal(button) {
        resetModal();

        form.action = button.dataset.cancelUrl;
        previousFocus = button;

        modal.hidden = false;
        document.body.style.overflow = 'hidden';

        closeBtn.focus();
    }

    // Menutup popup.
    function closeModal() {
        modal.hidden = true;
        document.body.style.overflow = '';

        resetModal();

        if (previousFocus && previousFocus.isConnected) {
            previousFocus.focus();
        }
    }

    // Tombol Batalkan Pesanan.
    document.querySelectorAll('.rw-btn-cancel').forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            openModal(button);
        });
    });

    // Tombol silang.
    closeBtn.addEventListener('click', closeModal);

    // Tutup ketika area luar popup diklik.
    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Tutup menggunakan tombol Escape.
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });

    // Menampilkan kolom jika memilih alasan lainnya.
    form.querySelectorAll('input[name="alasan_pilihan"]')
        .forEach(function (radio) {
            radio.addEventListener('change', function () {
                if (!radio.checked) {
                    return;
                }

                const isOther = radio.value === 'lainnya';

                otherReason.hidden = !isOther;
                otherReason.required = isOther;

                if (isOther) {
                    otherReason.focus();
                } else {
                    otherReason.value = '';
                }
            });
        });

    // Mengirim permintaan pembatalan tanpa refresh halaman.
    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const selected = form.querySelector(
            'input[name="alasan_pilihan"]:checked'
        );

        if (!selected) {
            showMessage(
                'Silakan pilih alasan pembatalan terlebih dahulu.',
                'error'
            );
            return;
        }

        let alasan = selected.value;

        if (alasan === 'lainnya') {
            alasan = otherReason.value.trim();

            if (!alasan) {
                showMessage(
                    'Silakan tuliskan alasan pembatalan kamu.',
                    'error'
                );
                otherReason.focus();
                return;
            }
        }

        submitBtn.disabled = true;
        submitBtn.textContent = 'Mengirim...';

        showMessage('', '');

        try {
            const csrfToken = form.querySelector('[name="_token"]')?.value;

            if (!csrfToken) {
                throw new Error('Token keamanan tidak ditemukan.');
            }

            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    alasan: alasan
                })
            });

            const result = await response.json();

            // Menangani pembatalan yang gagal.
            if (!response.ok || !result.success) {
                const errorText = result.message
                    || Object.values(result.errors || {}).flat()[0]
                    || 'Pembatalan gagal diproses. Silakan coba lagi.';

                showMessage(errorText, 'error');

                submitBtn.disabled = false;
                submitBtn.textContent = 'Coba Lagi';

                return;
            }

            // Mengambil ID pesanan dari URL.
            const pesananId = form.action.match(
                /riwayat-pesanan\/(\d+)\/batalkan/
            )?.[1];

            // Mencari baris pesanan pada tabel riwayat.
            const barisPesanan = pesananId
                ? document.getElementById(`pesanan-${pesananId}`)
                : null;

            // Memperbarui tabel jika pesanan langsung dibatalkan.
            if (
                barisPesanan &&
                result.message === 'Pesanan berhasil dibatalkan.'
            ) {
                // Mengubah status pesanan.
                const kolomStatus = barisPesanan.querySelector(
                    '[data-label="Status"]'
                );

                if (kolomStatus) {
                    kolomStatus.innerHTML = `
                        <span class="rw-badge rw-badge--cancel">
                            <i class="ph ph-x-circle"></i>
                            Dibatalkan
                        </span>
                    `;
                }

                // Memperbarui keterangan progres.
                const kolomProgress = barisPesanan.querySelector(
                    '[data-label="Progress"]'
                );

                if (kolomProgress) {
                    kolomProgress.innerHTML = `
                        <div>
                            <div class="rw-text-main">-</div>
                            <div class="rw-text-sub">
                                Pesanan dibatalkan
                            </div>
                        </div>
                    `;
                }

                // Menghapus tombol pembatalan dari baris pesanan.
                const tombolBatal = barisPesanan.querySelector(
                    '.rw-btn-cancel'
                );

                if (tombolBatal) {
                    tombolBatal.remove();
                }
            }

            // Menyembunyikan formulir dan menampilkan hasilnya.
            body.hidden = true;
            footer.hidden = true;

            title.textContent = 'Pembatalan Pesanan';

            showMessage(
                result.message || 'Permintaan berhasil dikirim.',
                'success'
            );

        } catch (error) {
            console.error('Kesalahan pembatalan:', error);

            showMessage(
                'Terjadi masalah koneksi atau respons server tidak valid. Silakan coba lagi.',
                'error'
            );

            submitBtn.disabled = false;
            submitBtn.textContent = 'Coba Lagi';
        }
    });
});
</script>
