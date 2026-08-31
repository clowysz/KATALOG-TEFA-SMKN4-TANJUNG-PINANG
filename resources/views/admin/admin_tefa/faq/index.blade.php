@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@section('content')
<div class="header-action">
    <div>
        <h2>Kelola FAQ</h2>
        <p>Informasi umum mengenai website dan layanan TEFA</p>
    </div>
    <button onclick="openFaqModal('modalTambahFaq')" class="btn-primary" style="width: auto;">+ Tambah FAQ</button>
</div>

<div class="tefa-card">
    <div class="faq-list" id="faqContainer">
        <!-- Daftar FAQ akan di-render secara otomatis oleh JavaScript di sini -->
    </div>
    
    <div id="emptyFaq" style="display: none; text-align: center; padding: 40px;">
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">Belum Ada FAQ</h3>
        <p style="color: #6c757d;">Tambahkan pertanyaan dan jawaban pertama Anda.</p>
    </div>
</div>

<!-- ================= MODAL TAMBAH FAQ ================= -->
<div id="modalTambahFaq" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-title">Tambah FAQ Baru</div>
        <div class="modal-desc">Masukkan pertanyaan dan jawaban untuk ditampilkan pada website katalog TEFA.</div>
        
        <form id="formTambahFaq">
            <label class="detail-label">Pertanyaan</label>
            <input type="text" id="addQuestion" class="form-control" placeholder="Tuliskan pertanyaan..." required>
            
            <label class="detail-label">Jawaban</label>
            <textarea id="addAnswer" class="form-control" rows="4" placeholder="Tuliskan jawaban lengkap..." required style="resize: vertical;"></textarea>
            
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeFaqModal('modalTambahFaq')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL EDIT FAQ ================= -->
<div id="modalEditFaq" class="modal-overlay">
    <div class="modal-box" style="max-width: 500px;">
        <div class="modal-title">Edit FAQ</div>
        <div class="modal-desc">Perbarui informasi pertanyaan atau jawaban.</div>
        
        <form id="formEditFaq">
            <input type="hidden" id="editFaqId">
            <label class="detail-label">Pertanyaan</label>
            <input type="text" id="editQuestion" class="form-control" required>
            
            <label class="detail-label">Jawaban</label>
            <textarea id="editAnswer" class="form-control" rows="4" required style="resize: vertical;"></textarea>
            
            <div class="modal-actions">
                <button type="button" class="btn-outline" onclick="closeFaqModal('modalEditFaq')">Batal</button>
                <button type="submit" class="btn-primary" style="width: auto;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL HAPUS FAQ ================= -->
<div id="modalHapusFaq" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-title">Hapus FAQ?</div>
        <div class="modal-desc">Apakah Anda yakin ingin menghapus pertanyaan ini? Data yang dihapus tidak dapat dikembalikan.</div>
        <input type="hidden" id="deleteFaqId">
        
        <div class="modal-actions">
            <button type="button" class="btn-outline" onclick="closeFaqModal('modalHapusFaq')">Batal</button>
            <button type="button" id="btnConfirmDeleteFaq" class="btn-primary" style="width: auto; background-color: #dc3545;">Hapus</button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toastFaq" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/faq.js') }}"></script>
@endsection