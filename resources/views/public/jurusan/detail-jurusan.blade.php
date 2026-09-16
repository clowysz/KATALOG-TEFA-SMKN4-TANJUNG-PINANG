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
        <img src="{{ asset($jurusan->hero) }}" alt="{{ $jurusan->name }}">
</div>

    <div class="jurusan-hero-text">
    <h3>JURUSAN</h3>
    <h1>{{ $jurusan->name }}</h1>
    <p>{{ $jurusan->description }}</p>
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
        <p>Di jurusan Rekayasa Perangkat Lunak, kamu akan mempelajari berbagai hal yang berkaitan dengan pembuatan aplikasi dan sistem perangkat lunak. Mulai dari dasar pemrograman, struktur data, algoritma, hingga pengembangan aplikasi berbasis web, mobile, dan desktop.</p>
        
        <p>Kamu juga akan belajar tentang basis data, desain antarmuka pengguna, pengujian perangkat lunak, serta manajemen proyek perangkat lunak. Semua pembelajaran ini bertujuan untuk membekali kamu dengan keterampilan yang dibutuhkan di dunia kerja dan industri digital.</p>
        
        <p>Dengan kurikulum yang selalu diperbarui sesuai perkembangan teknologi, kamu akan siap menjadi seorang pengembang perangkat lunak yang kompeten, kreatif, dan inovatif.</p>
        
        <p>RPL adalah pilihan yang tepat bagi kamu yang memiliki minat di bidang teknologi, logika, dan kreativitas. Jurusan ini membuka peluang karir yang luas, baik sebagai programmer, web developer, mobile developer, analis sistem, hingga software engineer.</p>
        
        <p>Di SMKN 4 Tanjungpinang, kamu akan mendapatkan pembelajaran yang praktis dan relevan dengan kebutuhan industri, didukung oleh fasilitas lengkap, guru profesional, serta lingkungan belajar yang kondusif.</p>
        
        <p>Dengan memilih RPL, kamu tidak hanya belajar membuat aplikasi, tetapi juga belajar memecahkan masalah, berkolaborasi dalam tim, dan berinovasi untuk menciptakan solusi digital yang bermanfaat bagi banyak orang.</p>
    </div>
</section>

@endsection