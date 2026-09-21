@extends('admin.layouts.app')

@section('title','Tambah Akun')

@section('content')
<div style="padding:20px;max-width:700px;margin:40px auto 0;">
    <div class="tefa-card" style="background:white;padding:30px;border-radius:12px;box-shadow:0 4px 15px rgba(0,0,0,0.05);">
        <div style="margin-bottom:20px;">
            <a href="{{ route('akun.index') }}" style="text-decoration:none;display:inline-block;padding:6px 12px;border:1px solid #CBD5E1;border-radius:6px;color:#1E2D3D;font-size:14px;background:#F8FAFC;font-weight:500;">
                ← Kembali ke Daftar Akun
            </a>
        </div>

        <h2 style="margin:0 0 5px;color:#1E2D3D;font-size:24px;">Tambah Akun Baru</h2>
        <p style="margin:0 0 25px;color:#64748B;font-size:14px;">Tambahkan admin baru untuk mengelola TEFA</p>

        @if($errors->any())
        <div class="alert alert-danger" style="background:#FEE2E2;color:#991B1B;padding:12px;border-radius:6px;margin-bottom:20px;">
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('akun.store') }}" method="POST">
            @csrf

            <!-- NAMA -->
            <div style="margin-bottom:20px;">
                <label for="nama" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Nama Pengguna</label>
                <input type="text" id="nama" name="nama" class="form-control" placeholder="Masukkan nama" value="{{ old('nama') }}" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;" required>
            </div>

            <!-- EMAIL -->
            <div style="margin-bottom:20px;">
                <label for="email" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;" required>
            </div>

            <!-- PASSWORD -->
            <div style="margin-bottom:20px;">
                <label for="password" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Password</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;" required>
            </div>

            <!-- ROLE -->
            <div style="margin-bottom:20px;">
                <label for="role" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Role</label>
                <select id="role" name="role" class="form-control" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;" required>
                    <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih Role...</option>
                    <option value="admin_tefa" {{ old('role')==='admin_tefa'?'selected':'' }}>Admin TEFA</option>
                    <option value="admin_jurusan" {{ old('role')==='admin_jurusan'?'selected':'' }}>Admin Jurusan</option>
                </select>
            </div>

            <!-- JURUSAN -->
            <div id="jurusanContainer" style="display:none;margin-bottom:20px;">
                <label for="id_jurusan" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Jurusan</label>
                <select id="id_jurusan" name="id_jurusan" class="form-control" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;">
                    <option value="" disabled {{ old('id_jurusan') ? '' : 'selected' }}>Pilih Jurusan...</option>
                    @foreach($jurusanKosong as $jurusan)
                    <option value="{{ $jurusan->id_jurusan }}" {{ old('id_jurusan')==$jurusan->id_jurusan?'selected':'' }}>
                        {{ $jurusan->nama_jurusan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- BANTUAN JURUSAN -->
            <span id="helpTextJurusan" style="display:block;color:#64748B;font-size:13px;margin-bottom:20px;">
                Pilih role terlebih dahulu untuk menentukan kebutuhan jurusan.
            </span>

            <!-- STATUS -->
            <div style="margin-bottom:30px;">
                <label for="status" style="display:block;font-weight:600;margin-bottom:8px;color:#1E2D3D;">Status</label>
                <select id="status" name="status" class="form-control" style="width:100%;padding:10px;border:1px solid #CBD5E1;border-radius:6px;" required>
                    <option value="aktif" {{ old('status','aktif')==='aktif'?'selected':'' }}>Aktif</option>
                    <option value="tidak_aktif" {{ old('status')==='tidak_aktif'?'selected':'' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- TOMBOL -->
            <div style="display:flex;gap:10px;">
                <button type="submit" class="btn-primary" style="background:#4a5568;color:white;padding:10px 20px;border:none;border-radius:6px;cursor:pointer;font-weight:600;">
                    Tambah Akun
                </button>
                <a href="{{ route('akun.index') }}" style="text-decoration:none;padding:10px 20px;border:1px solid #CBD5E1;border-radius:6px;color:#1E2D3D;background:#F8FAFC;text-align:center;font-weight:500;display:inline-block;">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection