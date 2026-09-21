@extends('admin.layouts.app-jurusan')

@section('title', 'Deskripsi Jurusan')

@section('content')

<div class="page-header">
    <h2>Kelola Deskripsi Jurusan</h2>

    <p>
        Perbarui informasi profil jurusan
        {{ $jurusan->nama_jurusan }}
    </p>
</div>

<div class="tefa-card" style="max-width: 700px;">

    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 16px; border-bottom: 1px solid #f0f0f0;">

        <div style="width: 48px; height: 48px; background: #fcf4e8; color: var(--accent-rpl); display: flex; align-items: center; justify-content: center; font-size: 24px; border-radius: 8px;">
            💻
        </div>

        <div>
            <h3 style="color: var(--accent-rpl);">
                {{ $jurusan->nama_jurusan }}
            </h3>

            <p style="font-size: 13px; color: var(--text-muted);">
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
    >
        @csrf

        <label
            for="descText"
            class="detail-label"
        >
            Deskripsi Profil Jurusan
        </label>

        <textarea
            id="descText"
            name="deskripsi"
            class="form-control"
            rows="8"
            readonly
            required
            style="background-color: #f8f9fa;"
        >{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>

        {{-- Tombol awal --}}
        <div
            style="margin-top: 24px; display: flex; gap: 12px;"
            id="actionButtons"
        >
            <button
                type="button"
                id="btnEditDesc"
                class="btn-primary"
                style="width: auto;"
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
                class="btn-primary"
                style="width: auto; background-color: var(--accent-rpl);"
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

    const descText = document.getElementById('descText');
    const btnEdit = document.getElementById('btnEditDesc');
    const btnCancel = document.getElementById('btnCancelDesc');

    const actionButtons = document.getElementById('actionButtons');
    const saveButtons = document.getElementById('saveButtons');

    let tempDesc = descText.value;

    // Mode Edit
    btnEdit.addEventListener('click', function () {

        tempDesc = descText.value;

        descText.removeAttribute('readonly');
        descText.style.backgroundColor = '#fff';

        descText.focus();

        actionButtons.style.display = 'none';
        saveButtons.style.display = 'flex';

    });

    // Batal Edit
    btnCancel.addEventListener('click', function () {

        descText.value = tempDesc;

        descText.setAttribute('readonly', true);
        descText.style.backgroundColor = '#f8f9fa';

        actionButtons.style.display = 'flex';
        saveButtons.style.display = 'none';

    });

});
</script>

@endsection