@extends('admin.layouts.app')

@section('title', 'Kelola FAQ')

@section('content')

<!-- CSS KHUSUS HALAMAN FAQ ADMIN -->
<style>
    .faq-container { margin-top: 10px; }
    .faq-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
    .faq-header h2 { font-size: 20px; font-weight: bold; color: #1e293b; margin-bottom: 4px; }
    .faq-header p { color: #64748b; font-size: 14px; margin: 0; }
    
    .btn-add-faq { background: #3B698F; color: white; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }
    .btn-add-faq:hover { background: #4a82b0; color: white; }
    
    .faq-list { display: flex; flex-direction: column; gap: 16px; }
    .faq-card { 
        display: flex; background: #ffffff; padding: 20px; border-radius: 12px; 
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; 
        gap: 20px; align-items: flex-start; 
    }
    
    .faq-number { 
        font-size: 20px; font-weight: 800; color: #3B698F; background: #EBF3F9; 
        width: 48px; height: 48px; display: flex; align-items: center; 
        justify-content: center; border-radius: 12px; flex-shrink: 0; 
    }
    
    .faq-content { flex-grow: 1; }
    .faq-content h4 { font-size: 16px; color: #1e293b; margin-bottom: 8px; line-height: 1.4; margin-top: 0; }
    .faq-content p { font-size: 14px; color: #64748b; line-height: 1.6; margin: 0; }
    
    .faq-actions { display: flex; gap: 10px; flex-shrink: 0; align-items: center; }
    
    .btn-edit-faq { 
        padding: 8px 16px; border: 1px solid #3B698F; color: #3B698F; 
        border-radius: 6px; text-decoration: none; font-size: 13px; font-weight: 600; 
    }
    .btn-edit-faq:hover { background: #3B698F; color: white; }
    
    .btn-delete-faq { 
        padding: 8px 16px; border: 1px solid #dc3545; color: #dc3545; 
        background: transparent; border-radius: 6px; cursor: pointer; 
        font-size: 13px; font-weight: 600; 
    }
    .btn-delete-faq:hover { background: #dc3545; color: white; }
</style>

<!-- ==========================================
     DATA DUMMY SEMENTARA PENGGANTI DATABASE
     ========================================== -->
@php
$faqs = [
    (object)[
        'id' => 1,
        'pertanyaan' => 'Bagaimana cara memesan produk di TEFA SMKN 4 Tanjungpinang?',
        'jawaban' => 'Anda dapat memilih produk atau jasa pada katalog jurusan, lalu menekan tombol "Pesan" untuk melanjutkan ke proses checkout.'
    ],
    (object)[
        'id' => 2,
        'pertanyaan' => 'Berapa lama estimasi pengerjaan pesanan jasa?',
        'jawaban' => 'Waktu pengerjaan bergantung pada tingkat kesulitan dan antrean di masing-masing jurusan. Admin akan mengonfirmasi estimasi waktu setelah pesanan masuk.'
    ]
];
@endphp

<div class="faq-container">
    {{-- Header Halaman --}}
    <div class="faq-header">
        <div>
            <h2>Kelola FAQ</h2>
            <p>Informasi umum mengenai website dan layanan TEFA</p>
        </div>
        <!-- Menggunakan URL sementara '#' agar tidak error route not defined -->
        <a href="/buat/fah" class="btn-add-faq">
            + Tambah FAQ
        </a>
    </div>

    {{-- Daftar Card FAQ --}}
    <div class="faq-list">
        @forelse($faqs as $index => $faq)
            <div class="faq-card">
                {{-- Nomor Urut --}}
                <div class="faq-number">
                    {{ $index + 1 }}
                </div>

                {{-- Konten FAQ --}}
                <div class="faq-content">
                    <h4>{{ $faq->pertanyaan }}</h4>
                    <p>{{ $faq->jawaban }}</p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="faq-actions">
                    <a href="#" class="btn-edit-faq">
                        Edit
                    </a>

                    <form action="/tefa/faq" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-faq">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="faq-card" style="justify-content: center;">
                <p style="color: #6c757d; margin: 0;">Belum ada data FAQ.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection