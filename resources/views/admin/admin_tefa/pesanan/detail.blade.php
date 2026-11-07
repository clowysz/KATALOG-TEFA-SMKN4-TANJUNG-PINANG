@extends('admin.layouts.app')

@section('title', 'Detail Pesanan')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/pesanan-tefa.css') }}?v=5">
@endpush

@section('content')

@php
    $formatTanggal = function ($tanggal) {
        if (!$tanggal) {
            return '-';
        }

        return \Carbon\Carbon::parse($tanggal)
            ->locale('id')
            ->translatedFormat('d F Y, H:i') . ' WIB';
    };

    $permintaan         = $pesanan->permintaanPembatalan;
    $pembatalanMenunggu = $permintaan && $permintaan->status_permintaan === 'menunggu';
    $pesananDibatalkan  = $pesanan->status === 'dibatalkan';

    $dibatalkanPembeli = $pesananDibatalkan
        && $permintaan
        && $permintaan->status_permintaan === 'disetujui';

    $dibatalkanAdmin = $pesananDibatalkan && !$dibatalkanPembeli;

    $riwayatBatal = $pesananDibatalkan
        ? $pesanan->riwayatStatus
            ->where('status', 'dibatalkan')
            ->sortByDesc('id_riwayat_status')
            ->first()
        : null;

    $alasanAdmin = ($dibatalkanAdmin && filled($riwayatBatal?->keterangan))
        ? \Illuminate\Support\Str::after($riwayatBatal->keterangan, 'Alasan: ')
        : null;

    $namaAdmin = $dibatalkanPembeli
        ? $permintaan->admin?->nama
        : $riwayatBatal?->pelaksana?->nama;

    $tanggalDibatalkan = $dibatalkanPembeli
        ? ($permintaan->tanggal_keputusan ?? $riwayatBatal?->tanggal_update)
        : ($riwayatBatal?->tanggal_update ?? $pesanan->updated_at);

    $statusTerpilih = old('status', $pesanan->status);
@endphp

