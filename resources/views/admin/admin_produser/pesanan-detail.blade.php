@extends('admin.layouts.app-produser')

@section('title', 'Detail Pesanan')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/pesanan-detail-produser.css') }}">
@endpush

@section('content')

@php
    $tahapanList = $pesanan->tahapanPengerjaan->sortBy('urutan')->values();
    $bolehKelola = $pesanan->status === 'diproses';
@endphp

<div id="produserOrderPage"
     data-store-url="{{ route('produser.tahapan.store', $pesanan->id_pesanan) }}"
     data-update-base-url="{{ url('/produser/pesanan/' . $pesanan->id_pesanan . '/tahapan') }}">

    {{-- ================= HEADER ================= --}}
    <div class="detail-page-header">

        <a href="{{ route('admin.produser.pesanan') }}" class="btn-level-2">
            <i class="ph ph-arrow-left"></i>
            Kembali
        </a>

        <div class="detail-page-title">
            <h3>Detail Pesanan</h3>
            <p>Kelola pengerjaan pesanan dan tahapan pekerjaan.</p>
        </div>

    </div>

    {{-- ================= NOTIFIKASI ================= --}}
    @if(session('success'))
        <div class="prod-alert prod-alert-success" role="alert">
            <i class="ph ph-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="prod-alert prod-alert-danger" role="alert">
            <i class="ph ph-warning-circle"></i>

            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- ================= HERO PESANAN ================= --}}
    <div class="order-hero-card">

        <div class="order-hero-top-v2">

            <div class="order-hero-main">

                <div class="order-hero-badges">
                    <span class="hero-badge-dark">#{{ $pesanan->id_pesanan }}</span>
                    <span class="hero-badge-light">{{ ucfirst($pesanan->status) }}</span>
                </div>

                <h1 class="order-hero-name">
                    {{ $pesanan->produkJasa->nama_produk_jasa ?? 'Produk/Jasa' }}
                </h1>

                <div class="order-hero-meta">
                    <span>
                        <i class="ph ph-tag"></i>
                        {{ ucfirst($pesanan->produkJasa->jenis ?? '-') }}
                    </span>

                    @if($pesanan->produkJasa?->jurusan)
                        <span>
                            <i class="ph ph-buildings"></i>
                            {{ $pesanan->produkJasa->jurusan->nama_jurusan }}
                        </span>
                    @endif
                </div>

            </div>

            <div class="order-hero-total-box">
                <div class="order-hero-total-label">Total Pesanan</div>

                <div class="order-hero-total-value">
                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </div>

                <div class="order-hero-total-item">{{ $pesanan->jumlah }} item</div>
            </div>

        </div>

        <div class="order-hero-bottom">

            <div class="hero-stat">
                <div class="hero-stat-label">Tanggal Pesanan</div>
                <div class="hero-stat-value">
                    {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}
                </div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Harga Satuan</div>
                <div class="hero-stat-value">
                    Rp {{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }} {{ $pesanan->produkJasa->satuan_harga ? '/' . $pesanan->produkJasa->satuan_harga : '' }}
                </div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Jumlah</div>
                <div class="hero-stat-value">{{ $pesanan->jumlah }} item</div>
            </div>

            <div class="hero-stat">
                <div class="hero-stat-label">Status</div>
                <div class="hero-stat-value">{{ ucfirst($pesanan->status) }}</div>
            </div>

        </div>

    </div>

    {{-- ================= INFORMASI + CATATAN ================= --}}
    <div class="two-column">

        <div class="prod-card">
            <div class="prod-card-body">

                <div class="prod-card-header">
                    <div>
                        <h4 class="prod-section-title">
                            <i class="ph ph-info"></i>
                            Informasi Pesanan
                        </h4>

                        <p class="prod-section-desc">Informasi lengkap mengenai pesanan.</p>
                    </div>
                </div>

                <div class="detail-grid">

                    <div>
                        <div class="detail-label">Tanggal Pesanan</div>
                        <div class="detail-value">
                            {{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Harga Satuan</div>
                        <div class="detail-value">
                            Rp {{ number_format($pesanan->produkJasa->harga ?? 0, 0, ',', '.') }}
                        </div>
                    </div>

                    <div>
                        <div class="detail-label">Jumlah</div>
                        <div class="detail-value">{{ $pesanan->jumlah }} item</div>
                    </div>

                    <div>
                        <div class="detail-label">Total Harga</div>
                        <div class="detail-value">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="prod-card">
            <div class="prod-card-body">

                <h4 class="prod-section-title">
                    <i class="ph ph-note"></i>
                    Catatan Pembeli
                </h4>

                @if($pesanan->catatan)
                    <div class="buyer-note">{{ $pesanan->catatan }}</div>
                @else
                    <div class="empty-note">Tidak ada catatan dari pembeli.</div>
                @endif

            </div>
        </div>

    </div>

    {{-- ================= TAHAPAN PENGERJAAN ================= --}}
    <div class="prod-card prod-card-spaced">
        <div class="prod-card-body">

            <div class="prod-card-header">

                <div>
                    <h4 class="prod-section-title">
                        <i class="ph ph-list-numbers"></i>
                        Tahapan Pengerjaan
                    </h4>

                    <p class="prod-section-desc">Atur tahapan pekerjaan pesanan ini.</p>
                </div>

                @if($bolehKelola)
                    <button type="button"
                            class="prod-btn prod-btn-primary"
                            data-action="open-kelola">
                        <i class="ph ph-list-plus"></i>
                        Kelola Tahapan
                    </button>
                @endif

            </div>

            @if(!$bolehKelola)
                <div class="prod-alert prod-alert-warning">
                    <i class="ph ph-info"></i>

                    <span>
                        Tahapan dan progress dapat dikelola setelah pesanan
                        berstatus <strong>diproses</strong>.
                    </span>
                </div>
            @endif

            @if($tahapanList->count())

                <div class="stepper-container">

                    @foreach($tahapanList as $index => $tahapan)

                        @php
                            $statusTahap = strtolower($tahapan->status);

                            if ($statusTahap === 'selesai') {
                                $circleClass = 'selesai';
                            } elseif ($statusTahap === 'sedang dikerjakan' || $tahapan->persentase_progress > 0) {
                                $circleClass = 'proses';
                            } else {
                                $circleClass = 'belum';
                            }
                        @endphp

                        <div class="stepper-item">

                            @if(!$loop->last)
                                <div class="stepper-line"></div>
                            @endif

                            <div class="stepper-circle {{ $circleClass }}">{{ $index + 1 }}</div>

                            <div class="stepper-content">

                                <div class="stepper-top">
                                    <div>
                                        <h5 class="stepper-name">{{ $tahapan->nama_tahapan }}</h5>
                                        <span class="stepper-status">{{ $tahapan->status }}</span>
                                    </div>

                                    <div class="stepper-percent">{{ $tahapan->persentase_progress }}%</div>
                                </div>

                                <div class="mini-progress-bg">
                                    {{-- Style inline hanya untuk lebar bar (nilai dari database) --}}
                                    <div class="mini-progress-fill"
                                         style="width: {{ $tahapan->persentase_progress }}%;"></div>
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="prod-empty">

                    <i class="ph ph-list-dashes prod-empty-icon"></i>

                    <p class="prod-empty-title">Belum ada tahapan pengerjaan</p>

                    @if($bolehKelola)
                        <p class="prod-empty-text">
                            Tambahkan tahapan agar proses pengerjaan dapat dipantau.
                        </p>

                        <button type="button"
                                class="prod-btn prod-btn-primary"
                                data-action="open-kelola">
                            <i class="ph ph-plus"></i>
                            Tambah Tahapan
                        </button>
                    @else
                        <p class="prod-empty-text">
                            Tahapan belum dapat dibuat sebelum pesanan diproses.
                        </p>
                    @endif

                </div>

            @endif

        </div>
    </div>

    {{-- ================= PERBARUI PROGRESS ================= --}}
    @if($bolehKelola)

        <div class="prod-card prod-card-spaced">
            <div class="prod-card-body">

                <div class="prod-card-header">
                    <div>
                        <h4 class="prod-section-title">
                            <i class="ph ph-chart-line-up"></i>
                            Perbarui Progress
                        </h4>

                        <p class="prod-section-desc">Catat perkembangan pengerjaan pesanan.</p>
                    </div>
                </div>

                <form id="formUpdateProgress"
                      action="{{ route('produser.updateProgress', $pesanan->id_pesanan) }}"
                      method="POST">

                    @csrf

                    <div class="progress-layout">

                        <div class="form-group">
                            <label class="form-label-custom" for="updateProgress">Progress Pengerjaan</label>

                            <div class="range-wrapper">
                                <input type="range"
                                       class="range-slider"
                                       name="persentase_progress"
                                       id="updateProgress"
                                       min="0"
                                       max="100"
                                       value="0"
                                       data-range-output="progressValue">

                                <span id="progressValue" class="range-value">0%</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label-custom" for="inputKeteranganProgress">Keterangan Progress</label>

                            <input type="text"
                                   id="inputKeteranganProgress"
                                   name="keterangan_progress"
                                   class="custom-input"
                                   maxlength="255"
                                   placeholder="Contoh: Tahap desain sudah selesai."
                                   required>
                        </div>

                    </div>

                    <div class="form-actions">
                        <button type="submit" class="prod-btn prod-btn-primary">
                            <i class="ph ph-floppy-disk"></i>
                            Simpan Progress
                        </button>
                    </div>

                </form>

            </div>
        </div>

    @endif

    {{-- ================= RIWAYAT PROGRESS ================= --}}
    <div class="prod-card">
        <div class="prod-card-body">

            <div class="prod-card-header">
                <div>
                    <h4 class="prod-section-title">
                        <i class="ph ph-clock-counter-clockwise"></i>
                        Riwayat Progress
                    </h4>

                    <p class="prod-section-desc">Riwayat perkembangan pengerjaan pesanan.</p>
                </div>
            </div>

            @if($pesanan->progressPengerjaan->count())

                <div class="history-list">

                    @foreach($pesanan->progressPengerjaan->sortByDesc('tanggal_update') as $progress)

                        <div class="history-item">

                            <div class="history-marker-wrap">
                                <div class="history-marker"></div>

                                @if(!$loop->last)
                                    <div class="history-line"></div>
                                @endif
                            </div>

                            <div class="history-content">

                                <div>
                                    <div class="history-percent">{{ $progress->persentase_progress }}%</div>
                                    <div class="history-description">{{ $progress->keterangan_progress }}</div>
                                    <div class="history-user">
                                        Oleh: {{ $progress->pelaksana->nama ?? '-' }}
                                    </div>
                                </div>

                                <div class="history-date">
                                    {{ \Carbon\Carbon::parse($progress->tanggal_update)->translatedFormat('d M Y') }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($progress->tanggal_update)->format('H:i') }}
                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="prod-empty">
                    <i class="ph ph-clock prod-empty-icon"></i>
                    <p class="prod-empty-text">Belum ada riwayat progress.</p>
                </div>

            @endif

        </div>
    </div>

</div>

{{-- =========================================================
     MODAL KELOLA TAHAPAN
========================================================= --}}
@if($bolehKelola)

    <div id="modalKelolaTahapan" class="prod-modal-overlay">
        <div class="prod-modal" role="dialog" aria-modal="true" aria-labelledby="kelolaTahapanTitle">

            <div class="prod-modal-header">
                <div>
                    <h3 class="prod-modal-title" id="kelolaTahapanTitle">Kelola Tahapan Pengerjaan</h3>
                    <p class="prod-modal-subtitle">Tambah, ubah, hapus, atau atur urutan tahapan.</p>
                </div>

                <button type="button"
                        class="prod-modal-close"
                        data-action="close-kelola"
                        aria-label="Tutup">
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <div class="prod-modal-body">

                <div class="stage-toolbar">

                    <div id="reorderNotice" class="reorder-notice" hidden>
                        Urutan diubah. Klik <strong>Simpan Urutan</strong> untuk menyimpan.
                    </div>

                    <div class="stage-toolbar-actions">

                        <button type="button"
                                id="btnSimpanUrutan"
                                class="prod-btn prod-btn-success"
                                data-action="save-reorder"
                                hidden>
                            <i class="ph ph-floppy-disk"></i>
                            Simpan Urutan
                        </button>

                        <button type="button"
                                class="prod-btn prod-btn-primary"
                                data-action="add-tahap">
                            <i class="ph ph-plus"></i>
                            Tambah Tahapan
                        </button>

                    </div>

                </div>

                @if($tahapanList->count())

                    <div class="table-scroll">

                        <table class="stage-table">

                            <thead>
                                <tr>
                                    <th class="col-handle"></th>
                                    <th class="col-no">No.</th>
                                    <th>Tahapan</th>
                                    <th>Status</th>
                                    <th class="col-progress">Progress</th>
                                    <th class="col-action">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach($tahapanList as $index => $tahapan)

                                    <tr class="stage-row"
                                        data-id="{{ $tahapan->id }}"
                                        data-order="{{ $index }}">

                                        <td class="cell-handle">
                                            <span class="drag-handle" title="Seret untuk mengubah urutan">
                                                <i class="ph ph-dots-six-vertical"></i>
                                            </span>
                                        </td>

                                        <td class="cell-no">
                                            <strong class="stage-no">{{ $index + 1 }}</strong>
                                        </td>

                                        <td class="cell-name">
                                            <strong>{{ $tahapan->nama_tahapan }}</strong>
                                        </td>

                                        <td class="cell-status">
                                            <span class="stepper-status">{{ $tahapan->status }}</span>
                                        </td>

                                        <td class="cell-progress">{{ $tahapan->persentase_progress }}%</td>

                                        <td class="cell-actions">
                                            <div class="stage-actions">

                                                <button type="button"
                                                        class="icon-btn"
                                                        title="Edit"
                                                        aria-label="Edit tahapan"
                                                        data-action="edit-tahap"
                                                        data-id="{{ $tahapan->id }}"
                                                        data-nama="{{ $tahapan->nama_tahapan }}"
                                                        data-status="{{ $tahapan->status }}"
                                                        data-progress="{{ $tahapan->persentase_progress }}">
                                                    <i class="ph ph-pencil-simple"></i>
                                                </button>

                                                <form action="{{ route('produser.tahapan.destroy', [$pesanan->id_pesanan, $tahapan->id]) }}"
                                                      method="POST"
                                                      data-confirm="Hapus tahapan ini?">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="icon-btn danger"
                                                            title="Hapus"
                                                            aria-label="Hapus tahapan">
                                                        <i class="ph ph-trash"></i>
                                                    </button>

                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="modal-empty">Belum ada tahapan.</div>

                @endif

            </div>

        </div>
    </div>

    {{-- ================= MODAL TAMBAH / EDIT TAHAPAN ================= --}}
    <div id="modalFormTahap" class="prod-modal-overlay">
        <div class="prod-modal small" role="dialog" aria-modal="true" aria-labelledby="modalFormTahapTitle">

            <div class="prod-modal-header">
                <div>
                    <h3 class="prod-modal-title" id="modalFormTahapTitle">Tambah Tahapan</h3>
                    <p class="prod-modal-subtitle">Isi informasi tahapan pengerjaan.</p>
                </div>

                <button type="button"
                        class="prod-modal-close"
                        data-action="close-form"
                        aria-label="Tutup">
                    <i class="ph ph-x"></i>
                </button>
            </div>

            <form id="formSimpanTahap"
                  action="{{ route('produser.tahapan.store', $pesanan->id_pesanan) }}"
                  method="POST">

                @csrf

                <div id="methodContainer"></div>

                <div class="prod-modal-body">

                    <div class="form-group form-group-spaced">
                        <label class="form-label-custom" for="inputNamaTahap">Nama Tahapan</label>

                        <input type="text"
                               name="nama_tahapan"
                               id="inputNamaTahap"
                               class="custom-input"
                               maxlength="255"
                               placeholder="Contoh: Analisis Kebutuhan"
                               required>
                    </div>

                    <div class="form-group form-group-spaced">
                        <label class="form-label-custom" for="inputStatusTahap">Status</label>

                        <select name="status"
                                id="inputStatusTahap"
                                class="custom-select"
                                required>
                            <option value="Belum Dimulai">Belum Dimulai</option>
                            <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                            <option value="Dalam Revisi">Dalam Revisi</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label-custom" for="inputProgressTahap">Progress</label>

                        <div class="range-wrapper">
                            <input type="range"
                                   name="persentase_progress"
                                   id="inputProgressTahap"
                                   class="range-slider"
                                   min="0"
                                   max="100"
                                   value="0"
                                   data-range-output="tahapProgressValue">

                            <span id="tahapProgressValue" class="range-value">0%</span>
                        </div>
                    </div>

                </div>

                <div class="prod-modal-footer">

                    <button type="button"
                            class="prod-btn prod-btn-secondary"
                            data-action="close-form">
                        Batal
                    </button>

                    <button type="submit" class="prod-btn prod-btn-primary">
                        <i class="ph ph-floppy-disk"></i>
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

    {{-- Form tersembunyi untuk menyimpan urutan --}}
    <form id="formReorderTahapan"
          action="{{ route('produser.tahapan.reorder', $pesanan->id_pesanan) }}"
          method="POST"
          hidden>

        @csrf

        <div id="reorderInputs"></div>

    </form>

@endif

@endsection

@push('scripts')
    <script src="{{ asset('js/pesanan-detail-produser.js') }}"></script>
@endpush