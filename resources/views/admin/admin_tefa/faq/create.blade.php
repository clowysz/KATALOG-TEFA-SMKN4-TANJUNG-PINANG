@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')

<div class="form-container">

    {{-- Tombol kembali --}}
    <a href="{{ route('tefa.faq.index') }}" class="btn-back">
        &larr; Kembali ke Kelola FAQ
    </a>

    <h2 class="form-title">
        Tambah FAQ Baru
    </h2>

    {{-- Pesan error validasi --}}
    @if($errors->any())
        <div class="error-message">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">

        <form action="{{ route('tefa.faq.store') }}" method="POST">

            @csrf

            {{-- Pertanyaan --}}
            <div class="form-group">
                <label
                    for="pertanyaan"
                    class="form-label"
                >
                    Pertanyaan
                </label>

                <input
                    type="text"
                    name="pertanyaan"
                    id="pertanyaan"
                    class="form-control"
                    placeholder="Masukkan pertanyaan..."
                    value="{{ old('pertanyaan') }}"
                    required
                >
            </div>

            {{-- Jawaban --}}
            <div class="form-group">
                <label
                    for="jawaban"
                    class="form-label"
                >
                    Jawaban
                </label>

                <textarea
                    name="jawaban"
                    id="jawaban"
                    class="form-control"
                    rows="5"
                    placeholder="Masukkan jawaban..."
                    required
                >{{ old('jawaban') }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Simpan FAQ
                </button>

                <a
                    href="{{ route('tefa.faq.index') }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/faq-form-tefa.js') }}"></script>

@endsection