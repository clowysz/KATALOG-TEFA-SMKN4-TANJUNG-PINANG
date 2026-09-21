@extends('admin.layouts.app-produser')

@section('title','Detail Produk/Jasa')

@section('content')
<div style="margin-bottom:24px;">
    <a href="{{ route('admin.produser.katalog') }}" class="btn-outline" style="border:none;padding-left:0;color:white;background:var(--prod-text-sec);padding:8px 16px;border-radius:8px;text-decoration:none;">
        <i class="ph ph-arrow-left"></i> Kembali ke Katalog
    </a>
</div>

<div class="tefa-card" style="padding:0;background:white;margin-bottom:24px;overflow:hidden;border-radius:12px;">
    <div style="background:#0F172A;position:relative;overflow:hidden;border-top-left-radius:12px;border-top-right-radius:12px;">
        <div id="mainImageContainer" style="width:100%;height:420px;background:#000;display:flex;align-items:center;justify-content:center;overflow:hidden;">
            @if($produkJasa->gambars->first())
                <img id="detKatalogImg" src="{{ asset('storage/'.$produkJasa->gambars->first()->path_gambar) }}" alt="{{ $produkJasa->nama_produk_jasa }}" style="width:100%;height:100%;object-fit:cover;">
            @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#94A3B8;">
                    <i class="ph ph-image" style="font-size:64px;"></i>
                </div>
            @endif
        </div>

        <div style="position:absolute;bottom:0;left:0;width:100%;padding:24px;background:linear-gradient(to top,rgba(0,0,0,.85) 0%,rgba(0,0,0,.4) 60%,transparent 100%);color:white;display:flex;flex-direction:column;justify-content:flex-end;">
            <div style="display:flex;gap:8px;margin-bottom:8px;">
                <span style="background:rgba(255,255,255,.2);backdrop-filter:blur(4px);color:white;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;">
                    {{ ucfirst($produkJasa->jenis) }}
                </span>
                <span style="background:#1E3A8A;color:white;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;">
                    ID: {{ $produkJasa->id_produk_jasa }}
                </span>
            </div>

            <h2 style="font-size:28px;font-weight:700;margin:0;color:#fff;text-shadow:0 2px 4px rgba(0,0,0,.5);">
                {{ $produkJasa->nama_produk_jasa }}
            </h2>
        </div>
    </div>

    @if($produkJasa->gambars->count()>1)
        <div id="thumbnailContainer" style="display:flex;gap:10px;justify-content:center;padding:12px 16px;background:transparent;overflow-x:auto;border-bottom:1px solid #f4f5f6;">
            @foreach($produkJasa->gambars as $index=>$gambar)
                <img src="{{ asset('storage/'.$gambar->path_gambar) }}" alt="{{ $produkJasa->nama_produk_jasa }}" class="detail-thumbnail" data-image="{{ asset('storage/'.$gambar->path_gambar) }}" style="width:70px;height:70px;object-fit:cover;border-radius:8px;cursor:pointer;border:{{ $index===0 ? '2px solid var(--primary)' : '1px solid #CBD5E1' }};transition:.2s;">
            @endforeach
        </div>
    @endif

    <div style="padding:32px;">
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:32px;padding-bottom:24px;border-bottom:1px solid #E2E8F0;align-items:center;">
            <div>
                <div style="font-size:12px;color:var(--prod-text-sec);text-transform:uppercase;font-weight:600;margin-bottom:4px;">Jenis</div>
                <div style="font-size:16px;font-weight:600;">{{ ucfirst($produkJasa->jenis) }}</div>
            </div>

            <div>
                <div style="font-size:12px;color:var(--prod-text-sec);text-transform:uppercase;font-weight:600;margin-bottom:4px;">Harga</div>
                <div style="color:var(--primary);font-size:20px;font-weight:700;">
                    Rp {{ number_format($produkJasa->harga,0,',','.') }}
                </div>
            </div>

            <div>
                <div style="font-size:12px;color:var(--prod-text-sec);text-transform:uppercase;font-weight:600;margin-bottom:4px;">Jumlah Pesanan</div>
                <div style="color:#D8893D;font-size:20px;font-weight:700;">
                    {{ $produkJasa->pesanans->count() }}
                </div>
            </div>
        </div>

        <div style="margin-bottom:24px;">
            <h3 style="font-size:15px;color:var(--prod-text-main);margin-bottom:8px;font-weight:700;">Jurusan</h3>
            <div style="font-size:14px;color:var(--prod-text-sec);">
                {{ $produkJasa->jurusan->nama_jurusan ?? '-' }}
            </div>
        </div>

        <div>
            <h3 style="font-size:15px;color:var(--prod-text-main);margin-bottom:12px;font-weight:700;">Deskripsi</h3>
            <div style="font-size:14px;color:var(--prod-text-sec);line-height:1.7;white-space:pre-line;">
                {{ $produkJasa->deskripsi ?: 'Tidak ada deskripsi.' }}
            </div>
        </div>
    </div>
