@extends('layouts.app-produser')

@section('title', 'Produk/Jasa Saya')

@section('content')
<div style="margin-bottom: 24px;">
    <h2 style="font-size: 24px; color: var(--prod-text-main); margin-bottom: 8px; font-weight: 700;">Produk/Jasa Saya</h2>
    <p style="color: var(--prod-text-sec); font-size: 14px;">Daftar layanan yang menjadi tanggung jawab pengelolaan Anda.</p>
</div>

<!-- Kotak Pencarian -->
<div style="margin-bottom: 24px; position: relative; max-width: 400px;">
    <i class="ph ph-magnifying-glass" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--prod-text-sec); font-size: 18px;"></i>
    <input type="text" id="searchKatalogProduser" class="form-control" placeholder="Cari nama produk atau jasa..." style="width: 100%; padding-left: 44px; border-radius: 8px;">
</div>

<!-- Grid Katalog -->
<div id="katalogContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
    <!-- Card Katalog Dimuat oleh JS -->
</div>

<!-- Empty State -->
<div id="emptyKatalog" style="display: none; text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px solid var(--prod-border);">
    <i class="ph ph-folder-open" style="font-size: 48px; color: var(--prod-text-sec); margin-bottom: 16px;"></i>
    <h3 style="color: var(--prod-text-main); margin-bottom: 8px;">Belum Ada Produk/Jasa</h3>
    <p style="color: var(--prod-text-sec); font-size: 14px;">Belum ada produk atau jasa yang ditugaskan kepada Anda.</p>
</div>
@endsection