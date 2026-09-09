@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/faq.css') }}">
@endpush

@section('content')

<div class="faq-manage-container">
    {{-- Header Section --}}
    <div class="faq-header-wrapper">
        <div class="faq-title-area">
            <h2 class="faq-title">Kelola FAQ</h2>
            <p class="faq-subtitle">Informasi umum mengenai website dan layanan TEFA</p>
        </div>

        <a href="{{ route('admin.faq.create') }}" class="btn-add-faq">
            <span class="plus-icon">+</span> Tambah FAQ
        </a>
    </div>

    {{-- Daftar Card FAQ --}}
    <div class="faq-list">
        @forelse($faqs as $index => $faq)
            <div class="faq-card-item">
                {{-- Nomor Urut --}}
                <div class="faq-number">
                    {{ $index + 1 }}
                </div>

                {{-- Konten FAQ --}}
                <div class="faq-content">
                    <h3 class="faq-question">{{ $faq->pertanyaan }}</h3>
                    <p class="faq-answer">{{ $faq->jawaban }}</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="faq-actions">
                    <a href="{{ route('admin.faq.edit', $faq->id) }}" class="btn-action btn-edit">
                        Edit
                    </a>
                    
                    <form action="{{ route('admin.faq.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="faq-empty">
                <p>Belum ada data FAQ yang ditambahkan.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection