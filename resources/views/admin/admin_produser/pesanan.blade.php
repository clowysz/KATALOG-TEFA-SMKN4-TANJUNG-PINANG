@extends('admin.layouts.app-produser')

@section('title','Pesanan Terkait')

@section('content')
<div style="margin-bottom:24px;">
    <h2 style="font-size:24px;color:var(--prod-text-main);margin-bottom:8px;font-weight:700;">Pesanan Terkait</h2>
    <p style="color:var(--prod-text-sec);font-size:14px;">Daftar semua pesanan untuk produk dan jasa yang Anda tangani.</p>
</div>

<div class="tefa-card" style="padding:24px;background:white;border-radius:12px;">
    <div style="margin-bottom:24px;position:relative;">
        <i class="ph ph-magnifying-glass" style="position:absolute;left:16px;top:50%;transform:translateY(-50%);color:var(--prod-text-sec);font-size:18px;"></i>
        <input type="text" id="searchPesanan" class="form-control" placeholder="Cari produk, jasa, atau pesanan..." style="width:100%;max-width:400px;margin-bottom:0;padding-left:44px;border-radius:8px;">
    </div>

    <div class="table-responsive">
        <table class="table-modern" style="width:100%;">
            <thead>
                <tr>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Order ID</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Produk/Jasa</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Jumlah</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Status Pengerjaan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);">Status Pesanan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);text-align:center;">Aksi</th>
                </tr>
            </thead>

            <tbody id="allOrderTable">
                @forelse($pesanans as $pesanan)
                    @php
                        $progressTerakhir=$pesanan->progressPengerjaan->sortByDesc('tanggal_update')->first();
                        $persentase=$progressTerakhir->persentase_progress??0;
                        $statusPesanan=$pesanan->status;
                    @endphp

                    <tr class="order-row">
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
                            <div style="font-weight:600;color:var(--prod-text-main);">
                                {{ $pesanan->produkJasa->nama_produk_jasa ?? '-' }}
                            </div>

                            @if($pesanan->produkJasa)
                                <div style="font-size:12px;color:var(--prod-text-sec);margin-top:4px;">
                                    {{ ucfirst($pesanan->produkJasa->jenis) }}
                                </div>
                            @endif
                        </td>

                        <td>
                            <div style="font-weight:600;color:var(--prod-text-main);">
                                {{ $pesanan->jumlah }} item
                            </div>
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
                                {{ ucfirst($statusPesanan) }}
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
                    <tr id="emptyOrderRow">
                        <td colspan="6" style="text-align:center;padding:50px 20px;color:var(--prod-text-sec);">
                            <i class="ph ph-receipt" style="font-size:42px;"></i>
                            <p style="margin:12px 0 0;font-size:14px;">Belum ada pesanan yang terkait dengan produk atau jasa Anda.</p>
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
    const search=document.getElementById('searchPesanan');
    const rows=document.querySelectorAll('.order-row');

    if(!search)return;

    search.addEventListener('input',function(){
        const keyword=this.value.toLowerCase().trim();

        rows.forEach(function(row){
            row.style.display=row.textContent.toLowerCase().includes(keyword)?'':'none';
        });
    });
});
</script>
@endpush