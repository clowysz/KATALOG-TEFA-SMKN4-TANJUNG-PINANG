@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-pembeli.css') }}">
@endpush

@section('content')

<!-- Bagian Header (Banner) -->
<div class="jurusan-header">
    <h1>Katalog Layanan TEFA</h1>
    <p>Jelajahi berbagai produk dan jasa unggulan karya siswa-siswi kompeten SMKN 4 Tanjungpinang. Kualitas profesional dengan harga bersahabat.</p>
</div>

<!-- Daftar Jurusan -->
<div class="jurusan-container">
    <div class="jurusan-grid">
        
        <!-- Card 1: RPL -->
        <div class="jurusan-card">
            <div class="jurusan-img">
                <i class="ph ph-code"></i>
            </div>
            <div class="jurusan-content">
                <span class="jurusan-badge">IT & Software</span>
                <h3>Rekayasa Perangkat Lunak</h3>
                <p>Layanan pembuatan website, aplikasi kasir, sistem informasi, hingga pemeliharaan server untuk kebutuhan bisnis Anda.</p>
                <a href="/jurusan/rpl" class="btn-lihat-layanan">Lihat 12 Produk/Jasa</a>
            </div>
        </div>

        <!-- Card 2: DKV -->
        <div class="jurusan-card">
            <div class="jurusan-img">
                <i class="ph ph-bezier-curve"></i>
            </div>
            <div class="jurusan-content">
                <span class="jurusan-badge">Desain Kreatif</span>
                <h3>Desain Komunikasi Visual</h3>
                <p>Jasa pembuatan logo, desain kemasan, cetak banner, sablon, hingga dokumentasi foto dan video acara profesional.</p>
                <a href="/jurusan/dkv" class="btn-lihat-layanan">Lihat 24 Produk/Jasa</a>
            </div>
        </div>

        <!-- Card 3: Animasi -->
        <div class="jurusan-card">
            <div class="jurusan-img">
                <i class="ph ph-film-strip"></i>
            </div>
            <div class="jurusan-content">
                <span class="jurusan-badge">Multimedia</span>
                <h3>Animasi & 3D</h3>
                <p>Pembuatan video promosi animasi, aset 3D untuk game atau arsitektur, dan motion graphic untuk media sosial.</p>
                <a href="/jurusan/animasi" class="btn-lihat-layanan">Lihat 8 Produk/Jasa</a>
            </div>
        </div>

    </div>
</div>

@endsection