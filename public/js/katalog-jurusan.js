document.addEventListener("DOMContentLoaded", function() {
    
    // --- 1. DATA DEFAULT SESUAI SPESIFIKASI ---
    const defaultProduk = [
        { id: 'p1', type: 'Produk', name: 'Aplikasi Kasir', desc: 'Aplikasi Point of Sales modern berbasis web lengkap dengan manajemen stok, laporan penjualan harian, dan cetak struk otomatis.', price: 'Rp 1.500.000', orders: 24, img: 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=500&q=80' },
        { id: 'p2', type: 'Produk', name: 'Sistem Informasi Sekolah', desc: 'Platform sistem informasi akademik sekolah meliputi data siswa, guru, jadwal pelajaran, dan rapor digital terintegrasi.', price: 'Rp 3.500.000', orders: 15, img: 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=500&q=80' },
        { id: 'p3', type: 'Produk', name: 'Aplikasi Inventori', desc: 'Sistem manajemen inventori gudang untuk memantau barang masuk dan keluar dengan fitur notifikasi stok menipis.', price: 'Rp 2.000.000', orders: 32, img: 'https://images.unsplash.com/photo-1586528116311-ad8ed7c83a7f?w=500&q=80' }
    ];

    const defaultJasa = [
        { id: 'j1', type: 'Jasa', name: 'Pembuatan Website', desc: 'Jasa pembuatan website company profile, landing page, maupun e-commerce dengan desain responsif dan SEO friendly.', price: 'Mulai Rp 2.000.000', orders: 18, img: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=500&q=80' },
        { id: 'j2', type: 'Jasa', name: 'Pemeliharaan Website', desc: 'Layanan maintenance rutin website mencakup update plugin, backup data, dan perbaikan bug ringan (bulanan).', price: 'Rp 500.000 / bulan', orders: 12, img: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&q=80' },
        { id: 'j3', type: 'Jasa', name: 'Hosting & Domain', desc: 'Layanan setup cloud hosting dan pendaftaran domain perusahaan dengan sertifikat SSL gratis untuk keamanan ekstra.', price: 'Mulai Rp 800.000 / tahun', orders: 45, img: 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=500&q=80' }
    ];

    // Inisialisasi ke LocalStorage jika belum ada
    if (!localStorage.getItem('rpl_produk')) localStorage.setItem('rpl_produk', JSON.stringify(defaultProduk));
    if (!localStorage.getItem('rpl_jasa')) localStorage.setItem('rpl_jasa', JSON.stringify(defaultJasa));

    const dataProduk = JSON.parse(localStorage.getItem('rpl_produk'));
    const dataJasa = JSON.parse(localStorage.getItem('rpl_jasa'));

    // --- 2. LOGIKA UNTUK HALAMAN KATALOG UTAMA ---
    const produkContainer = document.getElementById('produkContainer');
    const jasaContainer = document.getElementById('jasaContainer');

    function renderCatalogCard(item) {
        return `
            <div class="catalog-card">
                <img src="${item.img}" alt="${item.name}" class="catalog-img">
                <div class="catalog-content">
                    <div class="catalog-title">${item.name}</div>
                    <div class="catalog-desc">${item.desc.substring(0, 80)}...</div>
                    <div class="catalog-meta">
                        <span class="catalog-price">${item.price}</span>
                        <span class="catalog-stats">${item.orders} pesanan</span>
                    </div>
                    <button class="btn-outline btn-lihat-detail" data-item='${JSON.stringify(item)}'>Lihat Detail</button>
                </div>
            </div>
        `;
    }

    if (produkContainer && jasaContainer) {
        produkContainer.innerHTML = dataProduk.map(renderCatalogCard).join('');
        jasaContainer.innerHTML = dataJasa.map(renderCatalogCard).join('');

        // Event listener saat tombol 'Lihat Detail' ditekan
        document.querySelectorAll('.btn-lihat-detail').forEach(btn => {
            btn.addEventListener('click', function() {
                const itemData = this.getAttribute('data-item');
                localStorage.setItem('selected_katalog', itemData);
                window.location.href = '/jurusan-admin/katalog/detail'; // Pindah Halaman
            });
        });
    }

    // --- 3. LOGIKA UNTUK HALAMAN DETAIL KATALOG ---
    const detailTitle = document.getElementById('detailTitle');
    if (detailTitle) {
        const item = JSON.parse(localStorage.getItem('selected_katalog'));
        if (item) {
            document.getElementById('detailImg').src = item.img;
            detailTitle.textContent = item.name;
            document.getElementById('detailBadge').textContent = item.orders + ' pesanan masuk';
            document.getElementById('detailPrice').textContent = item.price;
            document.getElementById('detailDesc').textContent = item.desc;
        }
    }
});