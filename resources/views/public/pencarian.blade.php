@extends('public.layouts')

@push('css')
    <!-- Kita pinjam CSS jurusan-detail karena di sana sudah ada desain kartu katalog (k-card) yang rapi -->
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')
<div style="padding: 60px 5% 100px 5%; min-height: 70vh; background: #F8FAFC;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        <!-- Header Pencarian -->
        <div style="margin-bottom: 40px; border-bottom: 1px solid #E2E8F0; padding-bottom: 20px;">
            <h2 style="font-size: 24px; color: #1E3A8A; font-weight: 700; font-family: 'Poppins', sans-serif; margin-bottom: 8px;">Hasil Pencarian</h2>
            <p style="color: #64748B; font-size: 15px;">
                <!-- Mengambil parameter 'keyword' dari URL (nanti di backend diganti dengan data asli) -->
                Menampilkan hasil untuk kata kunci: <strong style="color: #1E2D3D;">"{{ request()->query('keyword') ?? 'Semua' }}"</strong>
            </p>
        </div>

        <!-- Grid Hasil -->
        <div class="katalog-grid">
            @forelse($results ?? [] as $item)
                <!-- Template Hasil Pencarian yang akan diulang -->
                <div class="k-card">
                    <div class="k-card-img">
                        <span class="k-badge">KATEGORI</span>
                        <img src="https://placehold.co/400x300/E2E8F0/1E3A8A?text=Gambar" alt="Gambar">
                    </div>
                    <div class="k-card-body">
                        <div class="k-card-title">{{ $item->judul ?? 'Judul Item' }}</div>
                        <div class="k-card-desc">Deskripsi singkat item akan muncul di sini.</div>
                        <div class="k-card-price">Rp0</div>
                        <a href="#" class="k-card-btn">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <!-- Empty State Pencarian -->
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px dashed #CBD5E1; margin-top: 20px;">
                    <i class="ph ph-magnifying-glass" style="font-size: 48px; color: #94A3B8; margin-bottom: 16px;"></i>
                    <h3 style="font-size: 18px; font-weight: 600; color: #1E2D3D; margin-bottom: 8px;">Pencarian tidak ditemukan</h3>
                    <p style="font-size: 14px; color: #64748B; margin: 0;">Kami tidak menemukan produk, jasa, atau portofolio yang cocok dengan kata kunci tersebut.</p>
                </div>
            @endforelse
        </div>
        
    </div>
</div>
@endsection