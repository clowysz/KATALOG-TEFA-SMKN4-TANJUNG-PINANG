@extends('layouts.app-produser')

@section('title', 'Detail Pesanan')

@section('content')
<div style="margin-bottom: 24px;">
    <a href="/produser/pesanan" class="btn-outline" style="border: none; padding-left: 0; color: white; background: var(--prod-text-sec); padding: 8px 16px; border-radius: 8px; text-decoration: none;"><i class="ph ph-arrow-left"></i> Kembali ke Daftar</a>
</div>

<!-- KOTAK BIRU (HERO CARD) YANG SUDAH DIPERBAIKI -->
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
                <button class="btn-outline" style="padding: 6px 12px; font-size: 13px; background: #F8FAFC; border-color: var(--prod-border);">Kelola Tahapan</button>
            </div>
            
            <!-- Tempat Stepper Interaktif Muncul -->
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

            <!-- Box Progress Slider (Otomatis muncul/hilang) -->
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

<div id="toastUpdate" class="toast-notification"></div>
@endsection

@section('scripts')
<script src="{{ asset('js/produser-action.js') }}"></script>
@endsection