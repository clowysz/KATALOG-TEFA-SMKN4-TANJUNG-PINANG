// Buka modal
function openLayananModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.add('active');
}

// Tutup modal
function closeLayananModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.classList.remove('active');
}

// CSRF
function getCsrfToken() {
    const meta = document.querySelector('meta[name="csrf-token"]');

    if (!meta) {
        console.error('CSRF token tidak ditemukan.');
        return '';
    }

    return meta.getAttribute('content');
}

// Toast
function showLayananToast(message, success = true) {
    const toast = document.getElementById('toastNotif');

    if (!toast) return;

    toast.textContent = message;
    toast.style.backgroundColor = success ? '#28a745' : '#dc3545';
    toast.classList.add('show');

    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}

// Deteksi halaman
function isHalamanProduk() {
    return document.getElementById('kelolaProdukContainer') !== null;
}

function getTipeLayanan() {
    return isHalamanProduk() ? 'Produk' : 'Jasa';
}

function getJenisLayanan() {
    return isHalamanProduk() ? 'produk' : 'jasa';
}

// Modal tambah
function openTambahModal() {
    const form = document.getElementById('formLayanan');

    if (form) form.reset();

    const formId = document.getElementById('formId');
    if (formId) formId.value = '';

    const modalTitle = document.getElementById('modalFormTitle');

    if (modalTitle) {
        modalTitle.textContent = `Tambah ${getTipeLayanan()}`;
    }

    const formImg = document.getElementById('formImg');

    if (formImg) {
        formImg.setAttribute('required', 'true');
        formImg.value = '';
    }

    const preview = document.getElementById('imagePreviewContainer');

    if (preview) {
        preview.innerHTML = '';
    }

    window.uploadedFiles = [];

    openLayananModal('modalAdd');
}

