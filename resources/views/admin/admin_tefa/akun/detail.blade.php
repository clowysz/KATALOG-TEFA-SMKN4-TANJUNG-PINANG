@extends('admin.layouts.app')

@section('title', 'Detail Akun')

@section('content')

{{-- Link Kembali --}}
<div class="back-link-wrapper">
    <a href="{{ route('akun.index') }}" class="back-link">
        ← Kembali ke Daftar Akun
    </a>
</div>

{{-- Judul Halaman --}}
<h2 class="page-title">Detail Akun</h2>

{{-- Container Utama --}}
<div class="detail-container">

    {{-- Card Informasi Akun --}}
    <div class="detail-card">
        
        <div class="info-row">
            <span class="info-label">Nama Pengguna</span>
            <span class="info-value text-bold">{{ $akun->nama_pengguna }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value text-bold">{{ $akun->email }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value">
                <span class="badge-role">{{ $akun->role }}</span>
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">Jurusan</span>
            <span class="info-value">{{ $akun->jurusan ?? '—' }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Status Akun</span>
            <span class="info-value">
                @if(strtolower(trim($akun->status)) === 'aktif')
                    <span class="badge-status status-active">
                        <span class="dot">●</span> Aktif
                    </span>
                @else
                    <span class="badge-status status-inactive">
                        <span class="dot">●</span> Nonaktif
                    </span>
                @endif
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">Password</span>
            <span class="info-value dots-password">••••••••</span>
        </div>

    </div>

    {{-- Tombol Aksi --}}
    <div class="action-buttons">

        {{-- Edit Akun --}}
        <a href="{{ route('akun.edit', $akun->id) }}" class="btn-action btn-primary">
            Edit Akun
        </a>

        {{-- Reset Password --}}
        <button type="button" 
                class="btn-action btn-outline-primary"
                onclick="document.getElementById('resetPasswordForm').style.display='block';">
            Reset Password
        </button>

        {{-- Hapus Akses --}}
        @if(strtolower(trim($akun->status)) === 'aktif')
            <form action="{{ route('akun.hapus-akses', $akun->id) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus akses akun ini?');"
                  style="width: 100%;">
                @csrf
                @method('PUT')
                <button type="submit" class="btn-action btn-outline-danger">
                    Hapus Akses
                </button>
            </form>
        @else
            <button type="button" class="btn-action btn-disabled" disabled>
                Akses Sudah Dinonaktifkan
            </button>
        @endif

    </div>

    {{-- Form Reset Password (Pop-up/Dropdown Tambahan) --}}
    <div id="resetPasswordForm" class="reset-form-box" style="display: none;">
        <h3>Reset Password</h3>
        <form action="{{ route('akun.reset-password', $akun->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required minlength="8">
            </div>
            <div class="reset-form-actions">
                <button type="button" class="btn-cancel-sm" onclick="document.getElementById('resetPasswordForm').style.display='none';">
                    Batal
                </button>
                <button type="submit" class="btn-submit-sm">
                    Simpan
                </button>
            </div>
        </form>
    </div>

</div>

@endsection