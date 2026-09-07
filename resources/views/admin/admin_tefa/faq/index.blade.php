@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@section('content')

<link rel="stylesheet" href="{{ asset('css/faq.css') }}">

<div class="faq-page">

    {{-- HEADER HALAMAN --}}
    <div class="faq-page-header">

        <div class="faq-title-area">
            <h2>Kelola FAQ</h2>
            <p>Informasi umum mengenai website dan layanan TEFA</p>
        </div>

        <a href="{{ route('admin.faq.create') }}" class="faq-add-button">
            <span class="plus-icon">+</span>
            <span>Tambah FAQ</span>
        </a>

    </div>


    {{-- DAFTAR FAQ --}}
    <div class="faq-items">

        @forelse($faqs as $index => $faq)

            <div class="faq-item">

                {{-- NOMOR --}}
                <div class="faq-item-number">
                    {{ $index + 1 }}
                </div>


                {{-- PERTANYAAN & JAWABAN --}}
                <div class="faq-item-body">

                    <h4>
                        {{ $faq->pertanyaan }}
                    </h4>

                    <p>
                        {{ $faq->jawaban }}
                    </p>

                </div>


                {{-- AKSI --}}
                <div class="faq-item-actions">

                    <a
                        href="{{ route('faq.edit', $faq->id) }}"
                        class="faq-edit-button"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('faq.destroy', $faq->id) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="faq-delete-button"
                        >
                            Hapus
                        </button>

                    </form>

                </div>

            </div>

        @empty

            <div class="faq-empty">
                Belum ada data FAQ.
            </div>

        @endforelse

    </div>

</div>

@endsection 