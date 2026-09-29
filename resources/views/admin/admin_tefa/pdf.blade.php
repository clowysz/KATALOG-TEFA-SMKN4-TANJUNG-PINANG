<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <title>Katalog Produk dan Jasa TEFA</title>

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;

            font-family: Arial, Helvetica, sans-serif;

            color: #123D78;

            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            background: #ffffff;
        }

        /* =====================================================
           HALAMAN PDF
        ===================================================== */

        .pdf-page {
            width: 210mm;
            height: 297mm;

            padding: 7mm 8mm 0;

            overflow: hidden;
            position: relative;

            background: #EAF5FF;

            page-break-after: always;
        }

        .pdf-page:last-child {
            page-break-after: auto;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            height: 47mm;

            position: relative;

            background: #06449B;
            color: #ffffff;

            overflow: hidden;

            margin-bottom: 3mm;
        }

        .header-top {
            height: 15mm;

            background: #07377D;

            display: flex;
            align-items: center;
            justify-content: flex-end;

            padding: 0 5mm;

            gap: 4mm;

            font-size: 9pt;
            font-weight: bold;

            letter-spacing: 0.4px;
        }

        .header-top .dot {
            color: #B9D8FF;
        }

        .header-content {
            height: 32mm;

            display: flex;
            align-items: center;

            padding: 3mm 5mm;

            gap: 5mm;

            position: relative;
            z-index: 2;
        }

        /* =====================================================
           LOGO
        ===================================================== */

        .logo {
            width: 24mm;
            height: 24mm;

            min-width: 24mm;

            border: 2px solid #ffffff;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            text-align: center;

            overflow: hidden;

            background: #0B5BB5;
        }

        .logo img {
            width: 100%;
            height: 100%;

            object-fit: contain;

            display: block;
        }

        /* =====================================================
           HEADER TEXT
        ===================================================== */

        .header-text {
            flex: 1;
            min-width: 0;
        }

        .school-name {
            font-size: 12pt;
            font-weight: bold;

            letter-spacing: 0.8px;

            margin-bottom: 1mm;
        }

        .header-title {
            font-size: 30pt;
            font-weight: 900;

            line-height: 0.95;

            letter-spacing: -0.8px;

            text-transform: uppercase;

            margin: 0;
        }

        .header-title span {
            display: block;

            font-size: 23pt;

            margin-top: 1mm;
        }

        .header-decoration {
            position: absolute;

            right: -5mm;
            bottom: -7mm;

            width: 24mm;
            height: 24mm;

            background: #2875D4;

            transform: rotate(45deg);

            z-index: 1;
        }

        /* =====================================================
           GRID KATALOG
        ===================================================== */

        .catalog-grid {
            height: 222mm;

            display: grid;

            grid-template-columns: repeat(3, minmax(0, 1fr));
            grid-template-rows: repeat(4, minmax(0, 1fr));

            gap: 3mm;
        }

        /* =====================================================
           KARTU
        ===================================================== */

        .catalog-card {
            min-width: 0;
            min-height: 0;

            background: #ffffff;

            border: 1px solid #D7E8F8;

            border-radius: 3mm;

            padding: 3mm;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            position: relative;

            page-break-inside: avoid;
        }

        /* =====================================================
           BADGE
        ===================================================== */

        .card-badges {
            display: flex;
            align-items: center;

            gap: 2mm;

            margin-bottom: 2mm;

            flex-shrink: 0;

            min-width: 0;
        }

        .badge {
            min-width: 17mm;
            max-width: 28mm;

            padding: 1.3mm 2mm;

            border-radius: 5mm;

            color: #ffffff;

            font-size: 7.5pt;
            font-weight: bold;

            text-align: center;

            text-transform: uppercase;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .badge-jurusan {
            background: #06449B;
        }

        .badge-jenis {
            background: #B30D35;
        }

        /* =====================================================
           GAMBAR
        ===================================================== */

        .card-image {
            width: 100%;
            height: 24mm;

            flex-shrink: 0;

            border-radius: 2mm;

            overflow: hidden;

            background: #E9EEF5;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 2mm;
        }

        .card-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;
        }

        .no-image {
            padding: 2mm;

            font-size: 8pt;
            font-weight: bold;

            color: #94A3B8;

            text-align: center;
        }

        /* =====================================================
           NAMA PRODUK / JASA
        ===================================================== */

        .card-title {
            font-size: 10pt;

            line-height: 1.2;

            font-weight: 800;

            color: #06449B;

            margin: 0 0 1.5mm;

            overflow: hidden;

            max-height: 9mm;

            overflow-wrap: anywhere;
        }

        /* =====================================================
           DESKRIPSI
        ===================================================== */

        .card-description {
            font-size: 7.5pt;

            line-height: 1.3;

            color: #475569;

            margin: 0;

            overflow: hidden;

            max-height: 16mm;

            overflow-wrap: anywhere;
        }

        /* =====================================================
           HARGA
        ===================================================== */

        .card-price-wrapper {
            margin-top: auto;

            padding-top: 1.5mm;

            flex-shrink: 0;
        }

        .price-label {
            display: inline-block;

            background: #E7F1FF;

            color: #1D4ED8;

            padding: 0.5mm 2mm;

            border-radius: 2mm;

            font-size: 7pt;

            margin-bottom: 1mm;
        }

        .card-price {
            font-size: 11pt;

            font-weight: 900;

            line-height: 1.15;

            color: #06449B;

            overflow-wrap: anywhere;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            height: 14mm;

            margin: 3mm -8mm 0;

            padding: 2mm 8mm;

            background: #07377D;

            color: #ffffff;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 4mm;

            overflow: hidden;
        }

        .footer-item {
            display: flex;
            align-items: center;

            gap: 2mm;

            min-width: 0;

            font-size: 7.5pt;

            line-height: 1.4;
        }

        .footer-icon {
            width: 8mm;
            height: 8mm;

            min-width: 8mm;

            background: #ffffff;

            color: #06449B;

            border-radius: 50%;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 11pt;

            font-weight: bold;
        }

        .footer-label {
            font-size: 7pt;

            color: #C9E0FF;
        }

        /* =====================================================
           KARTU KOSONG
        ===================================================== */

        .empty-card {
            background: transparent;

            border: none;

            box-shadow: none;
        }
    </style>
