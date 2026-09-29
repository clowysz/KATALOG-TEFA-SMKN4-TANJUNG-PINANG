@extends('public.layouts')

@section('title', 'Customer Service')

@section('content')

<div style="
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 20px;
">

    <div style="
        max-width: 500px;
        width: 100%;
        text-align: center;
        background: white;
        padding: 40px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    ">

        <i
            class="ph ph-shopping-cart-simple"
            style="
                font-size: 60px;
                color: #1E3A8A;
                margin-bottom: 20px;
            "
        ></i>

        <h2>
            Belum Ada Pesanan
        </h2>

        <p>
            Kamu belum memiliki pesanan.
            Silakan pilih dan pesan produk terlebih dahulu
            untuk dapat menghubungi Customer Service.
        </p>

       <a
    href="/#jurusan-unggulan"
    class="btn-jurusan"
    style="
        display: inline-block;
        margin-top: 20px;
        padding: 12px 24px;
        background: #1E3A8A;
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
    "
>
    Lihat Jurusan
</a>

<style>
    .btn-jurusan {
        transition: transform 0.3s ease;
    }

    .btn-jurusan:hover {
        transform: scale(1.08);
    }
</style>

    </div>

</div>

@endsection