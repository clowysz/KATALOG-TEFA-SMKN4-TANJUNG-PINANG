@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk/Jasa')

@section('content')
<style>
.detail-page-wrapper {
    padding: 0 24px 40px;
}

/* TOMBOL KEMBALI (sama seperti admin TEFA) */
.back-link-wrapper {
    margin-bottom: 2px;
}

.back-link {
    display: inline-block !important;
    padding: 8px 16px !important;
    border: 1px solid #1E3A8A !important;
    border-radius: 8px !important;
    color: #1E3A8A !important;
    background: #FFFFFF !important;
    text-decoration: none !important;
    font-weight: 600 !important;
    font-size: 14px !important;
    opacity: 1 !important;
    filter: none !important;
    box-shadow: none !important;
    transform: none !important;
}

.back-link i {
    color: #1E3A8A !important;
}

.back-link:hover {
    background: #1E3A8A !important;
    color: #FFFFFF !important;
    border-color: #1E3A8A !important;
}

.back-link:hover i {
    color: #FFFFFF !important;
}

/* STATE LOADING & ERROR */
.detail-state-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 50px 20px;
    text-align: center;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05);
    margin-top: 16px;
}

.detail-state-box h3 {
    color: #0f172a;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 4px;
}

.detail-state-box p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

/* CONTAINER ATAS */
.detail-top-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 24px 32px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    align-items: start;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    border: 1px solid #f1f5f9;
    margin-bottom: 20px;
    margin-top: 16px;
}

/* GALERI */
.detail-gallery,
.admin-product-gallery {
    width: 100%;
}

.admin-main-image {
    position: relative;
    width: 100%;
    height: 380px;
    overflow: hidden;
    border-radius: 14px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
}

.admin-gallery-image {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    cursor: zoom-in;
}

.admin-gallery-image.active {
    opacity: 1;
    visibility: visible;
    z-index: 1;
}

.admin-gallery-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.9);
    color: #0f172a;
    font-size: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: background 0.2s ease, transform 0.2s ease;
}

.admin-gallery-arrow:hover {
    background: #ffffff;
    transform: translateY(-50%) scale(1.08);
}

.admin-gallery-prev { left: 14px; }
.admin-gallery-next { right: 14px; }

.admin-gallery-dots {
    position: absolute;
    bottom: 14px;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    z-index: 10;
}

.admin-gallery-dot {
    width: 8px;
    height: 8px;
    padding: 0;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.6);
    cursor: pointer;
    transition: all 0.2s ease;
}

.admin-gallery-dot.active {
    width: 20px;
    border-radius: 10px;
    background: #ffffff;
}

.admin-gallery-thumbnails {
    display: flex;
    gap: 10px;
    width: 100%;
    margin-top: 14px;
    padding-bottom: 4px;
    overflow-x: auto;
    scrollbar-width: thin;
}

.admin-gallery-thumbnails::-webkit-scrollbar {
    height: 4px;
}

.admin-gallery-thumbnails::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.admin-gallery-thumb {
    flex: 0 0 70px;
    width: 70px;
    height: 55px;
    padding: 0;
    border: 2px solid transparent;
    border-radius: 8px;
    overflow: hidden;
    background: #e2e8f0;
    opacity: 0.6;
    cursor: pointer;
    transition: all 0.2s ease;
}

.admin-gallery-thumb:hover,
.admin-gallery-thumb.active {
    opacity: 1;
    border-color: #1e3a8a;
}

.admin-gallery-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* INFORMASI */
.detail-info {
    display: flex;
    flex-direction: column;
}

.detail-badge {
    align-self: flex-start;
    display: inline-flex;
    align-items: center;
    padding: 6px 14px;
    border-radius: 20px;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
}

.detail-title {
    color: #0f172a;
    font-size: 28px;
    font-weight: 800;
    line-height: 1.3;
    margin: 0 0 20px;
}

.price-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 24px;
}

