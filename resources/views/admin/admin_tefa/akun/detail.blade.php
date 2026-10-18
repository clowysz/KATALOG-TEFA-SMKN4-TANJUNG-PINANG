@extends('admin.layouts.app')

@section('title','Detail Akun')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/akun-tefa.css') }}?v=2">
@endpush

@section('content')

<div class="detail-wrapper">

    <a
        href="{{ route('akun.index') }}"
        class="btn-back"
    >
        &larr; Kembali ke Daftar Akun
    </a>


    <h2 class="page-title">
        Detail Akun
    </h2>


    @if(session('success'))

        <div class="alert-custom alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-custom alert-danger">

            <ul class="alert-list">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <div class="detail-card">

        <div class="info-row">

            <span class="info-label">
                Nama Pengguna
            </span>

            <span class="info-value">
                {{ $akun->nama }}
            </span>

        </div>


        <div class="info-row">

            <span class="info-label">
                Email
            </span>

            <span class="info-value">
                {{ $akun->email }}
            </span>

        </div>


        <div class="info-row">

            <span class="info-label">
                Role
            </span>

            <span class="info-value">

                <span class="badge-role">
                    {{ $akun->role === 'admin_tefa' ? 'Admin TEFA' : 'Admin Jurusan' }}
                </span>

            </span>

        </div>


        <div class="info-row">

            <span class="info-label">
                Jurusan
            </span>

            <span class="info-value">
                {{ $akun->jurusanDipegang->nama_jurusan ?? '—' }}
            </span>

        </div>


        <div class="info-row">

            <span class="info-label">
                Status Akun
            </span>

            <span class="info-value">

                @if($akun->status === 'aktif')

                    <span class="badge-status status-active">
                        ● Aktif
                    </span>

                @else

                    <span class="badge-status status-inactive">
                        ● Nonaktif
                    </span>

                @endif

            </span>

        </div>


        <div class="info-row">

            <span class="info-label">
                Password
            </span>

            <span class="info-value info-value-password">
                ••••••••
            </span>

        </div>

    </div>


    <!-- Tombol Aksi -->
    <div class="action-buttons">

        <a
            href="{{ route('akun.edit',$akun->id) }}"
            class="btn-custom btn-primary-custom"
        >
            Edit Akun
        </a>


        <button
            type="button"
            id="btnResetPassword"
            class="btn-custom btn-outline-primary-custom"
        >
            Reset Password
        </button>


        @if($akun->status === 'aktif')

            <form
                id="accessActionForm"
                class="access-form"
                action="{{ route('akun.updateStatus',$akun->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')

                <input
                    type="hidden"
                    name="status"
                    value="tidak_aktif"
                >

                <button
                    type="button"
                    class="btn-custom btn-outline-danger-custom"
                    data-access-open="nonaktifkan"
                >
                    Hapus Akses
                </button>

            </form>

        @else

            <form
                id="accessActionForm"
                class="access-form"
                action="{{ route('akun.updateStatus',$akun->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')

                <input
                    type="hidden"
                    name="status"
                    value="aktif"
                >

                <button
                    type="button"
                    class="btn-custom btn-outline-primary-custom"
                    data-access-open="aktifkan"
                >
                    Aktifkan Akses
                </button>

            </form>

        @endif

    </div>


    <!-- Form Reset Password (ditampilkan / disembunyikan oleh akun-detail.js) -->
    <div
        id="resetPasswordForm"
        class="reset-form-box"
        style="display:none;"
    >

        <h3 class="reset-form-title">
            Reset Password
        </h3>


        <form
            action="{{ route('akun.resetPassword',$akun->id) }}"
            method="POST"
        >

            @csrf

            @method('PUT')


            <div class="form-group-custom">

                <label for="password">
                    Password Baru
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control-custom"
                    required
                    minlength="6"
                >

            </div>


            <div class="form-group-custom">

                <label for="password_confirmation">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control-custom"
                    required
                    minlength="6"
                >

            </div>


            <div class="reset-form-actions">

                <button
                    type="button"
                    id="cancelReset"
                    class="btn-custom btn-outline-primary-custom"
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="btn-custom btn-primary-custom"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


{{-- =========================
     MODAL KONFIRMASI AKSES
     (ditampilkan oleh akun-access-modal.js)
========================== --}}

<div
    id="accessModal"
    class="modal-access-overlay"
    style="display:none;"
>

    <div class="modal-access-box">

        <h3
            id="accessModalTitle"
            class="modal-access-title"
        >
            Hapus Akses?
        </h3>


        <p
            id="accessModalDesc"
            class="modal-access-desc"
        >
            Apakah Anda yakin ingin menonaktifkan akses akun ini?
        </p>


        <div class="modal-access-actions">

            <button
                type="button"
                class="btn-modal-access-cancel"
                data-access-close
            >
                Batal
            </button>


            <button
                type="button"
                class="btn-modal-access-confirm"
                data-access-submit
            >
                Hapus Akses
            </button>

        </div>

    </div>

</div>


@endsection


@section('scripts')

<script src="{{ asset('js/akun-detail.js') }}"></script>

@endsection