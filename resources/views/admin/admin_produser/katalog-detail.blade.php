@extends('admin.layouts.app-produser')

@section('title', 'Detail Produk/Jasa')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 2rem; font-family: 'Inter', -apple-system, sans-serif;">

<!-- Navigation Header -->
    <div style="margin-bottom: 16px;">
        <a href="{{ route('admin.produser.katalog') }}" style="display: inline-flex; align-items: center; gap: 10px; color: #1e6091; background: #ffffff; font-size: 14px; font-weight: 500; text-decoration: none; padding: 8px 20px; border-radius: 12px; border: 1px solid #d0d7de; transition: all 0.2s ease;">
             <i class="ph ph-arrow-left" style="font-size: 18px; color: #1e6091;"></i> Kembali ke Katalog
        </a>
    </div>

    <!-- Hero / Detail Card -->
    <div class="tefa-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; margin-bottom: 24px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03); padding: 20px;">
        
        <!-- Header Gambar Utama (Full Cover, tanpa gap) -->
        <div id="mainImageContainer" style="width: 100%; height: 320px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 0;">
            @if($produkJasa->gambars->first())
                <img id="detKatalogImg" src="{{ asset('storage/'.$produkJasa->gambars->first()->path_gambar) }}" alt="{{ $produkJasa->nama_produk_jasa }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
            @else
                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #64748b; gap: 8px;">
                    <i class="ph ph-image" style="font-size: 48px;"></i>
                    <span style="font-size: 13px;">Tidak ada gambar</span>
                </div>
            @endif
        </div>

        <!-- Thumbnail Galeri -->
        @if($produkJasa->gambars->count() > 1)
            <div id="thumbnailContainer" style="display: flex; gap: 10px; justify-content: center; padding: 12px 0 0 0; overflow-x: auto;">
                @foreach($produkJasa->gambars as $index => $gambar)
                    <img src="{{ asset('storage/'.$gambar->path_gambar) }}" alt="{{ $produkJasa->nama_produk_jasa }}" class="detail-thumbnail" data-image="{{ asset('storage/'.$gambar->path_gambar) }}" style="width: 56px; height: 56px; object-fit: cover; border-radius: 8px; cursor: pointer; border: {{ $index === 0 ? '2px solid var(--primary, #2563eb)' : '1px solid #cbd5e1' }}; transition: all 0.2s ease;">
                @endforeach
            </div>
        @endif

        <!-- Judul & Tag Produk -->
        <div style="margin-top: 16px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">
            <div style="display: flex; gap: 8px; margin-bottom: 8px; flex-wrap: wrap;">
                <span style="background: #e2e8f0; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; letter-spacing: 0.3px;">
                    {{ ucfirst($produkJasa->jenis) }}
                </span>
                <span style="background: #1e3a8a; color: #ffffff; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 600; letter-spacing: 0.3px;">
                    ID: {{ $produkJasa->id_produk_jasa }}
                </span>
            </div>

            <h2 style="font-size: 20px; font-weight: 800; margin: 0; color: #0f172a; line-height: 1.3;">
                {{ $produkJasa->nama_produk_jasa }}
            </h2>
        </div>

        <!-- Informasi Utama Grid -->
        <div style="padding-top: 20px;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #e2e8f0;">
                
                <div style="background: #f8fafc; padding: 12px 16px; border-radius: 10px; border: 1px solid #f1f5f9;">
                    <div style="font-size: 11px; color: var(--prod-text-sec, #64748b); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px;">Jenis</div>
                    <div style="font-size: 15px; font-weight: 700; color: #0f172a;">{{ ucfirst($produkJasa->jenis) }}</div>
                </div>

                <div style="background: #f8fafc; padding: 12px 16px; border-radius: 10px; border: 1px solid #f1f5f9;">
                    <div style="font-size: 11px; color: var(--prod-text-sec, #64748b); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px;">Harga</div>
                    <div style="color: var(--primary, #2563eb); font-size: 17px; font-weight: 800;">
                        Rp {{ number_format($produkJasa->harga, 0, ',', '.') }}
                    </div>
                </div>

                <div style="background: #f8fafc; padding: 12px 16px; border-radius: 10px; border: 1px solid #f1f5f9;">
                    <div style="font-size: 11px; color: var(--prod-text-sec, #64748b); text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px; margin-bottom: 2px;">Jumlah Pesanan</div>
                    <div style="color: #d97706; font-size: 17px; font-weight: 800;">
                        {{ $produkJasa->pesanans->count() }}
                    </div>
                </div>

            </div>

            <!-- Detail Jurusan -->
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 4px; font-weight: 700;">Jurusan</h3>
                <div style="font-size: 14px; font-weight: 600; color: var(--prod-text-main, #1e293b);">
                    {{ $produkJasa->jurusan->nama_jurusan ?? '-' }}
                </div>
            </div>

            <!-- Detail Deskripsi -->
            <div>
                <h3 style="font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; margin-bottom: 6px; font-weight: 700;">Deskripsi</h3>
                <div style="font-size: 13.5px; color: var(--prod-text-sec, #334155); line-height: 1.6; white-space: pre-line; background: #fafafa; padding: 14px; border-radius: 8px; border: 1px solid #f1f5f9;">
                    {{ $produkJasa->deskripsi ?: 'Tidak ada deskripsi.' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Table Pesanan Terkait -->
    <div class="tefa-card" style="padding: 20px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03);">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
            <h3 style="font-size: 16px; margin: 0; font-weight: 800; color: #0f172a;">
                Pesanan Terkait 
                <span style="font-size: 13px; font-weight: 600; color: #64748b; background: #f1f5f9; padding: 2px 8px; border-radius: 10px; margin-left: 6px;">
                    {{ $produkJasa->pesanans->count() }}
                </span>
            </h3>
        </div>

        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table-modern" style="width: 100%; border-collapse: separate; border-spacing: 0;">
                <thead>
                    <tr>
                        <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left;">Order ID</th>
                        <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left;">Jumlah</th>
                        <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left;">Status Pengerjaan</th>
                        <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: left;">Status Pesanan</th>
                        <th style="background: #f8fafc; border-bottom: 2px solid #e2e8f0; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; text-align: center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($produkJasa->pesanans as $pesanan)
                        @php
                            $progressTerakhir = $pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                            $persentase = $progressTerakhir->persentase_progress ?? 0;
                        @endphp

                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 14px; vertical-align: middle;">
                                <div style="font-weight: 700; color: var(--prod-text-main, #0f172a); font-size: 13px;">
                                    #{{ $pesanan->id_pesanan }}
                                </div>

                                @if($pesanan->tanggal_pesan)
                                    <div style="font-size: 11px; color: var(--prod-text-sec, #64748b); margin-top: 2px;">
                                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                                    </div>
                                @endif
                            </td>

                            <td style="padding: 12px 14px; vertical-align: middle;">
                                <span style="font-weight: 600; color: var(--prod-text-main, #1e293b); font-size: 13px;">
                                    {{ $pesanan->jumlah }} item
                                </span>
                            </td>

                            <td style="padding: 12px 14px; vertical-align: middle;">
                                <div style="min-width: 130px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                                        <span style="font-size: 11px; color: var(--prod-text-sec, #64748b); font-weight: 500;">Progress</span>
                                        <span style="font-size: 11px; font-weight: 700; color: var(--prod-text-main, #0f172a);">
                                            {{ $persentase }}%
                                        </span>
                                    </div>

                                    <div style="width: 100%; height: 6px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                                        <div style="width: {{ $persentase }}%; height: 100%; background: var(--primary, #2563eb); border-radius: 10px; transition: width 0.3s ease;"></div>
                                    </div>
                                </div>
                            </td>

                            <td style="padding: 12px 14px; vertical-align: middle;">
                                <span style="display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; background: #f1f5f9; color: var(--prod-text-main, #334155); text-transform: capitalize;">
                                    {{ ucfirst($pesanan->status) }}
                                </span>
                            </td>

                            <td style="padding: 12px 14px; vertical-align: middle; text-align: center;">
                                <a href="{{ route('admin.produser.pesanan.detail', $pesanan->id_pesanan) }}" style="display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 6px 12px; border-radius: 6px; text-decoration: none; background: var(--primary, #2563eb); color: #ffffff; font-size: 12px; font-weight: 600; transition: all 0.2s ease;">
                                    <i class="ph ph-eye" style="font-size: 14px;"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 36px 16px; color: var(--prod-text-sec, #64748b);">
                                <i class="ph ph-receipt" style="font-size: 40px; color: #cbd5e1; margin-bottom: 6px; display: block;"></i>
                                <p style="margin: 0; font-size: 13px; font-weight: 500;">Belum ada pesanan untuk produk/jasa ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const mainImg = document.getElementById('detKatalogImg');
    const thumbnails = document.querySelectorAll('.detail-thumbnail');

    thumbnails.forEach(function(thumb){
        thumb.addEventListener('click', function(){
            if(!mainImg) return;

            mainImg.src = this.dataset.image;

            thumbnails.forEach(function(item){
                item.style.border = '1px solid #cbd5e1';
            });

            this.style.border = '2px solid var(--primary, #2563eb)';
        });
    });
});
</script>
@endpush