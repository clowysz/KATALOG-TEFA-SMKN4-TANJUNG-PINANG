@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endpush

@section('content')
<div class="checkout-body">
    <div class="checkout-container">
        
        <a href="/jurusan/rpl/produk/detail" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali ke Produk
        </a>

        <div class="checkout-header">
            <h1>Detail Pesanan</h1>
            <p>Periksa kembali pesanan Anda sebelum dikonfirmasi.</p>
        </div>

        <!-- Kartu 1: Produk -->
        <div class="c-card">
            <div class="c-product">
                <img src="https://placehold.co/400x400/E2E8F0/1E3A8A?text=POS" alt="Aplikasi POS" class="c-product-img">
                <div class="c-product-info">
                    <span class="c-badge">PRODUK</span>
                    <h3>Aplikasi Point of Sale (POS)</h3>
                    <p>Aplikasi kasir dan manajemen penjualan yang membantu pencatatan transaksi, manajemen produk, laporan, dan stok secara efisien.</p>
                    <div class="c-product-price">Rp1.300.000</div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Kuantitas -->
        <div class="c-card" style="display: flex; justify-content: space-between; align-items: center;">
            <div class="c-card-title" style="margin: 0;">Jumlah Pesanan</div>
            <div class="qty-control">
                <button class="btn-qty">-</button>
                <input type="text" value="1" class="qty-input" readonly>
                <button class="btn-qty">+</button>
            </div>
            <div class="stok-info">Stok tersedia<br><span style="font-size: 16px;">50+</span></div>
        </div>

        <!-- Kartu 3: Catatan -->
        <div class="c-card">
            <div class="c-card-title">Tambah Catatan (Opsional)</div>
            <textarea class="c-input" placeholder="Tuliskan kebutuhan khusus atau catatan tambahan untuk pesanan Anda..."></textarea>
        </div>

        <!-- Kartu 4: Data Pemesan (Otomatis dari Akun Login) -->
        <div class="c-card">
            <div class="c-card-title">Informasi Pemesan</div>
            <div class="info-grid">
                <div class="input-group">
                    <label>Nama Lengkap</label>
                    <input type="text" class="c-input" value="Kharisma Putri Wulandari" readonly>
                </div>
                <div class="input-group">
                    <label>No. WhatsApp</label>
                    <input type="text" class="c-input" value="0812 3456 7890" readonly>
                </div>
                <div class="input-group">
                    <label>Email (Opsional)</label>
                    <input type="text" class="c-input" value="kharisma@email.com" readonly>
                </div>
                <div class="input-group">
                    <label>Instansi / Asal Sekolah</label>
                    <input type="text" class="c-input" value="SMKN 4 Tanjungpinang" readonly>
                </div>
            </div>
        </div>

        <!-- Kartu 5: Ringkasan -->
        <div class="c-card">
            <div class="c-card-title">Ringkasan Pesanan</div>
            <div class="summary-row"><span>Produk</span> <span>Aplikasi Point of Sale (POS)</span></div>
            <div class="summary-row"><span>Harga Satuan</span> <span>Rp1.300.000</span></div>
            <div class="summary-row"><span>Jumlah</span> <span>1</span></div>
            <div class="summary-total"><span>Subtotal</span> <span>Rp1.300.000</span></div>
        </div>

        <!-- Bagian Konfirmasi Bawah -->
        <div class="bottom-confirm">
            <div class="confirm-price-row">
                <div style="display: flex; gap: 12px; align-items: center;">
                    <div style="background: rgba(255,255,255,0.2); padding: 12px; border-radius: 12px;"><i class="ph ph-shopping-bag" style="font-size: 24px;"></i></div>
                    <div>
                        <div style="font-size: 16px; font-weight: 700;">Total (1 item)</div>
                        <div style="font-size: 12px; color: #CBD5E1;">Pastikan detail pesanan sudah sesuai.</div>
                    </div>
                </div>
                <div style="font-size: 24px; font-weight: 800;">Rp1.300.000</div>
            </div>
            
            <!-- Tombol Konfirmasi diarahkan ke halaman Riwayat Pesanan -->
            <a href="/riwayat-pesanan" class="btn-submit">
                Konfirmasi Pesanan <i class="ph ph-arrow-right"></i>
            </a>

            <div class="disclaimer">
                <i class="ph ph-info"></i> Setelah konfirmasi, kami akan menghubungi Anda melalui WhatsApp. Pembayaran dilakukan di luar website.
            </div>
        </div>

    </div>
</div>
@endsection