@extends('admin.layouts.app-jurusan')

@section('title', 'Deskripsi Jurusan')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/deskripsi-jurusan.css') }}?v=1">
@endsection

@section('content')

<div class="page-header deskripsi-header">
    <h2>Kelola Deskripsi Jurusan</h2>

    <p>
        Perbarui informasi profil jurusan
        {{ $jurusan->nama_jurusan }}
    </p>
</div>

<div class="tefa-card deskripsi-card">

    <div class="deskripsi-identity">

        <div class="deskripsi-icon">
            <i class="ph ph-laptop"></i>
        </div>

        <div>
            <h3 class="deskripsi-nama">
                {{ $jurusan->nama_jurusan }}
            </h3>

            <p class="deskripsi-sekolah">
                SMK Negeri 4 Tanjungpinang
            </p>
        </div>

    </div>

    
    @if(session('success'))
        <div class="alert-jurusan alert-jurusan-success">
            {{ session('success') }}
        </div>
    @endif

    
    @if($errors->any())
        <div class="alert-jurusan alert-jurusan-error">
            <ul>
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

        <label for="descText" class="detail-label deskripsi-label">
            Deskripsi Profil Jurusan
        </label>

        <textarea
            id="descText"
            name="deskripsi"
            class="form-control deskripsi-textarea"
            rows="10"
            readonly
            required
        >{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>

        
        <div class="deskripsi-actions" id="actionButtons">
            <button
                type="button"
                id="btnEditDesc"
                class="btn-jurusan-primary"
            >
                Edit Deskripsi
            </button>
        </div>

        
        <div class="deskripsi-actions" id="saveButtons" hidden>
            <button
                type="button"
                id="btnCancelDesc"
                class="btn-outline"
            >
                Batal
            </button>

            <button type="submit" class="btn-simpan-deskripsi">
                Simpan Perubahan
            </button>
        </div>

    </form>

</div>

@endsection

@section('scripts')
<script src="{{ asset('js/deskripsi-jurusan.js') }}"></script>
@endsection