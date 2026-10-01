@extends('admin.layouts.app')

@section('title', 'Edit Akun')

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
        background: #fff;
    }

    .form-control:focus {
        border-color: #3B698F;
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        align-items: center;
        margin-top: 30px;
    }

    .btn-primary {
        background: #1e3a8ad9;
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

    .help-text {
        display: block;
        color: #64748B;
        font-size: 13px;
        margin-top: -12px;
        margin-bottom: 20px;
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
    <a href="{{ route('akun.show', $akun->id) }}" class="btn-back">
        &larr; Kembali ke Detail Akun
    </a>

    <h2 class="faq-create-title">
        Edit Akun
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

        <form action="{{ route('akun.update', $akun->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="form-group">
                <label for="nama" class="form-label">
                    Nama Pengguna
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    value="{{ old('nama', $akun->nama) }}"
                    required
                >
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $akun->email) }}"
                    required
                >
            </div>

            {{-- Role --}}
            <div class="form-group">
                <label for="role" class="form-label">
                    Role
                </label>

                <select
                    name="role"
                    id="role"
                    class="form-control"
                    required
                >
                    <option value="admin_tefa" {{ old('role', $akun->role) === 'admin_tefa' ? 'selected' : '' }}>
                        Admin TEFA
                    </option>

                    <option value="admin_jurusan" {{ old('role', $akun->role) === 'admin_jurusan' ? 'selected' : '' }}>
                        Admin Jurusan
                    </option>
                </select>
            </div>

            {{-- Jurusan --}}
            <div class="form-group" id="jurusanContainer">
                <label for="id_jurusan" class="form-label">
                    Jurusan
                </label>

                <select
                    name="id_jurusan"
                    id="id_jurusan"
                    class="form-control"
                >
                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusanKosong as $jurusan)
                        <option
                            value="{{ $jurusan->id_jurusan }}"
                            {{ old('id_jurusan', $akun->jurusanDipegang->id_jurusan ?? '') == $jurusan->id_jurusan ? 'selected' : '' }}
                        >
                            {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <p id="helpTextJurusan" class="help-text"></p>

            {{-- Status --}}
            <div class="form-group">
                <label for="status" class="form-label">
                    Status Akun
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >
                    <option value="aktif" {{ old('status', $akun->status) === 'aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="tidak_aktif" {{ old('status', $akun->status) === 'tidak_aktif' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>
                </select>
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
                    href="{{ route('akun.show', $akun->id) }}"
                    class="btn-secondary"
                >
                    Batal
                </a>

            </div>

        </form>

    </div>

</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role');
    const jurusanContainer = document.getElementById('jurusanContainer');
    const jurusanSelect = document.getElementById('id_jurusan');
    const helpText = document.getElementById('helpTextJurusan');

    const namaInput = document.getElementById('nama');
    const emailInput = document.getElementById('email');

    function updateJurusan() {
        if (roleSelect.value === 'admin_jurusan') {
            jurusanContainer.style.display = 'block';
            jurusanSelect.disabled = false;
            jurusanSelect.required = true;

            helpText.textContent =
                'Pilih jurusan yang menjadi tanggung jawab akun ini.';
        } else {
            jurusanContainer.style.display = 'none';
            jurusanSelect.disabled = true;
            jurusanSelect.required = false;
            jurusanSelect.value = '';

            helpText.textContent =
                'Admin TEFA tidak terikat pada jurusan tertentu.';
        }
    }

    roleSelect.addEventListener('change', updateJurusan);

    updateJurusan();


    /*
    |--------------------------------------------------------------------------
    | Validasi Nama Pengguna
    |--------------------------------------------------------------------------
    */

    if (namaInput) {

        namaInput.addEventListener('invalid', function () {
            if (this.validity.valueMissing) {
                this.setCustomValidity(
                    'Nama pengguna wajib diisi.'
                );
            }
        });

        namaInput.addEventListener('input', function () {
            this.setCustomValidity('');
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Validasi Email
    |--------------------------------------------------------------------------
    */

    if (emailInput) {

        function validateEmail() {
            const value = emailInput.value.trim();

            // Email kosong
            if (value === '') {
                emailInput.setCustomValidity(
                    'Email wajib diisi.'
                );
                return;
            }

            // Format email tidak valid
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(value)) {
                emailInput.setCustomValidity(
                    'Silakan masukkan alamat email yang valid. Contoh: nama@email.com.'
                );
                return;
            }

            // Email valid
            emailInput.setCustomValidity('');
        }

        emailInput.addEventListener('input', validateEmail);

        emailInput.addEventListener('invalid', validateEmail);
    }
});
</script>
@endsection