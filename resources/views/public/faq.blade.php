@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@section('content')

<!-- Header Biru -->
<div class="faq-hero">
    <div class="faq-hero-icon">
        <i class="ph ph-question"></i>
    </div>

    <div class="faq-hero-text">
        <h1>FAQ</h1>
        <p>Temukan jawaban dari pertanyaan yang paling sering diajukan.</p>
    </div>
</div>

<!-- Konten Pertanyaan -->
<div class="faq-content">
    <div class="faq-wrapper">

        @forelse($faqs as $faq)

            <!-- Item FAQ -->
            <div class="faq-item">

                <div class="faq-header" onclick="toggleFaq(this)">

                    <div class="faq-num">
                        {{ $loop->iteration }}.
                    </div>

                    <div class="faq-question">
                        {{ $faq->pertanyaan }}
                    </div>

                    <div class="faq-toggle">
                        <i class="ph ph-caret-down"></i>
                    </div>

                </div>

                <div class="faq-body">
                    {{ $faq->jawaban }}
                </div>

            </div>

        @empty

            <!-- Empty State FAQ -->
            <div
                style="
                    text-align: center;
                    padding: 40px 20px;
                    background: white;
                    border-radius: 12px;
                    border: 1px dashed #CBD5E1;
                    margin-bottom: 24px;
                "
            >

                <i
                    class="ph ph-chat-circle-dots"
                    style="
                        font-size: 48px;
                        color: #94A3B8;
                        margin-bottom: 16px;
                    "
                ></i>

                <h3
                    style="
                        font-size: 18px;
                        font-weight: 600;
                        color: #1E2D3D;
                        margin-bottom: 8px;
                    "
                >
                    Belum ada data FAQ
                </h3>

                <p
                    style="
                        font-size: 14px;
                        color: #64748B;
                        margin: 0;
                    "
                >
                    Pertanyaan yang sering diajukan belum tersedia.
                </p>

            </div>

        @endforelse

        <!-- Box Kontak -->
        <div class="faq-more">

            <div class="faq-more-left">

                <div class="faq-more-icon">
                    <i class="ph ph-headset"></i>
                </div>

                <div class="faq-more-text">
                    <h3>Masih ada pertanyaan lainnya?</h3>

                    <p>
                        Jika Anda tidak menemukan jawaban yang Anda cari,
                        jangan ragu untuk menghubungi kami.
                    </p>
                </div>

            </div>

            <!-- Link WhatsApp dapat diganti setelah nomor TEFA ditentukan -->
            <a href="#" class="btn-hubungi">
                <i class="ph ph-chat-circle-text"></i>
                Hubungi Kami
            </a>

        </div>

    </div>
</div>

<!-- Script Accordion FAQ -->
<script>
    function toggleFaq(element) {

        // Ambil parent FAQ
        const parent = element.parentElement;

        // Cek apakah FAQ sedang terbuka
        const isActive = parent.classList.contains('active');

        // Tutup semua FAQ
        document.querySelectorAll('.faq-item').forEach(function (item) {
            item.classList.remove('active');
        });

        // Jika sebelumnya belum terbuka, buka FAQ yang diklik
        if (!isActive) {
            parent.classList.add('active');
        }
    }
</script>

@endsection