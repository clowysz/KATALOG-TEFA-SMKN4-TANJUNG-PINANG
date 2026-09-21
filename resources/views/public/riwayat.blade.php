@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/profil-pembeli.css') }}">
@endpush

@section('content')

@php
    $statusLabels=[
        'menunggu konfirmasi'=>'Menunggu Konfirmasi',
        'konfirmasi'=>'Dikonfirmasi',
        'diproses'=>'Diproses',
        'selesai'=>'Selesai',
        'dibatalkan'=>'Dibatalkan',
    ];
@endphp

<div class="page-wrapper-blue">

    <div
        class="bubble"
        style="width:150px;height:150px;top:-50px;right:-50px;animation-duration:8s;"
    ></div>

    <div
        class="bubble"
        style="width:80px;height:80px;top:20%;left:5%;animation-duration:6s;"
    ></div>

    <div style="width:100%;max-width:1200px;z-index:10;">

        <a
            href="/profil-pembeli"
            class="btn-back-white"
            style="margin-bottom:20px;"
        >
            <i class="ph ph-arrow-left"></i>
            Kembali ke Profil
        </a>

    </div>

    <div class="riwayat-top-text">

        <h2>
            <i class="ph ph-receipt"></i>
            Riwayat Pemesanan
        </h2>

        <p>
            Berikut adalah daftar riwayat pemesanan produk dan jasa yang pernah Anda pesan.
        </p>

    </div>

    <div class="r-card">

        <!-- FILTER -->
        <div class="r-tools">

            <div class="r-tabs">

                <a
                    href="{{ route('pembeli.riwayat') }}"
                    class="r-tab {{ !$status ? 'active' : '' }}"
                >
                    Semua Pesanan
                </a>

                <a
                    href="{{ route('pembeli.riwayat',['status'=>'konfirmasi']) }}"
                    class="r-tab {{ $status==='konfirmasi' ? 'active' : '' }}"
                >
                    Dikonfirmasi
                </a>

                <a
                    href="{{ route('pembeli.riwayat',['status'=>'diproses']) }}"
                    class="r-tab {{ $status==='diproses' ? 'active' : '' }}"
                >
                    Diproses
                </a>

                <a
                    href="{{ route('pembeli.riwayat',['status'=>'selesai']) }}"
                    class="r-tab {{ $status==='selesai' ? 'active' : '' }}"
                >
                    Selesai
                </a>

                <a
                    href="{{ route('pembeli.riwayat',['status'=>'dibatalkan']) }}"
                    class="r-tab {{ $status==='dibatalkan' ? 'active' : '' }}"
                >
                    Dibatalkan
                </a>

            </div>

            <div class="r-search-group">

                <form
                    action="{{ route('pembeli.riwayat') }}"
                    method="GET"
                    class="r-search"
                >

                    @if($status)
                        <input
                            type="hidden"
                            name="status"
                            value="{{ $status }}"
                        >
                    @endif

                    <i
                        class="ph ph-magnifying-glass"
                        style="color:#94A3B8"
                    ></i>

                    <input
                        type="text"
                        name="keyword"
                        placeholder="Cari pesanan..."
                        value="{{ $keyword }}"
                    >

                </form>

            </div>

        </div>


        <!-- TABEL PESANAN -->
        <div class="r-table-wrapper">

            <table class="r-table">

                <thead>

                    <tr>
                        <th>Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Progress</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayats as $item)

                        @php
                            $produk=$item->produkJasa;
                            $gambar=$produk?->gambars?->first();
                            $progressTerakhir=$item->progressPengerjaan()->latest('tanggal_update')->first();
                        @endphp

                        <tr>

                            <!-- PRODUK / JASA -->
                            <td>

                                <div class="r-item">

                                    <div class="r-item-icon">

                                        @if($produk?->jenis==='jasa')
                                            <i class="ph ph-wrench"></i>
                                        @else
                                            <i class="ph ph-package"></i>
                                        @endif

                                    </div>

                                    <div class="r-item-text">

                                        <h4>
                                            {{ $produk?->nama_produk_jasa ?? 'Produk/Jasa' }}
                                        </h4>

                                        <p>
                                            {{ $produk?->jurusan?->nama_jurusan ?? '-' }}
                                            <br>
                                            #{{ str_pad($item->id_pesanan,5,'0',STR_PAD_LEFT) }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- TANGGAL -->
                            <td>

                                <div class="r-text-main">

                                    <i class="ph ph-calendar-blank"></i>

                                    {{ \Carbon\Carbon::parse($item->tanggal_pesan)->translatedFormat('d F Y') }}

                                </div>

                                <div class="r-text-sub">

                                    <i class="ph ph-package"></i>

                                    Qty: {{ $item->jumlah }}

                                </div>

                            </td>


                            <!-- TOTAL -->
                            <td class="r-price">

                                Rp {{ number_format($item->total_harga,0,',','.') }}

                            </td>


                            <!-- STATUS -->
                            <td>

                                @php
                                    $badgeClass='s-kerja';

                                    if($item->status==='selesai'){
                                        $badgeClass='s-selesai';
                                    }elseif($item->status==='dibatalkan'){
                                        $badgeClass='s-batal';
                                    }
                                @endphp

                                <span class="s-badge {{ $badgeClass }}">

                                    @if($item->status==='selesai')
                                        <i class="ph ph-check-circle"></i>
                                    @elseif($item->status==='dibatalkan')
                                        <i class="ph ph-x-circle"></i>
                                    @elseif($item->status==='menunggu konfirmasi')
                                        <i class="ph ph-clock"></i>
                                    @else
                                        <i class="ph ph-spinner-gap"></i>
                                    @endif

                                    {{ $statusLabels[$item->status] ?? $item->status }}

                                </span>

                            </td>


                            <!-- PROGRESS -->
                            <td>

                                @if($progressTerakhir)

                                    <div class="r-text-main">
                                        {{ $progressTerakhir->persentase_progress }}%
                                    </div>

                                    <div class="r-text-sub">
                                        Progress pengerjaan
                                    </div>

                                @elseif($item->status==='selesai')

                                    <div class="r-text-main">
                                        100%
                                    </div>

                                    <div class="r-text-sub">
                                        Selesai
                                    </div>

                                @else

                                    <div class="r-text-main">
                                        Belum tersedia
                                    </div>

                                    <div class="r-text-sub">
                                        Menunggu proses
                                    </div>

                                @endif

                            </td>


                            <!-- DETAIL -->
                            <td>

                                <a
                                    href="{{ route('pembeli.riwayat.detail',$item->id_pesanan) }}"
                                    class="btn-detail-r"
                                >
                                    Detail Pesanan
                                    <i class="ph ph-caret-right"></i>
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                style="text-align:center;padding:60px 20px;background:white;"
                            >

                                <i
                                    class="ph ph-receipt"
                                    style="font-size:48px;color:#94A3B8;margin-bottom:16px;display:inline-block;"
                                ></i>

                                <h3
                                    style="font-size:16px;font-weight:600;color:#1E2D3D;margin-bottom:8px;"
                                >
                                    Belum ada data pesanan
                                </h3>

                                <p
                                    style="font-size:14px;color:#64748B;margin:0;"
                                >
                                    Anda belum memiliki pesanan yang sesuai dengan pencarian atau filter.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection