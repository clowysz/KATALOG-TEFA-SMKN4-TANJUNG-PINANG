@extends('admin.layouts.app')

@section('title', 'Detail Akun')

@section('content')
<div class="page-header">
    <a href="/akun" class="btn-outline" style="margin-bottom: 16px;">← Kembali ke Daftar Akun</a>
    <h2>Detail Akun</h2>
    <p>Informasi dan pengaturan akses pengguna</p>
</div>

<div class="detail-grid">
    <div class="tefa-card full-width">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
            <h3 style="color: var(--primary);">Informasi Pengguna</h3>
            <span class="badge badge-active" id="statusBadge">Aktif</span>
        </div>
        
        <div class="detail-grid" style="margin-bottom: 0;">
            <div class="detail-section">
                <div class="detail-label">Nama Pengguna</div>
                <div class="detail-value">Guru RPL</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Email</div>
                <div class="detail-value">rpl@smkn4.sch.id</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Role</div>
                <div class="detail-value">Admin Jurusan</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Jurusan</div>
                <div class="detail-value">Rekayasa Perangkat Lunak</div>
            </div>
            <div class="detail-section">
                <div class="detail-label">Password</div>
                <div class="detail-value">••••••••</div>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 24px 0;">
        
        <div style="display: flex; gap: 12px; flex-wrap: wrap;" id="actionButtons">
            <a href="/akun/edit" class="btn-primary" style="width: auto;">Edit Akun</a>
            <button onclick="openModal('modalReset')" class="btn-outline" style="width: auto;">Reset Password</button>
            <button onclick="openModal('modalHapus')" class="btn-outline" style="width: auto; color: #dc3545; border-color: #dc3545;">Hapus Akses</button>
        </div>
    </div>
</div>

<!-- ================= MODAL RESET PASSWORD ================= -->
<div id="modalReset" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Reset Password?</div>
        <div class="modal-desc">Atur password baru untuk akun ini. Password sebelumnya tidak akan berlaku lagi.</div>
        
        <form id="formResetPassword">
            <label class="detail-label">Password Baru</label>
            <input type="password" id="newPass" class="form-control" placeholder="Masukkan password baru" required>
            
            <label class="detail-label">Konfirmasi Password Baru</label>
            <input type="password" id="confirmPass" class="form-control" placeholder="Ulangi password baru" required>
            
            <div class="show-password">
                <input type="checkbox" id="toggleModalPass">
                <label for="toggleModalPass">Perlihatkan Password</label>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeModal('modalReset')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto;">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL HAPUS AKSES ================= -->
<div id="modalHapus" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Hapus Akses Akun?</div>
        <div class="modal-desc">Akun ini tidak dapat lagi mengakses halaman internal setelah akses dihapus. Data akun tetap tersimpan di dalam daftar akun.</div>
        
        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeModal('modalHapus')">Batal</button>
            <button type="button" id="btnConfirmHapus" class="btn-primary" style="width: auto; background-color: #dc3545;">Hapus Akses</button>
        </div>
    </div>
</div>

<!-- Toast Notifications -->
<div id="toastAction" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun-detail.js') }}"></script>
@endsection