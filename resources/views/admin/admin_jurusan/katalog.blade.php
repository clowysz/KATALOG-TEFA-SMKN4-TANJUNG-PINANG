@extends('admin.layouts.app-jurusan')

@section('title', 'Produk dan Jasa')

@section('content')

<style>
    /* =========================
       PAGE HEADER
    ========================= */

    .page-header {
        margin-bottom: 24px;
    }


    /* =========================
       SEARCH + FILTER
       TIDAK DIUBAH
    ========================= */

    .katalog-filter-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .katalog-search {
        background: #FFFFFF;
        padding: 12px 20px;
        border-radius: 12px;
        border: 1px solid #E2E8F0;

        display: flex;
        align-items: center;
        gap: 12px;

        width: 100%;
        max-width: 500px;

        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);

        box-sizing: border-box;
    }

    .katalog-search i {
        color: #94A3B8;
        font-size: 20px;
        flex-shrink: 0;
    }

    .katalog-search input {
        border: none;
        outline: none;

        width: 100%;

        font-size: 14px;
        color: #334155;
        background: transparent;

        font-family: inherit;
    }

    .katalog-search input::placeholder {
        color: #94A3B8;
    }


    /* =========================
       FILTER JENIS
       TIDAK DIUBAH
    ========================= */

    .katalog-filter-buttons {
        display: flex;
        align-items: center;
        gap: 8px;

        background: #FFFFFF;

        padding: 5px;

        border: 1px solid #E2E8F0;
        border-radius: 12px;

        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .katalog-filter-btn {
        border: none;
        background: transparent;

        color: #64748B;

        padding: 8px 14px;

        border-radius: 8px;

        font-size: 13px;
        font-weight: 600;

        cursor: pointer;

        transition: all 0.2s ease;

        font-family: inherit;
    }

    .katalog-filter-btn:hover {
        background: #F8FAFC;
        color: #1E3A8A;
    }

    .katalog-filter-btn.active {
        background: #1E3A8A;
        color: #FFFFFF;
    }


    /* =========================
       LOADING / EMPTY / ERROR
    ========================= */

    .katalog-state {
        background: white;
        border-radius: 16px;
        padding: 80px 20px;
        text-align: center;
        border: 1px dashed #cbd5e1;
    }


    /* =========================
       SECTION
    ========================= */

    .katalog-section-title {
        margin-bottom: 16px;

        color: #1e293b;

        display: flex;
        align-items: center;

        gap: 8px;

        font-size: 18px;
        font-weight: 700;
    }

    .katalog-section-title i {
        font-size: 21px;
    }


    /* =========================
       CARD GRID
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;

        max-width: 1200px;
        margin: 0 auto;
       
    padding-left: 19px;
    padding-right: 19px;
    box-sizing: border-box;
} 


    /* =========================
       CARD
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-card {
        background: #FFFFFF;

        border-radius: 16px;

        overflow: hidden;

        border: 1px solid #E2E8F0;

        box-shadow:
            0 4px 15px rgba(0, 0, 0, 0.03);

        display: flex;
        flex-direction: column;
         height:370px;s
        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            border-color 0.2s ease,
            background 0.2s ease;

        position: relative;

        cursor: default;
    }

    .catalog-card:hover {
        transform: translateY(-5px);

        box-shadow:
            0 10px 25px rgba(30, 58, 138, 0.1);
    }
   
    /* =========================
       IMAGE
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-img-wrapper {
        position: relative;

        width: 100%;

        height: 150px;

        background: #E2E8F0;

        overflow: hidden;
    }

    .catalog-img {
        width: 100%;
        height: 100%;

        object-fit: cover;

        transition:
            transform 0.3s ease;
    }

    .catalog-card:hover .catalog-img {
        transform: scale(1.02);
    }


    /* =========================
       NO IMAGE
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-no-img {
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
       JUMLAH PESANAN
       KHUSUS ADMIN JURUSAN
       TETAP KIRI ATAS
    ========================= */

    .catalog-stats {
        position: absolute;

        top: 12px;
        left: 12px;

        background:
            rgba(255, 255, 255, 0.95);

        color: #475569;

        padding: 5px 10px;

        border-radius: 20px;

        font-size: 11px;

        font-weight: 700;

        z-index: 3;

        box-shadow:
            0 2px 6px rgba(0, 0, 0, 0.12);
    }

    .catalog-stats i {
        font-size: 12px;
        margin-right: 3px;
    }


    /* =========================
       BADGE JENIS
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-badge {
        position: absolute;

        top: 12px;
        right: 12px;

        background:
            rgba(30, 58, 138, 0.9);

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
       CARD CONTENT
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-content {
        padding: 20px;

        display: flex;

        flex-direction: column;

        flex-grow: 1;
    }

    .catalog-title {
        font-size: 16px;

        font-weight: 700;

        color: #1E2D3D;

        margin-bottom: 8px;

        font-family: 'Poppins', sans-serif;

        line-height: 1.4;
    }

    .catalog-jurusan {
        font-size: 12px;

        color: #64748B;

        line-height: 1.5;

        margin-bottom: 8px;
    }

    .catalog-desc {
        font-size: 12px;

        color: #64748B;

        line-height: 1.5;

        margin-bottom: 16px;

        flex-grow: 1;
    }


    /* =========================
       HARGA
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .catalog-price {
        font-size: 18px;

        font-weight: 800;

        color: #1E3A8A;

        margin-bottom: 16px;
    }


    /* =========================
       DETAIL BUTTON
       SAMA PERSIS ADMIN TEFA
    ========================= */

    .btn-lihat-detail {
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

    .btn-lihat-detail:hover {
        background: #1E3A8A;

        color: #FFFFFF;

        border-color: #1E3A8A;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 768px) {

        .katalog-filter-bar {
            align-items: stretch;
        }

        .katalog-search {
            max-width: none;
        }

        .katalog-filter-buttons {
            width: 100%;
            justify-content: stretch;
        }

        .katalog-filter-btn {
            flex: 1;
        }

        .catalog-grid {
            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 16px;
        }

        .catalog-content {
            padding: 16px;
        }
    }

    @media (max-width: 480px) {

        .catalog-grid {
            grid-template-columns: 1fr;
        }
    }
</style>


<div class="page-header">

    <h2
        style="
            font-size: 20px;
            color: #1e293b;
            margin-bottom: 4px;
        "
    >
        Katalog Produk & Jasa
    </h2>

    <p
        style="
            color: #64748b;
            font-size: 14px;
            margin: 0;
        "
    >
        Etalase layanan Rekayasa Perangkat Lunak dan statistik pesanan
    </p>

</div>


<!-- =========================
     SEARCH + FILTER
     TETAP SEPERTI KODE USER
========================= -->

<div class="katalog-filter-bar">

    <div class="katalog-search">

        <i class="ph ph-magnifying-glass"></i>

        <input
            type="text"
            id="searchKatalog"
            placeholder="Cari nama produk atau jasa..."
        >

    </div>


    <div class="katalog-filter-buttons">

        <button
            type="button"
            class="katalog-filter-btn active"
            data-filter="semua"
        >
            Semua
        </button>

        <button
            type="button"
            class="katalog-filter-btn"
            data-filter="produk"
        >
            Produk
        </button>

        <button
            type="button"
            class="katalog-filter-btn"
            data-filter="jasa"
        >
            Jasa
        </button>

    </div>

</div>


<!-- =========================
     LOADING
========================= -->

<div
    id="katalogLoading"
    class="katalog-state"
>

    <div
        style="
            font-size: 40px;
            margin-bottom: 12px;
        "
    >

        <i
            class="ph ph-spinner-gap"
            style="color: #1E3A8A;"
        ></i>

    </div>

    <h3
        style="
            color: #1e293b;
            font-size: 18px;
        "
    >
        Memuat katalog...
    </h3>

</div>


<!-- =========================
     CONTENT
========================= -->

<div
    id="katalogContent"
    style="display: none;"
>


    <!-- =========================
         PRODUK
    ========================= -->

    <div id="produkSection">

        <h3 class="katalog-section-title">

            <i
                class="ph ph-package"
                style="color: #1E3A8A;"
            ></i>

            <span>Daftar Produk</span>

        </h3>


        <div
            id="produkContainer"
            class="catalog-grid"
            style="margin-bottom: 32px;"
        ></div>

    </div>


    <!-- =========================
         JASA
    ========================= -->

    <div id="jasaSection">

        <h3 class="katalog-section-title">

            <i
                class="ph ph-briefcase"
                style="color: #573911;"
            ></i>

            <span>Daftar Jasa</span>

        </h3>


        <div
            id="jasaContainer"
            class="catalog-grid"
        ></div>

    </div>

</div>


<!-- =========================
     EMPTY
========================= -->

<div
    id="katalogEmpty"
    class="katalog-state"
    style="display: none;"
>

    <div
        style="
            background: #f1f5f9;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        "
    >

        <i
            class="ph ph-package"
            style="
                font-size: 40px;
                color: #94a3b8;
            "
        ></i>

    </div>


    <h3
        style="
            color: #1e293b;
            font-size: 20px;
            margin-bottom: 8px;
        "
    >
        Katalog Masih Kosong
    </h3>


    <p
        style="
            color: #64748b;
            font-size: 14px;
            margin-bottom: 24px;
        "
    >
        Belum ada produk atau jasa yang ditambahkan dari database.
    </p>

</div>


<!-- =========================
     ERROR
========================= -->

<div
    id="katalogError"
    class="katalog-state"
    style="display: none;"
>

    <div
        style="
            background: #FEF2F2;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
        "
    >

        <i
            class="ph ph-warning"
            style="
                font-size: 40px;
                color: #DC2626;
            "
        ></i>

    </div>


    <h3
        style="
            color: #1e293b;
            margin-bottom: 8px;
        "
    >
        Gagal Memuat Katalog
    </h3>


    <p style="color: #64748b;">
        Silakan refresh halaman dan coba lagi.
    </p>

</div>


@endsection


@section('scripts')

<script src="{{ asset('js/katalog-jurusan.js') }}"></script>

@endsection