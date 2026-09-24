@extends('admin.layouts.app-jurusan')

@section('title', 'Tambah Akun')

@section('content')
<div class="page-header">
    <a
        href="/jurusan-admin/akun"
        class="btn-outline"
        style="margin-bottom: 16px; border: none; padding-left: 0;"
    >
        ← Kembali
    </a>
</div>

<div
    class="tefa-card"
    style="max-width: 650px; padding: 32px; border-radius: 16px; margin: 0 auto;"
>

    <form
        action="{{ route('jurusan.akun.store') }}"
        method="POST"
    >
        @csrf

        {{-- POINT 1: Mengubah pesan error Bahasa Inggris ke Bahasa Indonesia --}}
        @if ($errors->any())
            <div
                style="
                    background: #f8d7da;
                    color: #842029;
                    padding: 12px 16px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                "
            >
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as$error)
                        <li>
                            {{ str_replace('The layanan field is required.', 'Kolom produk/jasa tanggung jawab wajib dipilih.', $error) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label class="detail-label">
            Nama Pengguna
            <span class="required-star">*</span>
        </label>

        <input
            type="text"
            name="nama"
            class="form-control"
            placeholder="Masukkan nama lengkap"
            value="{{ old('nama') }}"
            required
        >

        <label class="detail-label">
            Email
            <span class="required-star">*</span>
        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Masukkan email"
            value="{{ old('email') }}"
            required
        >

        <label class="detail-label">
            Kata sandi
            <span class="required-star">*</span>
        </label>

        {{-- POINT 2: Ikon Mata Abu-Abu & Posisi Presisi di Tengah --}}
        <div style="position: relative;">
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                placeholder="Buat password"
                required
            >

            <span
                id="togglePassEye"
                style="
                    position: absolute;
                    right: 16px;
                    top: 50%;
                    transform: translateY(-50%);
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                "
            >
                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                </svg>
            </span>
        </div>

        <label
            class="detail-label"
            style="margin-top: 16px;"
        >
            Role
        </label>

        <input
            type="text"
            class="form-control"
            value="Admin Produser"
            readonly
            style="background-color: #f8f9fa;"
        >

        <label
            class="detail-label"
            style="margin-top: 24px;"
        >
            Produk/Jasa Tanggung Jawab
            <span class="required-star">*</span>
        </label>

        <div
            id="checkboxContainer"
            style="
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 10px;
            "
        >
            @forelse ($produkJasas as$produkJasa)
                <label
                    style="
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 10px 14px;
                        border: 1px solid #ccc;
                        border-radius: 10px;
                        cursor: pointer;
                        background: #fff;
                    "
                >
                    <input
                        type="checkbox"
                        name="layanan[]"
                        value="{{ $produkJasa->id_produk_jasa }}"
                        style="
                            width: 18px;
                            height: 18px;
                            cursor: pointer;
                            margin: 0;
                        "
                    >
                    <span>
                        {{ $produkJasa->nama_produk_jasa }}
                    </span>
                </label>
            @empty
                <p style="color: #6c757d;">
                    Belum ada produk atau jasa yang tersedia untuk jurusan Anda.
                </p>
            @endforelse
        </div>

        <div
            style="
                color: #6c757d;
                font-size: 13px;
                margin-top: 8px;
            "
        >
            Pilih minimal satu produk/jasa yang menjadi tanggung jawab Admin Produser.
        </div>

        <div
            style="
                display: flex;
                gap: 16px;
                margin-top: 32px;
            "
        >
            <button
                type="reset"
                class="btn-outline"
                style="flex: 1;"
            >
                Reset
            </button>

            <button
                type="submit"
                class="btn-primary"
                style="flex: 1;"
            >
                Tambah Akun
            </button>
        </div>

    </form>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleEye = document.getElementById('togglePassEye');
    const passInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    const eyeOpenSvg = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>`;
    const eyeClosedSvg = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>`;

    if (toggleEye && passInput && eyeIcon) {
        toggleEye.addEventListener('click', function () {
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.innerHTML = eyeClosedSvg;
            } else {
                passInput.type = 'password';
                eyeIcon.innerHTML = eyeOpenSvg;
            }
        });
    }
});
</script>
@endsection