@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 80px; position: relative;">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    
    <div class="jurusan-hero-content" style="position: relative; z-index: 10;">
        <div class="jurusan-hero-image">
            <img src="{{ asset('images/labor.jpeg') }}" alt="Jasa RPL">
        </div>
        <div class="jurusan-hero-text">
            <h3>JASA</h3>
            <h1>LAYANAN JASA</h1>
            <p>Kami menyediakan berbagai layanan di bidang teknologi informasi yang dirancang untuk membantu kebutuhan teknis maupun instansi.</p>
            <a href="/#jurusan-unggulan" class="btn-kembali-beranda" style="position: relative; z-index: 50;">
                <i class="ph ph-arrow-u-up-left"></i> Kembali ke Daftar Jurusan
            </a>
        </div>
    </div>
    
    <svg class="wave-jurusan" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: -1px; left: 0; width: 100%; display: block; z-index: 1;">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>

<section class="katalog-section">
    <div class="katalog-header">
        <h2>Jasa Terlaris</h2>
        <a href="#">Lihat Semua Jasa &gt;</a>
    </div>

    <div class="katalog-grid">
        @forelse($jasas ?? [] as $item)
            <div class="k-card">
                <div class="k-card-img">
                    <div class="k-badge">Jasa</div>
                    <img src="https://placehold.co/600x400/E2E8F0/1E3A8A?text=Maintenance+Server" alt="Jasa">
                </div>
                <div class="k-card-body">
                    <h3 class="k-card-title">Maintenance & Support</h3>
                    <p class="k-card-desc">Layanan perawatan sistem, update keamanan, dan dukungan teknis secara berkala.</p>
                    <div class="k-card-price">Rp500.000 / Bulan</div>
                    <a href="/jurusan/{{ $jurusan->slug ?? 'rpl' }}/jasa/detail/1" class="k-card-btn">Lihat Selengkapnya &gt;</a>
                </div>
            </div>
        @empty
            <!-- Empty State Jasa -->
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px dashed #CBD5E1;">
                <i class="ph ph-folder-open" style="font-size: 48px; color: #94A3B8; margin-bottom: 16px;"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #1E2D3D; margin-bottom: 8px;">Belum ada data Jasa</h3>
                <p style="font-size: 14px; color: #64748B; margin: 0;">Layanan jasa untuk jurusan ini belum tersedia. Silakan cek kembali nanti.</p>
            </div>
        @endforelse
    </div>
</section>

@endsection