@extends('admin.layouts.app-produser')

@section('title', 'Detail Produk/Jasa')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="/produser/katalog" class="btn-outline" style="border: none; padding-left: 0; color: white; background: var(--prod-text-sec); padding: 8px 16px; border-radius: 8px; text-decoration: none;"><i class="ph ph-arrow-left"></i> Kembali ke Katalog</a>
</div>

<div class="tefa-card" style="padding: 0; background: white; margin-bottom: 24px; overflow: hidden; border-radius: 12px;">
    
   <!-- AREA GALERI MULTIPLE GAMBAR DENGAN OVERLAY JUDUL DI ATAS -->
    <div style="background: #0F172A; position: relative; overflow: hidden; border-top-left-radius: 12px; border-top-right-radius: 12px;">
        
        <!-- Gambar Utama Full Width -->
        <div style="width: 100%; height: 420px; background: #000; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <img id="detKatalogImg" src="" alt="Gambar Utama" style="width: 100%; height: 100%; object-fit: cover;">
        </div>

        <!-- Overlay Judul & Badge di Atas Gambar (Dipertahankan di atas gambar) -->
        <div style="position: absolute; bottom: 0; left: 0; width: 100%; padding: 24px; background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 60%, transparent 100%); color: white; display: flex; flex-direction: column; justify-content: flex-end;">
            <div class="katalog-badges" style="display: flex; gap: 8px; margin-bottom: 8px;">
                <span class="katalog-badge-light" id="detKatalogTypeBadge" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">Memuat...</span>
                <span class="katalog-badge-dark" id="detKatalogCode" style="background: #1E3A8A; color: white; padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600;">Kode: PRD-000</span>
            </div>
            <h2 id="detKatalogName" style="font-size: 28px; font-weight: 700; margin: 0; color: #ffffff; text-shadow: 0 2px 4px rgba(0,0,0,0.5);">Memuat Judul...</h2>
        </div>
        
    </div>

   <!-- Tempat Thumbnail Kecil di Bawah Gambar -->
    <div id="thumbnailContainer" style="display: flex; gap: 10px; justify-content: center; padding: 12px 16px; background: transparent; overflow-x: auto; border-bottom: 1px solid #f4f5f6;"></div>
    <!-- Detail Spesifikasi -->
   <!-- Detail Spesifikasi (Rapi & Seimbang) -->
    <div style="padding: 32px;">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid #E2E8F0; align-items: center;">
            <div>
                <div class="hero-stat-label" style="font-size: 12px; color: var(--prod-text-sec); text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Jenis</div>
                <div class="hero-stat-value" id="detKatalogType" style="font-size: 16px; font-weight: 600;">Memuat...</div>
            </div>
            <div>
                <div class="hero-stat-label" style="font-size: 12px; color: var(--prod-text-sec); text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Harga</div>
                <div class="hero-stat-value" id="detKatalogPrice" style="color: var(--primary); font-size: 20px; font-weight: 700;">Rp 0</div>
            </div>
            <div>
                <div class="hero-stat-label" style="font-size: 12px; color: var(--prod-text-sec); text-transform: uppercase; font-weight: 600; margin-bottom: 4px;">Jumlah Pesanan</div>
                <div class="hero-stat-value" id="detKatalogTotalOrders" style="color: #D8893D; font-size: 20px; font-weight: 700;">0</div>
            </div>
        </div>
        
        <div>
            <h3 style="font-size: 15px; color: var(--prod-text-main); margin-bottom: 12px; font-weight: 700;">Deskripsi</h3>
            <div id="detKatalogDesc" style="font-size: 14px; color: var(--prod-text-sec); line-height: 1.7;">Memuat deskripsi...</div>
        </div>
    </div>
</div>

<!-- Tabel Pesanan Terkait di bagian bawah -->
<div class="tefa-card" style="padding: 24px; background: white; border-radius: 12px;">
    <h3 style="font-size: 16px; margin-bottom: 16px; font-weight: 700;">Pesanan Terkait (<span id="totalRelatedOrders">0</span>)</h3>
    <div class="table-responsive">
        <table class="table-modern" style="width: 100%;">
            <thead>
                <tr>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Order ID</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Produk/Jasa</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Customer</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Status Pengerjaan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border);">Status Pesanan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody id="relatedOrderTable">
                <!-- Dimuat oleh JS -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/produser-action.js') }}"></script>
<script>
    // Script tambahan khusus untuk menghandle multiple image preview di Admin Produser
    document.addEventListener("DOMContentLoaded", function() {
        // Mengambil data dari localStorage yang dikirim dari halaman katalog produser
        const item = JSON.parse(localStorage.getItem('selected_produser_katalog')) || JSON.parse(localStorage.getItem('selected_katalog'));
        
        if (item) {
            const mainImg = document.getElementById('detKatalogImg');
            const thumbContainer = document.getElementById('thumbnailContainer');
            
            // Cek apakah gambar berupa array (multiple) atau string tunggal
            let images = [];
            if (Array.isArray(item.img)) {
                images = item.img;
            } else if (typeof item.img === 'string') {
                images = [item.img];
            } else if (item.image) {
                images = Array.isArray(item.image) ? item.image : [item.image];
            }

            // Set gambar utama dengan foto pertama
            if (images.length > 0) {
                mainImg.src = images[0];
            }

            // Jika ada lebih dari 1 gambar, buat thumbnail kecil di bawahnya
            if (images.length > 1 && thumbContainer) {
                images.forEach((imgUrl, index) => {
                    const thumb = document.createElement('img');
                    thumb.src = imgUrl;
                    thumb.style.width = '70px';
                    thumb.style.height = '70px';
                    thumb.style.objectFit = 'cover';
                    thumb.style.borderRadius = '8px';
                    thumb.style.cursor = 'pointer';
                    thumb.style.border = index === 0 ? '2px solid var(--primary)' : '1px solid #CBD5E1';
                    thumb.style.transition = '0.2s';
                    
                    // Aksi klik thumbnail untuk mengganti gambar utama
                    thumb.onclick = function() {
                        mainImg.src = imgUrl;
                        Array.from(thumbContainer.children).forEach(child => {
                            child.style.border = '1px solid #CBD5E1';
                        });
                        this.style.border = '2px solid var(--primary)';
                    };
                    
                    thumbContainer.appendChild(thumb);
                });
            }

            // Mengisi data teks lainnya ke elemen HTML
            if(document.getElementById('detKatalogName')) document.getElementById('detKatalogName').textContent = item.name || item.nama;
            if(document.getElementById('detKatalogPrice')) document.getElementById('detKatalogPrice').textContent = item.price || item.harga;
            if(document.getElementById('detKatalogDesc')) document.getElementById('detKatalogDesc').textContent = item.desc || item.deskripsi;
            if(document.getElementById('detKatalogKategori')) document.getElementById('detKatalogKategori').textContent = item.category || 'Web Development';
            if(document.getElementById('detKatalogType')) document.getElementById('detKatalogType').textContent = item.type || 'Jasa';
            if(document.getElementById('detKatalogTypeBadge')) document.getElementById('detKatalogTypeBadge').textContent = item.type || 'Jasa';
            if(document.getElementById('detKatalogCode')) document.getElementById('detKatalogCode').textContent = 'Kode: ' + (item.code || 'PRD-001');
            if(document.getElementById('detKatalogTotalOrders')) document.getElementById('detKatalogTotalOrders').textContent = item.orders || 0;
        }
    });
</script>
@endsection