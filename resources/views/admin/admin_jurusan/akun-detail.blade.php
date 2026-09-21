@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Akun')

@section('content')

<div style="max-width: 600px; margin: 40px auto 24px auto;">

    <div
        class="tefa-card"
        style="
            padding: 32px;
            border-radius: 16px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        "
    >

        <!-- IDENTITAS AKUN -->
        <div class="detail-avatar-box">

            <div class="avatar-square">
                <i class="ph ph-user"></i>
            </div>

            <div>
                <h2
                    style="
                        font-size: 20px;
                        color: var(--text-dark);
                        margin-bottom: 4px;
                    "
                >
                    {{ $akun->nama }}
                </h2>

                <p
                    style="
                        color: var(--text-muted);
                        font-size: 14px;
                    "
                >
                    {{ $akun->email }}
                </p>
            </div>

        </div>

        <!-- ROLE -->
        <div class="detail-row">

            <div class="detail-row-label">
                Role
            </div>

            <div class="detail-row-value">
                Admin Produser
            </div>

        </div>

        <!-- PASSWORD -->
        <div class="detail-row">

            <div class="detail-row-label">
                Password
            </div>

            <div class="detail-row-value">
                ••••••••
            </div>

        </div>

        <!-- STATUS -->
        <div class="detail-row">

            <div class="detail-row-label">
                Status Akun
            </div>

            <div class="detail-row-value">

                @if ($akun->status === 'aktif')

                    <span class="badge">
                        Aktif
                    </span>

                @else

                    <span class="badge">
                        Tidak Aktif
                    </span>

                @endif

            </div>

        </div>

        <!-- JURUSAN -->
        <div class="detail-row">

            <div class="detail-row-label">
                Jurusan
            </div>

            <div class="detail-row-value">
                {{ $jurusan->nama_jurusan ?? '-' }}
            </div>

        </div>

        <!-- PRODUK / JASA -->
        <div style="padding-top: 16px;">

            <div
                class="detail-row-label"
                style="margin-bottom: 12px;"
            >
                Produk/Jasa Tanggung Jawab
            </div>

            <div
                id="detLayanan"
                style="
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                "
            >

                @forelse ($akun->penugasanProduser as $penugasan)

                    @if ($penugasan->produkJasa)

                        <span class="badge">
                            {{ $penugasan->produkJasa->nama_produk_jasa }}
                        </span>

                    @endif

                @empty

                    <span style="color: #6c757d;">
                        Belum ada produk/jasa yang ditugaskan.
                    </span>

                @endforelse

            </div>

        </div>

    </div>

    <!-- TOMBOL AKSI -->
    <div>

        <!-- EDIT AKUN -->
        <button
            id="btnToEdit"
            class="stacked-btn stacked-btn-primary"
            type="button"
            onclick="
                window.location.href =
                '/jurusan-admin/akun/edit?id={{ $akun->id }}'
            "
        >
            <i class="ph ph-pencil-simple"></i>
            Edit Akun
        </button>

        <!-- RESET PASSWORD -->
        <button
            onclick="openModal('modalReset')"
            class="stacked-btn stacked-btn-outline"
            type="button"
        >
            <i class="ph ph-key"></i>
            Reset Password
        </button>

        @if ($akun->status === 'aktif')

            <!-- HAPUS AKSES -->
            <button
                id="btnHapusAkses"
                onclick="openModal('modalHapus')"
                class="stacked-btn stacked-btn-danger"
                type="button"
            >
                <i class="ph ph-shield-warning"></i>
                Hapus Akses
            </button>

        @else

            <!-- AKTIFKAN KEMBALI -->
            <button
                id="btnAktifkan"
                class="stacked-btn stacked-btn-outline"
                type="button"
                style="
                    color:#28a745;
                    border-color:#28a745;
                "
            >
                <i class="ph ph-check-circle"></i>
                Aktifkan Kembali
            </button>

        @endif

    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL RESET PASSWORD -->
<!-- ===================================================== -->

<div id="modalReset" class="modal-overlay">

    <div class="modal-box">

        <div class="modal-title">
            Reset Password?
        </div>

        <div class="modal-desc">
            Apakah Anda yakin ingin mereset password akun ini?
        </div>

        <form id="formResetPassword">
            @csrf

            <label class="detail-label">
                Password Baru
            </label>

            <input
                type="password"
                id="newPass"
                class="form-control"
                placeholder="Masukkan password baru"
                required
            >

            <label class="detail-label">
                Konfirmasi Password Baru
            </label>

            <input
                type="password"
                id="confirmPass"
                class="form-control"
                placeholder="Ulangi password baru"
                required
            >

            <div
                class="show-password"
                style="margin-top: 8px;"
            >
                <input
                    type="checkbox"
                    id="toggleModalPass"
                >

                <label for="toggleModalPass">
                    Perlihatkan Password
                </label>
            </div>

            <div
                id="errorReset"
                style="
                    color: #dc3545;
                    font-size: 13px;
                    display: none;
                    margin-top: 8px;
                "
            >
                Password tidak cocok.
            </div>

            <div class="modal-actions">

                <button
                    type="button"
                    class="btn-outline"
                    onclick="closeModal('modalReset')"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-primary"
                    style="width: auto;"
                >
                    Reset Password
                </button>

            </div>

        </form>

    </div>

</div>

<!-- ===================================================== -->
<!-- MODAL HAPUS AKSES -->
<!-- ===================================================== -->

<div id="modalHapus" class="modal-overlay">

    <div class="modal-box">

        <div class="modal-title">
            Hapus Akses Akun?
        </div>

        <div
            class="modal-desc"
            id="hapusDesc"
        >
            Akun ini tidak dapat lagi mengakses halaman internal
            setelah akses dihapus. Data akun tetap tersimpan
            di dalam daftar akun.
        </div>

        <div class="modal-actions">

            <button
                type="button"
                class="btn-outline"
                onclick="closeModal('modalHapus')"
            >
                Batal
            </button>

            <button
                type="button"
                id="btnConfirmStatus"
                class="btn-primary"
                style="
                    width: auto;
                    background-color: #dc3545;
                "
            >
                Hapus Akses
            </button>

        </div>

    </div>

</div>

<div id="toastAction" class="toast-notification"></div>

@endsection

@section('scripts')

<script src="{{ asset('js/akun-jurusan-action.js') }}"></script>

@endsection