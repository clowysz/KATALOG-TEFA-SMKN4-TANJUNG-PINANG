@extends('admin.layouts.app-jurusan')

@section('title', 'Produk dan Jasa')

@section('content')
<div class="page-header" style="margin-bottom: 24px;">
    <h2 style="font-size: 20px; color: #1e293b; margin-bottom: 4px;">Katalog Produk & Jasa</h2>
    <p style="color: #64748b; font-size: 14px; margin: 0;">Etalase layanan Rekayasa Perangkat Lunak dan statistik pesanan</p>
</div>

<!-- Search Bar (Sesuai Desain Temanmu) -->
<div style="background: white; padding: 12px 20px; border-radius: 12px; border: 1px solid #e2e8f0; display: flex; align-items: center; gap: 12px; margin-bottom: 30px; max-width: 500px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
    <i class="ph ph-magnifying-glass" style="color: #94a3b8; font-size: 20px;"></i>
    <input type="text" placeholder="Cari nama produk atau jasa..." style="border: none; outline: none; width: 100%; font-size: 14px; color: #334155; background: transparent;">
</div>

@if(empty($katalogs))
    <!-- Tampilan Kosong (Empty State) -->
    <div style="background: white; border-radius: 16px; padding: 80px 20px; text-align: center; border: 1px dashed #cbd5e1;">
        <div style="background: #f1f5f9; width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
            <i class="ph ph-package" style="font-size: 40px; color: #94a3b8;"></i>
        </div>
        <h3 style="color: #1e293b; font-size: 20px; margin-bottom: 8px;">Katalog Masih Kosong</h3>
        <p style="color: #64748b; font-size: 14px; margin-bottom: 24px;">Miyyuki, belum ada produk atau jasa yang ditambahkan dari database saat ini.</p>
    </div>
@else
    <!-- Jika Database Sudah Terhubung Nanti -->
    <h3 style="margin-bottom: 16px; color: #1e293b; display: flex; align-items: center; gap: 8px; font-size: 18px;">
        <span style="color: #3B82F6;">📦</span> Daftar Produk
    </h3>
    <div id="produkContainer" class="catalog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <!-- Card Produk akan dilooping di sini -->
    </div>

    <h3 style="margin-bottom: 16px; color: #1e293b; display: flex; align-items: center; gap: 8px; font-size: 18px;">
        <span style="color: #10B981;">💼</span> Daftar Jasa
    </h3>
    <div id="jasaContainer" class="catalog-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
        <!-- Card Jasa akan dilooping di sini -->
    </div>
@endif
@endsection

@section('scripts')
<script src="{{ asset('js/katalog-jurusan.js') }}"></script>
@endsection