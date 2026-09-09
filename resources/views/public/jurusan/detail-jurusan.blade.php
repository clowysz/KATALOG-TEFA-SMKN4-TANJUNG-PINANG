@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<section class="jurusan-hero-section" style="padding-top: 80px; position: relative;">
    <div class="bubble" style="width: 100px; height: 100px; top: 20%; right: 10%; animation-duration: 7s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; bottom: 40%; right: 20%; animation-duration: 5s;"></div>

    <div class="jurusan-hero-content" style="position: relative; z-index: 10;">
        <div class="jurusan-hero-image">
            <img src="{{ asset('images/labor.jpeg') }}" alt="Siswa RPL Coding">
        </div>
        <div class="jurusan-hero-text">
            <h3>JURUSAN</h3>
            <h1>REKAYASA PERANGKAT LUNAK</h1>
            <p>Di SMKN 4 Tanjungpinang berfokus pada pengembangan bakat dan kompetensi siswa melalui pembelajaran berbasis proyek, menciptakan tenaga kerja yang adaptif, profesional, dan mandiri.</p>
            <a href="/#jurusan-unggulan" class="btn-kembali-beranda" style="position: relative; z-index: 50;">
                <i class="ph ph-arrow-u-up-left"></i> Kembali ke Daftar Jurusan
            </a>
        </div>
    </div>

    <svg class="wave-jurusan" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg" style="position: absolute; bottom: -2px; left: 0; width: 100%; display: block; z-index: 1;">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,213.3C960,224,1056,192,1152,176C1248,160,1344,160,1392,160L1440,160L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>

<section class="deskripsi-content" style="position: relative; z-index: 2; background-color: #F8FAFC;">
    <div class="deskripsi-wrapper">
        @if(isset($jurusan) && $jurusan->deskripsi)
            <p>{{ $jurusan->deskripsi }}</p>
        @else
            <!-- Empty State Deskripsi -->
            <div style="text-align: center; padding: 60px 20px; background: white; border-radius: 12px; border: 1px dashed #CBD5E1;">
                <i class="ph ph-file-text" style="font-size: 48px; color: #94A3B8; margin-bottom: 16px;"></i>
                <h3 style="font-size: 18px; font-weight: 600; color: #1E2D3D; margin-bottom: 8px;">Belum ada data deskripsi</h3>
                <p style="font-size: 14px; color: #64748B; margin: 0; text-align: center;">Deskripsi untuk jurusan ini belum ditambahkan oleh admin.</p>
            </div>
        @endif
    </div>
</section>

@endsection