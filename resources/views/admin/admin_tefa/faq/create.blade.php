@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    {{-- Tombol Kembali --}}
    <div style="margin-bottom: 24px;">
        <a href="/tefa/faq" style="display: inline-block; padding: 8px 16px; border: 1px solid #3B698F; border-radius: 8px; color: #3B698F; background: #ffffff; text-decoration: none; font-weight: 600; font-size: 14px;">
            &larr; Kembali ke Kelola FAQ
        </a>
    </div>

    <h2 style="margin-bottom: 20px; color: #1E2D3D; font-size: 24px;">Tambah FAQ Baru</h2>

    {{-- Form Tambah FAQ dalam Card Putih --}}
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <!-- Action diset '#' sementara agar aman saat mendesain UI -->
        <form action="#" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="pertanyaan" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Pertanyaan</label>
                <input type="text" 
                       name="pertanyaan" 
                       id="pertanyaan" 
                       style="width: 100%; padding: 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; outline: none;" 
                       placeholder="Masukkan pertanyaan..." 
                       value="{{ old('pertanyaan') }}" 
                       required>
            </div>

            <div style="margin-bottom: 30px;">
                <label for="jawaban" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Jawaban</label>
                <textarea name="jawaban" 
                          id="jawaban" 
                          rows="5" 
                          style="width: 100%; padding: 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; resize: vertical; outline: none;" 
                          placeholder="Masukkan jawaban..." 
                          required>{{ old('jawaban') }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="background: #3B698F; color: white; padding: 10px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px;">
                    Simpan FAQ
                </button>
                <a href="/tefa/faq" style="text-decoration: none; padding: 10px 24px; border: 1px solid #CBD5E1; border-radius: 8px; color: #64748B; background: #F8FAFC; font-weight: 600; font-size: 14px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection