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
           PAGE
        ===================================================== */

        .pdf-page {
            width: 210mm;
            height: 297mm;

            padding: 7mm 8mm 0;

            background: #EAF5FF;

            overflow: hidden;

            page-break-after: always;
        }

        .pdf-page:last-child {
            page-break-after: auto;
        }

        /* =====================================================
           HEADER
        ===================================================== */

        .header {
            width: 100%;
            height: 47mm;

            position: relative;

            background: #06449B;

            color: #ffffff;

            overflow: hidden;

            margin-bottom: 3mm;
        }

        /* =====================================================
           HEADER TOP
        ===================================================== */

        .header-top {
            width: 100%;
            height: 9mm;

            background: #07377D;

            display: flex;

            align-items: center;
            justify-content: flex-end;

            padding: 0 5mm;

            gap: 4mm;

            font-size: 9pt;

            font-weight: bold;

            letter-spacing: 0.4px;

            position: relative;

            z-index: 5;
        }

        .header-top .dot {
            color: #B9D8FF;
        }

        /* =====================================================
           HEADER CONTENT
        ===================================================== */

        .header-content {
            width: 100%;

            height: 38m;

            display: flex;

            align-items: center;

            padding: 3mm 5mm;

            gap: 5mm;

            position: relative;

            z-index: 5;
        }

        /* =====================================================
           LOGO
        ===================================================== */

        .logo {
            width: 25mm;

            height: 25mm;

            min-width: 25mm;

            display: flex;

            align-items: center;

            justify-content: center;

            overflow: hidden;

            background: transparent;

            border: none;
        }

        .logo img {
            width: 100%;

            height: 100%;

            display: block;

            object-fit: contain;
        }

        /* =====================================================
           FALLBACK LOGO
        ===================================================== */

        .logo-fallback {
            color: #ffffff;

            font-size: 7pt;

            font-weight: bold;

            line-height: 1.2;

            text-align: center;
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
            margin: 0;

            font-size: 30pt;

            font-weight: 900;

            line-height: 0.95;

            letter-spacing: -0.8px;

            text-transform: uppercase;
        }

        .header-title span {
            display: block;

            font-size: 23pt;

            margin-top: 1mm;
        }

        /* =====================================================
           DEKORASI HEADER
        ===================================================== */

       .header-decoration {
    position: absolute;

    right: -20mm;
    bottom: -20mm;

    width: 55mm;
    height: 55mm;

    background: #bbdbff;

    border-radius: 50%;

    opacity: 0.45;

    z-index: 1;
}

        /* =====================================================
           GRID
        ===================================================== */

        .catalog-grid {
            width: 100%;

            height: 222mm;

            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            grid-template-rows:
                repeat(4, minmax(0, 1fr));

            gap: 3mm;
        }

        /* =====================================================
           CARD
        ===================================================== */

        .catalog-card {
            width: 100%;

            height: 100%;

            min-width: 0;

            min-height: 0;

            background: #ffffff;

            border: 1px solid #D7E8F8;

            border-radius: 3mm;

            padding: 2.5mm;

            overflow: hidden;

            position: relative;

            page-break-inside: avoid;

            break-inside: avoid;
        }

        /* =====================================================
           JURUSAN + JENIS
        ===================================================== */

        .card-badges {
            width: 100%;

            height: 6mm;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 2mm;

            overflow: hidden;
        }

        .badge {
            display: block;

            height: 5mm;

            padding: 0.8mm 2mm;

            border-radius: 5mm;

            color: #ffffff;

            font-size: 7pt;

            font-weight: bold;

            line-height: 3.4mm;

            text-align: center;

            text-transform: uppercase;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }

        .badge-jurusan {
            background: #06449B;

            max-width: 25mm;
        }

        .badge-jenis {
            background: #B30D35;

            max-width: 25mm;
        }

        /* =====================================================
           GAMBAR
        ===================================================== */

        .card-image {
            width: 100%;

            height: 22mm;

            margin-top: 1.5mm;

            border-radius: 2mm;

            overflow: hidden;

            background: #E9EEF5;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .card-image img {
            width: 100%;

            height: 100%;

            display: block;

            object-fit: cover;
        }

        .no-image {
            width: 100%;

            height: 100%;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 2mm;

            color: #94A3B8;

            font-size: 7pt;

            font-weight: bold;

            text-align: center;
        }

        /* =====================================================
           NAMA
        ===================================================== */

        .card-title {
    width: 100%;

    height: 4.4mm;

    margin: 1.5mm 0 0;

    padding: 0;

    color: #06449B;

    font-size: 9pt;

    font-weight: 800;

    line-height: 3.5mm;

    overflow: hidden;

    word-break: normal;

    overflow-wrap: break-word;
}

