<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Katalog TEFA</title>

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #0F172A;
        }

        .page {
            width: 100%;
            min-height: 273mm;
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 11px;
            color: #64748B;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .card {
            height: 78mm;
            border: 1px solid #D9E1EA;
            border-radius: 8px;
            overflow: hidden;
            background: #FFFFFF;
        }

        .image-wrapper {
            width: 100%;
            height: 35mm;
            background: #F1F5F9;
            overflow: hidden;
        }

        .image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94A3B8;
            font-size: 11px;
        }

        .card-body {
            padding: 8px;
        }

        .jenis {
            display: inline-block;
            padding: 3px 7px;
            border-radius: 10px;
            background: #1E40AF;
            color: white;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .nama {
            margin: 0 0 3px;
            font-size: 12px;
            font-weight: bold;
            line-height: 1.3;
        }

        .jurusan {
            margin: 0 0 5px;
            font-size: 9px;
            color: #64748B;
        }

        .deskripsi {
            margin: 0 0 6px;
            font-size: 8.5px;
            color: #475569;
            line-height: 1.4;
            height: 25px;
            overflow: hidden;
        }

        .harga {
            margin: 0;
            font-size: 11px;
            font-weight: bold;
            color: #1E40AF;
        }
    </style>
</head>

<body>

@foreach($produkJasa->chunk(12) as $halaman)

    <div class="page">

        <div class="header">
            <h1>KATALOG TEFA SMKN 4 TANJUNGPINANG</h1>
            <p>Produk dan Jasa Teaching Factory</p>
        </div>

        <div class="grid">

            @foreach($halaman as $item)

                <div class="card">

                    <div class="image-wrapper">

                        @if($item->gambars && $item->gambars->first())

                            <img
                                src="{{ public_path('storage/' . $item->gambars->first()->path_gambar) }}"
                                alt="{{ $item->nama_produk_jasa }}"
                            >

                        @else

                            <div class="no-image">
                                Tidak ada gambar
                            </div>

                        @endif

                    </div>

                    <div class="card-body">

                        <span class="jenis">
                            {{ strtoupper($item->jenis) }}
                        </span>

                        <h2 class="nama">
                            {{ $item->nama_produk_jasa }}
                        </h2>

                        <p class="jurusan">
                            {{ $item->jurusan->nama_jurusan ?? 'Semua Jurusan' }}
                        </p>

                        <p class="deskripsi">
                            {{ $item->deskripsi ?: 'Tidak ada deskripsi.' }}
                        </p>

                        <p class="harga">
                            Rp{{ number_format($item->harga ?? 0, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

@endforeach

</body>
</html>