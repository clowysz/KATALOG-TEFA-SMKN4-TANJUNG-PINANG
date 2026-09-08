@extends('admin.layouts.app-produser')

@section('title', 'Detail Pesanan')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="/produser/pesanan" class="btn-outline" style="border: none; padding-left: 0; color: white; background: var(--prod-text-sec); padding: 8px 16px; border-radius: 8px; text-decoration: none;"><i class="ph ph-arrow-left"></i> Kembali ke Daftar</a>
</div>

<!-- KOTAK BIRU (HERO CARD) -->
<div class="order-hero-card">
    <div class="order-hero-top">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="display: flex; gap: 8px;">
                <span class="hero-badge-dark" id="heroOrderId">ORD-000</span>
                <span class="hero-badge-light" id="heroStatusPesanan">Memuat...</span>
            </div>
            <span class="hero-badge-light" id="heroStatusPengerjaan" style="color: var(--prod-text-sec);">Memuat...</span>
        </div>
        <div>
            <h2 id="heroTitle" style="font-size: 24px; margin-bottom: 12px; font-weight: 700;">Memuat Judul...</h2>
            <div style="display: flex; gap: 12px; align-items: center; font-size: 13px; color: rgba(255,255,255,0.8);">
                <span id="heroType" style="background: rgba(255,255,255,0.2); padding: 4px 10px; border-radius: 6px;">-</span>
                <span id="heroCode">Kode: -</span>
            </div>
        </div>
    </div>
    <div class="order-hero-bottom" style="background: white; border-top: 1px solid var(--prod-border);">
        <div><div class="hero-stat-label">Tanggal Pemesanan</div><div class="hero-stat-value" id="statDate">-</div></div>
        <div><div class="hero-stat-label">Pelanggan</div><div class="hero-stat-value" id="statCustomer">-</div></div>
        <div><div class="hero-stat-label">Total Harga</div><div class="hero-stat-value" id="statPrice">-</div></div>
        <div><div class="hero-stat-label">Status Pengerjaan</div><div class="hero-stat-value" id="statStatus">-</div></div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 400px; gap: 24px; align-items: start;">
    <!-- KOLOM KIRI (Kebutuhan & Stepper) -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <div class="tefa-card" style="padding: 24px; background: white;">
            <h3 style="font-size: 16px; margin-bottom: 4px;">Kebutuhan Pelanggan</h3>
            <p style="font-size: 13px; color: var(--prod-text-sec); margin-bottom: 24px;">Informasi permintaan dari pelanggan (read-only)</p>
            <div id="detNeedTitle" style="font-size: 15px; font-weight: 600; color: var(--prod-text-main); margin-bottom: 12px;"></div>
            <div id="detNeedDesc" style="font-size: 14px; line-height: 1.6; color: var(--prod-text-sec);">Memuat detail...</div>
        </div>

        <div class="tefa-card" style="padding: 24px; background: white;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <div>
                    <h3 style="font-size: 16px; margin-bottom: 4px;">Tahapan Pengerjaan</h3>
                    <p style="font-size: 13px; color: var(--prod-text-sec);" id="stepperSubtitle">0 dari 0 tahap selesai</p>
                </div>
                <!-- PERBAIKAN: Tombol Kelola Tahapan Diaktifkan -->
                <button type="button" onclick="openModalTahapan()" class="btn-outline" style="padding: 6px 12px; font-size: 13px; background: #F8FAFC; border-color: var(--prod-border); cursor: pointer;"><i class="ph ph-gear"></i> Kelola Tahapan</button>
            </div>
            
            <div class="stepper-container" id="stepperContainer"></div>
        </div>
    </div>

    <!-- KOLOM KANAN (Form Update Interaktif) -->
    <div class="tefa-card" style="padding: 24px; background: white; position: sticky; top: 24px;">
        <h3 style="font-size: 16px; margin-bottom: 4px;">Perbarui Progress</h3>
        <p style="font-size: 13px; color: var(--prod-text-sec); margin-bottom: 20px;" id="formSubtitle">Memperbarui: Tahap...</p>
        
        <div id="selectedStageBox" class="selected-stage-box" style="margin-bottom: 24px;">Pilih tahap pengerjaan...</div>

        <form id="formUpdateProgress">
            <input type="hidden" id="activeStageId">
            
            <label class="detail-label" style="font-weight: 600; color: var(--prod-text-main);">Status Tahap</label>
            <select id="updateStatus" class="form-control" style="margin-bottom: 24px; padding: 12px;" required disabled>
                <option value="Belum Dimulai">Belum Dimulai</option>
                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                <option value="Dalam Revisi">Dalam Revisi</option>
                <option value="Selesai">Selesai</option>
            </select>

            <div id="progressSliderBox" style="margin-bottom: 24px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 8px;">
                    <label class="detail-label" style="margin-bottom: 0; font-weight: 600; color: var(--prod-text-main);">Progress Pengerjaan</label>
                    <div style="font-weight: 700; color: var(--primary);" id="progressText">0%</div>
                </div>
                <input type="range" id="updateProgress" class="range-slider" min="0" max="100" value="0" disabled>
                <div style="display: flex; justify-content: space-between; font-size: 11px; color: var(--prod-text-sec); margin-top: 6px;">
                    <span>0%</span><span>100%</span>
                </div>
            </div>

            <label class="detail-label" style="font-weight: 600; color: var(--prod-text-main);">Catatan / Update</label>
            <textarea id="updateNote" class="form-control" rows="4" placeholder="Ketik catatan progres..." required disabled style="padding: 12px;"></textarea>

            <div style="display: flex; gap: 16px; margin-top: 16px;">
                <button type="button" class="btn-outline" style="flex: 1; padding: 12px;">Batal</button>
                <button type="submit" id="btnSimpanUpdate" class="btn-primary" style="flex: 2; padding: 12px;" disabled>Simpan Update</button>
            </div>
        </form>
    </div>
