@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@section('content')

<style>
    .faq-container {
        margin-top: 10px;
    }

    .faq-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .faq-header h2 {
        font-size: 20px;
        font-weight: bold;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .faq-header p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .btn-add-faq {
        background: #3B698F;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-add-faq:hover {
        background: #4a82b0;
        color: white;
    }

    .faq-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .faq-card {
        display: flex;
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
        gap: 20px;
        align-items: flex-start;
    }

    .faq-number {
        font-size: 20px;
        font-weight: 800;
        color: #3B698F;
        background: #EBF3F9;
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        flex-shrink: 0;
    }

    .faq-content {
        flex-grow: 1;
    }

    .faq-content h4 {
        font-size: 16px;
        color: #1e293b;
        margin-bottom: 8px;
        line-height: 1.4;
        margin-top: 0;
    }

    .faq-content p {
        font-size: 14px;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    .faq-actions {
        display: flex;
        gap: 10px;
        flex-shrink: 0;
        align-items: center;
    }

    .btn-edit-faq {
        padding: 8px 16px;
        border: 1px solid #3B698F;
        color: #3B698F;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-edit-faq:hover {
        background: #3B698F;
        color: white;
    }

    .btn-delete-faq {
        padding: 8px 16px;
        border: 1px solid #dc3545;
        color: #dc3545;
        background: transparent;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-delete-faq:hover {
        background: #dc3545;
        color: white;
    }

    .alert-success {
        background: #ecfdf5;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .alert-error {
        background: #fef2f2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .faq-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }

        .btn-add-faq {
            width: 100%;
            text-align: center;
        }

        .faq-card {
            flex-direction: column;
        }

        .faq-actions {
            width: 100%;
        }

        .btn-edit-faq,
        .btn-delete-faq {
            flex: 1;
            text-align: center;
        }
    }
</style>

<div class="faq-container">

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert-error">
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
                        onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn-delete-faq"
                        >
                            Hapus
                        </button>
                    </form>

                </div>

            </div>

        @empty

            <div
                class="faq-card"
                style="justify-content:center;text-align:center;padding:60px 20px;flex-direction:column;align-items:center;"
            >
                <div
                    style="
                        width:64px;
                        height:64px;
                        border-radius:50%;
                        background:#EBF3F9;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:28px;
                        margin-bottom:16px;
                    "
                >
                    ?
                </div>

                <h3
                    style="
                        color:#1e293b;
                        margin-bottom:8px;
                        font-size:18px;
                    "
                >
                    Belum Ada FAQ
                </h3>

                <p
                    style="
                        color:#64748b;
                        font-size:14px;
                        margin:0;
                    "
                >
                    Belum ada FAQ yang ditambahkan.
                </p>
            </div>

        @endforelse

    </div>

</div>

@endsection