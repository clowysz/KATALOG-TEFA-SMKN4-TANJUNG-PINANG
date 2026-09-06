@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@section('content')

<!-- Header Biru -->
<div class="faq-hero">
    <div class="faq-hero-icon"><i class="ph ph-question"></i></div>
    <div class="faq-hero-text">
        <h1>FAQ</h1>
        <p>Temukan jawaban dari pertanyaan yang paling sering diajukan.</p>
    </div>
</div>

<!-- Konten Pertanyaan -->
<div class="faq-content">
    <div class="faq-wrapper">
        
        <!-- Pertanyaan 1 -->
        <div class="faq-item">
            <div class="faq-header" onclick="toggleFaq(this)">
                <div class="faq-num">1.</div>
                <div class="faq-question">Apakah harus memiliki akun untuk melakukan pemesanan?</div>
                <div class="faq-toggle"><i class="ph ph-caret-down"></i></div>
            </div>
            <div class="faq-body">
                Ya. Pengguna perlu login atau membuat akun terlebih dahulu untuk melakukan pemesanan produk maupun jasa.
            </div>
        </div>

        <!-- Pertanyaan 2 -->
        <div class="faq-item">
            <div class="faq-header" onclick="toggleFaq(this)">
                <div class="faq-num">2.</div>
                <div class="faq-question">Apakah saya bisa membatalkan pesanan?</div>
                <div class="faq-toggle"><i class="ph ph-caret-down"></i></div>
            </div>
            <div class="faq-body">
                Pembatalan bergantung pada status pesanan. Jika pesanan sudah masuk tahap proses, pembatalan mungkin tidak dapat dilakukan. Hubungi admin untuk informasi lebih lanjut.
            </div>
        </div>

        <!-- Pertanyaan 3 -->
        <div class="faq-item">
            <div class="faq-header" onclick="toggleFaq(this)">
                <div class="faq-num">3.</div>
                <div class="faq-question">Kapan saya harus melakukan pembayaran?</div>
                <div class="faq-toggle"><i class="ph ph-caret-down"></i></div>
            </div>
            <div class="faq-body">
                Pembayaran dilakukan sesuai ketentuan pada saat pemesanan dan setelah konfirmasi dari pihak admin kami melalui WhatsApp.
            </div>
        </div>

        <!-- Box Kontak Darurat -->
        <div class="faq-more">
            <div class="faq-more-left">
                <div class="faq-more-icon"><i class="ph ph-headset"></i></div>
                <div class="faq-more-text">
                    <h3>Masih ada pertanyaan lainnya?</h3>
                    <p>Jika Anda tidak menemukan jawaban yang Anda cari, jangan ragu untuk menghubungi kami.</p>
                </div>
            </div>
            <!-- Nanti '#' diganti dengan link wa.me TEFA -->
            <a href="#" class="btn-hubungi"><i class="ph ph-chat-circle-text"></i> Hubungi Kami</a>
        </div>

    </div>
</div>

<!-- Script untuk Buka/Tutup Jawaban (Accordion) -->
<script>
    function toggleFaq(element) {
        // Ambil elemen parent (div.faq-item)
        const parent = element.parentElement;
        
        // Cek apakah item yang diklik sudah aktif
        const isActive = parent.classList.contains('active');
        
        // Tutup semua faq-item lainnya (agar hanya 1 yang terbuka)
        document.querySelectorAll('.faq-item').forEach(item => {
            item.classList.remove('active');
        });

        // Jika sebelumnya tidak aktif, maka aktifkan (buka)
        if (!isActive) {
            parent.classList.add('active');
        }
    }
</script>

@endsection