.price-label {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.detail-price {
    color: #1e3a8a;
    font-size: 28px;
    font-weight: 800;
}

/* META CARDS */
.detail-meta-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

.meta-card-item {
    background: #ffffff;
    border-radius: 14px;
    padding: 16px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid #f1f5f9;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
}

.meta-icon {
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border-radius: 10px;
    background: #eff6ff;
    color: #1d4ed8;
    display: flex;
    align-items: center;
    justify-content: center;
}

.meta-icon i {
    font-size: 20px;
}

.meta-label {
    display: block;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.3px;
    margin-bottom: 2px;
}

.meta-value {
    display: block;
    color: #0f172a;
    font-size: 14px;
    font-weight: 700;
}

/* DESKRIPSI */
.detail-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    border: 1px solid #f1f5f9;
    color: #0f172a;
}

.detail-section-title {
    margin: 0 0 16px;
    color: #0f172a;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.3px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f5f9;
}

.detail-text {
    color: #334155;
    font-size: 15px;
    line-height: 1.8;
    white-space: pre-line;
}

/* LIGHTBOX */
.admin-gallery-lightbox {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
    background: rgba(15, 23, 42, 0.9);
    backdrop-filter: blur(4px);
}

.admin-gallery-lightbox.active {
    display: flex;
}

