@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@section('content')

<div class="page-header">

    <a
        href="{{ route('pesanan.index') }}"
        class="btn-outline"
        style="margin-bottom: 16px; display: inline-block; text-decoration: none;"
    >
        ← Kembali ke Kelola Pesanan
    </a>

    <h2>
        Detail Pesanan #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
    </h2>

    <p>
        Informasi lengkap dan pembaruan status pesanan
    </p>

</div>

<div class="detail-grid">

    <div class="tefa-card">

        <h3 style="margin-bottom: 16px; color: var(--primary);">
            Informasi Pesanan
        </h3>

        <div class="detail-section">
            <div class="detail-label">Nomor Pesanan</div>

            <div class="detail-value">
                #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Tanggal Pesanan</div>

            <div class="detail-value">
                {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y, H:i') }} WIB
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Status Saat Ini</div>

            <div class="detail-value">
                <span class="badge badge-pending">
                    {{ ucfirst($pesanan->status) }}
                </span>
            </div>
        </div>

    </div>

    <div class="tefa-card">

        <h3 style="margin-bottom: 16px; color: var(--primary);">
            Informasi Pembeli
        </h3>

        <div class="detail-section">
            <div class="detail-label">Nama Lengkap</div>

            <div class="detail-value">
                {{ $pesanan->pembeli->nama ?? '-' }}
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Email</div>

            <div class="detail-value">
                {{ $pesanan->pembeli->email ?? '-' }}
            </div>
        </div>

        <div class="detail-section">
            <div class="detail-label">Nomor Telepon</div>

            <div class="detail-value">
                {{ $pesanan->pembeli->nomor_hp ?? '-' }}
            </div>
        </div>

    </div>

    <div class="tefa-card full-width">

        <h3 style="margin-bottom: 16px; color: var(--primary);">
            Informasi Produk / Jasa
        </h3>

        <div
            class="detail-grid"
            style="margin-bottom: 0;"
        >

            <div class="detail-section">

                <div class="detail-label">
                    Nama Produk/Jasa
                </div>

                <div class="detail-value">
                    {{ $pesanan->produkJasa->nama_produk_jasa ?? '-' }}
                </div>

            </div>

            <div class="detail-section">

                <div class="detail-label">
                    Jurusan
                </div>

                <div class="detail-value">
                    {{ $pesanan->produkJasa->jurusan->nama_jurusan ?? '-' }}
                </div>

            </div>

            <div class="detail-section">

                <div class="detail-label">
                    Jenis
                </div>

                <div class="detail-value">
                    {{ strtoupper($pesanan->produkJasa->jenis ?? '-') }}
                </div>

            </div>

            <div class="detail-section">

                <div class="detail-label">
                    Harga Satuan
                </div>

                <div class="detail-value">
                    Rp{{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                </div>

            </div>

            <div class="detail-section">

                <div class="detail-label">
                    Jumlah Pesanan
                </div>

                <div class="detail-value">
                    {{ $pesanan->jumlah }}
                </div>

            </div>

            <div class="detail-section">

                <div class="detail-label">
                    Total Harga
                </div>

                <div class="detail-value">
                    Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>

            </div>

        </div>

        <hr
            style="border: 0; border-top: 1px solid #eee; margin: 16px 0;"
        >

        <div class="detail-section">

            <div class="detail-label">
                Catatan / Kebutuhan Pembeli
            </div>

            <div
                class="detail-value"
                style="font-weight: 400; line-height: 1.5;"
            >
                @if($pesanan->catatan)
                    {{ $pesanan->catatan }}
                @else
                    Tidak ada catatan dari pembeli.
                @endif
            </div>

        </div>

    </div>

</div>

<div class="tefa-card mt-4">

    <h3 style="margin-bottom: 16px;">
        Update Status Pesanan
    </h3>

    @if($pesanan->status === 'diproses')
        <div
            class="alert alert-success"
            style="margin-bottom: 16px;"
        >
            Pesanan sudah diteruskan ke Admin Produser untuk dikerjakan.
        </div>
    @endif

    <form
        action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
        method="POST"
    >

        @csrf

        <label
            for="statusSelect"
            class="detail-label"
        >
            Ubah Status Menjadi:
        </label>

        <select
            id="statusSelect"
            name="status"
            class="form-control"
            style="max-width: 300px;"
            required
        >

            <option
                value="menunggu konfirmasi"
                {{ $pesanan->status == 'menunggu konfirmasi' ? 'selected' : '' }}
            >
                Menunggu Konfirmasi
            </option>

            <option
                value="konfirmasi"
                {{ $pesanan->status == 'konfirmasi' ? 'selected' : '' }}
            >
                Konfirmasi
            </option>

            <option
                value="diproses"
                {{ $pesanan->status == 'diproses' ? 'selected' : '' }}
            >
                Diproses
            </option>

            <option
                value="selesai"
                {{ $pesanan->status == 'selesai' ? 'selected' : '' }}
            >
                Selesai
            </option>

            <option
                value="dibatalkan"
                {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}
            >
                Dibatalkan
            </option>

        </select>

        <br>

        <button
            type="submit"
            class="btn-primary"
            style="max-width: 200px;"
        >
            Simpan Perubahan
        </button>

    </form>

</div>

@endsection