</div>

<div class="tefa-card" style="padding:24px;background:white;border-radius:12px;">
    <h3 style="font-size:16px;margin-bottom:16px;font-weight:700;">
        Pesanan Terkait ({{ $produkJasa->pesanans->count() }})
    </h3>

    <div class="table-responsive">
        <table class="table-modern" style="width:100%;">
            <thead>
                <tr>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Order ID</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Jumlah</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Status Pengerjaan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Status Pesanan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($produkJasa->pesanans as $pesanan)
                    @php
                        $progressTerakhir=$pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                        $persentase=$progressTerakhir->persentase_progress??0;
                    @endphp

                    <tr>
                        <td>
                            <div style="font-weight:700;color:var(--prod-text-main);">
                                #{{ $pesanan->id_pesanan }}
                            </div>

                            @if($pesanan->tanggal_pesan)
                                <div style="font-size:12px;color:var(--prod-text-sec);margin-top:4px;">
                                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d/m/Y') }}
                                </div>
                            @endif
                        </td>

                        <td>
                            <span style="font-weight:600;color:var(--prod-text-main);">
                                {{ $pesanan->jumlah }} item
                            </span>
                        </td>

                        <td>
                            <div style="min-width:120px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">
                                    <span style="font-size:12px;color:var(--prod-text-sec);">Progress</span>
                                    <span style="font-size:12px;font-weight:700;color:var(--prod-text-main);">
                                        {{ $persentase }}%
                                    </span>
                                </div>

                                <div style="width:100%;height:7px;background:#E5E7EB;border-radius:10px;overflow:hidden;">
                                    <div style="width:{{ $persentase }}%;height:100%;background:var(--primary);border-radius:10px;"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span style="display:inline-block;padding:6px 10px;border-radius:20px;font-size:12px;font-weight:600;background:#F1F5F9;color:var(--prod-text-main);">
                                {{ ucfirst($pesanan->status) }}
                            </span>
                        </td>

                        <td style="text-align:center;">
                            <a href="{{ route('admin.produser.pesanan.detail',$pesanan->id_pesanan) }}" style="display:inline-flex;align-items:center;justify-content:center;gap:6px;padding:8px 12px;border-radius:8px;text-decoration:none;background:var(--primary);color:white;font-size:13px;font-weight:600;">
                                <i class="ph ph-eye"></i>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:50px 20px;color:var(--prod-text-sec);">
                            <i class="ph ph-receipt" style="font-size:42px;"></i>
                            <p style="margin:12px 0 0;font-size:14px;">Belum ada pesanan untuk produk/jasa ini.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const mainImg=document.getElementById('detKatalogImg');
    const thumbnails=document.querySelectorAll('.detail-thumbnail');

    thumbnails.forEach(function(thumb){
        thumb.addEventListener('click',function(){
            if(!mainImg)return;

            mainImg.src=this.dataset.image;

            thumbnails.forEach(function(item){
                item.style.border='1px solid #CBD5E1';
            });

            this.style.border='2px solid var(--primary)';
        });
    });
});
</script>
@endpush