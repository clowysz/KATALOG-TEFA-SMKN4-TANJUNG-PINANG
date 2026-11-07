@extends('admin.layouts.app')

@section('title', 'Customer Service')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/kontak-tefa.css') }}?v=4">
@endpush

@section('content')

<div class="kontak-halaman">

    <!-- HEADER -->
    <div class="page-header">
        <h2>Kontak Customer Service</h2>
        <p>Atur nomor WhatsApp yang dihubungi pelanggan saat membuka Customer Service.</p>
    </div>

    <!-- PESAN BERHASIL -->
    @if(session('sukses'))
        <div class="katalog-sukses">
            {{ session('sukses') }}
        </div>
    @endif

    <!-- FORM NOMOR CUSTOMER SERVICE -->
    <form
        action="{{ route('tefa.cs.update') }}"
        method="POST"
        class="kontak-card"
        id="kontak-form"
        novalidate
    >
        @csrf
        @method('PUT')

        <div class="kontak-info">
            <div class="kontak-icon">
                <i class="ph ph-whatsapp-logo"></i>
            </div>

            <div class="kontak-teks">
                <h4>Nomor WhatsApp Customer Service</h4>
                <p>Pelanggan yang sudah memiliki pesanan akan diarahkan langsung ke WhatsApp nomor ini.</p>
            </div>
        </div>

        <div class="kontak-form">
            <div class="kontak-group">
                <label for="nomor-cs">Nomor WhatsApp</label>

                <input
                    type="tel"
                    name="nomor_cs"
                    id="nomor-cs"
                    class="{{ $errors->has('nomor_cs') ? 'is-invalid' : '' }}"
                    value="{{ old('nomor_cs', $nomorCs) }}"
                    data-awal="{{ $nomorCs }}"
                    inputmode="tel"
                    autocomplete="off"
                    maxlength="20"
                    placeholder="Contoh: 0896-5362-8650"
                >

                <p class="kontak-error" role="alert">{{ $errors->first('nomor_cs') }}</p>
            </div>

            <button type="submit" class="btn-kontak-simpan">
                Simpan
            </button>
        </div>

        <div class="kontak-footer">
            <p>
                Nomor yang sedang dipakai: <strong>{{ $nomorCs }}</strong>
            </p>

            <a
                href="{{ $urlWhatsapp }}"
                class="btn-kontak-tes"
                target="_blank"
                rel="noopener"
            >
                <i class="ph ph-arrow-square-out"></i>
                Coba buka WhatsApp
            </a>
        </div>
    </form>

</div>

@endsection

@section('scripts')
    {{-- Logika nomor kontak (validasi sendiri, tanpa dialog browser) --}}
    <script src="{{ asset('js/kontak-tefa.js') }}?v=3" defer></script>
@endsection