</head>

<body>

@php
    /*
    |--------------------------------------------------------------------------
    | LOGO SMK NEGERI 4
    |--------------------------------------------------------------------------
    */

    $logoPath = public_path('images/logo-smk4.png');

    $logoBase64 = null;

    if (file_exists($logoPath)) {
        $logoMime = mime_content_type($logoPath);

        $logoBase64 =
            'data:' .
            $logoMime .
            ';base64,' .
            base64_encode(
                file_get_contents($logoPath)
            );
    }
@endphp


@foreach($produkJasas->chunk(12) as $halaman)

    <div class="pdf-page">

        <!-- =================================================
             HEADER
        ================================================== -->

        <div class="header">

            <div class="header-top">

                <span>TEFA</span>

                <span class="dot">●</span>

                <span>SMK N 4</span>

                <span class="dot">●</span>

                <span>TANJUNG PINANG</span>

            </div>


            <div class="header-content">

                <!-- LOGO -->

                <div class="logo">

                    @if($logoBase64)

                        <img
                            src="{{ $logoBase64 }}"
                            alt="Logo SMK Negeri 4 Tanjungpinang"
                        >

                    @else

                        <span style="
                            color: #ffffff;
                            font-size: 7pt;
                            font-weight: bold;
                            line-height: 1.2;
                        ">
                            SMK NEGERI 4
                        </span>

                    @endif

                </div>


                <!-- JUDUL -->

                <div class="header-text">

                    <div class="school-name">
                        TEFA SMK N 4 TANJUNG PINANG
                    </div>

                    <h1 class="header-title">

                        KATALOG

                        <span>
                            PRODUK DAN JASA
                        </span>

                    </h1>

                </div>

            </div>


            <div class="header-decoration"></div>

        </div>


        <!-- =================================================
             GRID KATALOG
        ================================================== -->

        <div class="catalog-grid">

            @foreach($halaman as $item)

                <div class="catalog-card">

                    <!-- =================================================
                         BADGE JURUSAN + JENIS
                    ================================================== -->

                    <div class="card-badges">

                        <span class="badge badge-jurusan">
                            {{ $item->jurusan->nama_jurusan ?? 'TEFA' }}
                        </span>

                        <span class="badge badge-jenis">
                            {{ strtoupper($item->jenis ?? 'PRODUK') }}
                        </span>

                    </div>


                    <!-- =================================================
                         GAMBAR PRODUK / JASA
                    ================================================== -->

                    <div class="card-image">

                        @if($item->gambars && $item->gambars->first())

                            @php

                                $gambarPath = storage_path(
                                    'app/public/' .
                                    $item->gambars->first()->path_gambar
                                );

                                $gambarBase64 = null;

                                if (file_exists($gambarPath)) {

                                    $gambarMime =
                                        mime_content_type(
                                            $gambarPath
                                        );

                                    $gambarBase64 =
                                        'data:' .
                                        $gambarMime .
                                        ';base64,' .
                                        base64_encode(
                                            file_get_contents(
                                                $gambarPath
                                            )
                                        );
                                }

                            @endphp


                            @if($gambarBase64)

                                <img
                                    src="{{ $gambarBase64 }}"
                                    alt="{{ $item->nama_produk_jasa }}"
                                >

                            @else

                                <div class="no-image">
                                    Gambar tidak ditemukan
                                </div>

                            @endif

                        @else

                            <div class="no-image">
                                Tidak ada gambar
                            </div>

                        @endif

                    </div>


                    <!-- =================================================
                         NAMA PRODUK / JASA
                    ================================================== -->

                    <h3 class="card-title">

                        {{ $item->nama_produk_jasa }}

                    </h3>


                    <!-- =================================================
                         DESKRIPSI PENDEK
                    ================================================== -->

                    @php

                        $deskripsi = trim(
                            $item->deskripsi
                                ?? 'Informasi produk atau jasa TEFA.'
                        );

                        $batasKarakter = 71;

                        if (mb_strlen($deskripsi) > $batasKarakter) {

                            $potongan = mb_substr(
                                $deskripsi,
                                0,
                                $batasKarakter
                            );

                            $posisiSpasi = mb_strrpos(
                                $potongan,
                                ' '
                            );

                            if ($posisiSpasi !== false) {

                                $potongan = mb_substr(
                                    $potongan,
                                    0,
                                    $posisiSpasi
                                );

                            }

                            $deskripsi =
                                rtrim($potongan) . '...';
                        }

                    @endphp


                    <p class="card-description">

                        {{ $deskripsi }}

                    </p>


                    <!-- =================================================
                         HARGA
                    ================================================== -->

                    <div class="card-price-wrapper">

                        <span class="price-label">
                            Harga
                        </span>


                        <div class="card-price">

                            @if($item->harga !== null)

                                Rp{{ number_format(
                                    $item->harga,
                                    0,
                                    ',',
                                    '.'
                                ) }}{{ $item->satuan_harga
                                    ? '/' . $item->satuan_harga
                                    : ''
                                }}

                            @else

                                Hubungi untuk informasi harga

                            @endif

                        </div>

                    </div>

                </div>

            @endforeach


            <!-- =================================================
                 KARTU KOSONG
            ================================================== -->

            @for(
                $i = $halaman->count();
                $i < 12;
                $i++
            )

                <div class="catalog-card empty-card"></div>

            @endfor

        </div>


        <!-- =================================================
             FOOTER
        ================================================== -->

        <div class="footer">


            <!-- TELEPON -->

            <div class="footer-item">

                <div class="footer-icon">
                    ☎
                </div>


                <div>

                    <strong>
                        +62 812-3456-7890
                    </strong>

                    <br>

                    <span class="footer-label">
                        Hubungi kami untuk informasi lebih lanjut
                    </span>

                </div>

            </div>


            <!-- ALAMAT -->

            <div class="footer-item">

                <div class="footer-icon">
                    ⌖
                </div>


                <div>

                    <strong>
                        Jl. Nusantara No.KM.14
                    </strong>

                    <br>

                    <span class="footer-label">
                        Tanjung Pinang, Kepulauan Riau
                    </span>

                </div>

            </div>

        </div>

    </div>

@endforeach

</body>
</html>