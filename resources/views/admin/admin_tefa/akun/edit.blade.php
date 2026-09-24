@extends('admin.layouts.app')

@section('title','Edit Akun')

@section('content')

<style>
    /* Styling khusus untuk halaman edit */
    .edit-wrapper {
        padding: 16px 24px;
        max-width: 700px;
        margin: 24px auto; /* Membuat posisi tepat di tengah */
    }
    .back-link {
        text-decoration: none;
        color: var(--primary, #3B698F);
        font-size: 14px;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        margin-bottom: 20px;
    }
    .back-link:hover {
        text-decoration: underline;
    }
    .page-title {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 24px 0;
    }
    .alert-custom {
        padding: 14px 20px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 14px;
    }
    .alert-danger { 
        background: #fee2e2; 
        color: #991b1b; 
        border: 1px solid #fecaca; 
    }

    /* Card Edit Form */
    .edit-card {
        background: #fff;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        border: 1px solid #e2e8f0;
    }

    .form-group-custom {
        margin-bottom: 20px;
    }
    .form-group-custom label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #475569;
        font-size: 14px;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        box-sizing: border-box;
        background-color: #fff;
        color: #0f172a;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control-custom:focus {
        outline: none;
        border-color: var(--primary, #3B698F);
        box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.15);
    }

    /* Form Actions/Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 32px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }
    .btn-custom {
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: 1px solid transparent;
        transition: 0.2s;
    }
    .btn-primary-custom {
        background: var(--primary, #3B698F);
        color: #fff;
    }
    .btn-primary-custom:hover {
        background: #2c5273;
        color: #fff;
    }
    .btn-outline-custom {
        background: #fff;
        color: #64748b;
        border-color: #cbd5e1;
    }
    .btn-outline-custom:hover {
        background: #f8fafc;
        color: #334155;
    }
</style>

<div class="edit-wrapper">
    <a href="{{ route('akun.show',$akun->id) }}" class="back-link">← Kembali ke Detail Akun</a>

    <h2 class="page-title">Edit Akun</h2>

    <div class="edit-card">
        @if($errors->any())
        <div class="alert-custom alert-danger">
            <ul style="margin:0; padding-left:20px;">
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
            <div class="form-group-custom">
                <label for="nama">Nama Pengguna</label>
                <input type="text" id="nama" name="nama" class="form-control-custom" value="{{ old('nama',$akun->nama) }}" required>
            </div>

            <!-- EMAIL -->
            <div class="form-group-custom">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control-custom" value="{{ old('email',$akun->email) }}" required>
            </div>

            <!-- ROLE -->
            <div class="form-group-custom">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control-custom" required>
                    <option value="admin_tefa" {{ old('role',$akun->role)==='admin_tefa'?'selected':'' }}>
                        Admin TEFA
                    </option>
                    <option value="admin_jurusan" {{ old('role',$akun->role)==='admin_jurusan'?'selected':'' }}>
                        Admin Jurusan
                    </option>
                </select>
            </div>

            <!-- JURUSAN -->
            <div class="form-group-custom" id="jurusanContainer">
                <label for="id_jurusan">Jurusan</label>
                <select name="id_jurusan" id="id_jurusan" class="form-control-custom">
                    <option value="">-- Pilih Jurusan --</option>

                    @foreach($jurusanKosong as $jurusan)
                    <option value="{{ $jurusan->id_jurusan }}"
                        {{ old('id_jurusan',$akun->jurusanDipegang->id_jurusan ?? '')==$jurusan->id_jurusan?'selected':'' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <p id="helpTextJurusan" style="color:#64748b; font-size:13px; margin-top:-12px; margin-bottom:20px;"></p>

            <!-- STATUS -->
            <div class="form-group-custom">
                <label for="status">Status Akun</label>
                <select name="status" id="status" class="form-control-custom" required>
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
                <a href="{{ route('akun.show',$akun->id) }}" class="btn-custom btn-outline-custom">
                    Batal
                </a>

                <button type="submit" class="btn-custom btn-primary-custom">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
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