.admin-lightbox-image {
    max-width: 90vw;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

.admin-lightbox-close {
    position: absolute;
    top: 20px;
    right: 24px;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
    transition: background 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.admin-lightbox-close:hover {
    background: rgba(255, 255, 255, 0.4);
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .detail-top-card {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 24px;
    }
    .admin-main-image {
        height: 320px;
    }
    .detail-meta-cards {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .detail-page-wrapper {
        padding: 0 16px 36px;
    }
    .detail-meta-cards {
        grid-template-columns: 1fr;
    }
    .detail-top-card,
    .detail-card {
        padding: 20px;
        border-radius: 16px;
    }
    .admin-main-image {
        height: 250px;
    }
    .detail-title {
        font-size: 22px;
    }
    .detail-price {
        font-size: 24px;
    }
}
</style>

<div class="detail-page-wrapper">

    {{-- TOMBOL KEMBALI --}}
    <div class="back-link-wrapper">
        <a href="/jurusan-admin/katalog" class="back-link">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    {{-- LOADING --}}
    <div id="detailLoading" class="detail-state-box">
        <div style="font-size: 36px; margin-bottom: 12px;">⏳</div>
        <h3>Memuat detail...</h3>
        <p>Mohon tunggu sebentar, sedang mengambil data produk/jasa.</p>
    </div>

    {{-- ERROR --}}
    <div id="detailError" class="detail-state-box" style="display: none; border-color: #fee2e2;">
        <div style="font-size: 40px; margin-bottom: 12px;">⚠️</div>
        <h3>Data tidak ditemukan</h3>
        <p>Produk atau jasa yang dipilih tidak tersedia atau telah dihapus.</p>
    </div>

    {{-- KONTEN --}}
    <div id="detailContent" style="display: none;">

        {{-- CONTAINER ATAS: GALERI & INFO --}}
        <div class="detail-top-card">

            <div class="detail-gallery">
                <div class="admin-product-gallery">
                    <div class="admin-main-image" id="adminMainImage"></div>
                    <div class="admin-gallery-thumbnails" id="adminThumbnails" style="display: none;"></div>
                </div>
            </div>

            <div class="detail-info">
                <div class="detail-badge" id="detailBadge">-</div>

                <h1 class="detail-title" id="detailTitle">Memuat...</h1>

                <div class="price-box">
                    <div class="price-label">HARGA</div>
                    <div class="detail-price" id="detailPrice">Rp0</div>
                </div>
            </div>

        </div>

        {{-- META CARDS --}}
        <div class="detail-meta-cards">

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-tag"></i></div>
                <div>
                    <span class="meta-label">JENIS</span>
                    <span class="meta-value" id="metaJenis">-</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-shopping-cart"></i></div>
                <div>
                    <span class="meta-label">JUMLAH PESANAN</span>
                    <span class="meta-value" id="statPesanan">0</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-magnifying-glass"></i></div>
                <div>
                    <span class="meta-label">PENCARIAN</span>
                    <span class="meta-value" id="statPencarian">0</span>
                </div>
            </div>

            <div class="meta-card-item">
                <div class="meta-icon"><i class="ph ph-eye"></i></div>
                <div>
                    <span class="meta-label">TAMPILAN HALAMAN</span>
                    <span class="meta-value" id="statTampilan">0</span>
                </div>
            </div>

        </div>

        {{-- DESKRIPSI --}}
        <div class="detail-card">
            <h2 class="detail-section-title">DESKRIPSI</h2>
            <div class="detail-text" id="detailDesc">Memuat deskripsi...</div>
        </div>

    </div>
</div>

{{-- LIGHTBOX --}}
<div class="admin-gallery-lightbox" id="adminGalleryLightbox">
    <button type="button" class="admin-lightbox-close" onclick="adminGalleryCloseLightbox()">&times;</button>
    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Preview gambar">
</div>
@endsection

@section('scripts')
<script>
/* =========================================================
   GALERI (sama seperti admin TEFA)
========================================================= */
let adminGalleryIndex = 0;

function adminGalleryImages() {
    return document.querySelectorAll('.admin-gallery-image');
}

function adminGalleryUpdate() {
    const images = adminGalleryImages();
    const dots = document.querySelectorAll('.admin-gallery-dot');
    const thumbs = document.querySelectorAll('.admin-gallery-thumb');

    if (!images.length) return;

    images.forEach((el, i) => el.classList.toggle('active', i === adminGalleryIndex));
    dots.forEach((el, i) => el.classList.toggle('active', i === adminGalleryIndex));
    thumbs.forEach((el, i) => el.classList.toggle('active', i === adminGalleryIndex));

    const activeThumb = document.querySelector('.admin-gallery-thumb.active');
    if (activeThumb) {
        activeThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }
}

function adminGalleryNext() {
    const images = adminGalleryImages();
    if (images.length <= 1) return;
    adminGalleryIndex = (adminGalleryIndex + 1) % images.length;
    adminGalleryUpdate();
}

function adminGalleryPrev() {
    const images = adminGalleryImages();
    if (images.length <= 1) return;
    adminGalleryIndex = (adminGalleryIndex - 1 + images.length) % images.length;
    adminGalleryUpdate();
}

function adminGalleryGo(index) {
    const images = adminGalleryImages();
    if (index < 0 || index >= images.length) return;
    adminGalleryIndex = index;
    adminGalleryUpdate();
}

function adminGalleryOpenLightbox(src) {
    const modal = document.getElementById('adminGalleryLightbox');
    const image = document.getElementById('adminLightboxImage');
    if (!modal || !image) return;
    image.src = src;
    modal.classList.add('active');
}

function adminGalleryCloseLightbox() {
    const modal = document.getElementById('adminGalleryLightbox');
    if (modal) modal.classList.remove('active');
}

/* Bangun galeri dari data (slider, dots, thumbnail) */
function buildGallery(urls, altText) {
    const main = document.getElementById('adminMainImage');
    const thumbs = document.getElementById('adminThumbnails');

    main.innerHTML = '';
    thumbs.innerHTML = '';
    adminGalleryIndex = 0;

    urls.forEach(function (url, index) {
        const img = document.createElement('img');
        img.src = url;
        img.alt = altText;
        img.className = 'admin-gallery-image' + (index === 0 ? ' active' : '');
        img.addEventListener('click', function () {
            adminGalleryOpenLightbox(this.src);
        });
        main.appendChild(img);
    });

    if (urls.length > 1) {
        const prev = document.createElement('button');
        prev.type = 'button';
        prev.className = 'admin-gallery-arrow admin-gallery-prev';
        prev.setAttribute('aria-label', 'Gambar sebelumnya');
        prev.textContent = '‹';
        prev.addEventListener('click', adminGalleryPrev);

        const next = document.createElement('button');
        next.type = 'button';
        next.className = 'admin-gallery-arrow admin-gallery-next';
        next.setAttribute('aria-label', 'Gambar berikutnya');
        next.textContent = '›';
        next.addEventListener('click', adminGalleryNext);

        const dots = document.createElement('div');
        dots.className = 'admin-gallery-dots';

        urls.forEach(function (url, index) {
            const dot = document.createElement('button');
            dot.type = 'button';
            dot.className = 'admin-gallery-dot' + (index === 0 ? ' active' : '');
            dot.setAttribute('aria-label', 'Gambar ' + (index + 1));
            dot.addEventListener('click', function () { adminGalleryGo(index); });
            dots.appendChild(dot);

            const thumb = document.createElement('button');
            thumb.type = 'button';
            thumb.className = 'admin-gallery-thumb' + (index === 0 ? ' active' : '');
            thumb.addEventListener('click', function () { adminGalleryGo(index); });

            const thumbImg = document.createElement('img');
            thumbImg.src = url;
            thumbImg.alt = 'Gambar ' + (index + 1);
            thumb.appendChild(thumbImg);
            thumbs.appendChild(thumb);
        });

        main.appendChild(prev);
        main.appendChild(next);
        main.appendChild(dots);
        thumbs.style.display = 'flex';
    } else {
        thumbs.style.display = 'none';
    }

    /* Swipe di layar sentuh */
    let startX = 0;
    let startY = 0;

    main.addEventListener('touchstart', function (e) {
        if (!e.touches.length) return;
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
    }, { passive: true });

    main.addEventListener('touchend', function (e) {
        if (!e.changedTouches.length) return;
        const diffX = startX - e.changedTouches[0].clientX;
        const diffY = startY - e.changedTouches[0].clientY;

        if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
            if (diffX > 0) {
                adminGalleryNext();
            } else {
                adminGalleryPrev();
            }
        }
    }, { passive: true });
}

/* =========================================================
   LOAD DATA
========================================================= */
document.addEventListener('DOMContentLoaded', async function () {

    const params = new URLSearchParams(window.location.search);
    const idProdukJasa = params.get('id_produk_jasa');

    const loading = document.getElementById('detailLoading');
    const error = document.getElementById('detailError');
    const content = document.getElementById('detailContent');

    /* Lightbox: tutup dengan Esc & klik latar */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') adminGalleryCloseLightbox();
    });

    const lightbox = document.getElementById('adminGalleryLightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) adminGalleryCloseLightbox();
        });
    }

    if (!idProdukJasa) {
        loading.style.display = 'none';
        error.style.display = 'block';
        return;
    }

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

    try {
        const [responseProduk, responseJasa] = await Promise.all([
            fetch('/jurusan-admin/produk?jenis=produk', {
                headers: { 'Accept': 'application/json' }
            }),
            fetch('/jurusan-admin/produk?jenis=jasa', {
                headers: { 'Accept': 'application/json' }
            })
        ]);

        if (!responseProduk.ok || !responseJasa.ok) {
            throw new Error('Gagal mengambil data.');
        }

        const resultProduk = await responseProduk.json();
        const resultJasa = await responseJasa.json();

        const semuaData = [
            ...(resultProduk.data || []),
            ...(resultJasa.data || [])
        ];

        const item = semuaData.find(function (data) {
            return String(data.id_produk_jasa) === String(idProdukJasa);
        });

        if (!item) {
            throw new Error('Produk/jasa tidak ditemukan.');
        }

        const jenis = item.jenis === 'jasa' ? 'Jasa' : 'Produk';

        /* Galeri */
        let urls = [];

        if (item.gambars && item.gambars.length > 0) {
            urls = item.gambars
                .filter(function (g) { return g && g.path_gambar; })
                .map(function (g) { return '/storage/' + g.path_gambar; });
        }

        if (urls.length === 0) {
            urls = ['https://placehold.co/800x600/E2E8F0/1E3A8A?text=' + encodeURIComponent(jenis)];
        }

        buildGallery(urls, item.nama_produk_jasa || jenis);

        /* Informasi */
        document.getElementById('detailBadge').textContent = jenis.toUpperCase();
        document.getElementById('metaJenis').textContent = jenis;
        document.getElementById('detailTitle').textContent = item.nama_produk_jasa || '-';

        const satuan = item.satuan_harga ? '/' + item.satuan_harga : '';
        document.getElementById('detailPrice').textContent = formatRupiah(item.harga) + satuan;

        document.getElementById('detailDesc').textContent = item.deskripsi || 'Tidak ada deskripsi.';

        /* Statistik */
        document.getElementById('statPesanan').textContent = item.pesanans_count ?? 0;
        document.getElementById('statPencarian').textContent = item.jumlah_pencarian ?? 0;
        document.getElementById('statTampilan').textContent = item.jumlah_tampilan ?? 0;

        loading.style.display = 'none';
        content.style.display = 'block';

    } catch (err) {
        console.error(err);

        loading.style.display = 'none';
        content.style.display = 'none';
        error.style.display = 'block';
    }
});
</script>
@endsection