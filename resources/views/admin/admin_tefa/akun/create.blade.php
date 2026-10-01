@extends('admin.layouts.app')

@section('title','Tambah Akun')

@section('content')

<style>
    .akun-create-container {
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

    .akun-create-title {
        margin-bottom: 20px;
        color: #1E2D3D;
        font-size: 24px;
        font-weight: 700;
    }

    .akun-form-card {
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

    @media (max-width: 768px) {

        .akun-create-container {
            padding: 15px;
        }

        .akun-form-card {
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


<div class="akun-create-container">

    {{-- Tombol kembali --}}
    <a
        href="{{ route('akun.index') }}"
        class="btn-back"
    >
        &larr; Kembali ke Daftar Akun
    </a>


    <h2 class="akun-create-title">
        Tambah Akun Baru
    </h2>


    <div class="akun-form-card">

        <p
            style="
                margin:0 0 25px;
                color:#64748B;
                font-size:14px;
            "
        >
            Tambahkan admin baru untuk mengelola TEFA
        </p>


        {{-- Pesan error validasi --}}
        @if($errors->any())

            <div class="error-message">

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            action="{{ route('akun.store') }}"
            method="POST"
        >

            @csrf


            <!-- NAMA -->
            <div class="form-group">

                <label
                    for="nama"
                    class="form-label"
                >
                    Nama Pengguna
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    class="form-control"
                    placeholder="Masukkan nama"
                    value="{{ old('nama') }}"
                    required
                >

            </div>


            <!-- EMAIL -->
            <div class="form-group">

                <label
                    for="email"
                    class="form-label"
                >
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="Masukkan email"
                    value="{{ old('email') }}"
                    required
                >

            </div>


            <!-- PASSWORD -->
            <div class="form-group">

                <label
                    for="password"
                    class="form-label"
                >
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <!-- ROLE -->
            <div class="form-group">

                <label
                    for="role"
                    class="form-label"
                >
                    Role
                </label>

                <select
                    id="role"
                    name="role"
                    class="form-control"
                    required
                >

                    <option
                        value=""
                        disabled
                        {{ old('role') ? '' : 'selected' }}
                    >
                        Pilih Role...
                    </option>

                    <option
                        value="admin_tefa"
                        {{ old('role') === 'admin_tefa' ? 'selected' : '' }}
                    >
                        Admin TEFA
                    </option>

                    <option
                        value="admin_jurusan"
                        {{ old('role') === 'admin_jurusan' ? 'selected' : '' }}
                    >
                        Admin Jurusan
                    </option>

                </select>

            </div>


            <!-- JURUSAN -->
            <div
                id="jurusanContainer"
                style="display:none;"
                class="form-group"
            >

                <label
                    for="id_jurusan"
                    class="form-label"
                >
                    Jurusan
                </label>

                <select
                    id="id_jurusan"
                    name="id_jurusan"
                    class="form-control"
                >

                    <option
                        value=""
                        disabled
                        {{ old('id_jurusan') ? '' : 'selected' }}
                    >
                        Pilih Jurusan...
                    </option>

                    @foreach($jurusanKosong as $jurusan)

                        <option
                            value="{{ $jurusan->id_jurusan }}"
                            {{ old('id_jurusan') == $jurusan->id_jurusan ? 'selected' : '' }}
                        >
                            {{ $jurusan->nama_jurusan }}
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- BANTUAN JURUSAN -->
            <span
                id="helpTextJurusan"
                style="
                    display:block;
                    color:#64748B;
                    font-size:13px;
                    margin-bottom:20px;
                "
            >
                Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.
            </span>


            <!-- STATUS -->
            <div class="form-group">

                <label
                    for="status"
                    class="form-label"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="form-control"
                    required
                >

                    <option
                        value="aktif"
                        {{ old('status','aktif') === 'aktif' ? 'selected' : '' }}
                    >
                        Aktif
                    </option>

                    <option
                        value="tidak_aktif"
                        {{ old('status') === 'tidak_aktif' ? 'selected' : '' }}
                    >
                        Tidak Aktif
                    </option>

                </select>

            </div>


            <!-- TOMBOL -->
            <div class="form-actions">

                <button
                    type="submit"
                    class="btn-primary"
                >
                    Tambah Akun
                </button>

                <a
                    href="{{ route('akun.index') }}"
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

<script src="{{ asset('js/akun.js') }}"></script>

@endsection