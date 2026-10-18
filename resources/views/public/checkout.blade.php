@extends('public.layouts')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/checkout-pembeli.css') }}">
@endpush

@section('content')
<div class="checkout-body">
    <div class="checkout-container">

        <a href="{{ url()->previous() }}" class="back-link">
            <i class="ph ph-arrow-left"></i> Kembali
        </a>

        <div class="checkout-header">
            <h1>Detail Pesanan</h1>
            <p>Periksa kembali pesanan Anda sebelum dikonfirmasi.</p>
        </div>

        <form
            action="{{ route('pesanan.store') }}"
            method="POST"
            id="formCheckout"
            data-harga="{{ $produkJasa->harga }}"
        >
            @csrf

            <input
                type="hidden"
                name="id_produk_jasa"
                value="{{ $produkJasa->id_produk_jasa }}"
            >

            <div class="c-card">
                <div class="c-product">

                    @php
                        $gambar = $produkJasa->gambars->first();
                    @endphp

                    @if($gambar)
                        <img
                            src="{{ asset('storage/' . $gambar->path_gambar) }}"
                            alt="{{ $produkJasa->nama_produk_jasa }}"
                            class="c-product-img"
                        >
                    @else
                        <img
                            src="https://placehold.co/400x400/E2E8F0/1E3A8A?text=Produk"
                            alt="{{ $produkJasa->nama_produk_jasa }}"
                            class="c-product-img"
                        >
                    @endif

                    <div class="c-product-info">

                        <span class="c-badge">
                            {{ strtoupper($produkJasa->jenis) }}
                        </span>

                        <h3>
                            {{ $produkJasa->nama_produk_jasa }}
                        </h3>

                        <p>
                            {{ $produkJasa->deskripsi }}
                        </p>

                        <div class="c-product-price">
                            Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}{{ $produkJasa->satuan_harga ? '/' . $produkJasa->satuan_harga : '' }}
                        </div>

                    </div>
                </div>
            </div>

            <div class="c-card c-card--row">

                <div class="c-card-title c-card-title--flat">
                    Jumlah Pesanan
                </div>

                <div class="qty-control">

                    <button
                        type="button"
                        class="btn-qty"
                        id="btnMinus"
                        aria-label="Kurangi jumlah"
                    >
                        -
                    </button>

                    <input
                        type="number"
                        name="jumlah"
                        id="jumlah"
                        value="1"
                        min="1"
                        class="qty-input"
                        readonly
                    >

                    <button
                        type="button"
                        class="btn-qty"
                        id="btnPlus"
                        aria-label="Tambah jumlah"
                    >
                        +
                    </button>

                </div>

            </div>

            <div class="c-card">

                <div class="c-card-title">
                    Tambah Catatan (Opsional)
                </div>

                <textarea
                    name="catatan"
                    class="c-input"
                    rows="4"
                    maxlength="2000"
                    placeholder="Tuliskan kebutuhan khusus atau catatan tambahan untuk pesanan Anda..."
                >{{ old('catatan') }}</textarea>

            </div>

            <div class="c-card">

                <div class="c-card-title">
                    Informasi Pemesan
                </div>

                <div class="info-grid">

                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input
                            type="text"
                            class="c-input"
                            value="{{ Auth::user()->nama }}"
                            readonly
                        >
                    </div>

                    <div class="input-group">
                        <label>No. WhatsApp</label>
                        <input
                            type="text"
                            class="c-input"
                            value="{{ Auth::user()->nomor_hp ?? '-' }}"
                            readonly
                        >
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input
                            type="text"
                            class="c-input"
                            value="{{ Auth::user()->email }}"
                            readonly
                        >
                    </div>

                    <div class="input-group">
                        <label>Instansi / Asal Sekolah</label>
                        <input
                            type="text"
                            class="c-input"
                            value="SMKN 4 Tanjungpinang"
                            readonly
                        >
                    </div>

                </div>

            </div>

            <div class="c-card">

                <div class="c-card-title">
                    Ringkasan Pesanan
                </div>

                <div class="summary-row">
                    <span>Produk / Jasa</span>
                    <span>
                        {{ $produkJasa->nama_produk_jasa }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>Harga Satuan</span>
                    <span>
                        Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}{{ $produkJasa->satuan_harga ? '/' . $produkJasa->satuan_harga : '' }}
                    </span>
                </div>

                <div class="summary-row">
                    <span>Jumlah</span>
                    <span id="summaryJumlah">
                        1
                    </span>
                </div>

                <div class="summary-total">
                    <span>Subtotal</span>
                    <span id="summaryTotal">
                        Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}
                    </span>
                </div>

            </div>

            <div class="bottom-confirm">

                <div class="confirm-price-row">

                    <div class="confirm-left">

                        <div class="confirm-icon">
                            <i class="ph ph-shopping-bag"></i>
                        </div>

                        <div>

                            <div class="confirm-title" id="totalItemText">
                                Total (1 item)
                            </div>

                            <div class="confirm-note">
                                Pastikan detail pesanan sudah sesuai.
                            </div>

                        </div>

                    </div>

                    <div class="confirm-total" id="bottomTotal">
                        Rp{{ number_format($produkJasa->harga, 0, ',', '.') }}
                    </div>

                </div>

                <button type="submit" class="btn-submit">
                    Konfirmasi Pesanan
                    <i class="ph ph-arrow-right"></i>
                </button>

                <div class="disclaimer">
                    <i class="ph ph-info"></i>
                    <span>
                        Setelah konfirmasi, kami akan menghubungi Anda melalui WhatsApp.
                        Pembayaran dilakukan di luar website.
                    </span>
                </div>

            </div>

        </form>

    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/checkout-pembeli.js') }}"></script>
@endpush