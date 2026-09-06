@extends('public.layouts')

@section('content')

<!-- HERO SECTION DENGAN EFEK GELOMBANG DAN GELEMBUNG -->
<section class="hero-section">
    <div class="bubble" style="width: 80px; height: 80px; top: 10%; left: 15%; animation-duration: 5s;"></div>
    <div class="bubble" style="width: 120px; height: 120px; top: 40%; left: 35%; animation-duration: 8s;"></div>
    <div class="bubble" style="width: 60px; height: 60px; bottom: 20%; left: 5%; animation-duration: 6s;"></div>

    <div class="hero-content">
        <h1 class="hero-title">TEACHING<br>FACTORY</h1>
        <div class="hero-line"></div>
        <h2 class="hero-subtitle">SMK NEGERI 4<br>TANJUNGPINANG TIMUR</h2>
        <p class="hero-desc">Teaching Factory (TEFA) SMKN 4 Tanjungpinang adalah model pembelajaran berbasis produksi dan layanan standar industri. Program ini memberikan pengalaman kerja nyata agar siswa memiliki keterampilan profesional, menghasilkan produk, jasa yang berkualitas, serta siap berwirausaha mandiri.</p>
    </div>

    <div class="hero-image-box">
        <!-- Ganti dengan nama foto gerbang sekolah milikmu -->
        <img src="{{ asset('images/gerbang-sekolah.png') }}" alt="Gerbang SMKN 4 Tanjungpinang">
    </div>

    <svg class="wave-bottom" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,208C384,203,480,181,576,181.3C672,181,768,203,864,224C960,245,1056,267,1152,261.3C1248,256,1344,224,1392,208L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>

<!-- SECTION JURUSAN UNGGULAN (6 JURUSAN) -->
<section class="jurusan-section" id="jurusan-unggulan">
    <div class="section-header-wrap">
        <span class="section-subtitle-tag" style="color: #93C5FD; font-weight: 700;">JURUSAN ──</span>
        <h2 class="section-title-main" style="color: white !important; font-size: 32px; font-weight: 800; margin-top: 5px;">JURUSAN UNGGULAN</h2>
        <p class="section-desc-sub" style="color: #E2E8F0 !important;">Pilih jurusan untuk melihat produk, jasa dan informasi lebih lanjut di setiap jurusan</p>
    </div>

    <div class="slider-outer-wrapper">
        <button class="slider-arrow arrow-prev" id="prevBtn">
            <i class="ph ph-caret-left"></i>
        </button>

        <div class="slider-track-container">
            <div class="jurusan-cards-track" id="jurusanTrack">
                
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-animasi">
                        <img src="{{ asset('images/logo-animasi.png') }}" alt="Animasi">
                    </div>
                    <h3>Animasi</h3>
                    <div class="jurusan-divider"></div>
                    <p>Mewujudkan imajinasi menjadi animasi inspiratif dan berkarakter.</p>
                    <a href="/jurusan/animasi" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-rpl">
                        <img src="{{ asset('images/logo-rpl.png') }}" alt="RPL">
                    </div>
                    <h3>Rekayasa Perangkat Lunak</h3>
                    <div class="jurusan-divider"></div>
                    <p>Membangun solusi perangkat lunak kreatif, efisien, dan inovatif.</p>
                    <a href="/jurusan/rpl" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-gim">
                        <img src="{{ asset('images/logo-gim.png') }}" alt="GIM">
                    </div>
                    <h3>Pemrograman GIM</h3>
                    <div class="jurusan-divider"></div>
                    <p>Mencetak talenta pengembang gim digital yang interaktif dan kompetitif.</p>
                    <a href="/jurusan/gim" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-tkj">
                        <img src="{{ asset('images/logo-tkj.png') }}" alt="TKJ">
                    </div>
                    <h3>Teknik Komputer &amp; Jaringan</h3>
                    <div class="jurusan-divider"></div>
                    <p>Spesialis infrastruktur jaringan, server handal, dan keamanan sistem komputer.</p>
                    <a href="/jurusan/tkj" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-pspt">
                        <img src="{{ asset('images/logo-pspt.png') }}" alt="PSPT">
                    </div>
                    <h3>Produksi &amp; Siaran TV</h3>
                    <div class="jurusan-divider"></div>
                    <p>Menghasilkan karya multimedia penyiaran, video sinematik, dan siaran berkualitas.</p>
                    <a href="/jurusan/pspt" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-dkv">
                        <img src="{{ asset('images/logo-dkv.png') }}" alt="DKV">
                    </div>
                    <h3>Desain Komunikasi Visual</h3>
                    <div class="jurusan-divider"></div>
                    <p>Mengekspresikan pesan dan identitas visual melalui desain grafis profesional.</p>
                    <a href="/jurusan/dkv" class="btn-lihat-jurusan">Lihat Selengkapnya &gt;</a>
                </div>

            </div>
        </div>

        <button class="slider-arrow arrow-next" id="nextBtn">
            <i class="ph ph-caret-right"></i>
        </button>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('jurusanTrack');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const cards = document.querySelectorAll('.jurusan-card');
    
    let currentIndex = 0;
    const maxIndex = cards.length - 3; 

    function updateSlider() {
        const cardWidth = cards[0].offsetWidth;
        const gap = 24;
        const moveAmount = currentIndex * (cardWidth + gap);
        
        track.style.transform = `translateX(-${moveAmount}px)`;
    }

    nextBtn.addEventListener('click', function () {
        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateSlider();
    });

    prevBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = maxIndex;
        }
        updateSlider();
    });

    window.addEventListener('resize', updateSlider);
});
</script>

@endsection