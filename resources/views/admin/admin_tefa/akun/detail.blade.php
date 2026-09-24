@extends('admin.layouts.app')

@section('title','Detail Akun')

@section('content')

<style>
    /* Styling khusus untuk halaman detail */
    .detail-wrapper {
        padding: 16px 24px;
        max-width: 700px;
        margin: 24px auto; /* Properti ini yang bikin posisinya ke tengah secara horizontal */
    }
    .back-link {
        text-decoration: none;
        color: var(--primary, #3B698F);
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .back-link:hover {
        text-decoration: underline;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 24px 0;
    }
    .alert-custom {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    .alert-success { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }
    
    /* Card Detail */
    .detail-card {
        background: #fff;
        border-radius: 12px;
        padding: 24px 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
        margin-bottom: 24px;
    }
    .info-row {
        display: flex;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
        align-items: center;
    }
    .info-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .info-label {
        width: 35%;
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
    }
    .info-value {
        width: 65%;
        color: #0f172a;
        font-size: 15px;
        font-weight: 600;
    }
    
    /* Badges */
    .badge-role {
        background: #e0e7ff;
        color: #3730a3;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .badge-status {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    
    /* Buttons */
    .action-buttons {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
    }
    .btn-custom {
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: 0.2s;
    }
    .btn-primary-custom { background: var(--primary, #3B698F); color: #fff; }
    .btn-primary-custom:hover { background: #2c5273; color: #fff; }
    .btn-outline-primary-custom { background: #fff; color: var(--primary, #3B698F); border-color: var(--primary, #3B698F); }
    .btn-outline-primary-custom:hover { background: #f0f7ff; }
    .btn-outline-danger-custom { background: #fff; color: #ef4444; border-color: #ef4444; }
    .btn-outline-danger-custom:hover { background: #fef2f2; }
    
    /* Form Reset */
    .reset-form-box {
        background: #f8fafc;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #e2e8f0;
    }
    .form-group-custom { margin-bottom: 16px; }
    .form-group-custom label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; font-size: 14px; }
    .form-control-custom { width: 100%; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
    .form-control-custom:focus { outline: none; border-color: #3B698F; }
</style>

<div class="detail-wrapper">
    <a href="{{ route('akun.index') }}" class="back-link">← Kembali ke Daftar Akun</a>

    <h2 class="page-title">Detail Akun</h2>

    @if(session('success'))
    <div class="alert-custom alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert-custom alert-danger">
        <ul style="margin:0; padding-left:20px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="detail-card">
        <div class="info-row">
            <span class="info-label">Nama Pengguna</span>
            <span class="info-value">{{ $akun->nama }}</span>
        </div>

        <div class="info-row">
            <span class="info-label">Email</span>
            <span class="info-value">{{ $akun->email }}</span>
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
                        ● Aktif
                    </span>
                @else
                    <span class="badge-status status-inactive">
                        ● Nonaktif
                    </span>
                @endif
            </span>
        </div>

        <div class="info-row">
            <span class="info-label">Password</span>
            <span class="info-value" style="letter-spacing: 2px;">••••••••</span>
        </div>
    </div>

    <!-- Tombol Aksi -->
    <div class="action-buttons">
        <a href="{{ route('akun.edit',$akun->id) }}" class="btn-custom btn-primary-custom">
            Edit Akun
        </a>

        <button type="button" id="btnResetPassword" class="btn-custom btn-outline-primary-custom">
            Reset Password
        </button>

        @if($akun->status === 'aktif')
        <form action="{{ route('akun.updateStatus',$akun->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menonaktifkan akses akun ini?');">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="tidak_aktif">
            <button type="submit" class="btn-custom btn-outline-danger-custom">
                Hapus Akses
            </button>
        </form>
        @else
        <form action="{{ route('akun.updateStatus',$akun->id) }}" method="POST" style="margin: 0;" onsubmit="return confirm('Aktifkan kembali akses akun ini?');">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="aktif">
            <button type="submit" class="btn-custom btn-outline-primary-custom">
                Aktifkan Akses
            </button>
        </form>
        @endif
    </div>

    <!-- Form Reset Password -->
    <div id="resetPasswordForm" class="reset-form-box" style="display:none;">
        <h3 style="margin-top: 0; color: #1e293b; font-size: 18px; margin-bottom: 20px;">Reset Password</h3>

        <form action="{{ route('akun.resetPassword',$akun->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group-custom">
                <label for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-control-custom" required minlength="6">
            </div>

            <div class="form-group-custom">
                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-custom" required minlength="6">
            </div>

            <div style="display: flex; gap: 12px; margin-top: 24px;">
                <button type="button" id="cancelReset" class="btn-custom btn-outline-primary-custom">
                    Batal
                </button>
                <button type="submit" class="btn-custom btn-primary-custom">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun-detail.js') }}"></script>
@endsection