@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@section('content')

<div class="faq-container">
    {{-- Header Halaman --}}
    <div class="faq-header">
        <div>
            <h2>Kelola FAQ</h2>
            <p>Informasi umum mengenai website dan layanan TEFA</p>
        </div>
        <a href="{{ route('faq.create') }}" class="btn-add-faq">
            + Tambah FAQ
        </a>
    </div>

    {{-- Daftar Card FAQ --}}
    <div class="faq-list">
        @forelse($faqs as $index => $faq)
            <div class="faq-card">
                {{-- Nomor Urut --}}
                <div class="faq-number">
                    {{ $index + 1 }}
                </div>

                {{-- Konten FAQ --}}
                <div class="faq-content">
                    <h4>{{ $faq->pertanyaan }}</h4>
                    <p>{{ $faq->jawaban }}</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="faq-actions">
                    <a href="{{ route('faq.edit', $faq->id) }}" class="btn-edit-faq">
                        Edit
                    </a>

                    <form action="{{ route('faq.destroy', $faq->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-faq">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="faq-card" style="justify-content: center;">
                <p style="color: #6c757d; margin: 0;">Belum ada data FAQ.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection