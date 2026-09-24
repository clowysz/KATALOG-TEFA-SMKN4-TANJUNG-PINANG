@extends('admin.layouts.app-jurusan')

@section('title', 'Tambah Akun')

@section('content')

<style>
    /* Styling khusus Halaman Tambah Akun */
    .create-wrapper {
        padding: 16px 24px;
        max-width: 650px;
        margin: 24px auto; /* Membuat posisi tepat di tengah */
    }
    .back-link {
        text-decoration: none;
        color: var(--primary, #3B698F);
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .back-link:hover {
        text-decoration: underline;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 24px 0;
    }
    .alert-custom {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    /* Card Box */
    .create-card {
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }
    .form-label-custom {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }
    .required-star {
        color: #ef4444;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
        background-color: #fff;
        color: #0f172a;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary, #3B698F);
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.15);
    }
    .form-control-custom[readonly] {
        background-color: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }

    /* Toggle Password dengan Ikon SVG */
    .password-wrapper {
        position: relative;
    }
    .password-wrapper .form-control-custom {
        padding-right: 42px; /* Ruang untuk tombol mata */
    }
    .toggle-password-btn {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        padding: 4px;
        cursor: pointer;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s;
        border-radius: 4px;
    }
    .toggle-password-btn:hover {
        color: var(--primary, #3B698F);
    }

    /* Checkbox Card Options */
    .checkbox-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 8px;
    }
    .checkbox-item {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        cursor: pointer;
        background: #fff;
        font-size: 14px;
        font-weight: 500;
        color: #334155;
        transition: all 0.2s ease;
        user-select: none;
    }
    .checkbox-item:hover {
        border-color: var(--primary, #3B698F);
        background-color: #f0f7ff;
    }
    .checkbox-item input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: var(--primary, #3B698F);
        cursor: pointer;
        margin: 0;
    }
    .checkbox-item:has(input[type="checkbox"]:checked) {
        border-color: var(--primary, #3B698F);
        background-color: #eff6ff;
        color: var(--primary, #3B698F);
    }

    .help-text {
        color: #64748b;
        font-size: 13px;
        margin-top: 8px;
    }

    /* Tombol Aksi */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-custom {
        flex: 1;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-align: center;
        text-decoration: none;
        border: 1px solid transparent;
        transition: 0.2s;
    }
    .btn-primary-custom {
        background: var(--primary, #3B698F);
        color: #fff;
    }
    .btn-primary-custom:hover {
        background: #2c5273;
    }
    .btn-outline-custom {
        background: #fff;
        color: #64748b;
        border-color: #cbd5e1;
    }
    .btn-outline-custom:hover {
        background: #f8fafc;
        color: #334155;
    }
</style>

<div class="create-wrapper">
    <a href="/jurusan-admin/akun" class="back-link">← Kembali</a>

    <h2 class="page-title">Tambah Akun</h2>

    <div class="create-card">

        @if ($errors->any())
            <div class="alert-custom">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jurusan.akun.store') }}" method="POST">
            @csrf

            <!-- NAMA PENGGUNA -->
            <div class="form-group-custom">
                <label class="form-label-custom" for="nama">
                    Nama Pengguna <span class="required-star">*</span>
                </label>
                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control-custom"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('nama') }}"
                    required
                >
            </div>

            <!-- EMAIL -->
            <div class="form-group-custom">
                <label class="form-label-custom" for="email">
                    Email <span class="required-star">*</span>
                </label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control-custom"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <!-- KATA SANDI -->
            <div class="form-group-custom">
                <label class="form-label-custom" for="password">
                    Kata sandi <span class="required-star">*</span>
                </label>
                <div class="password-wrapper">
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control-custom"
                        placeholder="Buat Kata sandi"
                        required
                    >
                    <button type="button" id="togglePassBtn" class="toggle-password-btn" title="Lihat Kata Sandi">
                        <!-- Ikon Mata Terbuka (Default) -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Ikon Mata Tertutup / Coret -->
                        <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- ROLE -->
            <div class="form-group-custom">
                <label class="form-label-custom">Role</label>
                <input
                    type="text"
                    class="form-control-custom"
                    value="Admin Produser"
                    readonly
                >
            </div>

            <!-- PRODUK/JASA TANGGUNG JAWAB -->
            <div class="form-group-custom">
                <label class="form-label-custom">
                    Produk/Jasa Tanggung Jawab <span class="required-star">*</span>
                </label>

                <div class="checkbox-grid">
                    @forelse ($produkJasas as $produkJasa)
                        <label class="checkbox-item">
                            <input
                                type="checkbox"
                                name="layanan[]"
                                value="{{ $produkJasa->id_produk_jasa }}"
                                {{ is_array(old('layanan')) && in_array($produkJasa->id_produk_jasa, old('layanan')) ? 'checked' : '' }}
                            >
                            <span>{{ $produkJasa->nama_produk_jasa }}</span>
                        </label>
                    @empty
                        <p class="help-text">
                            Belum ada produk atau jasa yang tersedia untuk jurusan Anda.
                        </p>
                    @endforelse
                </div>

                <div class="help-text">
                    Pilih minimal satu produk/jasa yang menjadi tanggung jawab Admin Produser.
                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="form-actions">
                <button type="reset" class="btn-custom btn-outline-custom">
                    Reset
                </button>
                <button type="submit" class="btn-custom btn-primary-custom">
                    Tambah Akun
                </button>
            </div>

        </form>

    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePassBtn');
    const passInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeOffIcon = document.getElementById('eyeOffIcon');

    if (toggleBtn && passInput) {
        toggleBtn.addEventListener('click', function () {
            if (passInput.type === 'password') {
                passInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        });
    }
});
</script>
@endsection