/*
|--------------------------------------------------------------------------
| Slider jurusan unggulan (halaman beranda)
|--------------------------------------------------------------------------
*/
document.addEventListener("DOMContentLoaded", function () {
    const track = document.getElementById("jurusanTrack");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const container = document.querySelector(".slider-track-container");

    if (!track || !prevBtn || !nextBtn || !container) return;

    const cards = Array.from(track.querySelectorAll(".jurusan-card"));
    if (!cards.length) return;

    let currentIndex = 0;

    function getGap() {
        return parseFloat(getComputedStyle(track).columnGap) || 24;
    }

    // Jumlah kartu yang terlihat dihitung dari ukuran nyata (di CSS selalu 3)
    function getVisibleCards() {
        const cardWidth = cards[0].getBoundingClientRect().width;
        const gap = getGap();
        return Math.max(
            1,
            Math.round((track.clientWidth + gap) / (cardWidth + gap)),
        );
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

        prevBtn.setAttribute("aria-label", "Lihat jurusan sebelumnya");
        nextBtn.setAttribute("aria-label", "Lihat jurusan berikutnya");
    }

    function goNext() {
        currentIndex = currentIndex >= getMaxIndex() ? 0 : currentIndex + 1;
        updateSlider();
    }

    function goPrev() {
        currentIndex = currentIndex <= 0 ? getMaxIndex() : currentIndex - 1;
        updateSlider();
    }

    nextBtn.addEventListener("click", goNext);
    prevBtn.addEventListener("click", goPrev);

    // Geser dengan jari (swipe) di layar sentuh
    let startX = 0;
    let startY = 0;
    let tracking = false;

    container.addEventListener(
        "touchstart",
        function (e) {
            const t = e.touches[0];
            startX = t.clientX;
            startY = t.clientY;
            tracking = true;
        },
        { passive: true },
    );

    container.addEventListener(
        "touchend",
        function (e) {
            if (!tracking) return;
            tracking = false;

            const t = e.changedTouches[0];
            const dx = t.clientX - startX;
            const dy = t.clientY - startY;

            if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
                dx < 0 ? goNext() : goPrev();
            }
        },
        { passive: true },
    );

    window.addEventListener("resize", updateSlider);

    updateSlider();
});
