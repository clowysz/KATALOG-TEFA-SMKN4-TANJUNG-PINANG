@extends('admin.layouts.app')

@section('title', 'Tambah FAQ')

@section('content')
<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    {{-- Link Kembali --}}
    <div style="margin-bottom: 15px;">
        <a href="{{ route('faq.index') }}" style="text-decoration: none; color: #3B82F6; font-weight: 500;">
            ← Kembali ke Kelola FAQ
        </a>
    </div>

    <h2 style="margin-bottom: 20px; color: #1E2D3D; font-size: 24px;">Tambah FAQ Baru</h2>

    {{-- Form Tambah FAQ dalam Card Putih --}}
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <form action="{{ route('faq.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="pertanyaan" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Pertanyaan</label>
                <input type="text" 
                       name="pertanyaan" 
                       id="pertanyaan" 
                       style="width: 100%; padding: 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px;" 
                       placeholder="Masukkan pertanyaan..." 
                       value="{{ old('pertanyaan') }}" 
                       required>
            </div>

            <div style="margin-bottom: 30px;">
                <label for="jawaban" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1E2D3D;">Jawaban</label>
                <textarea name="jawaban" 
                          id="jawaban" 
                          rows="5" 
                          style="width: 100%; padding: 12px; border: 1px solid #CBD5E1; border-radius: 8px; font-size: 14px; resize: vertical;" 
                          placeholder="Masukkan jawaban..." 
                          required>{{ old('jawaban') }}</textarea>
            </div>

            <div style="display: flex; gap: 12px; align-items: center;">
                <button type="submit" style="background: #1E3A8A; color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px;">
                    Simpan FAQ
                </button>
                <a href="{{ route('faq.index') }}" style="text-decoration: none; padding: 12px 20px; border: 1px solid #CBD5E1; border-radius: 8px; color: #64748B; background: #F8FAFC; font-weight: 500; font-size: 14px;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection