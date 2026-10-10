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
        <img src="{{ asset('images/gerbang-sekolah.png') }}" alt="Gerbang SMKN 4 Tanjungpinang">
    </div>
 
    <svg class="wave-bottom" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path fill="#F8FAFC" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,208C384,203,480,181,576,181.3C672,181,768,203,864,224C960,245,1056,267,1152,261.3C1248,256,1344,224,1392,208L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
</section>
 
<!-- SECTION JURUSAN UNGGULAN (6 JURUSAN) -->
<section class="jurusan-section" id="jurusan-unggulan">
    <div class="section-header-wrap">
        <span class="section-subtitle-tag">JURUSAN ──</span>
        <h2 class="section-title-main">JURUSAN UNGGULAN</h2>
        <p class="section-desc-sub">Pilih jurusan untuk melihat produk, jasa dan informasi lebih lanjut di setiap jurusan</p>
    </div>
 
    <div class="slider-outer-wrapper">
        <button type="button" class="slider-arrow arrow-prev" id="prevBtn">
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
                    <a href="{{ url('/jurusan/animasi') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-rpl">
                        <img src="{{ asset('images/logo-rpl.png') }}" alt="RPL">
                    </div>
                    <h3>Rekayasa Perangkat Lunak</h3>
                    <div class="jurusan-divider"></div>
                    <p>Membangun solusi perangkat lunak kreatif, efisien, dan inovatif.</p>
                    <a href="{{ url('/jurusan/rpl') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-gim">
                        <img src="{{ asset('images/logo-gim.png') }}" alt="GIM">
                    </div>
                    <h3>Pemrograman GIM</h3>
                    <div class="jurusan-divider"></div>
                    <p>Mencetak talenta pengembang gim digital yang interaktif dan kompetitif.</p>
                    <a href="{{ url('/jurusan/gim') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-tkj">
                        <img src="{{ asset('images/logo-tkj.png') }}" alt="TKJ">
                    </div>
                    <h3>Teknik Komputer &amp; Jaringan</h3>
                    <div class="jurusan-divider"></div>
                    <p>Spesialis infrastruktur jaringan, server handal, dan keamanan sistem komputer.</p>
                    <a href="{{ url('/jurusan/tkj') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-pspt">
                        <img src="{{ asset('images/logo-pspt.png') }}" alt="PSPT">
                    </div>
                    <h3>Produksi &amp; Siaran TV</h3>
                    <div class="jurusan-divider"></div>
                    <p>Menghasilkan karya multimedia penyiaran, video sinematik, dan siaran berkualitas.</p>
                    <a href="{{ url('/jurusan/pspt') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
                <div class="jurusan-card">
                    <div class="jurusan-icon-box bg-dkv">
                        <img src="{{ asset('images/logo-dkv.png') }}" alt="DKV">
                    </div>
                    <h3>Desain Komunikasi Visual</h3>
                    <div class="jurusan-divider"></div>
                    <p>Mengekspresikan pesan dan identitas visual melalui desain grafis profesional.</p>
                    <a href="{{ url('/jurusan/dkv') }}" class="btn-lihat-jurusan">Lihat <span class="btn-more">Selengkapnya</span> &gt;</a>
                </div>
 
            </div>
        </div>
 
        <button type="button" class="slider-arrow arrow-next" id="nextBtn">
            <i class="ph ph-caret-right"></i>
        </button>
    </div>
</section>
 
@endsection
 
 
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const track     = document.getElementById('jurusanTrack');
    const prevBtn   = document.getElementById('prevBtn');
    const nextBtn   = document.getElementById('nextBtn');
    const container = document.querySelector('.slider-track-container');
 
    if (!track || !prevBtn || !nextBtn || !container) return;
 
    const cards = Array.from(track.querySelectorAll('.jurusan-card'));
    if (!cards.length) return;
 
    let currentIndex = 0;
 
    function getGap() {
        return parseFloat(getComputedStyle(track).columnGap) || 24;
    }
 
    // Jumlah kartu yang terlihat dihitung dari ukuran nyata (di CSS selalu 3)
    function getVisibleCards() {
        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = getGap();
        return Math.max(1, Math.round((track.clientWidth + gap) / (cardWidth + gap)));
    }
 
    function getMaxIndex() {
        return Math.max(0, cards.length - getVisibleCards());
    }
 
    function updateSlider() {
        currentIndex = Math.min(currentIndex, getMaxIndex());
 
        const cardWidth = cards[0].getBoundingClientRect().width;
        const moveAmount = currentIndex * (cardWidth + getGap());
 
        track.style.transform = `translateX(-${moveAmount}px)`;
 
        const noSlide = getMaxIndex() === 0;
        prevBtn.disabled = noSlide;
        nextBtn.disabled = noSlide;
 
        prevBtn.setAttribute('aria-label', 'Lihat jurusan sebelumnya');
        nextBtn.setAttribute('aria-label', 'Lihat jurusan berikutnya');
    }
 
    function goNext() {
        currentIndex = currentIndex >= getMaxIndex() ? 0 : currentIndex + 1;
        updateSlider();
    }
 
    function goPrev() {
        currentIndex = currentIndex <= 0 ? getMaxIndex() : currentIndex - 1;
        updateSlider();
    }
 
    nextBtn.addEventListener('click', goNext);
    prevBtn.addEventListener('click', goPrev);
 
    // Geser dengan jari (swipe) di layar sentuh
    let startX = 0;
    let startY = 0;
    let tracking = false;
 
    container.addEventListener('touchstart', function (e) {
        const t = e.touches[0];
        startX = t.clientX;
        startY = t.clientY;
        tracking = true;
    }, { passive: true });
 
    container.addEventListener('touchend', function (e) {
        if (!tracking) return;
        tracking = false;
 
        const t  = e.changedTouches[0];
        const dx = t.clientX - startX;
        const dy = t.clientY - startY;
 
        if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
            dx < 0 ? goNext() : goPrev();
        }
    }, { passive: true });
 
    window.addEventListener('resize', updateSlider);
 
    updateSlider();
});
</script>
@endpush
 
