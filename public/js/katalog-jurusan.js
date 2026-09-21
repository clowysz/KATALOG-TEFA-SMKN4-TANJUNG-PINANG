document.addEventListener('DOMContentLoaded', function () {
    const produkContainer = document.getElementById('produkContainer');
    const jasaContainer = document.getElementById('jasaContainer');
    const produkSection = document.getElementById('produkSection');
    const jasaSection = document.getElementById('jasaSection');
    const searchInput = document.getElementById('searchKatalog');
    const loading = document.getElementById('katalogLoading');
    const content = document.getElementById('katalogContent');
    const emptyState = document.getElementById('katalogEmpty');
    const errorState = document.getElementById('katalogError');

    let semuaProduk = [];
    let semuaJasa = [];

    function formatRupiah(value) {
        if (value === null || value === undefined || value === '') {
            return 'Rp0';
        }

        const number = Number(value);

        if (isNaN(number)) {
            return value;
        }

        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    function getImageUrl(item, jenis) {
        if (item.gambars && item.gambars.length > 0) {
            return '/storage/' + item.gambars[0].path_gambar;
        }

        return 'https://placehold.co/600x400/E2E8F0/1E3A8A?text=' + encodeURIComponent(jenis);
    }

    function getDescription(text) {
        if (!text) {
            return 'Tidak ada deskripsi.';
        }

        return text.length > 80
            ? text.substring(0, 80) + '...'
            : text;
    }

    function renderCards(data, container, jenis) {
        if (!container) {
            return;
        }

        container.innerHTML = '';

        if (data.length === 0) {
            container.innerHTML = `
                <div style="grid-column:1/-1;text-align:center;padding:50px 20px;background:white;border-radius:12px;border:1px dashed #cbd5e1;">
                    <div style="font-size:40px;margin-bottom:10px;">📂</div>
                    <h3 style="color:#1e293b;font-size:16px;margin-bottom:6px;">
                        Tidak ada ${jenis.toLowerCase()} ditemukan.
                    </h3>
                    <p style="color:#64748b;font-size:13px;margin:0;">
                        Coba gunakan kata kunci pencarian lain.
                    </p>
                </div>
            `;
            return;
        }

        data.forEach(function (item) {
            const card = document.createElement('div');
            card.className = 'catalog-card';

            const imageUrl = getImageUrl(item, jenis);
            const jumlahPesanan = item.pesanans_count || 0;

            card.innerHTML = `
                <img
                    src="${imageUrl}"
                    alt="${escapeHtml(item.nama_produk_jasa)}"
                    class="catalog-img"
                    style="object-fit:cover;"
                >

                <div class="catalog-content">

                    <div class="catalog-title">
                        ${escapeHtml(item.nama_produk_jasa)}
                    </div>

                    <div class="catalog-desc">
                        ${escapeHtml(getDescription(item.deskripsi))}
                    </div>

                    <div class="catalog-meta">
                        <span class="catalog-price">
                            ${formatRupiah(item.harga)}
                        </span>

                        <span class="catalog-stats">
                            ${jumlahPesanan} pesanan
                        </span>
                    </div>

                    <button
                        type="button"
                        class="btn-outline btn-lihat-detail"
                        data-id="${item.id_produk_jasa}"
                    >
                        Lihat Detail
                    </button>

                </div>
            `;

            container.appendChild(card);
        });

        container.querySelectorAll('.btn-lihat-detail').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');

                window.location.href =
                    '/jurusan-admin/katalog/detail?id_produk_jasa=' + encodeURIComponent(id);
            });
        });
    }

    function renderKatalog(keyword = '') {
        const search = keyword.toLowerCase().trim();

        const produkFiltered = semuaProduk.filter(function (item) {
            return (item.nama_produk_jasa || '')
                .toLowerCase()
                .includes(search);
        });

        const jasaFiltered = semuaJasa.filter(function (item) {
            return (item.nama_produk_jasa || '')
                .toLowerCase()
                .includes(search);
        });

        produkSection.style.display = produkFiltered.length > 0 ? 'block' : 'block';
        jasaSection.style.display = jasaFiltered.length > 0 ? 'block' : 'block';

        renderCards(
            produkFiltered,
            produkContainer,
            'Produk'
        );

        renderCards(
            jasaFiltered,
            jasaContainer,
            'Jasa'
        );

        if (produkFiltered.length === 0 && jasaFiltered.length === 0) {
            produkSection.style.display = 'none';
            jasaSection.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            emptyState.style.display = 'none';
        }
    }

    async function loadKatalog() {
        try {
            const [responseProduk, responseJasa] = await Promise.all([
                fetch('/jurusan-admin/produk?jenis=produk', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                }),

                fetch('/jurusan-admin/produk?jenis=jasa', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
            ]);

            if (!responseProduk.ok || !responseJasa.ok) {
                throw new Error('Gagal mengambil data katalog.');
            }

            const resultProduk = await responseProduk.json();
            const resultJasa = await responseJasa.json();

            semuaProduk = resultProduk.data || [];
            semuaJasa = resultJasa.data || [];

            loading.style.display = 'none';

            if (semuaProduk.length === 0 && semuaJasa.length === 0) {
                content.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }

            content.style.display = 'block';

            renderKatalog(
                searchInput ? searchInput.value : ''
            );

        } catch (error) {
            console.error(error);

            loading.style.display = 'none';
            content.style.display = 'none';
            emptyState.style.display = 'none';
            errorState.style.display = 'block';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            renderKatalog(this.value);
        });
    }

    loadKatalog();
});