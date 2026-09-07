@extends('admin.layouts.app')

@section('title', 'Edit Akun')

@section('content')

<link rel="stylesheet" href="{{ asset('css/edit-akun.css') }}">

<div class="edit-page">

    {{-- Link Kembali --}}
    <div class="back-link-wrapper">
        <a href="{{ route('akun.show', $akun->id) }}" class="back-link">
            ← Kembali ke Detail Akun
        </a>
    </div>

    {{-- Judul --}}
    <h2 class="page-title">Edit Akun</h2>

    {{-- Card Form --}}
    <div class="edit-card">

        <form action="{{ route('akun.update', $akun->id) }}" method="POST">

            @csrf
            @method('PUT')

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert-danger">
                    <strong>Data belum dapat disimpan.</strong>

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Nama Pengguna --}}
            <div class="form-group">

                <label for="nama_pengguna">
                    Nama Pengguna
                </label>

                <input
                    type="text"
                    id="nama_pengguna"
                    name="nama_pengguna"
                    class="form-control"
                    value="{{ old('nama_pengguna', $akun->nama_pengguna) }}"
                    required
                >

            </div>


            {{-- Email --}}
            <div class="form-group">

                <label for="email">
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

                <label for="roleSelect">
                    Role
                </label>

                <select
                    name="role"
                    id="roleSelect"
                    class="form-control"
                    required
                >

                    <option value="Admin TEFA"
                        {{ old('role', $akun->role) == 'Admin TEFA' ? 'selected' : '' }}>
                        Admin TEFA
                    </option>

                    <option value="Admin Jurusan"
                        {{ old('role', $akun->role) == 'Admin Jurusan' ? 'selected' : '' }}>
                        Admin Jurusan
                    </option>

                </select>

            </div>


            {{-- Jurusan --}}
            <div class="form-group">

                <label>
                    Jurusan
                </label>

                {{-- Informasi untuk Admin TEFA --}}
                <div
                    id="jurusanInfo"
                    class="jurusan-info"
                >
                    Admin TEFA tidak terikat pada jurusan tertentu.
                </div>


                {{-- Dropdown untuk Admin Jurusan --}}
                <select
                    name="jurusan"
                    id="jurusanSelect"
                    class="form-control"
                >

                    <option value="">
                        -- Pilih Jurusan --
                    </option>

                    <option value="Rekayasa Perangkat Lunak"
                        {{ old('jurusan', $akun->jurusan) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>
                        Rekayasa Perangkat Lunak
                    </option>

                    <option value="Teknik Komputer Jaringan"
                        {{ old('jurusan', $akun->jurusan) == 'Teknik Komputer Jaringan' ? 'selected' : '' }}>
                        Teknik Komputer Jaringan
                    </option>

                    <option value="Desain Komunikasi Visual"
                        {{ old('jurusan', $akun->jurusan) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>
                        Desain Komunikasi Visual
                    </option>

                    <option value="Pengembangan GIM"
                        {{ old('jurusan', $akun->jurusan) == 'Pengembangan GIM' ? 'selected' : '' }}>
                        Pengembangan GIM
                    </option>

                    <option value="Animasi"
                        {{ old('jurusan', $akun->jurusan) == 'Animasi' ? 'selected' : '' }}>
                        Animasi
                    </option>

                    <option value="Produksi Siaran dan Program Televisi"
                        {{ old('jurusan', $akun->jurusan) == 'Produksi Siaran dan Program Televisi' ? 'selected' : '' }}>
                        Produksi Siaran dan Program Televisi
                    </option>

                </select>

            </div>


            {{-- Status --}}
            <div class="form-group mb-large">

                <label for="status">
                    Status Akun
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-control"
                    required
                >

                    <option value="Aktif"
                        {{ old('status', $akun->status) == 'Aktif' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="Tidak Aktif"
                        {{ old('status', $akun->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>

                </select>

            </div>


            {{-- Tombol --}}
            <div class="form-actions">

                <a
                    href="{{ route('akun.show', $akun->id) }}"
                    class="btn-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-submit"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script src="{{ asset('js/edit-akun.js') }}"></script>
@endpush