@extends('admin.layouts.app-jurusan')

@section('title', 'Deskripsi Jurusan')

@section('content')
<style>
    .btn-edit-deskripsi {
        background: #1e3a8ad9;
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        width: auto;
    }

    .btn-edit-deskripsi:hover {
        background: #1E3A8A;
        color: white;
    }
    /* Tombol Simpan: model Level 2, warna oranye dipertahankan */
.btn-simpan-deskripsi {
    background: #ffffff;
    color: var(--accent-rpl);
    padding: 8px 16px;
    border: 1px solid var(--accent-rpl);
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    width: auto;
    transition: all 0.2s ease;
}

.btn-simpan-deskripsi:hover {
    background: var(--accent-rpl);
    color: #ffffff;
}
</style>

<div class="page-header" style="margin: 16px 24px;">
    <h2>Kelola Deskripsi Jurusan</h2>

    <p>
        Perbarui informasi profil jurusan
        {{ $jurusan->nama_jurusan }}
    </p>
</div>

<!-- Mengubah max-width menjadi margin agar full namun menyisakan gap di semua sisi -->
<div class="tefa-card" style="margin: 24px; padding: 24px;">

    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;">

      <div style="width: 48px; height: 48px; background: #fcf4e8; color: var(--accent-rpl); display: flex; align-items: center; justify-content: center; font-size: 24px; border-radius: 8px;">
    <i class="ph ph-laptop"></i>
</div>

        <div>
            <h3 style="color: var(--accent-rpl); margin-bottom: 4px;">
                {{ $jurusan->nama_jurusan }}
            </h3>

            <p style="font-size: 13px; color: var(--text-muted); margin: 0;">
                SMK Negeri 4 Tanjungpinang
            </p>
        </div>

    </div>

    {{-- Pesan berhasil --}}
    @if(session('success'))
        <div
            style="
                background-color: #d4edda;
                color: #155724;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
            "
        >
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div
            style="
                background-color: #f8d7da;
                color: #721c24;
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
            "
        >
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        id="formDeskripsi"
        action="{{ route('jurusan.updateDeskripsi') }}"
        method="POST"
        novalidate
    >
        @csrf

        <label
            for="descText"
            class="detail-label"
            style="font-weight: 600; margin-bottom: 8px; display: block;"
        >
            Deskripsi Profil Jurusan
        </label>

        <textarea
            id="descText"
            name="deskripsi"
            class="form-control"
            rows="10"
            readonly
            required
            style="background-color: #f8f9fa; width: 100%; box-sizing: border-box; padding: 12px;"
        >{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>

        {{-- Tombol awal --}}
        <div
            style="margin-top: 24px; display: flex; gap: 12px;"
            id="actionButtons"
        >
            <button
    type="button"
    id="btnEditDesc"
    class="btn-edit-deskripsi"
>
    Edit Deskripsi
</button>
        </div>

        {{-- Tombol saat mode edit --}}
        <div
            style="margin-top: 24px; display: none; gap: 12px;"
            id="saveButtons"
        >
            <button
                type="button"
                id="btnCancelDesc"
                class="btn-outline"
            >
                Batal
            </button>

<button
    type="submit"
    class="btn-simpan-deskripsi"
>
    Simpan Perubahan
</button>
        </div>

    </form>

</div>

@endsection

@section('scripts')

<script>
document.addEventListener("DOMContentLoaded", function () {

    // =========================================================
    // DEKLARASI ELEMEN
    // =========================================================
    const formDeskripsi = document.getElementById('formDeskripsi');
    const descText = document.getElementById('descText');
    const btnEdit = document.getElementById('btnEditDesc');
    const btnCancel = document.getElementById('btnCancelDesc');

    const actionButtons = document.getElementById('actionButtons');
    const saveButtons = document.getElementById('saveButtons');

    if (!descText) {
        return;
    }

    let tempDesc = descText.value;


    // =========================================================
    // VALIDASI DESKRIPSI - BAHASA INDONESIA
    // Catatan: textarea berstatus readonly di luar mode edit,
    // jadi validasi hanya berjalan saat mode edit aktif.
    // =========================================================

    // Hapus pesan saat user mengetik
    descText.addEventListener('input', function () {

        this.setCustomValidity('');

    });

    // Cek manual saat submit (form memakai novalidate):
    // menangkap kosong DAN hanya berisi spasi / enter
    if (formDeskripsi) {

        formDeskripsi.addEventListener('submit', function (event) {

            if (descText.value.trim() === '') {

                event.preventDefault();

                descText.setCustomValidity(
                    'Deskripsi jurusan wajib diisi.'
                );

                descText.reportValidity();

                return;

            }

            // Rapikan spasi di awal & akhir sebelum dikirim
            descText.value = descText.value.trim();
            descText.setCustomValidity('');

        });

    }


    // =========================================================
    // MODE EDIT
    // =========================================================
    btnEdit.addEventListener('click', function () {

        tempDesc = descText.value;

        descText.removeAttribute('readonly');
        descText.style.backgroundColor = '#fff';
        descText.style.border = '1px solid var(--accent-rpl)';

        descText.focus();

        actionButtons.style.display = 'none';
        saveButtons.style.display = 'flex';

    });


    // =========================================================
    // BATAL EDIT
    // =========================================================
    btnCancel.addEventListener('click', function () {

        descText.value = tempDesc;
        descText.setCustomValidity('');

        descText.setAttribute('readonly', true);
        descText.style.backgroundColor = '#f8f9fa';
        descText.style.border = '1px solid #ced4da';

        actionButtons.style.display = 'flex';
        saveButtons.style.display = 'none';

    });

});
</script>

@endsection