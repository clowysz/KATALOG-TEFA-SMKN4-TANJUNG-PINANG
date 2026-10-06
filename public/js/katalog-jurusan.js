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

    const filterButtons =
        document.querySelectorAll('.katalog-filter-btn');


    let semuaProduk = [];
    let semuaJasa = [];

    let filterAktif = 'semua';


    /* =========================
       FORMAT RUPIAH
    ========================= */

    function formatRupiah(value) {

        if (
            value === null ||
            value === undefined ||
            value === ''
        ) {
            return 'Rp0';
        }

        const number = Number(value);

        if (isNaN(number)) {
            return value;
        }

        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }


    /* =========================
       ESCAPE HTML
    ========================= */

    function escapeHtml(text) {

        const div = document.createElement('div');

        div.textContent = text ?? '';

        return div.innerHTML;
    }


    /* =========================
       IMAGE
    ========================= */

    function getImageUrl(item, jenis) {

        if (
            item.gambars &&
            item.gambars.length > 0
        ) {
            return '/storage/' + item.gambars[0].path_gambar;
        }

        return 'https://placehold.co/600x400/E2E8F0/1E3A8A?text='
            + encodeURIComponent(jenis);
    }


    /* =========================
       DESCRIPTION
    ========================= */

    function getDescription(text) {

        if (!text) {
            return 'Tidak ada deskripsi.';
        }

        return text.length > 80
            ? text.substring(0, 80) + '...'
            : text;
    }


    /* =========================
       FILTER DATA
    ========================= */

    function getFilteredData(data, keyword) {

        const search = keyword
            .toLowerCase()
            .trim();

        return data.filter(function (item) {

            return (item.nama_produk_jasa || '')
                .toLowerCase()
                .includes(search);

        });
    }


    /* =========================
       RENDER CARDS
    ========================= */

    function renderCards(
        data,
        container,
        jenis
    ) {

        if (!container) {
            return;
        }

        container.innerHTML = '';


        /* =========================
           EMPTY PER SECTION
        ========================= */

        if (data.length === 0) {

            const icon =
                jenis.toLowerCase() === 'produk'
                    ? 'ph-package'
                    : 'ph-briefcase';

            container.innerHTML = `

                <div
                    style="
                        grid-column:1/-1;
                        text-align:center;
                        padding:50px 20px;
                        background:white;
                        border-radius:12px;
                        border:1px dashed #cbd5e1;
                    "
                >

                    <div
                        style="
                            width:60px;
                            height:60px;
                            border-radius:50%;
                            background:#F1F5F9;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            margin:0 auto 12px;
                        "
                    >

                        <i
                            class="ph ${icon}"
                            style="
                                font-size:30px;
                                color:#94A3B8;
                            "
                        ></i>

                    </div>


                    <h3
                        style="
                            color:#1e293b;
                            font-size:16px;
                            margin-bottom:6px;
                        "
                    >
                        Tidak ada ${jenis.toLowerCase()} ditemukan.
                    </h3>


                    <p
                        style="
                            color:#64748b;
                            font-size:13px;
                            margin:0;
                        "
                    >
                        Coba gunakan kata kunci pencarian lain.
                    </p>

                </div>

            `;

            return;
        }


        /* =========================
           CARD
        ========================= */

        data.forEach(function (item) {

            const card =
                document.createElement('div');

            card.className = 'catalog-card';


            const imageUrl =
                getImageUrl(item, jenis);


            const jumlahPesanan =
                item.pesanans_count || 0;


            const satuanHarga =
                item.satuan_harga
                    ? '/' + escapeHtml(item.satuan_harga)
                    : '';


            const jurusan =
                item.jurusan &&
                item.jurusan.nama_jurusan
                    ? item.jurusan.nama_jurusan
                    : '';


            card.innerHTML = `

                <!-- IMAGE -->

                <div class="catalog-img-wrapper">

                    <img
                        src="${imageUrl}"
                        alt="${escapeHtml(item.nama_produk_jasa)}"
                        class="catalog-img"
                    >


                    <!-- JUMLAH PESANAN -->

                    <span class="catalog-stats">

                        <i
                            class="ph ph-shopping-cart"
                            style="
                                font-size:12px;
                                margin-right:3px;
                            "
                        ></i>

                        ${jumlahPesanan} pesanan

                    </span>


                    <!-- JENIS -->

                    <span class="catalog-badge">

                        ${escapeHtml(
                            String(jenis).toUpperCase()
                        )}

                    </span>

                </div>


                <!-- CARD BODY -->

                <div class="catalog-content">


                    <!-- TITLE -->

                    <div class="catalog-title">

                        ${escapeHtml(
                            item.nama_produk_jasa
                        )}

                    </div>


                    ${
                        jurusan
                            ? `
                                <div class="catalog-jurusan">
                                    ${escapeHtml(jurusan)}
                                </div>
                              `
                            : ''
                    }


                    <!-- DESCRIPTION -->

                    <div class="catalog-desc">

                        ${escapeHtml(
                            getDescription(item.deskripsi)
                        )}

                    </div>


                    <!-- PRICE -->

                    <div class="catalog-price">

                        ${formatRupiah(item.harga)}${satuanHarga}

                    </div>


                    <!-- DETAIL -->

                    <button
                        type="button"
                        class="btn-lihat-detail"
                        data-id="${item.id_produk_jasa}"
                    >
                        Lihat Detail
                    </button>


                </div>

            `;


            container.appendChild(card);

        });


        /* =========================
           DETAIL BUTTON
        ========================= */

        container
            .querySelectorAll('.btn-lihat-detail')
            .forEach(function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        const id =
                            this.getAttribute('data-id');


                        /*
                         * Admin hanya membuka
                         * halaman detail katalog.
                         *
                         * Tidak menambah jumlah_tampilan.
                         *
                         * Statistik tampilan hanya
                         * dihitung dari halaman publik.
                         */

                        window.location.href =
                            '/jurusan-admin/katalog/detail?id_produk_jasa='
                            + encodeURIComponent(id);

                    }
                );

            });

    }


    /* =========================
       RENDER KATALOG
    ========================= */

    function renderKatalog(keyword = '') {

        let produkFiltered = [];
        let jasaFiltered = [];


        /* =========================
           FILTER JENIS
        ========================= */

        if (
            filterAktif === 'semua' ||
            filterAktif === 'produk'
        ) {

            produkFiltered =
                getFilteredData(
                    semuaProduk,
                    keyword
                );

        }


        if (
            filterAktif === 'semua' ||
            filterAktif === 'jasa'
        ) {

            jasaFiltered =
                getFilteredData(
                    semuaJasa,
                    keyword
                );

        }


        /* =========================
           PRODUK SECTION
        ========================= */

        if (filterAktif === 'jasa') {

            produkSection.style.display = 'none';

        } else {

            produkSection.style.display = 'block';

            renderCards(
                produkFiltered,
                produkContainer,
                'Produk'
            );

        }


        /* =========================
           JASA SECTION
        ========================= */

        if (filterAktif === 'produk') {

            jasaSection.style.display = 'none';

        } else {

            jasaSection.style.display = 'block';

            renderCards(
                jasaFiltered,
                jasaContainer,
                'Jasa'
            );

        }


        /* =========================
           GLOBAL EMPTY STATE
        ========================= */

        if (
            produkFiltered.length === 0 &&
            jasaFiltered.length === 0
        ) {

            produkSection.style.display = 'none';
            jasaSection.style.display = 'none';

            emptyState.style.display = 'block';

        } else {

            emptyState.style.display = 'none';

        }

    }


    /* =========================
       LOAD KATALOG
    ========================= */

    async function loadKatalog() {

        try {

            const [
                responseProduk,
                responseJasa
            ] = await Promise.all([

                fetch(
                    '/jurusan-admin/produk?jenis=produk',
                    {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                ),

                fetch(
                    '/jurusan-admin/produk?jenis=jasa',
                    {
                        method: 'GET',

                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                )

            ]);


            if (
                !responseProduk.ok ||
                !responseJasa.ok
            ) {

                throw new Error(
                    'Gagal mengambil data katalog.'
                );

            }


            const resultProduk =
                await responseProduk.json();


            const resultJasa =
                await responseJasa.json();


            semuaProduk =
                resultProduk.data || [];


            semuaJasa =
                resultJasa.data || [];


            loading.style.display = 'none';


            /* =========================
               DATABASE KOSONG
            ========================= */

            if (
                semuaProduk.length === 0 &&
                semuaJasa.length === 0
            ) {

                content.style.display = 'none';

                emptyState.style.display = 'block';

                return;

            }


            content.style.display = 'block';


            renderKatalog(
                searchInput
                    ? searchInput.value
                    : ''
            );


        } catch (error) {

            console.error(error);


            loading.style.display = 'none';

            content.style.display = 'none';

            emptyState.style.display = 'none';

            errorState.style.display = 'block';

        }

    }


    /* =========================
       SEARCH
    ========================= */

    if (searchInput) {

        searchInput.addEventListener(
            'input',
            function () {

                const keyword = this.value;


                /*
                 * Pencarian admin hanya digunakan
                 * untuk filter tampilan katalog.
                 *
                 * TIDAK menambah:
                 * - jumlah_pencarian
                 * - jumlah_tampilan
                 *
                 * Jadi setiap huruf yang diketik
                 * tidak akan masuk statistik.
                 */

                renderKatalog(keyword);

            }
        );

    }


    /* =========================
       FILTER BUTTON
    ========================= */

    filterButtons.forEach(
        function (button) {

            button.addEventListener(
                'click',
                function () {

                    /*
                     * Ambil jenis filter
                     * dari data-filter.
                     */

                    filterAktif =
                        this.getAttribute(
                            'data-filter'
                        );


                    /*
                     * Update tampilan
                     * tombol aktif.
                     */

                    filterButtons.forEach(
                        function (filterButton) {

                            filterButton.classList.remove(
                                'active'
                            );

                        }
                    );


                    this.classList.add(
                        'active'
                    );


                    /*
                     * Render ulang.
                     *
                     * Tidak ada perubahan
                     * statistik di sini.
                     */

                    renderKatalog(
                        searchInput
                            ? searchInput.value
                            : ''
                    );

                }
            );

        }
    );


    /* =========================
       START
    ========================= */

    loadKatalog();

});