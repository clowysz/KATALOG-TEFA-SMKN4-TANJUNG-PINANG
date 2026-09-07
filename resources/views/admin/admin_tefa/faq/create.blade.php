@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')

<link rel="stylesheet" href="{{ asset('css/create-faq.css') }}">

<div class="faq-create-page">

    <div class="back-link-wrapper">
        <a href="{{ route('admin.faq.index') }}" class="back-link">
            ← Kembali ke Kelola FAQ
        </a>
    </div>

    <h2 class="page-title">Tambah FAQ</h2>

    <div class="faq-card">

        <form action="{{ route('faq.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="pertanyaan">Pertanyaan</label>

                <input
                    type="text"
                    name="pertanyaan"
                    id="pertanyaan"
                    class="form-control"
                    placeholder="Masukkan pertanyaan"
                    value="{{ old('pertanyaan') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="jawaban">Jawaban</label>

                <textarea
                    name="jawaban"
                    id="jawaban"
                    class="form-control textarea-control"
                    placeholder="Masukkan jawaban"
                    required
                >{{ old('jawaban') }}</textarea>
            </div>

            <div class="form-actions">

                <a href="{{ route('admin.faq.index') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-submit">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection