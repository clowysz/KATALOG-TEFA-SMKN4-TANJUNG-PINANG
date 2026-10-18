@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Akun')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/akun-detail-jurusan.css') }}?v=1">
@endsection

@section('content')

<div
    id="akunDetail"
    class="akun-detail-wrapper"
    data-akun-id="{{ $akun->id }}"
    data-status-url="{{ route('jurusan.akun.status') }}"
>

    {{-- HEADER --}}
    <div class="akun-detail-header">

        <a href="{{ route('jurusan.akun.index') }}" class="btn-jurusan-outline">
            ← Kembali
        </a>

        <div>
            <h2 class="akun-detail-title">
                Detail Akun Admin Produser
            </h2>

            <p class="akun-detail-subtitle">
                Informasi lengkap akun Admin Produser pada jurusan Anda.
            </p>
        </div>

    </div>


    {{-- INFORMASI AKUN --}}
    <div class="akun-detail-card">

        <div class="akun-detail-card-title">
            Informasi Akun
        </div>

        <div class="akun-detail-row">
            <div class="akun-detail-label">Nama</div>
            <div class="akun-detail-value">{{ $akun->nama }}</div>
        </div>

        <div class="akun-detail-row">
            <div class="akun-detail-label">Email</div>
            <div class="akun-detail-value">{{ $akun->email }}</div>
        </div>

        <div class="akun-detail-row">
            <div class="akun-detail-label">Role</div>
            <div class="akun-detail-value">Admin Produser</div>
        </div>

        <div class="akun-detail-row">
            <div class="akun-detail-label">Jurusan</div>
            <div class="akun-detail-value">{{ $jurusan->nama_jurusan }}</div>
        </div>

        <div class="akun-detail-row">

            <div class="akun-detail-label">Status</div>

            <div class="akun-detail-value">

                @if ($akun->status === 'aktif')

                    <span class="akun-detail-status akun-detail-status--aktif">
                        Aktif
                    </span>

                @else

                    <span class="akun-detail-status akun-detail-status--tidak-aktif">
                        Tidak Aktif
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- PRODUK / JASA YANG DITUGASKAN --}}
    <div class="akun-detail-card">

        <div class="akun-detail-card-title">
            Produk / Jasa yang Ditugaskan
        </div>

        <div class="akun-detail-services">

            @forelse ($akun->penugasanProduser as $penugasan)

                @if ($penugasan->produkJasa)

                    <div class="akun-detail-service">
                        {{ $penugasan->produkJasa->nama_produk_jasa }}
                    </div>

                @endif

            @empty

                <p class="akun-detail-empty">
                    Belum ada produk atau jasa yang ditugaskan
                    kepada akun ini.
                </p>

            @endforelse

        </div>

    </div>


    {{-- AKSI --}}
    <div class="akun-detail-card">

        <div class="akun-detail-card-title">
            Aksi Akun
        </div>

        <div class="akun-detail-actions">

            <a
                href="{{ route('jurusan.akun.edit', ['id' => $akun->id, 'from' => 'detail']) }}"
                class="btn-jurusan-primary"
            >
                Edit Akun
            </a>

            @if ($akun->status === 'aktif')

                <button
                    type="button"
                    id="btnNonaktifkan"
                    class="btn-jurusan-warning"
                >
                    Nonaktifkan Akun
                </button>

            @else

                <button
                    type="button"
                    id="btnAktifkan"
                    class="btn-jurusan-warning"
                >
                    Aktifkan Akun
                </button>

            @endif

        </div>

    </div>

</div>


{{-- MODAL KONFIRMASI STATUS --}}
<div id="statusModal" class="modal-overlay">

    <div class="modal-box">

        <div class="modal-title">
            Konfirmasi
        </div>

        <div class="modal-desc">
            Apakah Anda yakin ingin mengubah status akun ini?
        </div>

        <div class="modal-actions">

            <button
                type="button"
                id="btnCloseStatusModal"
                class="btn-jurusan-secondary"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmStatus"
                class="btn-jurusan-danger"
            >
                Ya, Nonaktifkan
            </button>

        </div>

    </div>

</div>

@endsection


@section('scripts')
<script src="{{ asset('js/akun-detail-jurusan.js') }}"></script>
@endsection