@extends('public.layouts')

@section('title', 'FAQ')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/faq-pembeli.css') }}">
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

                <div
                    class="faq-header"
                    role="button"
                    tabindex="0"
                    aria-expanded="false"
                >

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
            <div class="faq-empty">

                <i class="ph ph-chat-circle-dots"></i>

                <h3>Belum ada data FAQ</h3>

                <p>Pertanyaan yang sering diajukan belum tersedia.</p>

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

            <a href="{{ route('customer.service') }}" class="btn-hubungi">
                <i class="ph ph-chat-circle-text"></i>
                Hubungi Kami
            </a>

        </div>

    </div>
</div>

@endsection


@push('scripts')
    <script src="{{ asset('js/faq-pembeli.js') }}"></script>
@endpush