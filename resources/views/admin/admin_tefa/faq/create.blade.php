@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@section('content')

<div class="faq-container">
    {{-- Link Kembali (Menggeser Ke Kiri) --}}
    <div class="back-link-wrapper">
        <a href="{{ route('admin.faq.index') }}" class="back-link">
            &larr; Kembali ke Kelola FAQ
        </a>
    </div>

    {{-- Judul Halaman (Tetap Ditengah) --}}
    <h2 class="page-title">Tambah FAQ</h2>

    {{-- Form Card --}}
    <div class="faq-card">
        <form action="{{ route('admin.faq.store') }}" method="POST">
            @csrf

            {{-- Input Pertanyaan --}}
            <div class="form-group">
                <label for="pertanyaan" class="form-label">Pertanyaan</label>
                <input type="text" 
                       name="pertanyaan" 
                       id="pertanyaan" 
                       class="form-input @error('pertanyaan') is-invalid @enderror" 
                       placeholder="Masukkan pertanyaan" 
                       value="{{ old('pertanyaan') }}" 
                       required>
                @error('pertanyaan')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Jawaban --}}
            <div class="form-group">
                <label for="jawaban" class="form-label">Jawaban</label>
                <textarea name="jawaban" 
                          id="jawaban" 
                          rows="5" 
                          class="form-textarea @error('jawaban') is-invalid @enderror" 
                          placeholder="Masukkan jawaban" 
                          required>{{ old('jawaban') }}</textarea>
                @error('jawaban')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="action-buttons">
                <a href="{{ route('admin.faq.index') }}" class="btn btn-batal">
                    Batal
                </a>
                <button type="submit" class="btn btn-simpan">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

@endsection