@extends('admin.layouts.app')

@section('title', 'Tambah Akun')

@section('content')
<div style="padding: 20px; max-width: 700px; margin: 0 auto;">
    <div style="padding: 20px; max-width: 700px; margin: 0 auto; margin-top: 40px;"></div>
    
    {{-- Kartu Form Utama --}}
    <div class="tefa-card" style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">

        {{-- Tombol Kembali di dalam kartu agar pasti terlihat --}}
        <div style="margin-bottom: 20px;">
            <a href="{{ route('akun.index') }}" style="text-decoration: none; display: inline-block; padding: 6px 12px; border: 1px solid #CBD5E1; border-radius: 6px; color: #1E2D3D; font-size: 14px; background: #F8FAFC; font-weight: 500;">
                ← Kembali ke Daftar Akun
            </a>
        </div>

        <h2 style="margin: 0 0 5px 0; color: #1E2D3D; font-size: 24px;">Tambah Akun Baru</h2>
        <p style="margin: 0 0 25px 0; color: #64748B; font-size: 14px;">Tambahkan admin baru untuk mengelola TEFA</p>

        {{-- Pesan Error --}}
        @if($errors->any())
            <div class="alert alert-danger" style="background: #FEE2E2; color: #991B1B; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('akun.store') }}" method="POST">
            @csrf

            <!-- Nama Pengguna -->
            <div style="margin-bottom: 20px;">
                <label for="nama_pengguna" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Nama Pengguna</label>
                <input type="text" id="nama_pengguna" name="nama_pengguna" class="form-control" placeholder="Masukkan nama" value="{{ old('nama_pengguna') }}" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
            </div>

            <!-- Email -->
            <div style="margin-bottom: 20px;">
                <label for="email" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
            </div>

            <!-- Password -->
            <div style="margin-bottom: 20px;">
                <label for="password" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
            </div>

            <!-- Role -->
            <div style="margin-bottom: 20px;">
                <label for="role" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Role</label>
                <select id="role" name="role" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
                    <option value="" disabled selected>Pilih Role...</option>
                    <option value="Admin TEFA">Admin TEFA</option>
                    <option value="Admin Jurusan">Admin Jurusan</option>
                </select>
            </div>

            <!-- Jurusan -->
            <div id="jurusanContainer" style="display: none; margin-bottom: 20px;">
                <label for="jurusan" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Jurusan</label>
                <select id="jurusan" name="jurusan" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;">
                    <option value="" disabled selected>Pilih Jurusan...</option>
                    <option value="RPL">Rekayasa Perangkat Lunak</option>
                    <option value="TKJ">Teknik Komputer dan Jaringan</option>
                    <option value="DKV">Desain Komunikasi Visual</option>
                    <option value="ANIMASI">Animasi</option>
                    <option value="GIM">GIM</option>
                    <option value="PSPT">Produk Suara Program Televisi</option>
                </select>
            </div>

            <!-- Bantuan Jurusan -->
            <span id="helpTextJurusan" style="display: block; color: #64748B; font-size: 13px; margin-bottom: 20px;">
                Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.
            </span>

            <!-- Status -->
            <div style="margin-bottom: 30px;">
                <label for="status" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Status</label>
                <select id="status" name="status" class="form-control" style="width: 100%; padding: 10px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
                    <option value="Aktif" selected>Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>

            <!-- Tombol Aksi -->
            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-primary" style="background: #4a5568; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;">
                    Tambah Akun
                </button>
                <a href="{{ route('akun.index') }}" style="text-decoration: none; padding: 10px 20px; border: 1px solid #CBD5E1; border-radius: 6px; color: #1E2D3D; background: #F8FAFC; text-align: center; font-weight: 500; display: inline-block;">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>


@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection