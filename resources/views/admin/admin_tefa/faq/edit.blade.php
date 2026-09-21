@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')

<style>
    .page-header {
        margin-top: 16px;
        margin-bottom: 24px;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #fff;
        color: #3B698F;
        padding: 8px 16px;
        border-radius: 8px;
        border: 1px solid #3B698F;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 24px;
        margin-top: 10px;
        transition: all 0.3s;
    }

    .btn-back:hover {
        background: #3B698F;
        color: #fff;
    }

    .faq-edit-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: #334155;
        box-sizing: border-box;
        font-family: inherit;
        outline: none;
    }

    .form-control:focus {
        border-color: #3B698F;
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 140px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-primary {
        background: #3B698F;
        color: #fff;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-primary:hover {
        background: #2c5270;
    }

    .btn-secondary {
        background: #f8fafc;
        color: #475569;
        padding: 10px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        border: 1px solid #cbd5e1;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .error-message {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .error-message ul {
        margin: 0;
        padding-left: 20px;
    }

    @media (max-width: 768px) {
        .faq-edit-card {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
    }
</style>

{{-- Tombol kembali --}}
<a
    href="{{ route('tefa.faq.index') }}"
    class="btn-back"
>
    &larr; Kembali ke Kelola FAQ
</a>

<div class="page-header">
    <h2
        style="
            font-size:24px;
            font-weight:bold;
            color:#1e293b;
        "
    >
        Edit FAQ
    </h2>
</div>

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

<div class="faq-edit-card">

    <form
        action="{{ route('tefa.faq.update', $faq->id_faq) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        {{-- Pertanyaan --}}
        <div class="form-group">

            <label
                class="form-label"
                for="pertanyaan"
            >
                Pertanyaan
            </label>

            <input
                type="text"
                name="pertanyaan"
                id="pertanyaan"
                class="form-control"
                placeholder="Masukkan pertanyaan..."
                value="{{ old('pertanyaan', $faq->pertanyaan) }}"
                required
            >

        </div>

        {{-- Jawaban --}}
        <div class="form-group">

            <label
                class="form-label"
                for="jawaban"
            >
                Jawaban
            </label>

            <textarea
                name="jawaban"
                id="jawaban"
                rows="5"
                class="form-control"
                placeholder="Masukkan jawaban..."
                required
            >{{ old('jawaban', $faq->jawaban) }}</textarea>

        </div>

        {{-- Tombol --}}
        <div class="form-actions">

            <button
                type="submit"
                class="btn-primary"
            >
                Simpan Perubahan
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

@endsection