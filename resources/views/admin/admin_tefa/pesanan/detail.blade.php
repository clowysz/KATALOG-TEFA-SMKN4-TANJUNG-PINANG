@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="page-header">
    <a href="/pesanan" class="btn-outline" style="margin-bottom: 16px;">← Kembali ke Kelola Pesanan</a>
    <h2>Detail Pesanan #ORD-001</h2>
    <p>Informasi lengkap dan pembaruan status pesanan</p>
</div>

<div class="detail-grid">
    <!-- Card Informasi Pesanan -->
    <div class="tefa-card">
        <h3 style="margin-bottom: 16px; color: var(--primary);">Informasi Pesanan</h3>
        <div class="detail-section">
            <div class="detail-label">Nomor Pesanan</div>
            <div class="detail-value">ORD-001</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Tanggal Pesanan</div>
            <div class="detail-value">26 Agu 2026, 10:24 WIB</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Status Saat Ini</div>
            <div class="detail-value">
                <span class="badge badge-pending" id="currentStatusBadge">Menunggu Konfirmasi</span>
            </div>
        </div>
    </div>

    <!-- Card Informasi Pembeli -->
    <div class="tefa-card">
        <h3 style="margin-bottom: 16px; color: var(--primary);">Informasi Pembeli</h3>
        <div class="detail-section">
            <div class="detail-label">Nama Lengkap</div>
            <div class="detail-value">Budi Santoso</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Email</div>
            <div class="detail-value">budi.santoso@email.com</div>
        </div>
        <div class="detail-section">
            <div class="detail-label">Nomor Telepon</div>
            <div class="detail-value">0812-3456-7890</div>
        </div>
    </div>

    <!-- Card Informasi Produk -->
    <div class="tefa-card full-width">
        <h3 style="margin-bottom: 16px; color: var(--primary);">Informasi Produk / Jasa</h3>
        <div class="detail-grid" style="margin-bottom: 0;">
            <div class="detail-section">
                <div class="detail-label">Nama Produk/Jasa</div>
                <div class="detail-value">Website UMKM (Company Profile)</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Jurusan</div>
                <div class="detail-value">Rekayasa Perangkat Lunak</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Harga</div>
                <div class="detail-value">Menunggu Kesepakatan</div>
            </div>
        </div>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 16px 0;">
        <div class="detail-section">
            <div class="detail-label">Detail Kebutuhan Pelanggan</div>
            <div class="detail-value" style="font-weight: 400; line-height: 1.5;">
                Pembuatan website untuk toko roti "Budi Bakery". Membutuhkan halaman Beranda, Tentang Kami, Katalog Produk, dan Kontak. Desain diminta menggunakan warna pastel yang lembut.
            </div>
        </div>
    </div>
</div>

<!-- Card Update Status -->
<div class="tefa-card mt-4">
    <h3 style="margin-bottom: 16px;">Update Status Pesanan</h3>
    <form id="formUpdateStatus">
        <label for="statusSelect" class="detail-label">Ubah Status Menjadi:</label>
        <select id="statusSelect" class="form-control" style="max-width: 300px;">
            <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
            <option value="Dikonfirmasi">Dikonfirmasi</option>
            <option value="Diproses">Diproses</option>
            <option value="Selesai">Selesai</option>
            <option value="Dibatalkan">Dibatalkan</option>
        </select>
        <br>
        <button type="submit" class="btn-primary" style="max-width: 200px;">Simpan Perubahan</button>
    </form>
</div>

<!-- Elemen Toast Notification (Tersembunyi) -->
<div id="toastSuccess" class="toast-notification">
    ✓ Status pesanan berhasil diperbarui.
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/detail-pesanan.js') }}"></script>
@endsection