@extends('admin.layouts.app')

@section('title','Edit Akun')

@section('content')
<div class="back-link-wrapper">
    <a href="{{ route('akun.show',$akun->id) }}" class="back-link">← Kembali ke Detail Akun</a>
</div>

<h2 class="page-title">Edit Akun</h2>

<div class="edit-card">
    @if($errors->any())
    <div class="alert alert-danger" style="margin-bottom:20px;">
        <ul style="margin:0;padding-left:20px;">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('akun.update',$akun->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- NAMA -->
        <div class="form-group">
            <label for="nama">Nama Pengguna</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama',$akun->nama) }}" required>
        </div>

        <!-- EMAIL -->
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email',$akun->email) }}" required>
        </div>

        <!-- ROLE -->
        <div class="form-group">
            <label for="role">Role</label>
            <select name="role" id="role" class="form-control" required>
                <option value="admin_tefa" {{ old('role',$akun->role)==='admin_tefa'?'selected':'' }}>
                    Admin TEFA
                </option>
                <option value="admin_jurusan" {{ old('role',$akun->role)==='admin_jurusan'?'selected':'' }}>
                    Admin Jurusan
                </option>
            </select>
        </div>

        <!-- JURUSAN -->
        <div class="form-group" id="jurusanContainer">
            <label for="id_jurusan">Jurusan</label>
            <select name="id_jurusan" id="id_jurusan" class="form-control">
                <option value="">-- Pilih Jurusan --</option>

                @foreach($jurusanKosong as $jurusan)
                <option value="{{ $jurusan->id_jurusan }}"
                    {{ old('id_jurusan',$akun->jurusanDipegang->id_jurusan ?? '')==$jurusan->id_jurusan?'selected':'' }}>
                    {{ $jurusan->nama_jurusan }}
                </option>
                @endforeach
            </select>
        </div>

        <p id="helpTextJurusan" style="color:#64748b;font-size:13px;margin-bottom:20px;"></p>

        <!-- STATUS -->
        <div class="form-group mb-large">
            <label for="status">Status Akun</label>
            <select name="status" id="status" class="form-control" required>
                <option value="aktif" {{ old('status',$akun->status)==='aktif'?'selected':'' }}>
                    Aktif
                </option>
                <option value="tidak_aktif" {{ old('status',$akun->status)==='tidak_aktif'?'selected':'' }}>
                    Tidak Aktif
                </option>
            </select>
        </div>

        <!-- TOMBOL -->
        <div class="form-actions">
            <a href="{{ route('akun.show',$akun->id) }}" class="btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn-submit">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const roleSelect=document.getElementById('role');
    const jurusanContainer=document.getElementById('jurusanContainer');
    const jurusanSelect=document.getElementById('id_jurusan');
    const helpText=document.getElementById('helpTextJurusan');

    function updateJurusan(){
        if(roleSelect.value==='admin_jurusan'){
            jurusanContainer.style.display='block';
            jurusanSelect.disabled=false;
            jurusanSelect.required=true;
            helpText.textContent='Pilih jurusan yang menjadi tanggung jawab akun ini.';
        }else{
            jurusanContainer.style.display='none';
            jurusanSelect.disabled=true;
            jurusanSelect.required=false;
            jurusanSelect.value='';
            helpText.textContent='Admin TEFA tidak terikat pada jurusan tertentu.';
        }
    }

    roleSelect.addEventListener('change',updateJurusan);
    updateJurusan();
});
</script>
@endsection