@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')

<style>
    .faq-create-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

    .btn-back {
        display: inline-block;
        padding: 8px 16px;
        border: 1px solid #1E3A8A;
        border-radius: 8px;
        color: #1E3A8A;
        background: #fff;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 24px;
    }

    .btn-back:hover {
        background: #1E3A8A;
        color: #fff;
    }

    .faq-create-title {
        margin-bottom: 20px;
        color: #1E2D3D;
        font-size: 24px;
        font-weight: 700;
    }

    .faq-form-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #1E2D3D;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 14px;
        color: #334155;
        outline: none;
        box-sizing: border-box;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #3B698F;
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 130px;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 30px;
    }

    .btn-primary {
        background: rgba(30, 58, 138, 0.85);
        color: white;
        padding: 10px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: #1E3A8A;
        color: white;
    }

    .btn-primary:active {
        background: #172E6F;
        color: white;
    }

    .btn-secondary {
        text-decoration: none;
        padding: 10px 24px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        color: #1E3A8A;
        background: #F8FAFC;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-secondary:hover {
        background: #E2E8F0;
        color: #1E293B;
    }

    .error-message {
        background: #FEF2F2;
        color: #991B1B;
        border: 1px solid #FECACA;
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
        .faq-create-container {
            padding: 15px;
        }

        .faq-form-card {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }
    }
</style>

<div class="faq-create-container">

    {{-- Tombol kembali --}}
    <a href="{{ route('tefa.faq.index') }}" class="btn-back">
        &larr; Kembali ke Kelola FAQ
    </a>

    <h2 class="faq-create-title">
        Edit FAQ
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

    <div class="faq-form-card">

        <form
            action="{{ route('tefa.faq.update', $faq->id_faq) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

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
                    value="{{ old('pertanyaan', $faq->pertanyaan) }}"
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

</div>

@endsection