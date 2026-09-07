@extends('admin.layouts.app')

@section('title', 'Tambah Akun')

@section('content')

<div class="tefa-card" style="max-width: 480px; margin: 40px auto; padding: 32px; background: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); position: relative;">

    <!-- Tombol Kembali -->
    <a href="{{ route('akun.index') }}" 
       style="display: inline-flex; align-items: center; text-decoration: none; color: #64748b; font-size: 14px; font-weight: 500; margin-bottom: 16px; transition: color 0.2s;"
       onmouseover="this.style.color='#1e293b'" 
       onmouseout="this.style.color='#64748b'">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        Kembali
    </a>

    <h2 style="text-align: center; font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 24px;">Tambah Akun</h2>

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger" style="margin-bottom: 16px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 16px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('akun.store') }}" method="POST">
        @csrf

        <!-- Nama Pengguna -->
        <div class="form-group" style="margin-bottom: 18px;">
            <label for="nama_pengguna" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
                Nama Pengguna
            </label>
            <input
                type="text"
                id="nama_pengguna"
                name="nama_pengguna"
                class="form-control"
                placeholder="Masukkan nama pengguna"
                value="{{ old('nama_pengguna') }}"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;"
            >
        </div>

        <!-- Email -->
        <div class="form-group" style="margin-bottom: 18px;">
            <label for="email" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
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
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;"
            >
        </div>

        <!-- Password -->
        <div class="form-group" style="margin-bottom: 18px;">
            <label for="password" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
                Password
            </label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Buat password"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none;"
            >
        </div>

        <!-- Role -->
        <div class="form-group" style="margin-bottom: 6px;">
            <label for="role" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
                Role
            </label>
            <select
                id="role"
                name="role"
                class="form-control"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background-color: #fff;"
            >
                <option value="" disabled selected>Pilih Role</option>
                <option value="Admin TEFA">Admin TEFA</option>
                <option value="Admin Jurusan">Admin Jurusan</option>
            </select>
        </div>

        <!-- Bantuan Jurusan -->
        <span id="helpTextJurusan" class="help-text" style="display: block; font-size: 12px; color: #64748b; margin-bottom: 18px;">
            Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.
        </span>

        <!-- Jurusan -->
        <div id="jurusanContainer" class="form-group" style="margin-bottom: 18px;">
            <label for="jurusan" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
                Jurusan
            </label>
            <select
                id="jurusan"
                name="jurusan"
                class="form-control"
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background-color: #fff;"
            >
                <option value="" disabled selected>Pilih Jurusan</option>
                <option value="RPL">Rekayasa Perangkat Lunak</option>
                <option value="TKJ">Teknik Komputer dan Jaringan</option>
                <option value="DKV">Desain Komunikasi Visual</option>
                <option value="ANIMASI">Animasi</option>
                <option value="GIM">GIM</option>
                <option value="PSPT">Produk Suara Program Televisi</option>
            </select>
        </div>

        <!-- Status -->
        <div class="form-group" style="margin-bottom: 24px;">
            <label for="status" class="detail-label" style="display: block; font-weight: 600; margin-bottom: 6px; color: #334155;">
                Status
            </label>
            <select
                id="status"
                name="status"
                class="form-control"
                required
                style="width: 100%; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; background-color: #fff;"
            >
                <option value="" disabled selected>Pilih Status</option>
                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="btn-primary"
            style="width: 100%; padding: 12px; background-color: #3b698a; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;"
        >
            Tambah Akun
        </button>

    </form>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection