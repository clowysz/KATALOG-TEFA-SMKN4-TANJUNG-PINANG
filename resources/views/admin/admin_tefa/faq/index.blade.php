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
        background: #1e3a8ad9;
        color: white;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-add-faq:hover {
        background: #1E3A8A;
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
        color: #1E3A8A;
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
        border: 1px solid #1E3A8A;
        color: #1E3A8A;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-edit-faq:hover {
        background: #1E3A8A;
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


    /* =========================
       MODAL HAPUS FAQ
    ========================== */

    .modal-faq-delete-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.45);
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
    }

    .modal-faq-delete-box {
        background: #fff;
        padding: 32px;
        border-radius: 20px;
        width: 90%;
        max-width: 440px;
        box-shadow:
            0 20px 25px -5px rgba(0, 0, 0, 0.1);
        text-align: left;
        animation: faqModalFadeIn 0.2s ease-out;
    }

    @keyframes faqModalFadeIn {

        from {
            opacity: 0;
            transform: scale(.95);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }

    }

    .modal-faq-delete-title {
        font-size: 20px;
        font-weight: 700;
        color: #20456E;
        margin: 0 0 8px;
        font-family: sans-serif;
    }

    .modal-faq-delete-desc {
        font-size: 14px;
        color: #64748B;
        margin: 0 0 24px;
        font-family: sans-serif;
        line-height: 1.5;
    }

    .modal-faq-delete-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .btn-modal-faq-cancel {
        background: #fff;
        color: #334155;
        border: 1px solid #CBD5E1;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
        flex: 1;
    }

    .btn-modal-faq-cancel:hover {
        background: #F8FAFC;
    }

    .btn-modal-faq-delete {
        display: block;
        background: #DC2626;
        color: #fff;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        text-align: center;
        transition: .2s;
        cursor: pointer;
        flex: 1;
    }

    .btn-modal-faq-delete:hover {
        background: #B91C1C;
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

        .modal-faq-delete-box {
            padding: 24px;
        }

        .modal-faq-delete-actions {
            flex-direction: column;
        }

        .btn-modal-faq-cancel,
        .btn-modal-faq-delete {
            width: 100%;
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
                        class="faq-delete-form"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="button"
                            class="btn-delete-faq"
                            onclick="openFaqDeleteModal(this)"
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


{{-- =========================
     MODAL KONFIRMASI HAPUS FAQ
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
                onclick="closeFaqDeleteModal()"
            >
                Batal
            </button>

            <button
                type="button"
                class="btn-modal-faq-delete"
                onclick="submitFaqDelete()"
            >
                Hapus
            </button>

        </div>

    </div>

</div>


{{-- =========================
     JAVASCRIPT MODAL HAPUS
========================== --}}

<script>

    let faqDeleteForm = null;


    function openFaqDeleteModal(button) {

        faqDeleteForm = button.closest('.faq-delete-form');

        document.getElementById(
            'faqDeleteModal'
        ).style.display = 'flex';

    }


    function closeFaqDeleteModal() {

        document.getElementById(
            'faqDeleteModal'
        ).style.display = 'none';

        faqDeleteForm = null;

    }


    function submitFaqDelete() {

        if (faqDeleteForm) {

            faqDeleteForm.submit();

        }

    }


    window.addEventListener(
        'click',
        function(e) {

            const modal =
                document.getElementById(
                    'faqDeleteModal'
                );

            if (e.target === modal) {

                closeFaqDeleteModal();

            }

        }
    );

</script>

@endsection