@extends('admin.layouts.app-jurusan')

@section('title', 'Deskripsi Jurusan')

@section('content')
<div class="page-header">
    <h2>Kelola Deskripsi Jurusan</h2>
    <p>Perbarui informasi profil jurusan Rekayasa Perangkat Lunak</p>
</div>

<div class="tefa-card" style="max-width: 700px;">
    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;">
        <div style="width: 48px; height: 48px; background: #fcf4e8; color: var(--accent-rpl); display: flex; align-items: center; justify-content: center; font-size: 24px; border-radius: 8px;">
            💻
        </div>
        <div>
            <h3 style="color: var(--accent-rpl);">Rekayasa Perangkat Lunak</h3>
            <p style="font-size: 13px; color: var(--text-muted);">SMK Negeri 4 Tanjungpinang</p>
        </div>
    </div>

    <form id="formDeskripsi">
        <label class="detail-label">Deskripsi Profil Jurusan</label>
        <!-- Textarea dimatikan (readonly) secara default sebelum mode edit diaktifkan -->
        <textarea id="descText" class="form-control" rows="8" readonly style="background-color: #f8f9fa;">Mencetak tenaga terampil di bidang pemrograman komputer, pengembangan perangkat lunak (web, desktop, dan mobile), serta penguasaan basis data. Lulusan dipersiapkan untuk menjadi Software Engineer, Web Developer, maupun teknopreneur muda yang siap bersaing di era digital.</textarea>
        
        <div style="margin-top: 24px; display: flex; gap: 12px;" id="actionButtons">
            <button type="button" id="btnEditDesc" class="btn-primary" style="width: auto;">Edit Deskripsi</button>
        </div>
        
        <div style="margin-top: 24px; display: none; gap: 12px;" id="saveButtons">
            <button type="button" id="btnCancelDesc" class="btn-outline">Batal</button>
            <button type="submit" class="btn-primary" style="width: auto; background-color: var(--accent-rpl);">Simpan Perubahan</button>
        </div>
    </form>
</div>

<div id="toastDesc" class="toast-notification"></div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const descText = document.getElementById('descText');
    const btnEdit = document.getElementById('btnEditDesc');
    const btnCancel = document.getElementById('btnCancelDesc');
    const actionButtons = document.getElementById('actionButtons');
    const saveButtons = document.getElementById('saveButtons');
    const formDeskripsi = document.getElementById('formDeskripsi');
    const toast = document.getElementById('toastDesc');

    // Muat data dari LocalStorage jika ada
    const savedDesc = localStorage.getItem('rpl_deskripsi');
    if (savedDesc) {
        descText.value = savedDesc;
    }

    let tempDesc = descText.value; // Simpan sementara jika dibatalkan

    // Mode Edit
    btnEdit.addEventListener('click', function() {
        tempDesc = descText.value; 
        descText.removeAttribute('readonly');
        descText.style.backgroundColor = '#fff';
        descText.focus();
        
        actionButtons.style.display = 'none';
        saveButtons.style.display = 'flex';
    });

    // Batal Edit
    btnCancel.addEventListener('click', function() {
        descText.value = tempDesc; 
        descText.setAttribute('readonly', true);
        descText.style.backgroundColor = '#f8f9fa';
        
        actionButtons.style.display = 'flex';
        saveButtons.style.display = 'none';
    });

    // Simpan Perubahan
    formDeskripsi.addEventListener('submit', function(e) {
        e.preventDefault();
        
        localStorage.setItem('rpl_deskripsi', descText.value);
        
        descText.setAttribute('readonly', true);
        descText.style.backgroundColor = '#f8f9fa';
        
        actionButtons.style.display = 'flex';
        saveButtons.style.display = 'none';
        
        toast.textContent = '✓ Deskripsi jurusan berhasil diperbarui.';
        toast.style.backgroundColor = '#28a745';
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    });
});
</script>
@endsection