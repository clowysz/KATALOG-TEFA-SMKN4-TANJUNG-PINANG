@extends('admin.layouts.app')

@section('title', 'Daftar Akun')

@section('content')

@php
$akuns = [
(object)[
'id' => 1,
'nama_pengguna' => 'Miftakhul Khoiriyah',
'email' => '[miyuki@smkn4tanjungpinang.sch.id](mailto:miyuki@smkn4tanjungpinang.sch.id)',
'role' => 'Admin TEFA',
'jurusan' => '-',
'status' => 'Aktif'
],
(object)[
'id' => 2,
'nama_pengguna' => 'Pak Budi Santoso',
'email' => '[budi.rpl@smkn4tanjungpinang.sch.id](mailto:budi.rpl@smkn4tanjungpinang.sch.id)',
'role' => 'Admin Jurusan',
'jurusan' => 'Rekayasa Perangkat Lunak',
'status' => 'Aktif'
],
(object)[
'id' => 3,
'nama_pengguna' => 'Bu Siti Aminah',
'email' => '[siti.dkv@smkn4tanjungpinang.sch.id](mailto:siti.dkv@smkn4tanjungpinang.sch.id)',
'role' => 'Admin Jurusan',
'jurusan' => 'Desain Komunikasi Visual',
'status' => 'Tidak Aktif'
]
];
@endphp

<div class="header-action page-header">
    <div>
        <h2 style="font-size: 20px; font-weight: bold; color: #1e293b;">
            Daftar Akun
        </h2>
        <p style="color: #64748b; font-size: 14px; margin-top: 4px;">
            Kelola akses pengguna internal TEFA
        </p>
    </div>

```
<a href="/akun/tambah"
   class="btn-primary"
   style="text-decoration: none; width: auto;">
    + Tambah Akun
</a>
```

</div>

<div class="tefa-card">

```
<!-- Area Filter & Search -->
<div class="filter-bar">
    <input type="text"
           id="searchAkun"
           class="search-input"
           placeholder="Cari nama, email...">

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
                <td class="col-nama">
                    {{ $akun->nama_pengguna }}
                </td>

                <td class="col-email">
                    {{ $akun->email }}
                </td>

                <td class="col-role">
                    {{ $akun->role }}
                </td>

                <td class="col-jurusan">
                    {{ $akun->jurusan ?? '-' }}
                </td>

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

                <td>
                    <a href="{{ url('/akun/' . $akun->id) }}"
                       class="btn-outline btn-lihat-detail">
                        Lihat Detail
                    </a>
                </td>
            </tr>

            @empty

            <tr>
                <td colspan="6"
                    style="text-align:center; padding:60px 20px;">

                    <h3 style="color: #1e293b; margin-bottom: 8px; font-size: 18px;">
                        Belum Ada Akun
                    </h3>

                    <p style="color: #64748b; font-size: 14px;">
                        Data akun saat ini masih kosong atau belum ditambahkan ke dalam database.
                    </p>

                </td>
            </tr>

            @endforelse
        </tbody>

    </table>
</div>
```

</div>

@endsection

@section('scripts')

<script src="{{ asset('js/akun.js') }}"></script>

@endsection
