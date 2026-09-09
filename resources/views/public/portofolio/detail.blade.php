@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-detail.css') }}">
@endpush

@section('content')

<div class="detail-page-wrapper">
    <!-- Tombol Kembali -->
    <div style="max-width: 1200px; margin: 0 auto;">
        <a href="/jurusan/{{ $jurusan->slug ?? 'rpl' }}/portofolio" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali ke Portofolio
        </a>
    </div>

    <!-- Bagian Atas: Gambar & Judul Karya -->
    <div class="detail-top-container">
        <div class="detail-gallery">
            <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Karya+Portofolio" class="main-image" alt="Foto Karya">
            <div class="thumbnail-list">
                <img src="https://placehold.co/800x600/E2E8F0/1E3A8A?text=Detail+1" class="thumb-item active" alt="Thumb 1">
                <img src="https://placehold.co/800x600/CBD5E1/1E3A8A?text=Detail+2" class="thumb-item" alt="Thumb 2">
            </div>
        </div>

        <div class="detail-info">
            <div class="detail-badge" style="background: #16A34A; color: white;">KARYA SISWA</div>
            <!-- Gunakan variabel $portofolio->judul -->
            <h1 class="detail-title">IoT Untuk Irigasi Cerdas</h1>
            
            <!-- Menghapus tombol Pesan Sekarang, diganti dengan Info Singkat Karya -->
            <div style="margin-top: 24px; display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; gap: 12px; align-items: center;">
                    <div style="background: #F1F5F9; padding: 12px; border-radius: 8px; color: #1E3A8A;">
                        <i class="ph ph-calendar-blank" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; color: #64748B;">Tahun Pembuatan</div>
                        <!-- Gunakan variabel $portofolio->tahun -->
                        <div style="font-size: 16px; font-weight: 600; color: #1E2D3D;">2026</div>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px; align-items: center;">
                    <div style="background: #F1F5F9; padding: 12px; border-radius: 8px; color: #1E3A8A;">
                        <i class="ph ph-users" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <div style="font-size: 13px; color: #64748B;">Kreator / Tim Pembuat</div>
                        <!-- Gunakan variabel $portofolio->kreator -->
                        <div style="font-size: 16px; font-weight: 600; color: #1E2D3D;">Tim Robotik TEFA RPL</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Bawah: Deskripsi Karya -->
    <div class="detail-card">
        <h2 class="detail-section-title">Latar Belakang Proyek</h2>
        <!-- Gunakan variabel $portofolio->deskripsi -->
        <p class="detail-text">Sistem pengairan otomatis berbasis Internet of Things (IoT) ini dirancang khusus untuk membantu petani lokal di daerah Bintan dalam mengelola lahan pertanian modern. Sistem ini dapat memantau kelembaban tanah dan suhu udara secara real-time, lalu menyiram tanaman secara otomatis apabila tanah mulai mengering.</p>

        <h2 class="detail-section-title">Teknologi & Fitur Utama</h2>
        <ul class="detail-list">
            <li><i class="ph ph-cpu"></i> Menggunakan Mikrokontroler ESP32</li>
            <li><i class="ph ph-drop"></i> Sensor Kelembaban Tanah & Sensor DHT11 (Suhu)</li>
            <li><i class="ph ph-device-mobile"></i> Terintegrasi dengan Aplikasi Mobile (Flutter) untuk monitoring</li>
            <li><i class="ph ph-plugs"></i> Sistem pompa air otomatis yang hemat energi</li>
        </ul>

        <h2 class="detail-section-title">Pencapaian</h2>
        <div style="background: #FFFBEB; border-left: 4px solid #D97706; padding: 16px; border-radius: 0 8px 8px 0;">
            <p style="margin: 0; font-size: 15px; color: #92400E; font-weight: 500;">🏆 Meraih Juara 1 dalam Lomba Inovasi Teknologi Tepat Guna Tingkat Provinsi Kepulauan Riau Tahun 2026.</p>
        </div>
    </div>
</div>
@endsection