.card-description {
    width: 100%;

    height: 9mm;

    margin: -0.5mm 0 0;
    padding: 0 0 1mm;

    color: #475569;

    font-size: 7pt;

    line-height: 3.2mm;

    overflow: hidden;

    word-break: normal;

    overflow-wrap: break-word;
}
        /* =====================================================
           HARGA
        ===================================================== */

        .card-price {
            position: absolute;

            left: 2.5mm;

            right: 2.5mm;

            bottom: 2.5mm;

            height: 5.5mm;

            padding-top: 1mm;

            border-top: 0.3mm solid #E2EDF7;

            color: #06449B;

            font-size: 9pt;

            font-weight: 900;

            line-height: 4mm;

            overflow: hidden;

            white-space: nowrap;

            text-overflow: ellipsis;

            background: #ffffff;
        }

        /* =====================================================
           FOOTER
        ===================================================== */

        .footer {
            width: calc(100% + 16mm);

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
           EMPTY CARD
        ===================================================== */

        .empty-card {
            background: transparent;

            border: none;
        }
    </style>
</head>

<body>

@php

    /*
    |--------------------------------------------------------------------------
    | LOGO
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
                file_get_contents(
                    $logoPath
                )
            );
    }


    /*
    |--------------------------------------------------------------------------
    | FUNGSI SINGKATAN JURUSAN
    |--------------------------------------------------------------------------
    */

    function singkatanJurusan($nama)
    {
        $nama = strtoupper(
            trim($nama ?? '')
        );

        return match ($nama) {

            'REKAYASA PERANGKAT LUNAK',
            'RPL'
                => 'RPL',

            'TEKNIK KOMPUTER DAN JARINGAN',
            'TKJ'
                => 'TKJ',

            'DESAIN KOMUNIKASI VISUAL',
            'DKV'
                => 'DKV',

            'PRODUKSI DAN SIARAN PROGRAM TELEVISI',
            'PSPT'
                => 'PSPT',

            'ANIMASI'
                => 'ANIMASI',

            'GAME INTERACTIVE MEDIA',
            'GAME INTERACTIVE',
            'PENGEMBANGAN GIM',
            'GIM'
                => 'GIM',

            default
                => $nama ?: 'TEFA',
        };
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

                <!-- LOGO TANPA LINGKARAN -->

                <div class="logo">

                    @if($logoBase64)

                        <img
                            src="{{ $logoBase64 }}"
                            alt="Logo SMK Negeri 4 Tanjungpinang"
                        >

                    @else

                        <span class="logo-fallback">
                            SMK NEGERI 4
                        </span>

                    @endif

                </div>


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
             GRID 3 x 4
        ================================================== -->

        <div class="catalog-grid">

            @foreach($halaman as $item)

                <div class="catalog-card">

                    <!-- =================================================
                         BADGE
                    ================================================== -->

                    <div class="card-badges">

                        <span class="badge badge-jurusan">

                            {{ singkatanJurusan(
                                $item->jurusan->nama_jurusan ?? null
                            ) }}

                        </span>


                        <span class="badge badge-jenis">

                            {{ strtoupper(
                                $item->jenis ?? 'PRODUK'
                            ) }}

                        </span>

                    </div>


                    <!-- =================================================
                         GAMBAR
                    ================================================== -->

                    <div class="card-image">

                        @if(
                            $item->gambars &&
                            $item->gambars->first()
                        )

                            @php

                                $gambarPath = storage_path(
                                    'app/public/' .
                                    $item->gambars
                                        ->first()
                                        ->path_gambar
                                );

                                $gambarBase64 = null;

                                if (
                                    file_exists(
                                        $gambarPath
                                    )
                                ) {

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
                         NAMA
                    ================================================== -->

                    <div class="card-title">

                        {{ $item->nama_produk_jasa }}

                    </div>


                    <!-- =================================================
                         DESKRIPSI
                    ================================================== -->

                    @php

                        $deskripsi = trim(
                            $item->deskripsi
                                ?? 'Informasi produk atau jasa TEFA.'
                        );

                        $batasKarakter = 71;

                        if (
                            mb_strlen($deskripsi) >
                            $batasKarakter
                        ) {

                            $potongan = mb_substr(
                                $deskripsi,
                                0,
                                $batasKarakter
                            );

                            $posisiSpasi = mb_strrpos(
                                $potongan,
                                ' '
                            );

                            if (
                                $posisiSpasi !== false
                            ) {

                                $potongan = mb_substr(
                                    $potongan,
                                    0,
                                    $posisiSpasi
                                );
                            }

                            $deskripsi =
                                rtrim(
                                    $potongan
                                ) . '...';
                        }

                    @endphp


                    <div class="card-description">

                        {{ $deskripsi }}

                    </div>


                    <!-- =================================================
                         HARGA
                    ================================================== -->

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