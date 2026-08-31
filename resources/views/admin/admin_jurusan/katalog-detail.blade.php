@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk')

@section('content')
<div class="page-header" style="margin-bottom: 16px;">
    <a href="/jurusan-admin/katalog" class="btn-outline" style="border: none; padding-left: 0;">← Kembali</a>
</div>

<div class="tefa-card" style="max-width: 850px; padding: 0; overflow: hidden; border-radius: 12px;">
    <!-- Gambar Full Width -->
    <img id="detailImg" src="" alt="Thumbnail" class="detail-hero-img" style="margin-bottom: 0;">
    
    <div style="padding: 32px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h2 id="detailTitle" style="color: var(--primary); font-size: 26px;">Memuat...</h2>
            <span id="detailBadge" class="badge-tipe-produk">Memuat...</span>
        </div>
        
        <div id="detailPrice" style="font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 24px;">Rp 0</div>
        
        <div id="detailDesc" style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;">Memuat deskripsi...</div>
        
        <!-- Grid Statistik (Foto ke-6) -->
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
    // JS Khusus Halaman Detail
    document.addEventListener("DOMContentLoaded", function() {
        const item = JSON.parse(localStorage.getItem('selected_katalog'));
        if (item) {
            document.getElementById('detailImg').src = item.img;
            document.getElementById('detailTitle').textContent = item.name;
            document.getElementById('detailPrice').textContent = item.price;
            document.getElementById('detailDesc').textContent = item.desc;
            
            // Badge Type
            const badge = document.getElementById('detailBadge');
            badge.textContent = item.type;
            badge.className = item.type === 'Produk' ? 'badge-tipe-produk' : 'badge-tipe-jasa';

            // Hitung statistik buatan (dummy simulation) berdasarkan pesanan
            const pesanan = parseInt(item.orders) || 0;
            document.getElementById('statPesanan').textContent = pesanan;
            document.getElementById('statPencarian').textContent = pesanan * 5 + 12; // Simulasi logic
            document.getElementById('statTampilan').textContent = pesanan * 20 + 43; // Simulasi logic
        }
    });
</script>
@endsection