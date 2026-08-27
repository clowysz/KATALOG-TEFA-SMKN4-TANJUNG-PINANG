@extends('layouts.app-produser')

@section('title', 'Pesanan Terkait')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 24px; color: var(--prod-text-main); margin-bottom: 8px; font-weight: 700;">Pesanan Terkait</h2>
    <p style="color: var(--prod-text-sec); font-size: 14px;">Daftar semua pesanan untuk produk dan jasa yang Anda tangani.</p>
</div>

<div class="tefa-card" style="padding: 24px; background: white; border-radius: 12px;">
    
    <!-- Kolom Pencarian -->
    <div style="margin-bottom: 24px; position: relative;">
        <i class="ph ph-magnifying-glass" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--prod-text-sec); font-size: 18px;"></i>
        <input type="text" id="searchPesanan" class="form-control" placeholder="Cari produk, jasa, atau pesanan..." style="width: 100%; max-width: 400px; margin-bottom: 0; padding-left: 44px; border-radius: 8px;">
    </div>

    <!-- Tabel 6 Kolom -->
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
            <tbody id="allOrderTable">
                <!-- Dimuat oleh JS -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Menyulap Header Atas menjadi tombol Back persis seperti Figma
    document.querySelector('.header').innerHTML = `
        <a href="/produser/dashboard" style="color: white; text-decoration: none; display: flex; align-items: center; gap: 12px; font-size: 18px; font-weight: 600;">
            <i class="ph ph-arrow-left" style="font-size: 24px;"></i> Pesanan Terkait
        </a>
    `;
</script>
@endsection