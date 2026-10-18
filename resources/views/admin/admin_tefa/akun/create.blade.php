@extends('admin.layouts.app')

@section('title','Tambah Akun')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/akun-tefa.css') }}?v=2">
@endpush

@section('content')

<div class="form-container">

    {{-- Tombol kembali --}}
    <a
        href="{{ route('akun.index') }}"
        class="btn-back"
    >
        &larr; Kembali ke Daftar Akun
    </a>


    <h2 class="form-title">
        Tambah Akun Baru
    </h2>


    <div class="form-card">

        <p class="akun-form-intro">
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
            id="formTambahAkun"
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
                    minlength="6"
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


            <!-- JURUSAN (ditampilkan / disembunyikan oleh akun.js) -->
            <div
                id="jurusanContainer"
                class="form-group"
                style="display:none;"
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

                            @if($jurusan->user && $jurusan->user->status === 'tidak_aktif')
                                (admin sebelumnya nonaktif)
                            @endif
                        </option>

                    @endforeach

                </select>

            </div>


            <!-- BANTUAN JURUSAN -->
            <span
                id="helpTextJurusan"
                class="akun-help-text"
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

<script src="{{ asset('js/akun-form.js') }}"></script>

@endsection