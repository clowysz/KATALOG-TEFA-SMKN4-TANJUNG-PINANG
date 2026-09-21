@extends('admin.layouts.app')

@section('title','Detail Akun')

@section('content')
<div class="back-link-wrapper">
    <a href="{{ route('akun.index') }}" class="back-link">← Kembali ke Daftar Akun</a>
</div>

<h2 class="page-title">Detail Akun</h2>

@if(session('success'))
<div class="alert alert-success" style="margin-bottom:20px;">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger" style="margin-bottom:20px;">
    <ul style="margin:0;padding-left:20px;">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="detail-container">
    <div class="detail-card">
        <div class="info-row">
            <span class="info-label">Nama Pengguna</span>
            <span class="info-value text-bold">{{ $akun->nama }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value text-bold">{{ $akun->email }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Role</span>
            <span class="info-value">
                <span class="badge-role">
                    {{ $akun->role === 'admin_tefa' ? 'Admin TEFA' : 'Admin Jurusan' }}
                </span>
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">Jurusan</span>
            <span class="info-value">
                {{ $akun->jurusanDipegang->nama_jurusan ?? '—' }}
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">Status Akun</span>
            <span class="info-value">
                @if($akun->status === 'aktif')
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

    <div class="action-buttons">
        <a href="{{ route('akun.edit',$akun->id) }}" class="btn-action btn-primary">
            Edit Akun
        </a>

        <button type="button" id="btnResetPassword" class="btn-action btn-outline-primary">
            Reset Password
        </button>

        @if($akun->status === 'aktif')
        <form action="{{ route('akun.updateStatus',$akun->id) }}" method="POST" style="width:100%;" onsubmit="return confirm('Yakin ingin menonaktifkan akses akun ini?');">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="tidak_aktif">
            <button type="submit" class="btn-action btn-outline-danger">
                Hapus Akses
            </button>
        </form>
        @else
        <form action="{{ route('akun.updateStatus',$akun->id) }}" method="POST" style="width:100%;" onsubmit="return confirm('Aktifkan kembali akses akun ini?');">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="aktif">
            <button type="submit" class="btn-action btn-outline-primary">
                Aktifkan Akses
            </button>
        </form>
        @endif
    </div>

    <div id="resetPasswordForm" class="reset-form-box" style="display:none;">
        <h3>Reset Password</h3>

        <form action="{{ route('akun.resetPassword',$akun->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control" required minlength="6">
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required minlength="6">
            </div>

            <div class="reset-form-actions">
                <button type="button" id="cancelReset" class="btn-cancel-sm">
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

@section('scripts')
<script src="{{ asset('js/akun-detail.js') }}"></script>
@endsection