// Saat halaman siap
document.addEventListener('DOMContentLoaded', function () {
    const isProduk = isHalamanProduk();

    const container = document.getElementById(
        isProduk ? 'kelolaProdukContainer' : 'kelolaJasaContainer'
    );

    const tipeLayanan = getTipeLayanan();
    const jenisLayanan = getJenisLayanan();

    const searchInput = document.getElementById('searchItem');
    const form = document.getElementById('formLayanan');
    const formImg = document.getElementById('formImg');
    const previewContainer = document.getElementById('imagePreviewContainer');

    // Tombol tambah
    const btnTambah = document.querySelector(
        'button[onclick="openLayananModal(\'modalAdd\')"]'
    );

    if (btnTambah) {
        btnTambah.setAttribute('onclick', 'openTambahModal()');
    }

    let dataItems = [];

    // Ambil data
    async function loadData() {
        if (!container) return;

        try {
            const response = await fetch(
                `/jurusan-admin/produk?jenis=${jenisLayanan}`,
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }
            );

            if (!response.ok) {
                throw new Error('Gagal mengambil data.');
            }

            const result = await response.json();

            dataItems = result.data || [];

            renderCards();
        } catch (error) {
            console.error(error);

            container.innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:80px 20px;">
                    <div style="font-size:56px;margin-bottom:16px;">⚠️</div>
                    <h3 style="color:var(--text-dark);margin-bottom:8px;">
                        Gagal memuat ${tipeLayanan.toLowerCase()}
                    </h3>
                    <p style="color:var(--text-muted);">
                        Silakan refresh halaman dan coba lagi.
                    </p>
                </div>
            `;
        }
    }

    // Format harga
    function formatRupiah(value) {
        if (value === null || value === undefined || value === '') {
            return 'Rp0';
        }

        const number = Number(value);

        if (isNaN(number)) return value;

        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }

    // Potong deskripsi
    function shortDescription(text, length = 60) {
        if (!text) return '';

        return text.length <= length
            ? text
            : text.substring(0, length) + '...';
    }

    // Gambar
    function getImageUrl(item) {
        if (item.gambars && item.gambars.length > 0) {
            return '/storage/' + item.gambars[0].path_gambar;
        }

        return 'https://placehold.co/600x400/E2E8F0/1E3A8A?text=' +
            encodeURIComponent(tipeLayanan);
    }

    // Render card
    function renderCards(filterText = '') {
        if (!container) return;

        container.innerHTML = '';

        const keyword = filterText.toLowerCase().trim();

        const filteredData = dataItems.filter(item => {
            const name = item.nama_produk_jasa || '';
            return name.toLowerCase().includes(keyword);
        });

        if (filteredData.length === 0) {
            container.innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:80px 20px;">
                    <div style="font-size:56px;margin-bottom:16px;">📫</div>
                    <h3 style="color:var(--text-dark);margin-bottom:8px;">
                        Tidak ada ${tipeLayanan.toLowerCase()} ditemukan.
                    </h3>
                    <p style="color:var(--text-muted);">
                        Coba gunakan kata kunci pencarian yang lain.
                    </p>
                </div>
            `;

            return;
        }

        filteredData.forEach(item => {
            const card = document.createElement('div');

            card.className = 'catalog-card';

            const imageUrl = getImageUrl(item);
            const harga = formatRupiah(item.harga);
            const pesanan = item.pesanans_count || 0;

            card.innerHTML = `
                <img
                    src="${imageUrl}"
                    alt="${item.nama_produk_jasa}"
                    class="catalog-img"
                    style="object-fit:cover;"
                >

                <div class="catalog-content">
                    <div class="catalog-title">
                        ${item.nama_produk_jasa}
                    </div>

                    <div class="catalog-desc">
                        ${shortDescription(item.deskripsi)}
                    </div>

                    <div class="catalog-meta" style="margin-bottom:0;">
                        <span class="catalog-price">${harga}</span>
                        <span class="catalog-stats">${pesanan} pesanan</span>
                    </div>

                    <div class="catalog-actions">
                        <button
                            class="btn-outline btn-edit"
                            data-id="${item.id_produk_jasa}"
                        >
                            Edit
                        </button>

                        <button
                            class="btn-outline btn-delete"
                            data-id="${item.id_produk_jasa}"
                            style="color:#dc3545;border-color:#dc3545;"
                        >
                            Hapus
                        </button>
                    </div>
                </div>
            `;

            container.appendChild(card);
        });

        // Edit
        container.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');

                const item = dataItems.find(data =>
                    String(data.id_produk_jasa) === String(id)
                );

                if (!item) return;

                document.getElementById('formId').value =
                    item.id_produk_jasa;

                document.getElementById('formName').value =
                    item.nama_produk_jasa;

                document.getElementById('formDesc').value =
                    item.deskripsi;

                document.getElementById('formPrice').value =
                    item.harga;

                if (formImg) {
                    formImg.removeAttribute('required');
                    formImg.value = '';
                }

                if (previewContainer) {
                    previewContainer.innerHTML = '';

                    if (item.gambars && item.gambars.length > 0) {
                        item.gambars.forEach(gambar => {
                            const wrapper = document.createElement('div');

                            wrapper.style.position = 'relative';
                            wrapper.style.display = 'inline-block';

                            const img = document.createElement('img');

                            img.src = '/storage/' + gambar.path_gambar;
                            img.style.width = '70px';
                            img.style.height = '70px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '8px';
                            img.style.border = '1px solid #CBD5E1';

                            wrapper.appendChild(img);
                            previewContainer.appendChild(wrapper);
                        });
                    } else {
                        previewContainer.innerHTML = `
                            <div style="font-size:12px;color:#64748b;">
                                Belum ada gambar.
                            </div>
                        `;
                    }
                }

                window.uploadedFiles = [];

                document.getElementById('modalFormTitle').textContent =
                    `Edit ${tipeLayanan}`;

                openLayananModal('modalAdd');
            });
        });

        // Hapus
        container.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function () {
                const id = this.getAttribute('data-id');

                document.getElementById('deleteId').value = id;

                openLayananModal('modalDelete');
            });
        });
    }

    // Search
    if (searchInput) {
        searchInput.addEventListener('keyup', function () {
            renderCards(this.value);
        });
    }

    // Submit
    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const id = document.getElementById('formId').value;
            const isEdit = id !== '';
            const csrf = getCsrfToken();

            if (!csrf) {
                showLayananToast(
                    'Token keamanan tidak ditemukan.',
                    false
                );
                return;
            }

            try {
                const formData = new FormData();

                formData.append(
                    'nama_produk_jasa',
                    document.getElementById('formName').value
                );

                formData.append('jenis', jenisLayanan);

                formData.append(
                    'deskripsi',
                    document.getElementById('formDesc').value
                );

                let harga =
                    document.getElementById('formPrice').value;

                harga = harga.replace(/[^0-9]/g, '');

                formData.append('harga', harga);
                formData.append('_token', csrf);

                if (window.uploadedFiles.length > 0) {
                    window.uploadedFiles.forEach(file => {
                        formData.append('gambar[]', file);
                    });
                }

                if (isEdit) {
                    formData.append('_method', 'PUT');
                }

                const url = isEdit
                    ? `/jurusan-admin/produk/${id}`
                    : '/jurusan-admin/produk';

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.message || 'Gagal menyimpan data.'
                    );
                }

                showLayananToast(
                    result.message || 'Data berhasil disimpan.'
                );

                closeLayananModal('modalAdd');

                await loadData();
            } catch (error) {
                console.error(error);

                showLayananToast(
                    error.message || 'Terjadi kesalahan.',
                    false
                );
            }
        });
    }

    // Konfirmasi hapus
    const btnConfirmDelete =
        document.getElementById('btnConfirmDelete');

    if (btnConfirmDelete) {
        btnConfirmDelete.addEventListener('click', async function () {
            const id =
                document.getElementById('deleteId').value;

            const csrf = getCsrfToken();

            if (!csrf) {
                showLayananToast(
                    'Token keamanan tidak ditemukan.',
                    false
                );
                return;
            }

            try {
                const formData = new FormData();

                formData.append('_token', csrf);
                formData.append('_method', 'DELETE');

                const response = await fetch(
                    `/jurusan-admin/produk/${id}`,
                    {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json'
                        },
                        body: formData
                    }
                );

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(
                        result.message || 'Gagal menghapus data.'
                    );
                }

                showLayananToast(
                    result.message || 'Data berhasil dihapus.'
                );

                closeLayananModal('modalDelete');

                await loadData();
            } catch (error) {
                console.error(error);

                showLayananToast(
                    error.message || 'Terjadi kesalahan.',
                    false
                );
            }
        });
    }

    loadData();
});