</div>

<!-- ================= MODAL KELOLA TAHAPAN (CRUD) ================= -->
<div id="modalKelolaTahapan" class="modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center;">
    <div class="modal-box" style="background: white; border-radius: 16px; width: 100%; max-width: 650px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 1px solid var(--prod-border); padding-bottom: 12px;">
            <div>
                <h3 style="font-size: 18px; font-weight: 700; color: var(--prod-text-main); margin-bottom: 2px;">Kelola Tahapan Pengerjaan</h3>
                <p style="font-size: 13px; color: var(--prod-text-sec);">Tambah, ubah, atau hapus tahapan untuk pesanan ini</p>
            </div>
            <button type="button" onclick="closeModalTahapan()" style="background: none; border: none; font-size: 20px; cursor: pointer; color: var(--prod-text-sec);"><i class="ph ph-x"></i></button>
        </div>

        <button type="button" onclick="openFormTambahTahap()" class="btn-primary" style="margin-bottom: 16px; padding: 10px 16px; font-size: 13px; width: auto;"><i class="ph ph-plus"></i> Tambah Tahap Baru</button>

        <div style="overflow-x: auto; border: 1px solid var(--prod-border); border-radius: 8px; margin-bottom: 20px;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 13px;">
                <thead>
                    <tr style="background: #F8FAFC; border-bottom: 1px solid var(--prod-border); color: var(--prod-text-sec);">
                        <th style="padding: 12px;">No</th>
                        <th style="padding: 12px;">Nama Tahap</th>
                        <th style="padding: 12px;">Status</th>
                        <th style="padding: 12px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabelTahapanBody">
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 20px; color: var(--prod-text-sec);">Memuat data tahapan...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="display: flex; justify-content: flex-end;">
            <button type="button" onclick="closeModalTahapan()" class="btn-outline" style="padding: 10px 20px;">Tutup</button>
        </div>
    </div>
</div>

<!-- SUB-MODAL FORM TAMBAH / EDIT TAHAP -->
<div id="modalFormTahap" class="modal-overlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.6); z-index: 1100; justify-content: center; align-items: center;">
    <div class="modal-box" style="background: white; border-radius: 16px; width: 100%; max-width: 450px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
        <h3 id="formTahapTitle" style="font-size: 16px; font-weight: 700; margin-bottom: 16px; color: var(--prod-text-main);">Tambah Tahap</h3>
        <form id="formSimpanTahap">
            <input type="hidden" id="editStageId">
            <label class="detail-label" style="font-weight: 600; color: var(--prod-text-main);">Nama Tahap Pengerjaan</label>
            <input type="text" id="inputNamaTahap" class="form-control" placeholder="Contoh: Desain UI/UX" required style="margin-bottom: 16px; padding: 10px;">
            
            <label class="detail-label" style="font-weight: 600; color: var(--prod-text-main);">Status Awal</label>
            <select id="inputStatusTahap" class="form-control" style="margin-bottom: 20px; padding: 10px;" required>
                <option value="Belum Dimulai">Belum Dimulai</option>
                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                <option value="Dalam Revisi">Dalam Revisi</option>
                <option value="Selesai">Selesai</option>
            </select>

            <div style="display: flex; gap: 12px;">
                <button type="button" onclick="closeFormTahap()" class="btn-outline" style="flex: 1; padding: 10px;">Batal</button>
                <button type="submit" class="btn-primary" style="flex: 2; padding: 10px;">Simpan Tahap</button>
            </div>
        </form>
    </div>
</div>

<div id="toastUpdate" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/produser-action.js') }}"></script>
@endsection