@extends('layouts.app')

@section('title', 'Tambah FAQ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@section('content')

<div class="faq-form-container">
    {{-- Link Kembali --}}
    <div class="back-link-wrapper">
        <a href="{{ route('faq.index') }}" class="back-link">
            ← Kembali ke Kelola FAQ
        </a>
    </div>

    <h2 class="page-title">Tambah FAQ Baru</h2>

    {{-- Form Tambah FAQ --}}
    <div class="faq-form-card">
        <form action="{{ route('faq.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>
                <input type="text" 
                       name="pertanyaan" 
                       id="pertanyaan" 
                       class="form-control" 
                       placeholder="Masukkan pertanyaan..." 
                       value="{{ old('pertanyaan') }}" 
                       required>
            </div>

            <div class="form-group mb-large">
                <label for="jawaban">Jawaban</label>
                <textarea name="jawaban" 
                          id="jawaban" 
                          rows="5" 
                          class="form-control" 
                          placeholder="Masukkan jawaban..." 
                          required>{{ old('jawaban') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('faq.index') }}" class="btn-cancel">
                    Batal
                </a>
                <button type="submit" class="btn-submit">
                    Simpan FAQ
                </button>
            </div>
        </form>
    </div>
</div>

@endsection