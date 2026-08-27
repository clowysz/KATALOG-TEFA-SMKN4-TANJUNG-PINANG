@extends('layouts.app-jurusan')

@section('title', 'Edit Akun')

@section('content')
<div class="page-header" style="margin-bottom: 16px;">
    <!-- Jarak untuk header -->
</div>

<div class="tefa-card" style="max-width: 650px; padding: 32px; border-radius: 16px; margin: 0 auto 40px auto;">
    <form id="formEditAkunJurusan">
        <label class="detail-label">Nama Pengguna <span class="required-star">*</span></label>
        <input type="text" id="editNama" class="form-control" required>

        <label class="detail-label">Email <span class="required-star">*</span></label>
        <input type="email" id="editEmail" class="form-control" required>

        <label class="detail-label">Role</label>
        <input type="text" class="form-control" value="Admin Produk/Jasa" readonly style="background-color: #f8f9fa;">

        <label class="detail-label" style="margin-top: 24px;">Produk/Jasa Tanggung Jawab <span class="required-star">*</span></label>
        <div id="editCheckboxContainer" class="chip-checkbox-grid" style="margin-bottom: 24px;">
            <!-- Chip dimuat oleh JS -->
        </div>
        <div id="errorEditLayanan" style="color: #dc3545; font-size: 13px; display: none;">Pilih minimal satu layanan.</div>

        <label class="detail-label">Status Akun</label>
        <!-- Toggle Status Modern -->
        <div class="status-toggle-container">
            <input type="radio" id="statusAktif" name="editStatusRadio" value="Aktif" class="status-toggle-input">
            <label for="statusAktif" class="status-toggle-label">Aktif</label>
            
            <input type="radio" id="statusTidakAktif" name="editStatusRadio" value="Tidak Aktif" class="status-toggle-input">
            <label for="statusTidakAktif" class="status-toggle-label">Tidak Aktif</label>
        </div>

        <div style="display: flex; gap: 16px; margin-top: 32px;">
            <button type="button" id="btnBack" class="btn-outline" style="flex: 1;">Batal</button>
            <button type="submit" class="btn-primary" style="flex: 1;">Simpan Perubahan</button>
        </div>
    </form>
</div>
<div id="toastAction" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun-jurusan-action.js') }}"></script>
@endsection