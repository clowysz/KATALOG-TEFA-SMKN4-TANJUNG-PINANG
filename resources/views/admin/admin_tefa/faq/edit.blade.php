@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit-faq.css') }}">

<div class="edit-faq-page">

    {{-- Tombol kembali --}}
    <div class="back-link-wrapper">
        <a href="{{ route('admin.faq.index') }}" class="back-link">
            ← Kembali ke Kelola FAQ
        </a>
    </div>

    {{-- Judul --}}
    <h2 class="page-title">Edit FAQ</h2>

    {{-- Card Form --}}
    <div class="edit-faq-card">

        <form action="{{ route('faq.update', $faq->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Data belum dapat disimpan.</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Pertanyaan --}}
            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>

                <input
                    type="text"
                    name="pertanyaan"
                    id="pertanyaan"
                    class="form-control"
                    value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                    required
                >
            </div>

            {{-- Jawaban --}}
            <div class="form-group">
                <label for="jawaban">Jawaban</label>

                <textarea
                    name="jawaban"
                    id="jawaban"
                    class="form-control textarea-jawaban"
                    rows="6"
                    required
                >{{ old('jawaban', $faq->jawaban) }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="form-actions">

                <a href="{{ route('admin.faq.index') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-submit">
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection