@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/pesanan-tefa.css') }}?v=1">
@endpush

@section('content')

<div class="detail-pesanan-container">

    {{-- =========================
         HEADER
         ========================= --}}

    <div class="detail-pesanan-header">

        <a
            href="{{ route('pesanan.index') }}"
            class="btn-back-pesanan"
        >
            &larr; Kembali ke Kelola Pesanan
        </a>

        <h2 class="detail-pesanan-title">
            Detail Pesanan #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
        </h2>

        <p class="detail-pesanan-subtitle">
            Informasi lengkap dan pembaruan status pesanan
        </p>

    </div>


    {{-- PESAN HASIL UPDATE STATUS --}}
    @if(session('success'))
        <div class="pesanan-alert pesanan-alert-success">
            <i class="ph ph-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="pesanan-alert pesanan-alert-error">
            <i class="ph ph-warning-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="pesanan-alert pesanan-alert-error">
            <i class="ph ph-warning-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif


    {{-- =========================
         INFORMASI PESANAN
         ========================= --}}

    <div class="detail-pesanan-grid">

        <div class="detail-pesanan-card">

            <h3 class="detail-card-title">
                Informasi Pesanan
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nomor Pesanan
                    </span>

                    <div class="detail-value">
                        #ORD-{{ str_pad($pesanan->id_pesanan, 3, '0', STR_PAD_LEFT) }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Tanggal Pesanan
                    </span>

                    <div class="detail-value">
                        {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y, H:i') }}
                        WIB
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Status Saat Ini
                    </span>

                    <div class="detail-value">

                        <span class="badge-status-pesanan">
                            {{ ucfirst($pesanan->status) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             INFORMASI PEMBELI
             ========================= --}}

        <div class="detail-pesanan-card">

            <h3 class="detail-card-title">
                Informasi Pembeli
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nama Lengkap
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->nama ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Email
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->email ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Nomor Telepon
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->pembeli->nomor_hp ?? '-' }}
                    </div>

                </div>

            </div>

        </div>


        {{-- =========================
             INFORMASI PRODUK / JASA
             ========================= --}}

        <div class="detail-pesanan-card detail-pesanan-grid-full">

            <h3 class="detail-card-title">
                Informasi Produk / Jasa
            </h3>

            <div class="detail-info-grid">

                <div class="detail-info-item">

                    <span class="detail-label">
                        Nama Produk/Jasa
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->produkJasa->nama_produk_jasa ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jurusan
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->produkJasa->jurusan->nama_jurusan ?? '-' }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jenis
                    </span>

                    <div class="detail-value">
                        {{ strtoupper($pesanan->produkJasa->jenis ?? '-') }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Harga Satuan
                    </span>

                    <div class="detail-value">
                        Rp{{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Jumlah Pesanan
                    </span>

                    <div class="detail-value">
                        {{ $pesanan->jumlah }}
                    </div>

                </div>


                <div class="detail-info-item">

                    <span class="detail-label">
                        Total Harga
                    </span>

                    <div class="detail-value">
                        Rp{{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>

                </div>

            </div>


            {{-- Catatan --}}
            <div class="catatan-pesanan">

                <span class="detail-label">
                    Catatan / Kebutuhan Pembeli
                </span>

                <div class="catatan-content">

                    @if($pesanan->catatan)

                        {{ $pesanan->catatan }}

                    @else

                        Tidak ada catatan dari pembeli.

                    @endif

                </div>

            </div>

        </div>

    </div>


   
  
{{-- PEMBUNGKUS KOTAK STATUS DAN PEMBATALAN --}}
<div class="detail-pesanan-bottom">

    {{-- KOTAK UPDATE STATUS --}}
    <div class="detail-pesanan-card status-card">

    <h3 class="detail-card-title">Update Status Pesanan</h3>

    @php
        $pembatalanMenunggu =
            $pesanan->permintaanPembatalan &&
            $pesanan->permintaanPembatalan->status_permintaan === 'menunggu';
    @endphp

    @if($pesanan->status === 'diproses')
        <div class="detail-pesanan-alert">
            Pesanan sudah diteruskan ke Admin Produser untuk dikerjakan.
        </div>
    @endif

    @if($pesanan->status === 'dibatalkan')

        <p>
            Pesanan ini sudah dibatalkan. Status tidak dapat diubah
            melalui bagian ini.
        </p>

    @elseif($pembatalanMenunggu)

        <div class="detail-pesanan-alert">
            Pembeli mengajukan pembatalan. Update status pesanan
            dikunci sampai Admin TEFA mengambil keputusan.
        </div>

        <form action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
              method="POST">
            @csrf

            <div class="status-form-group">
                <label for="statusSelect" class="status-form-label">
                    Ubah Status Menjadi:
                </label>

                <select id="statusSelect"
                        name="status"
                        class="status-select"
                        disabled>
                    <option value="{{ $pesanan->status }}" selected>
                        {{ ucfirst($pesanan->status) }}
                    </option>
                </select>
            </div>

            <div class="status-form-actions">
                <button type="submit"
                        class="btn-save-status"
                        disabled>
                    Simpan Perubahan
                </button>
            </div>
        </form>

    @else

        <form action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
              method="POST">
            @csrf

            <div class="status-form-group">
                <label for="statusSelect" class="status-form-label">
                    Ubah Status Menjadi:
                </label>

                <select id="statusSelect"
                        name="status"
                        class="status-select"
                        required>
                    <option value="menunggu konfirmasi"
                        {{ $pesanan->status === 'menunggu konfirmasi' ? 'selected' : '' }}>
                        Menunggu Konfirmasi
                    </option>

                    <option value="konfirmasi"
                        {{ $pesanan->status === 'konfirmasi' ? 'selected' : '' }}>
                        Konfirmasi
                    </option>

                    <option value="diproses"
                        {{ $pesanan->status === 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>

                    <option value="selesai"
                        {{ $pesanan->status === 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                </select>
            </div>

            <div class="status-form-actions">
                <button type="submit" class="btn-save-status">
                    Simpan Perubahan
                </button>
            </div>
        </form>
   @endif
</div>



        {{-- KOTAK PEMBATALAN PESANAN --}}
        <div class="detail-pesanan-card cancellation-card">

            <h3 class="detail-card-title">Pembatalan Pesanan</h3>

            @php
                $permintaan = $pesanan->permintaanPembatalan;
            @endphp

            @if(!$permintaan)

                <div class="cancellation-empty">
                    <p><strong>Belum ada permintaan pembatalan.</strong></p>
                    <p>Jika pembeli mengajukan pembatalan, permintaannya akan muncul di sini.</p>
                </div>

            @else

                <div class="cancellation-info">
                    <div class="cancellation-row">
                        <span class="cancellation-label">Status Permintaan</span>

                        @if($permintaan->status_permintaan === 'menunggu')
                            <span class="cancellation-badge pending">Menunggu Persetujuan</span>
                        @elseif($permintaan->status_permintaan === 'disetujui')
                            <span class="cancellation-badge approved">Disetujui</span>
                        @else
                            <span class="cancellation-badge rejected">Ditolak</span>
                        @endif
                    </div>

                    <div class="cancellation-row">
                        <span class="cancellation-label">Alasan Pembeli</span>
                        <p>{{ $permintaan->alasan }}</p>
                    </div>

                    @if($permintaan->catatan_admin)
                        <div class="cancellation-row">
                            <span class="cancellation-label">Catatan Admin</span>
                            <p>{{ $permintaan->catatan_admin }}</p>
                        </div>
                    @endif
                </div>

                @if(
                    $permintaan->status_permintaan === 'menunggu'
                    && $pesanan->status === 'konfirmasi'
                )

                    <div class="cancellation-actions">

                        <form
                        action="{{ route('pesanan.permintaan-pembatalan.setujui', $permintaan->id_permintaan) }}"
                        method="POST"
                        class="cancellation-confirm-form"
                        data-confirm-type="approve"
                        >
                            @csrf

                            <button type="submit" class="btn-cancellation-approve">
                                Setujui Pembatalan
                            </button>
                        </form>

                        <form
                        action="{{ route('pesanan.permintaan-pembatalan.tolak', $permintaan->id_permintaan) }}"
                        method="POST"
                        class="cancellation-confirm-form"
                        data-confirm-type="reject"
                        >
                            @csrf

                            <button type="submit" class="btn-cancellation-reject">
                                Tolak Permintaan
                            </button>
                        </form>

                    </div>

                @elseif($permintaan->status_permintaan === 'menunggu')

                    <p class="cancellation-notice">
                        Permintaan belum dapat diproses karena status pesanan bukan Konfirmasi.
                    </p>

                @endif

            @endif

        </div>

    </div>
</div>


{{-- MODAL KONFIRMASI PEMBATALAN --}}
<div id="cancellationConfirmModal"
     class="cancellation-modal"
     aria-hidden="true">

    <div class="cancellation-modal-backdrop"></div>

    <div class="cancellation-modal-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="cancellationModalTitle">

        <div id="cancellationModalIcon"
             class="cancellation-modal-icon">
            !
        </div>

        <h3 id="cancellationModalTitle">
            Konfirmasi Tindakan
        </h3>

        <p id="cancellationModalMessage">
            Apakah kamu yakin ingin melanjutkan tindakan ini?
        </p>

        <div class="cancellation-modal-actions">
            <button type="button"
                    id="cancellationModalCancel"
                    class="cancellation-modal-btn cancel">
                Kembali
            </button>

            <button type="button"
                    id="cancellationModalConfirm"
                    class="cancellation-modal-btn confirm">
                Ya, Lanjutkan
            </button>
        </div>

    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('cancellationConfirmModal');
    const modalBox = modal.querySelector('.cancellation-modal-box');
    const title = document.getElementById('cancellationModalTitle');
    const message = document.getElementById('cancellationModalMessage');
    const confirmButton = document.getElementById('cancellationModalConfirm');
    const cancelButton = document.getElementById('cancellationModalCancel');

    let selectedForm = null;

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        selectedForm = null;
    }

    document.querySelectorAll('.cancellation-confirm-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            selectedForm = form;

            const type = form.dataset.confirmType;
            modalBox.classList.remove('is-reject');

            if (type === 'approve') {
                title.textContent = 'Setujui Pembatalan?';
                message.textContent =
                    'Apakah kamu yakin ingin menyetujui pembatalan pesanan ini? Pesanan akan berstatus dibatalkan.';
                confirmButton.textContent = 'Ya, Setujui';
            } else {
                title.textContent = 'Tolak Permintaan?';
                message.textContent =
                    'Apakah kamu yakin ingin menolak permintaan pembatalan ini? Pesanan akan tetap berjalan.';
                confirmButton.textContent = 'Ya, Tolak';
                modalBox.classList.add('is-reject');
            }

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            confirmButton.focus();
        });
    });

    confirmButton.addEventListener('click', function () {
        if (!selectedForm) return;

        const formToSubmit = selectedForm;
        closeModal();

        // Kirim form ke Laravel setelah admin mengonfirmasi.
        HTMLFormElement.prototype.submit.call(formToSubmit);
    });

    cancelButton.addEventListener('click', closeModal);

    modal.querySelector('.cancellation-modal-backdrop')
        .addEventListener('click', closeModal);

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('show')) {
            closeModal();
        }
    });
});
</script>


@endsection