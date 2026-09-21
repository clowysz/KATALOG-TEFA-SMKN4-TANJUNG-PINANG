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
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
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
            Password
            <span class="required-star">*</span>
        </label>

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
                    top: 12px;
                    cursor: pointer;
                    color: #aaa;
                "
            >
                👁️
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
            class="chip-checkbox-grid"
        >

            @forelse ($produkJasas as $produkJasa)

                <label style="cursor: pointer;">
                    <input
                        type="checkbox"
                        name="layanan[]"
                        value="{{ $produkJasa->id_produk_jasa }}"
                        style="display: none;"
                    >

                    <span
                        class="chip-checkbox"
                        onclick="
                            const checkbox = this.previousElementSibling;
                            checkbox.checked = !checkbox.checked;
                            this.classList.toggle('active', checkbox.checked);
                        "
                    >
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

    if (toggleEye && passInput) {

        toggleEye.addEventListener('click', function () {

            if (passInput.type === 'password') {
                passInput.type = 'text';
                toggleEye.textContent = '👁️‍🗨️';
            } else {
                passInput.type = 'password';
                toggleEye.textContent = '👁️';
            }

        });

    }

});
</script>
@endsection