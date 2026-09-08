@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/riwayat-detail.css') }}">
@endpush

@section('content')
<div class="rd-page">
    <!-- Header -->
    <div class="rd-header">
        <div class="rd-container">
            <a href="/riwayat-pesanan" class="rd-back-btn">
                <i class="ph ph-arrow-left"></i> Kembali ke Riwayat Pemesanan
            </a>
            <div class="rd-title-area">
                <div class="rd-title-icon"><i class="ph ph-receipt"></i></div>
                <div>
                    <h1>Detail Pesanan</h1>
                    <p>Informasi lengkap mengenai pesanan yang Anda buat.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten -->
    <div class="rd-body">
        <div class="rd-container">
            
            <!-- Info Nomor & Status -->
            <div class="rd-card rd-flex-between">
                <div>
                    <div class="rd-label">No. Pesanan</div>
                    <div class="rd-order-id">#RPL250825-001</div>
                    <div class="rd-date">25 Agustus 2025, 14:30</div>
                </div>
                <div class="rd-status-box warning">
                    <div class="rd-status-title"><i class="ph ph-clock"></i> Sedang Dikerjakan</div>
                    <div class="rd-status-est">Estimasi selesai: 7 - 14 Hari</div>
                </div>
            </div>

            <!-- Info Produk -->
            <div class="rd-card rd-product">
                <img src="https://placehold.co/400x300/E2E8F0/1E3A8A?text=POS" alt="POS">
                <div class="rd-product-info">
                    <span class="rd-badge">PRODUK</span>
                    <h2>Aplikasi Point of Sale (POS)</h2>
                    <p>Aplikasi kasir dan manajemen penjualan yang membantu pencatatan transaksi, manajemen produk, laporan, dan stok secara efisien.</p>
                    <div class="rd-price">Rp1.300.000</div>
                    <div class="rd-qty">Jumlah: 1</div>
                </div>
            </div>

            <!-- Status Pengerjaan (Timeline) -->
            <div class="rd-card">
                <h3 class="rd-card-title">Status Pengerjaan</h3>
                <div class="rd-timeline">
                    <div class="rd-step active">
                        <div class="rd-icon"><i class="ph ph-check"></i></div>
                        <div class="rd-text">Pesanan Dibuat<br><span>25 Agustus 2025<br>14:30</span></div>
                    </div>
                    <div class="rd-line active"></div>
                    <div class="rd-step current">
                        <div class="rd-icon"></div>
                        <div class="rd-text">Sedang Dikerjakan<br><span>26 Agustus 2025<br>10:15</span></div>
                    </div>
                    <div class="rd-line"></div>
                    <div class="rd-step pending">
                        <div class="rd-icon"><i class="ph ph-clipboard-text"></i></div>
                        <div class="rd-text">Selesai<br><span>-</span></div>
                    </div>
                    <div class="rd-line"></div>
                    <div class="rd-step pending">
                        <div class="rd-icon"><i class="ph ph-truck"></i></div>
                        <div class="rd-text">Dikirim / Diserahkan<br><span>-</span></div>
                    </div>
                </div>
            </div>

            <!-- Grid 2 Kolom (Pemesan & Detail) -->
            <div class="rd-grid-2">
                <div class="rd-card">
                    <h3 class="rd-card-title">Informasi Pemesan</h3>
                    <div class="rd-info-row"><i class="ph ph-user"></i> <span>Nama Lengkap</span> <strong>Kharisma Putri Wulandari</strong></div>
                    <div class="rd-info-row"><i class="ph ph-phone"></i> <span>No. WhatsApp</span> <strong>0812 3456 7890</strong></div>
                    <div class="rd-info-row"><i class="ph ph-envelope"></i> <span>Email</span> <strong>kharisma@email.com</strong></div>
                    <div class="rd-info-row"><i class="ph ph-buildings"></i> <span>Instansi / Asal Sekolah</span> <strong>SMKN 4 Tanjungpinang</strong></div>
                </div>
                
                <div class="rd-card">
                    <h3 class="rd-card-title">Detail Pesanan</h3>
                    <div class="rd-info-row"><i class="ph ph-receipt"></i> <span>Produk</span> <strong>Aplikasi Point of Sale (POS)</strong></div>
                    <div class="rd-info-row"><i class="ph ph-tag"></i> <span>Harga Satuan</span> <strong>Rp1.300.000</strong></div>
                    <div class="rd-info-row"><i class="ph ph-package"></i> <span>Jumlah</span> <strong>1</strong></div>
                    <div class="rd-divider"></div>
                    <div class="rd-info-row total"><span>Subtotal</span> <strong>Rp1.300.000</strong></div>
                </div>
            </div>

            <!-- Catatan -->
            <div class="rd-card">
                <h3 class="rd-card-title"><i class="ph ph-chat-circle-text"></i> Catatan Pesanan</h3>
                <div class="rd-notes">Mohon dibuatkan dengan tampilan sederhana dan mudah digunakan. Terima kasih.</div>
            </div>

        </div>
    </div>
</div>
@endsection