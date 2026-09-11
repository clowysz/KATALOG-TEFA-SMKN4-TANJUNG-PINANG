@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk')

@section('content')
<div class="page-header" style="margin-bottom: 16px;">
    <a href="/jurusan-admin/katalog" class="btn-outline" style="border: none; padding-left: 0;">← Kembali</a>
</div>

<div class="tefa-card" style="max-width: 850px; padding: 0; overflow: hidden; border-radius: 12px;">
    
    <!-- AREA GALERI MULTIPLE GAMBAR -->
    <div style="background: #F8FAFC; text-align: center; padding: 20px 0; border-bottom: 1px solid #E2E8F0;">
        <!-- Gambar Utama -->
        <img id="detailImg" src="" alt="Gambar Utama" style="width: 100%; max-height: 400px; object-fit: contain; margin-bottom: 16px;">
        
        <!-- Tempat Thumbnail (Akan muncul kotak-kotak kecil di sini jika gambar > 1) -->
        <div id="thumbnailContainer" style="display: flex; gap: 12px; justify-content: center; padding: 0 20px; overflow-x: auto;"></div>
    </div>
    
    <!-- AREA DETAIL TEKS -->
    <div style="padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 id="detailTitle" style="color: var(--primary); font-size: 26px;">Memuat...</h2>
            <span id="detailBadge" class="badge-tipe-produk">Memuat...</span>
        </div>
        
        <div id="detailPrice" style="font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 24px;">Rp 0</div>
        
        <div id="detailDesc" style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">Memuat deskripsi...</div>
        
        <!-- Grid Statistik -->
        <div class="stat-grid-3">
            <div class="stat-box">
                <h3 id="statPesanan" style="color: var(--primary); font-size: 24px;">0</h3>
                <p style="font-size: 12px; color: var(--text-muted);">Pesanan</p>
            </div>
            <div class="stat-box">
                <h3 id="statPencarian" style="color: var(--accent-rpl); font-size: 24px;">0</h3>
                <p style="font-size: 12px; color: var(--text-muted);">Pencarian</p>
            </div>
            <div class="stat-box">
                <h3 id="statTampilan" style="color: #28a745; font-size: 24px;">0</h3>
                <p style="font-size: 12px; color: var(--text-muted);">Tampilan</p>
            </div>
        </div>

        <!-- Highlight Info Tambahan -->
        <div class="info-box">
            <div class="info-box-title">Informasi Tambahan</div>
            <div style="font-size: 13px; color: #855b35; line-height: 1.5;">Produk ini dikembangkan oleh siswa RPL SMKN 4 Tanjungpinang. Termasuk dokumentasi teknis, panduan penggunaan, dan garansi perbaikan bug selama 3 bulan.</div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const item = JSON.parse(localStorage.getItem('selected_katalog'));
        
        if (item) {
            const mainImg = document.getElementById('detailImg');
            const thumbContainer = document.getElementById('thumbnailContainer');
            
            // Logika untuk menampilkan multiple gambar
            let images = [];
            if (Array.isArray(item.img)) {
                images = item.img; // Jika gambarnya banyak (array)
            } else if (typeof item.img === 'string') {
                images = [item.img]; // Jika gambarnya cuma 1
            }

            // Pasang gambar pertama sebagai gambar yang paling besar
            if (images.length > 0) {
                mainImg.src = images[0];
            }

            // Jika gambar lebih dari 1, buat deretan thumbnail di bawahnya
            if (images.length > 1) {
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
                    
                    // Efek saat kotak kecil (thumbnail) diklik, gambar utama berubah
                    thumb.onclick = function() {
                        mainImg.src = imgUrl; 
                        
                        // Hapus garis biru di thumbnail lain, pindahkan ke yang baru diklik
                        Array.from(thumbContainer.children).forEach(child => {
                            child.style.border = '1px solid #CBD5E1';
                        });
                        this.style.border = '2px solid var(--primary)';
                    };
                    
                    thumbContainer.appendChild(thumb);
                });
            }

            // Masukkan data teks
            document.getElementById('detailTitle').textContent = item.name;
            document.getElementById('detailPrice').textContent = item.price;
            document.getElementById('detailDesc').textContent = item.desc;
            
            // Masukkan tipe badge (Produk / Jasa)
            const badge = document.getElementById('detailBadge');
            badge.textContent = item.type;
            badge.className = item.type === 'Produk' ? 'badge-tipe-produk' : 'badge-tipe-jasa';

            // Hitung statistik buatan (simulasi)
            const pesanan = parseInt(item.orders) || 0;
            document.getElementById('statPesanan').textContent = pesanan;
            document.getElementById('statPencarian').textContent = pesanan * 5 + 12; 
            document.getElementById('statTampilan').textContent = pesanan * 20 + 43; 
        }
    });
</script>
@endsection