<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk dan Jasa TEFA</title>

    <style>
        @page {
            margin: 0;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: #EAF5FF;
            font-family: Helvetica, Arial, sans-serif;
            color: #123D78;
        }

        table {
            border-collapse: separate;
        }

        .pdf-page {
            width: 210mm;
        }

        .pdf-page-next {
            page-break-before: always;
        }

        .wrap {
            margin: 4mm 8mm 0 8mm;
        }

        /* HEADER */
        .header-box {
            position: relative;
            width: 194mm;
            height: 44mm;
            background: #06449B;
            overflow: hidden;
        }

        .header-bubble {
            position: absolute;
            right: -20mm;
            bottom: -22mm;
            width: 55mm;
            height: 55mm;
            background: #5788C8;
            border-radius: 50%;
            z-index: 1;
        }

        .header {
            position: relative;
            z-index: 2;
            width: 194mm;
            height: 44mm;
            color: #ffffff;
            border-collapse: collapse;
        }

        .header-top {
            height: 9mm;
            background: #07377D;
            text-align: right;
            padding: 0 5mm;
            font-size: 9pt;
            font-weight: bold;
            color: #ffffff;
        }

        .header-top .dot {
            color: #B9D8FF;
        }

        .header-logo {
            width: 30mm;
            padding: 0 0 0 5mm;
            vertical-align: middle;
        }

        .header-logo img {
            width: 25mm;
            height: 25mm;
        }

        .logo-fallback {
            font-size: 7pt;
            font-weight: bold;
            text-align: center;
        }

        .header-text {
            vertical-align: middle;
            padding-left: 3mm;
        }

        .school-name {
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 1mm;
        }

        .header-title {
            margin: 0;
            font-size: 30pt;
            font-weight: bold;
            line-height: 1;
            text-transform: uppercase;
        }

        .header-title span {
            display: block;
            font-size: 23pt;
            margin-top: 1mm;
        }

        /* GRID */
        .catalog-grid {
            width: 194mm;
            margin-top: 3mm;
            border-spacing: 3mm;
            margin-left: -3mm;
            margin-right: -3mm;
        }

        .catalog-grid td {
            width: 60.6mm;
            height: 51mm;
            vertical-align: top;
            padding: 0;
        }

        .catalog-card {
            width: 55.6mm;
            height: 45mm;
            background: #ffffff;
            border: 1px solid #D7E8F8;
            border-radius: 3mm;
            padding: 2.5mm;
            overflow: hidden;
        }

        .card-badges {
            width: 100%;
            height: 5mm;
        }

        .card-badges td {
            height: 5mm;
            padding: 0;
        }

        .badge {
            display: inline-block;
            padding: 0.8mm 2mm;
            border-radius: 3mm;
            color: #ffffff;
            font-size: 7pt;
            font-weight: bold;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .badge-jurusan { background: #06449B; }
        .badge-jenis   { background: #B30D35; }

        .card-image {
            width: 55mm;
            height: 19mm;
            margin-top: 1.5mm;
            overflow: hidden;
            background: #E9EEF5;
            text-align: center;
        }

        .no-image {
            padding-top: 8mm;
            color: #94A3B8;
            font-size: 7pt;
            font-weight: bold;
        }

        .card-title {
            width: 55mm;
            height: 4.5mm;
            margin-top: 1mm;
            color: #06449B;
            font-size: 9pt;
            font-weight: bold;
            line-height: 4.5mm;
            white-space: nowrap;
            overflow: hidden;
        }

        .card-description {
            width: 55mm;
            height: 7.5mm;
            color: #475569;
            font-size: 7pt;
            line-height: 3.3mm;
            overflow: hidden;
        }

        .card-price {
            width: 55mm;
            height: 5mm;
            border-top: 0.3mm solid #E2EDF7;
            padding-top: 1mm;
            color: #06449B;
            font-size: 9pt;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
        }

        /* FOOTER */
        .footer {
            width: 210mm;
            height: 16mm;
            margin-top: 4mm;
            background: #07377D;
            color: #ffffff;
            border-collapse: collapse;
        }

        .footer td {
            padding: 4mm 8mm;
            vertical-align: middle;
            font-size: 8pt;
        }

        .footer-label {
            font-size: 7pt;
            color: #C9E0FF;
        }
    </style>
</head>
<body>

@php
    $logoPath = public_path('images/logo-smk4.png');
    $logoBase64 = null;

    if (file_exists($logoPath)) {
        $logoBase64 = 'data:' . mime_content_type($logoPath) . ';base64,' . base64_encode(file_get_contents($logoPath));
    }

    if (!function_exists('singkatanJurusan')) {
        function singkatanJurusan($nama)
        {
            $nama = strtoupper(trim($nama ?? ''));

            return match ($nama) {
                'REKAYASA PERANGKAT LUNAK', 'RPL' => 'RPL',
                'TEKNIK KOMPUTER DAN JARINGAN', 'TKJ' => 'TKJ',
                'DESAIN KOMUNIKASI VISUAL', 'DKV' => 'DKV',
                'PRODUKSI DAN SIARAN PROGRAM TELEVISI', 'PSPT' => 'PSPT',
                'ANIMASI' => 'ANIMASI',
                'GAME INTERACTIVE MEDIA', 'GAME INTERACTIVE', 'PENGEMBANGAN GIM', 'GIM' => 'GIM',
                default => $nama ?: 'TEFA',
            };
        }
    }

    $halamanList = $produkJasas->chunk(12);
    $totalHalaman = $halamanList->count();
@endphp

@foreach($halamanList as $indexHalaman => $halaman)

    <div class="pdf-page {{ $loop->first ? '' : 'pdf-page-next' }}">

        <div class="wrap">

            <div class="header-box">
            <div class="header-bubble"></div>
            <table class="header">
                <tr>
                    <td colspan="2" class="header-top">
                        TEFA &nbsp;<span class="dot">&bull;</span>&nbsp; SMK N 4 &nbsp;<span class="dot">&bull;</span>&nbsp; TANJUNG PINANG
                    </td>
                </tr>
                <tr>
                    <td class="header-logo">
                        @if($logoBase64)
                            <img src="{{ $logoBase64 }}" alt="Logo">
                        @else
                            <div class="logo-fallback">SMK NEGERI 4</div>
                        @endif
                    </td>
                    <td class="header-text">
                        <div class="school-name">TEFA SMK N 4 TANJUNG PINANG</div>
                        <h1 class="header-title">
                            KATALOG
                            <span>PRODUK DAN JASA</span>
                        </h1>
                    </td>
                </tr>
            </table>
            </div>

            <table class="catalog-grid">
                @foreach($halaman->values()->pad(12, null)->chunk(3) as $baris)
                    <tr>
                        @foreach($baris as $item)
                            <td>
                                @if($item)
                                    <div class="catalog-card">

                                        <table class="card-badges">
                                            <tr>
                                                <td align="left">
                                                    <span class="badge badge-jurusan">{{ singkatanJurusan($item->jurusan->nama_jurusan ?? null) }}</span>
                                                </td>
                                                <td align="right">
                                                    <span class="badge badge-jenis">{{ strtoupper($item->jenis ?? 'PRODUK') }}</span>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="card-image">
                                            @php
                                                $gambarBase64 = null;
                                                $iw = 55;
                                                $ih = 19;
                                                $ml = 0;
                                                $mt = 0;
                                                $pertama = $item->gambars ? $item->gambars->first() : null;

                                                if ($pertama) {
                                                    $gambarPath = storage_path('app/public/' . $pertama->path_gambar);

                                                    if (file_exists($gambarPath)) {
                                                        $gambarBase64 = 'data:' . mime_content_type($gambarPath) . ';base64,' . base64_encode(file_get_contents($gambarPath));

                                                        $ukuran = @getimagesize($gambarPath);

                                                        if ($ukuran && $ukuran[0] > 0 && $ukuran[1] > 0) {
                                                            $skala = max(55 / $ukuran[0], 19 / $ukuran[1]);
                                                            $iw = round($ukuran[0] * $skala, 2);
                                                            $ih = round($ukuran[1] * $skala, 2);
                                                            $ml = -round(($iw - 55) / 2, 2);
                                                            $mt = -round(($ih - 19) / 2, 2);
                                                        }
                                                    }
                                                }
                                            @endphp

                                            @if($gambarBase64)
                                                <img src="{{ $gambarBase64 }}" style="width: {{ $iw }}mm; height: {{ $ih }}mm; margin-left: {{ $ml }}mm; margin-top: {{ $mt }}mm;">
                                            @else
                                                <div class="no-image">{{ $pertama ? 'Gambar tidak ditemukan' : 'Tidak ada gambar' }}</div>
                                            @endif
                                        </div>

                                        <div class="card-title">{{ \Illuminate\Support\Str::limit($item->nama_produk_jasa, 32) }}</div>

                                        @php
                                            $deskripsi = trim($item->deskripsi ?? 'Informasi produk atau jasa TEFA.');
                                            $batasKarakter = 71;

                                            if (mb_strlen($deskripsi) > $batasKarakter) {
                                                $potongan = mb_substr($deskripsi, 0, $batasKarakter);
                                                $posisiSpasi = mb_strrpos($potongan, ' ');

                                                if ($posisiSpasi !== false) {
                                                    $potongan = mb_substr($potongan, 0, $posisiSpasi);
                                                }

                                                $deskripsi = rtrim($potongan) . '...';
                                            }
                                        @endphp

                                        <div class="card-description">{{ $deskripsi }}</div>

                                        <div class="card-price">
                                            @if($item->harga !== null)
                                                Rp{{ number_format($item->harga, 0, ',', '.') }}{{ $item->satuan_harga ? '/' . $item->satuan_harga : '' }}
                                            @else
                                                Hubungi untuk informasi harga
                                            @endif
                                        </div>

                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>

        </div>

        <table class="footer">
            <tr>
                <td>
                    <strong>{{ $nomorKontak }}</strong><br>
                    <span class="footer-label">Hubungi kami untuk informasi lebih lanjut</span>
                </td>
                <td align="right">
                    <strong>Jl. Nusantara No.KM.14</strong><br>
                    <span class="footer-label">Tanjung Pinang, Kepulauan Riau</span>
                </td>
            </tr>
        </table>

    </div>

@endforeach

</body>
</html>