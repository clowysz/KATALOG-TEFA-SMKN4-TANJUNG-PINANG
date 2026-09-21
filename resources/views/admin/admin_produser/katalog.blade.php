@extends('admin.layouts.app-produser')

@section('title','Produk/Jasa Saya')

@section('content')
<div style="margin-bottom:24px;">
    <h2 style="font-size:24px;color:var(--prod-text-main);margin-bottom:8px;font-weight:700;">Produk/Jasa Saya</h2>
    <p style="color:var(--prod-text-sec);font-size:14px;">Daftar layanan yang menjadi tanggung jawab pengelolaan Anda.</p>
</div>

<div style="margin-bottom:24px;position:relative;max-width:400px;">
    <i class="ph ph-magnifying-glass" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--prod-text-sec);font-size:18px;"></i>
    <input type="text" id="searchKatalogProduser" class="form-control" placeholder="Cari nama produk atau jasa..." style="width:100%;padding-left:44px;border-radius:8px;">
</div>

<div id="katalogContainer" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:24px;">
    @forelse($produkJasas as $produk)
        @php
            $gambar=$produk->gambars->first();
            $jumlahPesanan=$produk->pesanans->count();
        @endphp

        <div class="katalog-item tefa-card" style="padding:0;background:white;border-radius:12px;overflow:hidden;border:1px solid var(--prod-border);">
            <div style="height:190px;background:#F1F5F9;overflow:hidden;position:relative;">
                @if($gambar)
                    <img src="{{ asset('storage/'.$gambar->path_gambar) }}" alt="{{ $produk->nama_produk_jasa }}" style="width:100%;height:100%;object-fit:cover;">
                @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:var(--prod-text-sec);">
                        <i class="ph ph-image" style="font-size:48px;"></i>
                    </div>
                @endif

                <span style="position:absolute;top:12px;left:12px;background:rgba(255,255,255,.92);color:var(--prod-text-main);padding:5px 10px;border-radius:6px;font-size:12px;font-weight:600;">
                    {{ ucfirst($produk->jenis) }}
                </span>
            </div>

            <div style="padding:20px;">
                <div style="font-size:12px;color:var(--prod-text-sec);margin-bottom:6px;">
                    {{ $produk->jurusan->nama_jurusan ?? '-' }}
                </div>

                <h3 style="font-size:17px;color:var(--prod-text-main);font-weight:700;margin-bottom:8px;">
                    {{ $produk->nama_produk_jasa }}
                </h3>

                <p style="font-size:13px;color:var(--prod-text-sec);line-height:1.6;margin-bottom:16px;">
                    {{ \Illuminate\Support\Str::limit($produk->deskripsi,100) }}
                </p>

                <div style="display:flex;justify-content:space-between;align-items:end;gap:12px;margin-bottom:16px;">
                    <div>
                        <div style="font-size:11px;color:var(--prod-text-sec);margin-bottom:3px;">Harga</div>
                        <div style="font-size:17px;color:var(--primary);font-weight:700;">
                            Rp {{ number_format($produk->harga,0,',','.') }}
                        </div>
                    </div>

                    <div style="text-align:right;">
                        <div style="font-size:11px;color:var(--prod-text-sec);margin-bottom:3px;">Pesanan</div>
                        <div style="font-size:14px;color:var(--prod-text-main);font-weight:600;">
                            {{ $jumlahPesanan }}
                        </div>
                    </div>
                </div>

                <a href="{{ route('admin.produser.katalog.detail',$produk->id_produk_jasa) }}" style="display:flex;align-items:center;justify-content:center;gap:6px;width:100%;padding:10px 14px;border-radius:8px;text-decoration:none;background:var(--primary);color:white;font-size:13px;font-weight:600;">
                    <i class="ph ph-eye"></i>
                    Lihat Detail
                </a>
            </div>
        </div>
    @empty
        <div style="grid-column:1/-1;text-align:center;padding:60px 20px;background:white;border-radius:12px;border:1px solid var(--prod-border);">
            <i class="ph ph-folder-open" style="font-size:48px;color:var(--prod-text-sec);margin-bottom:16px;"></i>
            <h3 style="color:var(--prod-text-main);margin-bottom:8px;">Belum Ada Produk/Jasa</h3>
            <p style="color:var(--prod-text-sec);font-size:14px;">Belum ada produk atau jasa yang ditugaskan kepada Anda.</p>
        </div>
    @endforelse
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const search=document.getElementById('searchKatalogProduser');
    const items=document.querySelectorAll('.katalog-item');

    if(!search)return;

    search.addEventListener('input',function(){
        const keyword=this.value.toLowerCase().trim();

        items.forEach(function(item){
            item.style.display=item.textContent.toLowerCase().includes(keyword)?'':'none';
        });
    });
});
</script>
@endpush