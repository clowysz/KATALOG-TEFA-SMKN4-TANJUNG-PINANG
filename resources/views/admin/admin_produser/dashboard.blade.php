@extends('admin.layouts.app-produser')

@section('title','Dashboard')

@section('content')
<div style="margin-bottom:32px;">
    <h2 style="font-size:24px;color:var(--prod-text-main);margin-bottom:8px;font-weight:700;">Dashboard</h2>
    <p style="color:var(--prod-text-sec);font-size:14px;">Pantau pesanan yang berkaitan dengan produk atau jasa yang menjadi tanggung jawab Anda.</p>
</div>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:24px;">
    <div class="tefa-card" style="padding:24px;background:white;border-radius:12px;border:1px solid var(--prod-border);">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <div style="font-size:13px;color:var(--prod-text-sec);margin-bottom:8px;">Produk/Jasa Saya</div>
                <div style="font-size:28px;font-weight:700;color:var(--prod-text-main);">{{ $totalProdukSaya }}</div>
            </div>
            <div style="width:48px;height:48px;border-radius:10px;background:#F1F5F9;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                <i class="ph ph-package" style="font-size:24px;"></i>
            </div>
        </div>
    </div>

    <div class="tefa-card" style="padding:24px;background:white;border-radius:12px;border:1px solid var(--prod-border);">
        <div style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <div style="font-size:13px;color:var(--prod-text-sec);margin-bottom:8px;">Pesanan Masuk</div>
                <div style="font-size:28px;font-weight:700;color:var(--prod-text-main);">{{ $totalPesananMasuk }}</div>
            </div>
            <div style="width:48px;height:48px;border-radius:10px;background:#F1F5F9;display:flex;align-items:center;justify-content:center;color:var(--primary);">
                <i class="ph ph-receipt" style="font-size:24px;"></i>
            </div>
        </div>
    </div>
</div>

<div class="tefa-card" style="padding:24px;background:white;border-radius:12px;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <div>
            <h3 style="color:var(--prod-text-main);font-size:18px;margin-bottom:4px;font-weight:700;">Pesanan Terkait</h3>
            <p style="color:var(--prod-text-sec);font-size:13px;">Pesanan yang sedang diproses untuk produk/jasa Anda.</p>
        </div>
        <a href="{{ route('admin.produser.pesanan') }}" style="text-decoration:none;font-size:13px;padding:10px 16px;border-radius:8px;background:var(--primary);color:white;font-weight:600;">
            Lihat Semua Pesanan
        </a>
    </div>

    <div class="table-responsive">
        <table class="table-modern" style="width:100%;">
            <thead>
                <tr>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);padding:16px 12px;">Order ID</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);padding:16px 12px;">Produk/Jasa</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);padding:16px 12px;">Jumlah</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);padding:16px 12px;">Status Pengerjaan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);padding:16px 12px;">Status Pesanan</th>
                    <th style="background:white;border-bottom:1px solid var(--prod-border);text-align:center;padding:16px 12px;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($pesananMasuk as $pesanan)
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
                        <td colspan="6" style="text-align:center;padding:50px 20px;color:var(--prod-text-sec);">
                            <i class="ph ph-receipt" style="font-size:42px;"></i>
                            <p style="margin:12px 0 0;font-size:14px;">Belum ada pesanan yang sedang diproses untuk produk atau jasa Anda.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection