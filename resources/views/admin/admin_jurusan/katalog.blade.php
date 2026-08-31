@extends('admin.layouts.app-jurusan')

@section('title', 'Produk dan Jasa')

@section('content')
<div class="page-header">
    <h2>Katalog Produk & Jasa</h2>
    <p>Etalase layanan Rekayasa Perangkat Lunak dan statistik pesanan</p>
</div>

<!-- Section Produk -->
<h3 style="margin-bottom: 16px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
    <span style="color: var(--primary);">📦</span> Daftar Produk
</h3>
<div id="produkContainer" class="catalog-grid">
    <!-- Card Produk akan dimuat oleh JS -->
</div>

<!-- Section Jasa -->
<h3 style="margin-bottom: 16px; color: var(--text-dark); display: flex; align-items: center; gap: 8px;">
    <span style="color: var(--accent-rpl);">💼</span> Daftar Jasa
</h3>
<div id="jasaContainer" class="catalog-grid">
    <!-- Card Jasa akan dimuat oleh JS -->
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/katalog-jurusan.js') }}"></script>
@endsection