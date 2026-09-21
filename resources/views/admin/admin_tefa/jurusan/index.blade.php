@extends('admin.layouts.app')

@section('title', 'Jurusan')

@section('content')

<style>
    .tefa-jurusan-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
        margin-top: 20px;
    }

    .j-card {
        background: #ffffff;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        border: 1px solid #f1f5f9;
    }

    .j-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 20px;
    }

    .j-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .j-stat-box {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
    }

    .j-stat-num {
        font-size: 24px;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 6px;
    }

    .j-stat-label {
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
    }

    .theme-rpl {
        border-top: 4px solid #d97706;
    }

    .theme-rpl .j-stat-num {
        color: #d97706;
    }

    .theme-tkj {
        border-top: 4px solid #059669;
    }

    .theme-tkj .j-stat-num {
        color: #059669;
    }

    .theme-dkv {
        border-top: 4px solid #991b1b;
    }

    .theme-dkv .j-stat-num {
        color: #991b1b;
    }

    .theme-animasi {
        border-top: 4px solid #334155;
    }

    .theme-animasi .j-stat-num {
        color: #334155;
    }

    .theme-gim {
        border-top: 4px solid #2563eb;
    }

    .theme-gim .j-stat-num {
        color: #2563eb;
    }

    .theme-pspt {
        border-top: 4px solid #ca8a04;
    }

    .theme-pspt .j-stat-num {
        color: #ca8a04;
    }

    .empty-jurusan {
        text-align: center;
        padding: 60px 20px;
        color: #64748b;
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }
</style>


<div class="page-header">
    <h2 style="font-size: 20px; font-weight: bold; color: #1e293b;">
        Jurusan
    </h2>

    <p style="color: #64748b; margin-top: 6px;">
        Ringkasan produk, jasa, portofolio, dan pesanan setiap jurusan.
    </p>
</div>


@if($jurusans->count() > 0)

    <div class="tefa-jurusan-grid">

        @foreach($jurusans as $jurusan)

            @php
                $kode = strtolower($jurusan->kode_jurusan ?? '');

                $theme = match($kode) {
                    'rpl' => 'theme-rpl',
                    'tkj' => 'theme-tkj',
                    'dkv' => 'theme-dkv',
                    'animasi' => 'theme-animasi',
                    'gim' => 'theme-gim',
                    'pspt' => 'theme-pspt',
                    default => 'theme-rpl',
                };
            @endphp


            <div class="j-card {{ $theme }}">

                <div class="j-card-title">
                    {{ $jurusan->nama_jurusan }}
                </div>


                <div class="j-stats">

                    <div class="j-stat-box">
                        <div class="j-stat-num">
                            {{ $jurusan->total_produk }}
                        </div>

                        <div class="j-stat-label">
                            Produk
                        </div>
                    </div>


                    <div class="j-stat-box">
                        <div class="j-stat-num">
                            {{ $jurusan->total_jasa }}
                        </div>

                        <div class="j-stat-label">
                            Jasa
                        </div>
                    </div>


                    <div class="j-stat-box">
                        <div class="j-stat-num">
                            {{ $jurusan->total_portofolio }}
                        </div>

                        <div class="j-stat-label">
                            Portofolio
                        </div>
                    </div>


                    <div class="j-stat-box">
                        <div class="j-stat-num">
                            {{ $jurusan->total_pesanan }}
                        </div>

                        <div class="j-stat-label">
                            Pesanan
                        </div>
                    </div>

                </div>

            </div>

        @endforeach

    </div>

@else

    <div class="empty-jurusan">

        <h3 style="margin-bottom: 8px; color: #1e293b;">
            Belum Ada Jurusan
        </h3>

        <p style="margin: 0;">
            Data jurusan belum tersedia di dalam sistem.
        </p>

    </div>

@endif

@endsection