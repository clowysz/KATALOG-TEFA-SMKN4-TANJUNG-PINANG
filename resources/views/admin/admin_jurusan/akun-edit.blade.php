@extends('admin.layouts.app-jurusan')

@section('title', 'Edit Akun')

@section('content')

<div class="page-header" style="margin-bottom: 16px;">
    <a
        href="/jurusan-admin/akun/detail?id={{ $akun->id }}"
        class="btn-outline"
        style="border: none; padding-left: 0;"
    >
        ← Kembali
    </a>
</div>


<div
    class="tefa-card"
    style="
        max-width: 650px;
        padding: 32px;
        border-radius: 16px;
        margin: 0 auto 40px auto;
    "
>

    <form
        action="{{ route('jurusan.akun.update') }}"
        method="POST"
    >
        @csrf

        @method('PUT')


        @if ($errors->any())

            <div
                style="
                    background: #f8d7da;
                    color: #842029;
                    padding: 12px 16px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                "
            >

                <ul style="margin: 0; padding-left: 20px;">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <input
            type="hidden"
            name="id"
            value="{{ $akun->id }}"
        >


        <!-- NAMA -->

        <label class="detail-label">

            Nama Pengguna
            <span class="required-star">*</span>

        </label>

        <input
            type="text"
            name="nama"
            class="form-control"
            value="{{ old('nama', $akun->nama) }}"
            required
        >


        <!-- EMAIL -->

        <label class="detail-label">

            Email
            <span class="required-star">*</span>

        </label>

        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email', $akun->email) }}"
            required
        >


        <!-- ROLE -->

        <label
            class="detail-label"
            style="margin-top: 16px;"
        >
            Role
        </label>

        <input
            type="text"
            class="form-control"
            value="Admin Produser"
            readonly
            style="background-color: #f8f9fa;"
        >


        <!-- PRODUK / JASA -->

        <label
            class="detail-label"
            style="margin-top: 24px;"
        >

            Produk/Jasa Tanggung Jawab
            <span class="required-star">*</span>

        </label>


        <div
            id="editCheckboxContainer"
            class="chip-checkbox-grid"
            style="margin-bottom: 8px;"
        >

            @forelse ($produkJasas as $produkJasa)

                @php

                    $sudahDitugaskan = $akun->penugasanProduser
                        ->contains(
                            'id_produk_jasa',
                            $produkJasa->id_produk_jasa
                        );

                @endphp


                <label style="cursor: pointer;">

                    <input
                        type="checkbox"
                        name="layanan[]"
                        value="{{ $produkJasa->id_produk_jasa }}"
                        style="display: none;"
                        {{ $sudahDitugaskan ? 'checked' : '' }}
                    >


                    <span
                        class="chip-checkbox {{ $sudahDitugaskan ? 'active' : '' }}"
                        onclick="
                            const checkbox = this.previousElementSibling;
                            checkbox.checked = !checkbox.checked;
                            this.classList.toggle('active', checkbox.checked);
                        "
                    >

                        {{ $produkJasa->nama_produk_jasa }}

                    </span>

                </label>

            @empty

                <p style="color: #6c757d;">

                    Belum ada produk atau jasa yang tersedia
                    untuk jurusan Anda.

                </p>

            @endforelse

        </div>


        <div
            style="
                color: #6c757d;
                font-size: 13px;
                margin-top: 8px;
            "
        >

            Pilih minimal satu produk/jasa yang menjadi
            tanggung jawab Admin Produser.

        </div>


        <!-- STATUS -->

        <label
            class="detail-label"
            style="margin-top: 24px;"
        >
            Status Akun
        </label>


        <div class="status-toggle-container">

            <input
                type="radio"
                id="statusAktif"
                name="status"
                value="aktif"
                class="status-toggle-input"
                {{ old('status', $akun->status) === 'aktif' ? 'checked' : '' }}
            >

            <label
                for="statusAktif"
                class="status-toggle-label"
            >
                Aktif
            </label>


            <input
                type="radio"
                id="statusTidakAktif"
                name="status"
                value="tidak_aktif"
                class="status-toggle-input"
                {{ old('status', $akun->status) === 'tidak_aktif' ? 'checked' : '' }}
            >

            <label
                for="statusTidakAktif"
                class="status-toggle-label"
            >
                Tidak Aktif
            </label>

        </div>


        <!-- BUTTON -->

        <div
            style="
                display: flex;
                gap: 16px;
                margin-top: 32px;
            "
        >

            <a
                href="/jurusan-admin/akun/detail?id={{ $akun->id }}"
                class="btn-outline"
                style="
                    flex: 1;
                    text-align: center;
                    text-decoration: none;
                "
            >
                Batal
            </a>


            <button
                type="submit"
                class="btn-primary"
                style="flex: 1;"
            >
                Simpan Perubahan
            </button>

        </div>

    </form>

</div>

@endsection