@extends('admin.layouts.app')

@section('title', 'Edit Akun')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/akun-tefa.css') }}?v=2">
@endpush

@section('content')

<div class="form-container">

    {{-- Tombol kembali --}}
    <a href="{{ route('akun.show', $akun->id) }}" class="btn-back">
        &larr; Kembali ke Detail Akun
    </a>

    <h2 class="form-title">
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

    <div class="form-card">

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

            {{-- Jurusan (ditampilkan / disembunyikan oleh script di bawah) --}}
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

                            @if(
                                $jurusan->user
                                && $jurusan->id_user != $akun->id
                                && $jurusan->user->status === 'tidak_aktif'
                            )
                                (admin sebelumnya nonaktif)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <p id="helpTextJurusan" class="akun-help-text akun-help-text-tight"></p>

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

<script src="{{ asset('js/akun-form.js') }}"></script>

@endsection