@extends('admin.layouts.app')

@section('title', 'Edit Akun')

@section('content')

{{-- Link Kembali --}}
<div class="back-link-wrapper">
    <a href="{{ route('akun.show', $akun->id) }}" class="back-link">
        ← Kembali ke Detail Akun
    </a>
</div>

{{-- Judul Halaman --}}
<h2 class="page-title">Edit Akun</h2>

{{-- Card Form --}}
<div class="edit-card">
    <form action="{{ route('akun.update', $akun->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Nama Pengguna --}}
        <div class="form-group">
            <label>Nama Pengguna</label>
            <input type="text" 
                   name="nama_pengguna" 
                   class="form-control" 
                   value="{{ old('nama_pengguna', $akun->nama_pengguna) }}" 
                   required>
        </div>

        {{-- Email --}}
        <div class="form-group">
            <label>Email</label>
            <input type="email" 
                   name="email" 
                   class="form-control" 
                   value="{{ old('email', $akun->email) }}" 
                   required>
        </div>

        {{-- Role --}}
        <div class="form-group">
            <label>Role</label>
            <select name="role" id="roleSelect" class="form-control" required>
                <option value="Admin TEFA" {{ old('role', $akun->role) == 'Admin TEFA' ? 'selected' : '' }}>Admin TEFA</option>
                <option value="Admin Jurusan" {{ old('role', $akun->role) == 'Admin Jurusan' ? 'selected' : '' }}>Admin Jurusan</option>
            </select>
        </div>

        {{-- Jurusan (Dinamis) --}}
        <div class="form-group" id="jurusanWrapper">
            <label>Jurusan</label>
            <select name="jurusan" id="jurusanSelect" class="form-control">
                <option value="">-- Pilih Jurusan --</option>
                <option value="Rekayasa Perangkat Lunak" {{ old('jurusan', $akun->jurusan) == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak</option>
                <option value="Teknik Komputer Jaringan" {{ old('jurusan', $akun->jurusan) == 'Teknik Komputer Jaringan' ? 'selected' : '' }}>Teknik Komputer Jaringan</option>
                <option value="Desain Komunikasi Visual" {{ old('jurusan', $akun->jurusan) == 'Desain Komunikasi Visual' ? 'selected' : '' }}>Desain Komunikasi Visual</option>
                <option value="Pengembangan GIM" {{ old('jurusan', $akun->jurusan) == 'Pengembangan GIM' ? 'selected' : '' }}>Pengembangan GIM</option>
                <option value="Animasi" {{ old('jurusan', $akun->jurusan) == 'Animasi' ? 'selected' : '' }}>Animasi</option>
                <option value="Produksi Siaran dan Program Televisi" {{ old('jurusan', $akun->jurusan) == 'Produksi Siaran dan Program Televisi' ? 'selected' : '' }}>Produksi Siaran dan Program Televisi</option>

            </select>
        </div>

        {{-- Status Akun --}}
        <div class="form-group mb-large">
            <label>Status Akun</label>
            <select name="status" class="form-control" required>
                <option value="aktif" {{ old('status', strtolower($akun->status)) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ old('status', strtolower($akun->status)) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-actions">
            <a href="{{ route('akun.show', $akun->id) }}" class="btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn-submit">
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('js/edit-akun.js') }}"></script>
@endpush