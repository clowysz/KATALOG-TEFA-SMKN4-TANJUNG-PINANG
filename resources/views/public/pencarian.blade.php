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

        <!-- Grid Hasil (Memakai class yang sama dengan halaman produk) -->
        <div class="katalog-grid">
            
            <!-- Contoh Hasil 1 (Produk) -->
            <div class="k-card">
                <div class="k-card-img">
                    <span class="k-badge">PRODUK</span>
                    <img src="https://placehold.co/400x300/E2E8F0/1E3A8A?text=Aplikasi+Kasir" alt="Gambar">
                </div>
                <div class="k-card-body">
                    <div class="k-card-title">Aplikasi Point of Sale (POS)</div>
                    <div class="k-card-desc">Aplikasi kasir dan manajemen penjualan yang membantu pencatatan transaksi secara efisien.</div>
                    <div class="k-card-price">Rp1.300.000</div>
                    <a href="/jurusan/rpl/produk/detail/1" class="k-card-btn">Lihat Detail</a>
                </div>
            </div>

            <!-- Contoh Hasil 2 (Jasa) -->
            <div class="k-card">
                <div class="k-card-img">
                    <span class="k-badge" style="background: #059669;">JASA</span>
                    <img src="https://placehold.co/400x300/E2E8F0/1E3A8A?text=Desain+Logo" alt="Gambar">
                </div>
                <div class="k-card-body">
                    <div class="k-card-title">Jasa Desain Identitas Visual (Logo)</div>
                    <div class="k-card-desc">Pembuatan logo profesional untuk branding usaha dan perusahaan Anda.</div>
                    <div class="k-card-price">Mulai Rp500.000</div>
                    <a href="/jurusan/dkv/jasa/detail/1" class="k-card-btn">Lihat Detail</a>
                </div>
            </div>

            <!-- Contoh Hasil 3 (Portofolio) -->
            <div class="k-card">
                <div class="k-card-img">
                    <span class="k-badge" style="background: #D97706;">PORTOFOLIO</span>
                    <img src="https://placehold.co/400x300/E2E8F0/1E3A8A?text=Film+Pendek" alt="Gambar">
                </div>
                <div class="k-card-body">
                    <div class="k-card-year">2025</div>
                    <div class="k-card-title">Film Pendek "Suara Harapan"</div>
                    <div class="k-card-desc">Juara 1 Festival Film Pelajar Nasional. Diproduksi oleh tim siswa PSPT.</div>
                    <div style="flex-grow: 1;"></div> <!-- Spacer agar tombol di bawah -->
                    <a href="/jurusan/pspt/portofolio/detail/1" class="k-card-btn">Lihat Detail</a>
                </div>
            </div>

        </div>
        
    </div>
</div>
@endsection