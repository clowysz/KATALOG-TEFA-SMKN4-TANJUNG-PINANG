@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/faq-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="faq-container">

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="faq-alert faq-alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="faq-alert faq-alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="faq-header">
        <div>
            <h2>Kelola FAQ</h2>
            <p>Informasi umum mengenai website dan layanan TEFA</p>
        </div>

        <a href="{{ route('tefa.faq.create') }}" class="btn-add-faq">
            + Tambah FAQ
        </a>
    </div>

    <div class="faq-list">

        @forelse($faqs as $index => $faq)

            <div class="faq-card">

                {{-- Nomor FAQ --}}
                <div class="faq-number">
                    {{ $index + 1 }}
                </div>

                {{-- Isi FAQ --}}
                <div class="faq-content">
                    <h4>
                        {{ $faq->pertanyaan }}
                    </h4>

                    <p>
                        {{ $faq->jawaban }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="faq-actions">

                    {{-- Edit --}}
                    <a
                        href="{{ route('tefa.faq.edit', $faq->id_faq) }}"
                        class="btn-edit-faq"
                    >
                        Edit
                    </a>

                    {{-- Hapus --}}
                    <form
                        action="{{ route('tefa.faq.destroy', $faq->id_faq) }}"
                        method="POST"
                        class="faq-delete-form"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            class="btn-delete-faq"
                            data-faq-delete
                        >
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div class="faq-card faq-empty">

                <div class="faq-empty-icon">
                    ?
                </div>

                <h3 class="faq-empty-title">
                    Belum Ada FAQ
                </h3>

                <p class="faq-empty-text">
                    Belum ada FAQ yang ditambahkan.
                </p>

            </div>

        @endforelse

    </div>

</div>


{{-- =========================
     MODAL KONFIRMASI HAPUS FAQ
     (ditampilkan oleh faq-index-tefa.js)
========================== --}}

<div
    id="faqDeleteModal"
    class="modal-faq-delete-overlay"
    style="display:none;"
>

    <div class="modal-faq-delete-box">

        <h3 class="modal-faq-delete-title">
            Hapus FAQ?
        </h3>

        <p class="modal-faq-delete-desc">
            Yakin ingin menghapus FAQ ini? Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="modal-faq-delete-actions">

            <button
                type="button"
                class="btn-modal-faq-cancel"
                data-faq-delete-close
            >
                Batal
            </button>

            <button
                type="button"
                class="btn-modal-faq-delete"
                data-faq-delete-submit
            >
                Hapus
            </button>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script src="{{ asset('js/faq-index-tefa.js') }}"></script>

@endsection