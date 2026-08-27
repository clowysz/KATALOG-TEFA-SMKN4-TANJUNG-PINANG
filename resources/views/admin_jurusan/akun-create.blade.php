@extends('layouts.app-jurusan')

@section('title', 'Tambah Akun')

@section('content')
<div class="page-header">
    <a href="/jurusan-admin/akun" class="btn-outline" style="margin-bottom: 16px; border: none; padding-left: 0;">← Kembali</a>
</div>

<div class="tefa-card" style="max-width: 650px; padding: 32px; border-radius: 16px; margin: 0 auto;">
    <form id="formTambahAkunJurusan">
        <label class="detail-label">Nama Pengguna <span class="required-star">*</span></label>
        <input type="text" id="nama" class="form-control" placeholder="Masukkan nama lengkap" required>

        <label class="detail-label">Email <span class="required-star">*</span></label>
        <input type="email" id="email" class="form-control" placeholder="Masukkan email" required>

        <label class="detail-label">Password <span class="required-star">*</span></label>
        <div style="position: relative;">
            <input type="password" id="password" class="form-control" placeholder="Buat password" required>
            <span id="togglePassEye" style="position: absolute; right: 16px; top: 12px; cursor: pointer; color: #aaa;">👁️</span>
        </div>

        <label class="detail-label" style="margin-top: 16px;">Role</label>
        <input type="text" class="form-control" value="Admin Produk/Jasa" readonly style="background-color: #f8f9fa;">

        <label class="detail-label" style="margin-top: 24px;">Produk/Jasa Tanggung Jawab <span class="required-star">*</span></label>
        
        <div id="checkboxContainer" class="chip-checkbox-grid">
            <!-- Chip akan dimuat oleh JS -->
        </div>
        <div id="errorLayanan" style="color: #dc3545; font-size: 13px; display: none; margin-top: 8px;">Pilih minimal satu layanan.</div>

        <div style="display: flex; gap: 16px; margin-top: 32px;">
            <button type="reset" class="btn-outline" style="flex: 1;">Reset</button>
            <button type="submit" class="btn-primary" style="flex: 1;">Tambah Akun</button>
        </div>
    </form>
</div>

<div id="toastAkun" class="toast-notification">✓ Akun berhasil ditambahkan.</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun-jurusan.js') }}"></script>
<script>
    // Script khusus untuk Toggle Eye Password
    const toggleEye = document.getElementById('togglePassEye');
    const passInput = document.getElementById('password');
    if(toggleEye) {
        toggleEye.addEventListener('click', function() {
            if(passInput.type === 'password') {
                passInput.type = 'text';
                toggleEye.textContent = '👁️‍🗨️';
            } else {
                passInput.type = 'password';
                toggleEye.textContent = '👁️';
            }
        });
    }
</script>
@endsection