<div class="detail-pesanan-container">


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

        
        

        <div class="detail-pesanan-card">

            <h3 class="detail-card-title">
               
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

    
    <div class="detail-pesanan-bottom">

        
        

        <div class="detail-pesanan-card status-card">

            <h3 class="detail-card-title">Update Status Pesanan</h3>

            @if($pesanan->status === 'diproses')
                <div class="detail-pesanan-alert">
                    Pesanan sudah diteruskan ke Admin Produser untuk dikerjakan.
                </div>
            @endif

            @if($pesananDibatalkan)

                <p>
                    Pesanan ini sudah dibatalkan. Status tidak dapat diubah
                    melalui bagian ini.
                </p>

            @elseif($pembatalanMenunggu)

                <div class="detail-pesanan-alert">
                    Pembeli mengajukan pembatalan. Update status pesanan
                    dikunci sampai Admin TEFA mengambil keputusan.
                </div>

                <form
                    action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
                    method="POST"
                >
                    @csrf

                    <div class="status-form-group">
                        <label for="statusSelect" class="status-form-label">
                            Ubah Status Menjadi:
                        </label>

                        <select
                            id="statusSelect"
                            name="status"
                            class="status-select"
                            disabled
                        >
                            <option value="{{ $pesanan->status }}" selected>
                                {{ ucfirst($pesanan->status) }}
                            </option>
                        </select>
                    </div>

                    <div class="status-form-actions">
                        <button
                            type="submit"
                            class="btn-save-status"
                            disabled
                        >
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            @else

                <form
                    action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}"
                    method="POST"
                >
                    @csrf

                    <div class="status-form-group">
                        <label for="statusSelect" class="status-form-label">
                            Ubah Status Menjadi:
                        </label>

                        <select
                            id="statusSelect"
                            name="status"
                            class="status-select"
                            required
                        >
                            <option
                                value="menunggu konfirmasi"
                                {{ $statusTerpilih === 'menunggu konfirmasi' ? 'selected' : '' }}
                            >
                                Menunggu Konfirmasi
                            </option>

                            <option
                                value="konfirmasi"
                                {{ $statusTerpilih === 'konfirmasi' ? 'selected' : '' }}
                            >
                                Konfirmasi
                            </option>

                            <option
                                value="diproses"
                                {{ $statusTerpilih === 'diproses' ? 'selected' : '' }}
                            >
                                Diproses
                            </option>

                            <option
                                value="selesai"
                                {{ $statusTerpilih === 'selesai' ? 'selected' : '' }}
                            >
                                Selesai
                            </option>

                            
                            @if($pesanan->status !== 'selesai')
                                <option
                                    value="dibatalkan"
                                    {{ $statusTerpilih === 'dibatalkan' ? 'selected' : '' }}
                                >
                                    Dibatalkan
                                </option>
                            @endif
                        </select>
                    </div>

                    
                    <div class="status-form-group" id="alasanPembatalanGroup" hidden>
                        <label for="alasanPembatalan" class="status-form-label">
                            Alasan Pembatalan:
                        </label>

                        <textarea
                            id="alasanPembatalan"
                            name="alasan_pembatalan"
                            class="status-reason-input"
                            rows="4"
                            maxlength="2000"
                            placeholder="Tulis alasan pesanan dibatalkan..."
                            disabled
                        >{{ old('alasan_pembatalan') }}</textarea>

                        <small class="status-reason-hint">
                            Alasan ini akan ditampilkan kepada pembeli di riwayat pesanannya.
                        </small>
                    </div>

                    <div class="status-form-actions">
                        <button type="submit" class="btn-save-status">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            @endif

        </div>

        
        

        <div class="detail-pesanan-card cancellation-card">

            <h3 class="detail-card-title">Pembatalan Pesanan</h3>

            
            @if(!$permintaan && !$pesananDibatalkan)

                <div class="cancellation-empty">
                    <p><strong>Belum ada permintaan pembatalan.</strong></p>
                    <p>Jika pembeli mengajukan pembatalan, permintaannya akan muncul di sini.</p>
                </div>

            @endif

            
            @if($pesananDibatalkan)

                <div class="cancellation-summary">

                    <div class="cancellation-summary-item">
                        <span class="cancellation-label">Dibatalkan Oleh</span>

                        @if($dibatalkanPembeli)
                            <span class="cancellation-badge by-buyer">Pembeli</span>
                            <span class="cancellation-note">
                                Disetujui oleh Admin TEFA{{ $namaAdmin ? ' (' . $namaAdmin . ')' : '' }}
                            </span>
                        @else
                            <span class="cancellation-badge by-admin">Admin TEFA</span>

                            @if($namaAdmin)
                                <span class="cancellation-note">{{ $namaAdmin }}</span>
                            @endif
                        @endif
                    </div>

                    <div class="cancellation-summary-item">
                        <span class="cancellation-label">Tanggal Dibatalkan</span>
                        <p class="cancellation-text">{{ $formatTanggal($tanggalDibatalkan) }}</p>
                    </div>

                    
                    
                    @if($dibatalkanAdmin)
                        <div class="cancellation-summary-item full">
                            <span class="cancellation-label">Alasan Admin</span>

                            @if($alasanAdmin)
                                <p class="cancellation-text">{{ $alasanAdmin }}</p>
                            @else
                                <p class="cancellation-text is-empty">
                                    Tidak ada alasan yang tercatat.
                                </p>
                            @endif
                        </div>
                    @endif

                </div>

            @endif

            
            @if($permintaan)

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
                        <span class="cancellation-label">Tanggal Pengajuan</span>
                        <p class="cancellation-text">{{ $formatTanggal($permintaan->created_at) }}</p>
                    </div>

                    @if($permintaan->status_permintaan === 'ditolak')
                        <div class="cancellation-row">
                            <span class="cancellation-label">Tanggal Ditolak</span>
                            <p class="cancellation-text">{{ $formatTanggal($permintaan->tanggal_keputusan) }}</p>
                        </div>
                    @endif

                    <div class="cancellation-row">
                        <span class="cancellation-label">Alasan Pembeli</span>
                        <p class="cancellation-text">{{ $permintaan->alasan }}</p>
                    </div>

                    @if($permintaan->catatan_admin)
                        <div class="cancellation-row">
                            <span class="cancellation-label">Catatan Admin</span>
                            <p class="cancellation-text">{{ $permintaan->catatan_admin }}</p>
                        </div>
                    @endif

                </div>

                @if($pembatalanMenunggu && $pesanan->status === 'konfirmasi')

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

                @elseif($pembatalanMenunggu)

                    <p class="cancellation-notice">
                        Permintaan belum dapat diproses karena status pesanan bukan Konfirmasi.
                    </p>

                @endif

            @endif

        </div>

    </div>

</div>

<div
    id="cancellationConfirmModal"
    class="cancellation-modal"
    aria-hidden="true"
>

    <div class="cancellation-modal-backdrop"></div>

    <div
        class="cancellation-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="cancellationModalTitle"
    >

        <div id="cancellationModalIcon" class="cancellation-modal-icon">
            !
        </div>

        <h3 id="cancellationModalTitle">
            Konfirmasi Tindakan
        </h3>

        <p id="cancellationModalMessage">
            Apakah kamu yakin ingin melanjutkan tindakan ini?
        </p>

        <div class="cancellation-modal-actions">
            <button
                type="button"
                id="cancellationModalCancel"
                class="cancellation-modal-btn cancel"
            >
                Kembali
            </button>

            <button
                type="button"
                id="cancellationModalConfirm"
                class="cancellation-modal-btn confirm"
            >
                Ya, Lanjutkan
            </button>
        </div>

    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('js/detail-pesanan.js') }}?v=2"></script>
@endsection