@extends('public.layouts')

@section('title', 'Customer Service')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/customer-service.css') }}">
@endpush

@section('content')

<div class="cs-page">

    <div class="cs-card">

        <i class="ph ph-shopping-cart-simple cs-icon"></i>

        <h2>
            Belum Ada Pesanan
        </h2>

        <p>
            Kamu belum memiliki pesanan.
            Silakan pilih dan pesan produk terlebih dahulu
            untuk dapat menghubungi Customer Service.
        </p>

        <a href="/katalog" class="btn-jurusan">
            Lihat Katalog
        </a>

    </div>

</div>

@endsection