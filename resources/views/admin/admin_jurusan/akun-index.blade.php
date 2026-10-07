@extends('admin.layouts.app-jurusan')

@section('title', 'Daftar Akun')

@section('content')

<div class="header-action akun-page-header">


<div>
    <h2>Daftar Akun</h2>
    <p>Kelola Admin Produser untuk mengelola produk dan jasa</p>
</div>

<a
    href="/jurusan-admin/akun/tambah"
    class="btn-primary btn-tambah-akun-jurusan"
>
    + Tambah Akun
</a>


</div>

<div class="tefa-card akun-card">


<div class="akun-filter-bar">

    <input
        type="text"
        id="searchAkun"
        class="search-input"
        placeholder="Cari nama, email..."
    >

    <select
        id="filterStatus"
        class="filter-select"
    >
        <option value="semua">Semua Status</option>
        <option value="aktif">Aktif</option>
        <option value="tidak_aktif">Tidak Aktif</option>
    </select>

    <select
        id="filterLayanan"
        class="filter-select"
    >
        <option value="semua">Semua Produk/Jasa</option>

        @foreach ($produkJasas as $produkJasa)

            <option value="{{ strtolower($produkJasa->nama_produk_jasa) }}">
                {{ $produkJasa->nama_produk_jasa }}
            </option>

        @endforeach

    </select>

</div>


<div class="table-responsive">

    <table class="akun-table">

        <thead>

            <tr>
                <th>Nama Pengguna</th>
                <th>Email</th>
                <th>Role</th>
                <th>Tanggung Jawab</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>

        </thead>


        <tbody id="akunTableBody">

            @forelse ($akuns as $akun)

                @php
                    $layananAkun = $akun->penugasanProduser
                        ->map(function ($penugasan) {
                            return $penugasan->produkJasa
                                ? $penugasan->produkJasa->nama_produk_jasa
                                : null;
                        })
                        ->filter()
                        ->values();
                @endphp


                <tr
                    class="akun-row"
                    data-nama="{{ strtolower($akun->nama) }}"
                    data-email="{{ strtolower($akun->email) }}"
                    data-status="{{ strtolower($akun->status) }}"
                    data-layanan="{{ strtolower($layananAkun->implode(', ')) }}"
                >

                    <td>
                        <strong>{{ $akun->nama }}</strong>
                    </td>

                    <td>
                        {{ $akun->email }}
                    </td>

                    <td>
                        Admin Produser
                    </td>

                    <td>

                        @if ($layananAkun->count() > 0)

                            <div class="akun-layanan-list">

                                @foreach ($layananAkun as $layanan)

                                    <span class="akun-layanan-badge">
                                        {{ $layanan }}
                                    </span>

                                @endforeach

                            </div>

                        @else

                            <span class="akun-no-tanggung-jawab">
                                Belum ada tanggung jawab
                            </span>

                        @endif

                    </td>

                    <td>

                        @if ($akun->status === 'aktif')

                            <span class="akun-status-badge akun-status-aktif">
                                Aktif
                            </span>

                        @else

                            <span class="akun-status-badge akun-status-tidak-aktif">
                                Tidak Aktif
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="akun-action-buttons">

                            <a
                                href="/jurusan-admin/akun/detail?id={{ $akun->id }}"
                                class="akun-action-button"
                            >
                                Detail
                            </a>

                            <a
    href="/jurusan-admin/akun/edit?id={{ $akun->id }}&from=index"
    class="akun-action-button"
>
    Edit
</a>

                        </div>

                    </td>

                </tr>

            @empty

                <tr id="emptyAkunRow">

                    <td
                        colspan="6"
                        class="akun-empty-row"
                    >

                        <h3>
                            Belum Ada Akun
                        </h3>

                        <p>
                            Belum ada Admin Produser yang dibuat untuk jurusan ini.
                        </p>

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>


<div
    id="emptyAkun"
    class="akun-filter-empty"
>

    <h3>
        Akun Tidak Ditemukan
    </h3>

    <p>
        Tidak ada akun yang sesuai dengan pencarian atau filter.
    </p>

</div>


</div>

@endsection

@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchAkun');
    const filterStatus = document.getElementById('filterStatus');
    const filterLayanan = document.getElementById('filterLayanan');

    const rows = document.querySelectorAll('.akun-row');
    const emptyAkun = document.getElementById('emptyAkun');
    const emptyAkunRow = document.getElementById('emptyAkunRow');


    function filterAkun() {

        const search = searchInput.value.toLowerCase().trim();
        const status = filterStatus.value.toLowerCase();
        const layanan = filterLayanan.value.toLowerCase();

        let jumlahTampil = 0;


        rows.forEach(function (row) {

            const nama = row.dataset.nama || '';
            const email = row.dataset.email || '';
            const rowStatus = row.dataset.status || '';
            const dataLayanan = row.dataset.layanan || '';


            const cocokSearch =
                nama.includes(search) ||
                email.includes(search);


            const cocokStatus =
                status === 'semua' ||
                rowStatus === status;


            const cocokLayanan =
                layanan === 'semua' ||
                dataLayanan.includes(layanan);


            if (
                cocokSearch &&
                cocokStatus &&
                cocokLayanan
            ) {

                row.style.display = '';
                jumlahTampil++;

            } else {

                row.style.display = 'none';

            }

        });


        if (emptyAkunRow) {
            emptyAkunRow.style.display = 'none';
        }


        if (jumlahTampil === 0 && rows.length > 0) {
            emptyAkun.style.display = 'block';
        } else {
            emptyAkun.style.display = 'none';
        }

    }


    searchInput.addEventListener('input', filterAkun);
    filterStatus.addEventListener('change', filterAkun);
    filterLayanan.addEventListener('change', filterAkun);

});
</script>

@endsection
