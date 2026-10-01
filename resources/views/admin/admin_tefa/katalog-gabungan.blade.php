@extends('admin.layouts.app')

@section('title', 'Katalog Gabungan')

@section('content')

<style>
    .katalog-container {
        padding: 24px;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .katalog-header {
        margin-bottom: 20px;
    }

    .katalog-header h3 {
        font-size: 24px;
        font-weight: 800;
        color: #0F172A;
        margin: 0 0 6px 0;
    }

    .katalog-header p {
        font-size: 14px;
        color: #64748B;
        margin: 0;
    }

    /* =========================
       TOOLBAR PDF
    ========================= */

    .katalog-toolbar {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 16px 18px;
        margin-bottom: 24px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;

        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .selected-info {
        display: flex;
        align-items: center;
        gap: 7px;

        color: #1E3A8A;
        font-size: 14px;
        font-weight: 700;

        background: #EFF6FF;
        padding: 9px 13px;
        border-radius: 10px;
    }

    .selected-info i {
        font-size: 18px;
    }

    .btn-select-all {
        border: 1px solid #CBD5E1;
        background: #FFFFFF;
        color: #334155;

        padding: 9px 14px;
        border-radius: 10px;

        font-size: 14px;
        font-weight: 700;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .btn-select-all:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #1E3A8A;
    }

    .btn-generate-pdf {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        border: none;

        background: #1E3A8A;
        color: #FFFFFF;

        padding: 10px 17px;
        border-radius: 10px;

        font-size: 14px;
        font-weight: 800;

        cursor: pointer;

        transition: all 0.2s ease;
    }

    .btn-generate-pdf:hover {
        background: #1D4ED8;
        transform: translateY(-1px);
    }

    .btn-generate-pdf:disabled {
        background: #CBD5E1;
        color: #FFFFFF;
        cursor: not-allowed;
        transform: none;
    }

    /* =========================
       ALERT
    ========================= */

    .katalog-alert {
        background: #FEF2F2;
        color: #B91C1C;

        border: 1px solid #FECACA;

        padding: 12px 15px;
        border-radius: 10px;

        margin-bottom: 20px;

        font-size: 14px;
        font-weight: 600;
    }

    /* =========================
       GRID KATALOG
       DISAMAKAN DENGAN KATALOG PEMBELI
    ========================= */

    .katalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;

        max-width: 1200px;
        margin: 0 auto;
    }

    /* =========================
       CARD
       DISAMAKAN DENGAN KATALOG PEMBELI
    ========================= */

    .katalog-card {
        background: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;

        border: 1px solid #E2E8F0;

        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);

        display: flex;
        flex-direction: column;

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            border-color 0.2s ease,
            background 0.2s ease;

        position: relative;
        cursor: pointer;
    }

    .katalog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(30, 58, 138, 0.1);
    }

    /* =========================
       CARD TERPILIH
       LOGIC SELECTION TETAP
    ========================= */

    .katalog-card.selected {
        border-color: #1E40AF;

        background: #F8FAFF;

        box-shadow:
            0 0 0 3px rgba(30, 64, 175, 0.10),
            0 10px 25px rgba(30, 58, 138, 0.12);
    }

    /* =========================
       CHECK INDICATOR
       KHUSUS ADMIN
    ========================= */

    .card-check {
        position: absolute;

        top: 12px;
        left: 12px;

        width: 30px;
        height: 30px;

        border-radius: 50%;

        background: rgba(255, 255, 255, 0.95);

        border: 2px solid #CBD5E1;

        color: transparent;

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 5;

        transition: all 0.2s ease;

        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.12);
    }

    .card-check i {
        font-size: 18px;
        font-weight: 800;
    }

    .katalog-card.selected .card-check {
        background: #1E40AF;
        border-color: #1E40AF;
        color: #FFFFFF;
    }

    /* =========================
       IMAGE
       DISAMAKAN DENGAN PEMBELI
    ========================= */

    .card-img-wrapper {
        position: relative;

        width: 100%;
        height: 150px;

        background: #E2E8F0;

        overflow: hidden;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        transition: transform 0.3s ease;
    }

    .katalog-card:hover .card-img-wrapper img {
        transform: scale(1.02);
    }

    .card-img-wrapper .no-img {
        width: 100%;
        height: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #E2E8F0;
        color: #64748B;

        font-size: 48px;
    }

    /* =========================
       BADGE
       DISAMAKAN DENGAN PEMBELI
    ========================= */

    .badge-jenis {
        position: absolute;

        top: 12px;
        right: 12px;

        background: rgba(30, 58, 138, 0.9);

        color: #FFFFFF;

        padding: 4px 12px;

        font-size: 11px;
        font-weight: 700;

        border-radius: 20px;

        text-transform: uppercase;

        letter-spacing: 1px;

        z-index: 3;
    }

    /* =========================
       CARD BODY
       DISAMAKAN DENGAN PEMBELI
    ========================= */

    .card-body-content {
        padding: 20px;

        display: flex;
        flex-direction: column;

        flex-grow: 1;
    }

    .card-title {
        font-size: 16px;
        font-weight: 700;

        color: #1E2D3D;

        margin-bottom: 8px;

        font-family: 'Poppins', sans-serif;

        line-height: 1.4;
    }

    .card-jurusan {
        font-size: 12px;

        color: #64748B;

        line-height: 1.5;

        margin-bottom: 8px;
    }

    .card-desc {
        font-size: 12px;

        color: #64748B;

        line-height: 1.5;

        margin-bottom: 16px;

        flex-grow: 1;
    }

    .card-price {
        font-size: 18px;
        font-weight: 800;

        color: #1E3A8A;

        margin-bottom: 16px;
    }

    /* =========================
       DETAIL BUTTON
       DISAMAKAN DENGAN PEMBELI
    ========================= */

    .btn-detail {
        display: block;

        text-align: center;

        padding: 10px;

        background: #F8FAFC;

        color: #1E3A8A;

        font-size: 13px;

        font-weight: 600;

        border-radius: 8px;

        border: 1px solid #E2E8F0;

        text-decoration: none;

        transition: 0.3s;
    }

    .btn-detail:hover {
        background: #1E3A8A;
        color: #FFFFFF;

        border-color: #1E3A8A;
    }

    /* =========================
       EMPTY STATE
    ========================= */

    .empty-state {
        grid-column: 1 / -1;

        text-align: center;

        padding: 60px 20px;

        background: #FFFFFF;

        border-radius: 12px;

        border: 1px dashed #CBD5E1;

        margin-top: 10px;

        color: #64748B;
    }

    /* =========================
       PAGINATION
    ========================= */

    .pagination-wrapper {
        margin-top: 40px;

        padding-top: 24px;

        border-top: 1px solid #E2E8F0;

        display: flex;
        flex-direction: column;

        align-items: center;

        gap: 12px;
    }

    .pagination-info {
        font-size: 13px;

        color: #64748B;

        font-weight: 500;

        margin: 0;

        text-align: center;
    }

    .custom-pagination {
        display: flex;

        gap: 6px;

        list-style: none;

        padding: 0;
        margin: 0;

        align-items: center;
        justify-content: center;
    }

    .custom-pagination .page-item {
        margin: 0;
    }

    .custom-pagination .page-link {
        display: flex;

        align-items: center;
        justify-content: center;

        min-width: 38px;
        height: 38px;

        padding: 0 10px;

        border-radius: 10px;

        background: #FFFFFF;

        border: 1px solid #E2E8F0;

        color: #475569;

        font-weight: 600;

        font-size: 14px;

        text-decoration: none;

        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);

        transition: all 0.2s ease;
    }

    .custom-pagination .page-item.active .page-link {
        background: #1E40AF;

        color: #FFFFFF;

        border-color: #1E40AF;

        box-shadow: 0 4px 10px rgba(30, 64, 175, 0.25);
    }

    .custom-pagination .page-link:hover:not(.active) {
        background: #F8FAFC;

        border-color: #CBD5E1;

        color: #1E40AF;
    }

    .custom-pagination .page-item.disabled .page-link {
        background: #F8FAFC;

        color: #CBD5E1;

        border-color: #E2E8F0;

        cursor: not-allowed;
    }

    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 768px) {

        .katalog-container {
            padding: 16px;
        }

        .katalog-toolbar {
            align-items: stretch;
        }

        .toolbar-left {
            width: 100%;
        }

        .btn-select-all,
        .btn-generate-pdf {
            flex: 1;
        }

        .katalog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="katalog-container">

    <!-- HEADER -->

    <div class="katalog-header">

        <h3>
            Katalog Gabungan Tefa
        </h3>

        <p>
            Seluruh produk dan jasa dari semua jurusan.
        </p>

    </div>


    <!-- PESAN ERROR -->

    @if($errors->has('produk_jasa_ids'))

        <div class="katalog-alert">
            {{ $errors->first('produk_jasa_ids') }}
        </div>

    @endif


    <!-- TOOLBAR PDF -->

    <div class="katalog-toolbar">

        <div class="toolbar-left">

            <div class="selected-info">

                <i class="ph ph-check-circle"></i>

                <span>
                    <span id="selected-count">0</span>
                    item dipilih
                </span>

            </div>

            <button
                type="button"
                class="btn-select-all"
                id="btn-select-all"
            >
                Pilih Semua
            </button>

        </div>


        <form
            action="{{ route('admin.tefa.katalog_pdf') }}"
            method="POST"
            id="pdf-form"
        >

            @csrf

            <div id="selected-inputs"></div>

            <button
                type="submit"
                class="btn-generate-pdf"
                id="btn-generate-pdf"
                disabled
            >
                <i class="ph ph-file-pdf"></i>

                Generate PDF
            </button>

        </form>

    </div>


    <!-- GRID KATALOG -->

    <div class="katalog-grid">

        @forelse($katalog as $item)

            <div
                class="katalog-card"
                data-id="{{ $item->id_produk_jasa }}"
            >

                <!-- CHECK INDICATOR -->

                <div class="card-check">

                    <i class="ph ph-check"></i>

                </div>


                <!-- IMAGE -->

                <div class="card-img-wrapper">

                    @if($item->gambars && $item->gambars->first())

                        <img
                            src="{{ asset('storage/' . $item->gambars->first()->path_gambar) }}"
                            alt="{{ $item->nama_produk_jasa }}"
                        >

                    @else

                        <div class="no-img">
                            <i class="ph ph-image"></i>
                        </div>

                    @endif


                    <!-- JENIS -->

                    <span class="badge-jenis">
                        {{ strtoupper($item->jenis) }}
                    </span>

                </div>


                <!-- CARD BODY -->

                <div class="card-body-content">

                    <h4 class="card-title">
                        {{ $item->nama_produk_jasa }}
                    </h4>


                    <p class="card-jurusan">
                        {{ $item->jurusan->nama_jurusan ?? 'Semua Jurusan' }}
                    </p>


                    <p class="card-desc">
                        {{ \Illuminate\Support\Str::limit($item->deskripsi, 90) }}
                    </p>


                    <div class="card-price">

                        Rp{{ number_format($item->harga, 0, ',', '.') }}{{ $item->satuan_harga ? '/' . $item->satuan_harga : '' }}

                    </div>


                    <!-- DETAIL -->

                    <a
                        href="{{ route('admin.tefa.katalog_detail', $item->id_produk_jasa) }}"
                        class="btn-detail"
                    >
                        Lihat Detail
                        
                    </a>

                </div>

            </div>

        @empty

            <div class="empty-state">

                <i
                    class="ph ph-squares-four"
                    style="
                        font-size: 48px;
                        color: #CBD5E1;
                        margin-bottom: 12px;
                        display: block;
                    "
                ></i>

                <p style="
                    font-weight: 600;
                    margin: 0;
                ">
                    Belum ada produk atau jasa yang tersedia.
                </p>

            </div>

        @endforelse

    </div>


    <!-- PAGINATION -->

    @if($katalog->hasPages())

        <div class="pagination-wrapper">

            <p class="pagination-info">

                Menampilkan
                {{ $katalog->firstItem() }}
                sampai
                {{ $katalog->lastItem() }}
                dari
                {{ $katalog->total() }}
                hasil

            </p>


            <ul class="custom-pagination">

                {{-- PALING AWAL --}}

                @if($katalog->onFirstPage())

                    <li class="page-item disabled">

                        <span class="page-link">
                            &laquo;&laquo;
                        </span>

                    </li>

                @else

                    <li class="page-item">

                        <a
                            class="page-link"
                            href="{{ $katalog->url(1) }}"
                            title="Halaman Pertama"
                        >
                            &laquo;&laquo;
                        </a>

                    </li>

                @endif


                {{-- SEBELUMNYA --}}

                @if($katalog->onFirstPage())

                    <li class="page-item disabled">

                        <span class="page-link">
                            &lsaquo;
                        </span>

                    </li>

                @else

                    <li class="page-item">

                        <a
                            class="page-link"
                            href="{{ $katalog->previousPageUrl() }}"
                            title="Halaman Sebelumnya"
                        >
                            &lsaquo;
                        </a>

                    </li>

                @endif


                {{-- NOMOR HALAMAN --}}

                @foreach(range(1, $katalog->lastPage()) as $page)

                    @if($page == $katalog->currentPage())

                        <li class="page-item active">

                            <span class="page-link">
                                {{ $page }}
                            </span>

                        </li>

                    @else

                        <li class="page-item">

                            <a
                                class="page-link"
                                href="{{ $katalog->url($page) }}"
                            >
                                {{ $page }}
                            </a>

                        </li>

                    @endif

                @endforeach


                {{-- BERIKUTNYA --}}

                @if($katalog->hasMorePages())

                    <li class="page-item">

                        <a
                            class="page-link"
                            href="{{ $katalog->nextPageUrl() }}"
                            title="Halaman Selanjutnya"
                        >
                            &rsaquo;
                        </a>

                    </li>

                @else

                    <li class="page-item disabled">

                        <span class="page-link">
                            &rsaquo;
                        </span>

                    </li>

                @endif


                {{-- PALING AKHIR --}}

                @if($katalog->hasMorePages())

                    <li class="page-item">

                        <a
                            class="page-link"
                            href="{{ $katalog->url($katalog->lastPage()) }}"
                            title="Halaman Terakhir"
                        >
                            &raquo;&raquo;
                        </a>

                    </li>

                @else

                    <li class="page-item disabled">

                        <span class="page-link">
                            &raquo;&raquo;
                        </span>

                    </li>

                @endif

            </ul>

        </div>

    @endif

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | PENYIMPANAN ITEM TERPILIH
    |--------------------------------------------------------------------------
    */

    let selectedItems = new Set();


    /*
    |--------------------------------------------------------------------------
    | AMBIL ELEMENT
    |--------------------------------------------------------------------------
    */

    const cards = document.querySelectorAll('.katalog-card[data-id]');

    const selectedCount =
        document.getElementById('selected-count');

    const selectAllButton =
        document.getElementById('btn-select-all');

    const generateButton =
        document.getElementById('btn-generate-pdf');

    const selectedInputs =
        document.getElementById('selected-inputs');


    /*
    |--------------------------------------------------------------------------
    | UPDATE TAMPILAN
    |--------------------------------------------------------------------------
    */

    function updateSelectedUI() {

        selectedCount.textContent =
            selectedItems.size;

        generateButton.disabled =
            selectedItems.size === 0;


        /*
        |--------------------------------------------------------------------------
        | UPDATE CARD
        |--------------------------------------------------------------------------
        */

        cards.forEach(function (card) {

            const id =
                card.dataset.id;

            if (selectedItems.has(id)) {

                card.classList.add('selected');

            } else {

                card.classList.remove('selected');

            }

        });


        /*
        |--------------------------------------------------------------------------
        | UPDATE TOMBOL PILIH SEMUA
        |--------------------------------------------------------------------------
        */

        const visibleIds =
            Array.from(cards).map(function (card) {
                return card.dataset.id;
            });


        const allVisibleSelected =
            visibleIds.length > 0 &&
            visibleIds.every(function (id) {
                return selectedItems.has(id);
            });


        if (allVisibleSelected) {

            selectAllButton.textContent =
                'Batalkan Semua';

        } else {

            selectAllButton.textContent =
                'Pilih Semua';

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE INPUT FORM
        |--------------------------------------------------------------------------
        */

        selectedInputs.innerHTML = '';


        selectedItems.forEach(function (id) {

            const input =
                document.createElement('input');

            input.type = 'hidden';

            input.name =
                'produk_jasa_ids[]';

            input.value =
                id;

            selectedInputs.appendChild(input);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | KLIK KARTU
    |--------------------------------------------------------------------------
    */

    cards.forEach(function (card) {

        card.addEventListener('click', function (event) {

            /*
            |--------------------------------------------------------------------------
            | JIKA YANG DIKLIK ADALAH TOMBOL DETAIL
            |--------------------------------------------------------------------------
            */

            if (
                event.target.closest('.btn-detail')
            ) {
                return;
            }


            const id =
                card.dataset.id;


            /*
            |--------------------------------------------------------------------------
            | TOGGLE PILIHAN
            |--------------------------------------------------------------------------
            */

            if (selectedItems.has(id)) {

                selectedItems.delete(id);

            } else {

                selectedItems.add(id);

            }


            updateSelectedUI();

        });

    });


    /*
    |--------------------------------------------------------------------------
    | PILIH SEMUA ITEM YANG SEDANG TAMPIL
    |--------------------------------------------------------------------------
    */

    selectAllButton.addEventListener(
        'click',
        function () {

            const visibleIds =
                Array.from(cards).map(function (card) {
                    return card.dataset.id;
                });


            if (visibleIds.length === 0) {
                return;
            }


            const allVisibleSelected =
                visibleIds.every(function (id) {
                    return selectedItems.has(id);
                });


            if (allVisibleSelected) {

                visibleIds.forEach(function (id) {

                    selectedItems.delete(id);

                });

            } else {

                visibleIds.forEach(function (id) {

                    selectedItems.add(id);

                });

            }


            updateSelectedUI();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | CEGAH SUBMIT KOSONG
    |--------------------------------------------------------------------------
    */

    document
        .getElementById('pdf-form')
        .addEventListener('submit', function (event) {

            if (selectedItems.size === 0) {

                event.preventDefault();

                alert(
                    'Silakan pilih minimal satu produk atau jasa.'
                );

            }

        });


    /*
    |--------------------------------------------------------------------------
    | INIT
    |--------------------------------------------------------------------------
    */

    updateSelectedUI();

});
</script>

@endsection