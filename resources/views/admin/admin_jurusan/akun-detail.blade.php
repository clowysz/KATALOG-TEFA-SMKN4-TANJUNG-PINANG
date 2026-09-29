@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Akun')

@section('content')

<style>
    .detail-account-wrapper {
        padding: 24px;
    }

    .detail-account-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
    }

    .detail-account-title {
        margin: 0;
        color: #1E3A8A;
        font-weight: 700;
    }

    .detail-account-subtitle {
        margin: 5px 0 0;
        color: #6c757d;
        font-size: 14px;
    }

    .detail-card {
        background: #fff;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        margin-bottom: 20px;
    }

    .detail-card-title {
        font-size: 18px;
        font-weight: 700;
        color: #1E3A8A;
        margin-bottom: 20px;
    }

    .detail-row {
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        color: #6c757d;
        font-weight: 600;
    }

    .detail-value {
        color: #212529;
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-aktif {
        background: #dcfce7;
        color: #166534;
    }

    .status-tidak-aktif {
        background: #fee2e2;
        color: #991b1b;
    }

    .service-list {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .service-item {
        padding: 9px 14px;
        border-radius: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1E3A8A;
        font-weight: 600;
        font-size: 14px;
    }

    .empty-service {
        color: #6c757d;
        margin: 0;
    }

    .detail-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-detail {
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-edit {
        background: #1E3A8A;
        color: #fff;
    }

    .btn-edit:hover {
        background: #172f70;
        color: #fff;
    }

    .btn-back {
        background: #e9ecef;
        color: #343a40;
    }

    .btn-back:hover {
        background: #dee2e6;
        color: #343a40;
    }

    .btn-status {
        background: #fff3cd;
        color: #856404;
    }

    .btn-status:hover {
        background: #ffe69c;
    }

    .btn-danger {
        background: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background: #bb2d3b;
        color: #fff;
    }

    @media (max-width: 768px) {
        .detail-account-wrapper {
            padding: 15px;
        }

        .detail-account-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-row {
            grid-template-columns: 1fr;
            gap: 4px;
        }
    }
</style>

<div class="detail-account-wrapper">

    {{-- HEADER --}}
    <div class="detail-account-header">

        <div>
            <h2 class="detail-account-title">
                Detail Akun Admin Produser
            </h2>

            <p class="detail-account-subtitle">
                Informasi lengkap akun Admin Produser pada jurusan Anda.
            </p>
        </div>

        <a
            href="{{ route('jurusan.akun.index') }}"
            class="btn-detail btn-back"
        >
            ← Kembali
        </a>

    </div>


    {{-- INFORMASI AKUN --}}
    <div class="detail-card">

        <div class="detail-card-title">
            Informasi Akun
        </div>

        <div class="detail-row">

            <div class="detail-label">
                Nama
            </div>

            <div class="detail-value">
                {{ $akun->nama }}
            </div>

        </div>


        <div class="detail-row">

            <div class="detail-label">
                Email
            </div>

            <div class="detail-value">
                {{ $akun->email }}
            </div>

        </div>


        <div class="detail-row">

            <div class="detail-label">
                Role
            </div>

            <div class="detail-value">
                Admin Produser
            </div>

        </div>


        <div class="detail-row">

            <div class="detail-label">
                Jurusan
            </div>

            <div class="detail-value">
                {{ $jurusan->nama_jurusan }}
            </div>

        </div>


        <div class="detail-row">

            <div class="detail-label">
                Status
            </div>

            <div class="detail-value">

                @if ($akun->status === 'aktif')

                    <span class="status-badge status-aktif">
                        Aktif
                    </span>

                @else

                    <span class="status-badge status-tidak-aktif">
                        Tidak Aktif
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- PRODUK / JASA YANG DITUGASKAN --}}
    <div class="detail-card">

        <div class="detail-card-title">
            Produk / Jasa yang Ditugaskan
        </div>

        <div class="service-list">

            @forelse ($akun->penugasanProduser as $penugasan)

                @if ($penugasan->produkJasa)

                    <div class="service-item">
                        {{ $penugasan->produkJasa->nama_produk_jasa }}
                    </div>

                @endif

            @empty

                <p class="empty-service">
                    Belum ada produk atau jasa yang ditugaskan
                    kepada akun ini.
                </p>

            @endforelse

        </div>

    </div>


    {{-- ACTION --}}
    <div class="detail-card">

        <div class="detail-card-title">
            Aksi Akun
        </div>

        <div class="detail-actions">

            <a
                href="{{ route('jurusan.akun.edit', ['id' => $akun->id]) }}"
                class="btn-detail btn-edit"
            >
                Edit Akun
            </a>


            @if ($akun->status === 'aktif')

                <button
                    type="button"
                    id="btnHapusAkses"
                    class="btn-detail btn-status"
                >
                    Nonaktifkan Akun
                </button>

            @else

                <button
                    type="button"
                    id="btnAktifkan"
                    class="btn-detail btn-status"
                >
                    Aktifkan Akun
                </button>

            @endif

        </div>

    </div>

</div>


{{-- MODAL KONFIRMASI STATUS --}}
<div
    id="statusModal"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.45);
        z-index:9999;
        align-items:center;
        justify-content:center;
        padding:20px;
    "
