@extends('admin.layouts.app')

@section('title', 'Edit FAQ')

@section('content')
<style>
    /* Mengatur jarak halaman */
    .page-header { margin-top: 16px; margin-bottom: 24px; }
    
    /* Tombol Kembali */
    .btn-back { 
        display: inline-flex; align-items: center; gap: 8px; 
        background: #ffffff; color: #3B698F; 
        padding: 8px 16px; border-radius: 8px; 
        border: 1px solid #3B698F; text-decoration: none; 
        font-weight: 600; font-size: 14px; 
        margin-bottom: 24px; margin-top: 10px;
        transition: all 0.3s;
    }
    .btn-back:hover { background: #3B698F; color: #ffffff; }

    /* Desain Kotak Form */
    .tefa-form-card { 
        background: #ffffff; border-radius: 12px; padding: 24px; 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); 
        border: 1px solid #f1f5f9; 
    }
    
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-weight: 600; color: #1e293b; margin-bottom: 8px; }
    
    .form-control { 
        width: 100%; padding: 12px 14px; 
        border: 1px solid #cbd5e1; border-radius: 8px; 
        font-size: 14px; color: #334155; 
    }
    .form-control:focus { 
        outline: none; border-color: #3B698F; 
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1); 
    }
    
    .form-actions { display: flex; gap: 12px; margin-top: 24px; }
    
    /* Tombol Simpan (Warna disamakan dengan Tambah Akun) */
    .btn-primary { 
        background: #3B698F; color: white; 
        padding: 10px 24px; border-radius: 8px; 
        border: none; cursor: pointer; 
        font-weight: 600; font-size: 14px; 
    }
    .btn-primary:hover { background: #2c5270; }
    
    /* Tombol Batal */
    .btn-secondary { 
        background: #f8fafc; color: #475569; 
        padding: 10px 24px; border-radius: 8px; 
        border: 1px solid #cbd5e1; text-decoration: none; 
        font-weight: 600; font-size: 14px; cursor: pointer; 
    }
    .btn-secondary:hover { background: #e2e8f0; color: #1e293b; }
</style>

<!-- Tombol Kembali ke Kelola FAQ -->
<a href="/tefa/faq" class="btn-back">
    &larr; Kembali ke Kelola FAQ
</a>

<div class="page-header">
    <h2 style="font-size: 24px; font-weight: bold; color: #1e293b;">Edit FAQ</h2>
</div>

<div class="tefa-form-card">
    <!-- Action diset '#' sementara agar aman saat mendesain UI -->
    <form action="#" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label" for="pertanyaan">Pertanyaan</label>
            <input type="text" 
                   name="pertanyaan" 
                   id="pertanyaan" 
                   class="form-control" 
                   placeholder="Masukkan pertanyaan..." 
                   value="{{ old('pertanyaan', $faq->pertanyaan ?? 'Ini contoh pertanyaan dummy?') }}" 
                   required>
        </div>

        <div class="form-group">
            <label class="form-label" for="jawaban">Jawaban</label>
            <textarea name="jawaban" 
                      id="jawaban" 
                      rows="5" 
                      class="form-control" 
                      placeholder="Masukkan jawaban..." 
                      required>{{ old('jawaban', $faq->jawaban ?? 'Ini adalah contoh jawaban sementara agar tampilan bisa dilihat sebelum dihubungkan ke database.') }}</textarea>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="/tefa/faq" class="btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection