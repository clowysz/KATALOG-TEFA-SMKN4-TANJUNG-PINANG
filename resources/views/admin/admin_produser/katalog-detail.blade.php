@extends('admin.layouts.app-produser')

@section('title', 'Detail Produk/Jasa')

@section('content')
@php
    $jenisLabel = $produkJasa->jenis === 'jasa' ? 'Jasa' : 'Produk';

    $urls = $produkJasa->gambars
        ->filter(fn ($g) => $g && $g->path_gambar)
        ->map(fn ($g) => asset('storage/' . $g->path_gambar))
        ->values()
        ->all();

    if (count($urls) === 0) {
        $urls = ['https://placehold.co/800x600/E2E8F0/1E3A8A?text=' . urlencode($jenisLabel)];
    }

    $jumlahPesanan = $produkJasa->pesanans->count();
@endphp

<style>
.detail-page-wrapper {
    padding: 0 24px 40px;
}

/* TOMBOL KEMBALI */
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

.back-link i { color: #1E3A8A !important; }

.back-link:hover {
    background: #1E3A8A !important;
    color: #FFFFFF !important;
    border-color: #1E3A8A !important;
}

.back-link:hover i { color: #FFFFFF !important; }

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
.admin-product-gallery { width: 100%; }

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

.admin-gallery-thumbnails::-webkit-scrollbar { height: 4px; }
.admin-gallery-thumbnails::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

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
    grid-template-columns: repeat(3, 1fr);
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

.meta-icon i { font-size: 20px; }

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

/* KARTU (DESKRIPSI & PESANAN) */
.detail-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px;
    box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.05), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
    border: 1px solid #f1f5f9;
    color: #0f172a;
    margin-bottom: 20px;
}

.detail-section-title {
    margin: 0 0 16px;
    color: #0f172a;
    font-size: 18px;
    font-weight: 800;
    letter-spacing: 0.3px;
    padding-bottom: 10px;
    border-bottom: 2px solid #f1f5f9;
    display: flex;
    align-items: center;
    gap: 8px;
}

.detail-count {
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    background: #f1f5f9;
    padding: 2px 10px;
    border-radius: 10px;
    letter-spacing: 0;
}

.detail-text {
    color: #334155;
    font-size: 15px;
    line-height: 1.8;
    white-space: pre-line;
}

/* TABEL PESANAN TERKAIT */
.order-table-wrap { overflow-x: auto; }

.order-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.order-table th {
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    padding: 10px 14px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    text-align: left;
    white-space: nowrap;
}

.order-table td {
    padding: 12px 14px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #0f172a;
}

