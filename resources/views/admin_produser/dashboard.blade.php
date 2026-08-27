@extends('layouts.app-produser')

@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 32px;">
    <h2 style="font-size: 24px; color: var(--prod-text-main); margin-bottom: 8px; font-weight: 700;">Dashboard</h2>
    <p style="color: var(--prod-text-sec); font-size: 14px;">Pantau pesanan yang berkaitan dengan produk atau jasa yang menjadi tanggung jawab Anda.</p>
</div>

<div class="tefa-card" style="padding: 24px; background: white; border-radius: 12px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h3 style="color: var(--prod-text-main); font-size: 18px; margin-bottom: 4px; font-weight: 700;">Pesanan Terkait</h3>
            <p style="color: var(--prod-text-sec); font-size: 13px;">Semua Produk/Jasa Saya</p>
        </div>
        <a href="/produser/pesanan" class="btn-primary" style="text-decoration: none; font-size: 13px; padding: 10px 16px; border-radius: 8px; width: auto; background-color: var(--primary);">Lihat Semua Pesanan</a>
    </div>

    <div class="table-responsive">
        <table class="table-modern" style="width: 100%;">
            <thead>
                <tr>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); padding: 16px 12px;">Order ID</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); padding: 16px 12px;">Produk/Jasa</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); padding: 16px 12px;">Customer</th>
                    <!-- DUA KOLOM STATUS DITAMPILKAN -->
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); padding: 16px 12px;">Status Pengerjaan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); padding: 16px 12px;">Status Pesanan</th>
                    <th style="background: white; border-bottom: 1px solid var(--prod-border); text-align: center; padding: 16px 12px;">Aksi</th>
                </tr>
            </thead>
            <tbody id="dashboardOrderTable">
                <!-- Dimuat oleh JS -->
            </tbody>
        </table>
    </div>
</div>
@endsection