>

    <div
        style="
            background:#fff;
            width:100%;
            max-width:420px;
            border-radius:16px;
            padding:24px;
            box-shadow:0 15px 40px rgba(0,0,0,.2);
        "
    >

        <h4 style="margin-top:0;">
            Konfirmasi
        </h4>

        <p style="color:#6c757d;">
            Apakah Anda yakin ingin mengubah status akun ini?
        </p>

        <div
            style="
                display:flex;
                justify-content:flex-end;
                gap:10px;
                margin-top:20px;
            "
        >

            <button
                type="button"
                id="btnCloseStatusModal"
                class="btn-detail btn-back"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmStatus"
                class="btn-detail btn-danger"
            >
                Ya, Nonaktifkan
            </button>

        </div>

    </div>

</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const accountId = @json($akun->id);

    const statusModal = document.getElementById('statusModal');
    const btnHapusAkses = document.getElementById('btnHapusAkses');
    const btnAktifkan = document.getElementById('btnAktifkan');
    const btnCloseStatusModal = document.getElementById('btnCloseStatusModal');
    const btnConfirmStatus = document.getElementById('btnConfirmStatus');


    function openModal() {
        if (statusModal) {
            statusModal.style.display = 'flex';
        }
    }


    function closeModal() {
        if (statusModal) {
            statusModal.style.display = 'none';
        }
    }


    if (btnHapusAkses) {

        btnHapusAkses.addEventListener('click', function () {
            openModal();
        });

    }


    if (btnCloseStatusModal) {

        btnCloseStatusModal.addEventListener('click', function () {
            closeModal();
        });

    }


    if (btnConfirmStatus) {

        btnConfirmStatus.addEventListener('click', function () {

            fetch('{{ route('jurusan.akun.status') }}', {

                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    id: accountId,
                    status: 'tidak_aktif'
                })

            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {
                    window.location.reload();
                    return;
                }

                alert(
                    data.message ??
                    'Gagal mengubah status akun.'
                );

            })

            .catch(error => {

                console.error(error);

                alert(
                    'Terjadi kesalahan saat mengubah status akun.'
                );

            });

        });

    }


    if (btnAktifkan) {

        btnAktifkan.addEventListener('click', function () {

            fetch('{{ route('jurusan.akun.status') }}', {

                method: 'PUT',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },

                body: JSON.stringify({
                    id: accountId,
                    status: 'aktif'
                })

            })

            .then(response => response.json())

            .then(data => {

                if (data.success) {
                    window.location.reload();
                    return;
                }

                alert(
                    data.message ??
                    'Gagal mengaktifkan akun.'
                );

            })

            .catch(error => {

                console.error(error);

                alert(
                    'Terjadi kesalahan saat mengaktifkan akun.'
                );

            });

        });

    }


    if (statusModal) {

        statusModal.addEventListener('click', function (event) {

            if (event.target === statusModal) {
                closeModal();
            }

        });

    }

});
</script>

@endsection