.order-id { font-weight: 700; }
.order-date { font-size: 11px; color: #64748b; margin-top: 2px; }

.order-progress { min-width: 130px; }

.order-progress-head {
    display: flex;
    justify-content: space-between;
    margin-bottom: 4px;
    font-size: 11px;
    color: #64748b;
}

.order-progress-head strong { color: #0f172a; }

.order-progress-bar {
    width: 100%;
    height: 6px;
    background: #e2e8f0;
    border-radius: 10px;
    overflow: hidden;
}

.order-progress-fill {
    height: 100%;
    background: #1e3a8a;
    border-radius: 10px;
}

.order-status {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    background: #f1f5f9;
    color: #334155;
    text-transform: capitalize;
}

.btn-detail-order {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    text-decoration: none;
    background: #1e3a8a;
    color: #ffffff;
    font-size: 12px;
    font-weight: 600;
}

.btn-detail-order:hover { background: #172f70; color: #ffffff; }

.order-empty {
    text-align: center;
    padding: 36px 16px;
    color: #64748b;
}

.order-empty i {
    font-size: 40px;
    color: #cbd5e1;
    display: block;
    margin-bottom: 6px;
}

.order-empty p { margin: 0; font-size: 13px; font-weight: 500; }

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

.admin-gallery-lightbox.active { display: flex; }

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

.admin-lightbox-close:hover { background: rgba(255, 255, 255, 0.4); }

/* RESPONSIVE */
@media (max-width: 992px) {
    .detail-top-card {
        grid-template-columns: 1fr;
        gap: 28px;
        padding: 24px;
    }
    .admin-main-image { height: 320px; }
    .detail-meta-cards { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
    .detail-page-wrapper { padding: 0 16px 36px; }
    .detail-meta-cards { grid-template-columns: 1fr; }
    .detail-top-card,
    .detail-card {
        padding: 20px;
        border-radius: 16px;
    }
    .admin-main-image { height: 250px; }
    .detail-title { font-size: 22px; }
    .detail-price { font-size: 24px; }
}
</style>

<div class="detail-page-wrapper">

    {{-- TOMBOL KEMBALI --}}
    <div class="back-link-wrapper">
        <a href="{{ route('admin.produser.katalog') }}" class="back-link">
            <i class="ph ph-arrow-left"></i>
            <span>Kembali ke Katalog</span>
        </a>
    </div>

    {{-- CONTAINER ATAS: GALERI & INFO --}}
    <div class="detail-top-card">

        <div class="detail-gallery">
            <div class="admin-product-gallery">
                <div class="admin-main-image" id="adminMainImage"></div>
                <div class="admin-gallery-thumbnails" id="adminThumbnails" style="display: none;"></div>
            </div>
        </div>

        <div class="detail-info">
            <div class="detail-badge">{{ strtoupper($jenisLabel) }}</div>

            <h1 class="detail-title">{{ $produkJasa->nama_produk_jasa }}</h1>

            <div class="price-box">
                <div class="price-label">HARGA</div>
                <div class="detail-price">
                    Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}{{ $produkJasa->satuan_harga ? '/' . $produkJasa->satuan_harga : '' }}
                </div>
            </div>
        </div>

    </div>

    {{-- META CARDS --}}
    <div class="detail-meta-cards">

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-tag"></i></div>
            <div>
                <span class="meta-label">JENIS</span>
                <span class="meta-value">{{ $jenisLabel }}</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-shopping-cart"></i></div>
            <div>
                <span class="meta-label">JUMLAH PESANAN</span>
                <span class="meta-value">{{ $jumlahPesanan }}</span>
            </div>
        </div>

        <div class="meta-card-item">
            <div class="meta-icon"><i class="ph ph-buildings"></i></div>
            <div>
                <span class="meta-label">JURUSAN</span>
                <span class="meta-value">{{ $produkJasa->jurusan->nama_jurusan ?? '-' }}</span>
            </div>
        </div>

    </div>

    {{-- DESKRIPSI --}}
    <div class="detail-card">
        <h2 class="detail-section-title">DESKRIPSI</h2>
        <div class="detail-text">{{ $produkJasa->deskripsi ?: 'Tidak ada deskripsi.' }}</div>
    </div>

    {{-- PESANAN TERKAIT --}}
    <div class="detail-card">
        <h2 class="detail-section-title">
            PESANAN TERKAIT
            <span class="detail-count">{{ $jumlahPesanan }}</span>
        </h2>

        <div class="order-table-wrap">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Jumlah</th>
                        <th>Status Pengerjaan</th>
                        <th>Status Pesanan</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($produkJasa->pesanans as $pesanan)
                        @php
                            $progressTerakhir = $pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                            $persentase = $progressTerakhir->persentase_progress ?? 0;
                        @endphp

                        <tr>
                            <td>
                                <div class="order-id">#{{ $pesanan->id_pesanan }}</div>
                                @if($pesanan->tanggal_pesan)
                                    <div class="order-date">
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>

                            <td>{{ $pesanan->jumlah }} item</td>

                            <td>
                                <div class="order-progress">
                                    <div class="order-progress-head">
                                        <span>Progress</span>
                                        <strong>{{ $persentase }}%</strong>
                                    </div>
                                    <div class="order-progress-bar">
                                        <div class="order-progress-fill" style="width: {{ $persentase }}%;"></div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="order-status">{{ ucfirst($pesanan->status) }}</span>
                            </td>

                            <td style="text-align:center;">
                                <a href="{{ route('admin.produser.pesanan.detail', $pesanan->id_pesanan) }}"
                                   class="btn-detail-order">
                                    <i class="ph ph-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="order-empty">
                                    <i class="ph ph-receipt"></i>
                                    <p>Belum ada pesanan untuk produk/jasa ini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- LIGHTBOX --}}
<div class="admin-gallery-lightbox" id="adminGalleryLightbox">
    <button type="button" class="admin-lightbox-close" onclick="adminGalleryCloseLightbox()">&times;</button>
    <img src="" class="admin-lightbox-image" id="adminLightboxImage" alt="Preview gambar">
</div>
@endsection

@push('scripts')
<script>
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

document.addEventListener('DOMContentLoaded', function () {

    buildGallery(
        @json($urls),
        @json($produkJasa->nama_produk_jasa)
    );

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') adminGalleryCloseLightbox();
    });

    const lightbox = document.getElementById('adminGalleryLightbox');
    if (lightbox) {
        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) adminGalleryCloseLightbox();
        });
    }

});
</script>
@endpush