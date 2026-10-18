@extends('admin.layouts.app')

@section('title', 'Jurusan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/jurusan-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="page-header">
    <h2 class="jurusan-page-title">
        Jurusan
    </h2>

    <p class="jurusan-page-subtitle">
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

        <h3 class="empty-jurusan-title">
            Belum Ada Jurusan
        </h3>

        <p class="empty-jurusan-text">
            Data jurusan belum tersedia di dalam sistem.
        </p>

    </div>

@endif

@endsection