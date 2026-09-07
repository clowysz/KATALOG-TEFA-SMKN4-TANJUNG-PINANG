@extends('admin.layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<div class="header-action">
    <div>
        <h2>Daftar Akun</h2>
        <p>Kelola akses pengguna internal TEFA</p>
    </div>
    <!-- Tombol menuju halaman Tambah Akun -->
    <a href="/akun/tambah" class="btn-primary" style="text-decoration: none; width: auto;">+ Tambah Akun</a>
</div>

<div class="tefa-card">
    <!-- Area Filter & Search -->
    <div class="filter-bar">
        <input type="text" id="searchAkun" class="search-input" placeholder="Cari nama, email...">
        
        <select id="filterRole" class="filter-select">
            <option value="Semua">Semua Role</option>
            <option value="Admin TEFA">Admin TEFA</option>
            <option value="Admin Jurusan">Admin Jurusan</option>
        </select>

        <select id="filterStatusAkun" class="filter-select">
            <option value="Semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>
    </div>

    <!-- Tabel Akun -->
    <div class="table-responsive">
        <table class="tefa-table" id="akunTable">
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Jurusan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            
                <tbody>

                    @forelse($akuns as $akun)

                    <tr>

                        <!-- Nama Pengguna -->
                        <td class="col-nama">
                            {{ $akun->nama_pengguna }}
                        </td>


                        <!-- Email -->
                        <td class="col-email">
                            {{ $akun->email }}
                        </td>


                        <!-- Role -->
                        <td class="col-role">
                            {{ $akun->role }}
                        </td>


                        <!-- Jurusan -->
                        <td class="col-jurusan">
                            {{ $akun->jurusan ?? '-' }}
                        </td>


                        <!-- Status -->
                       <td>
                    @if(strtolower(trim($akun->status)) === 'aktif')
                        <span class="badge badge-active">
                            Aktif
                        </span>
                    @else
                        <span class="badge badge-inactive">
                            Tidak Aktif
                        </span>
                    @endif
                </td>


                        <!-- Aksi -->
                        <td>

                            <a
                                href="{{ url('/akun/' . $akun->id) }}"
                                class="btn-outline btn-lihat-detail"
                            >
                                Lihat Detail
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td
                            colspan="6"
                            style="text-align:center; padding:40px;"
                        >
                            Belum Ada Akun
                        </td>

                    </tr>

                    @endforelse

                </tbody>


        </table>
    </div>

    <div id="emptyAkun" style="display: none; text-align: center; padding: 40px;">
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">Belum Ada Akun</h3>
        <p style="color: #6c757d;">Tidak ada akun yang sesuai dengan filter.</p>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/akun.js') }}"></script>
@endsection