@extends('admin.layouts.app-jurusan')

@section('title', 'Daftar Akun')

@section('content')
<div class="header-action">
    <div>
        <h2>Daftar Akun</h2>
        <p>Kelola Admin Produser untuk mengelola produk dan jasa</p>
    </div>

    <a href="/jurusan-admin/akun/tambah"
       class="btn-primary"
       style="text-decoration: none; width: auto;">
        + Tambah Akun
    </a>
</div>

<div class="tefa-card" style="padding: 24px;">

    <div class="filter-bar" style="margin-bottom: 24px;">

        <input
            type="text"
            id="searchAkun"
            class="search-input"
            placeholder="Cari nama, email..."
            style="margin-bottom: 0;"
        >

        <select
            id="filterStatus"
            class="filter-select"
            style="margin-bottom: 0;"
        >
            <option value="semua">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="tidak_aktif">Tidak Aktif</option>
        </select>

        <select
            id="filterLayanan"
            class="filter-select"
            style="margin-bottom: 0;"
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
        <table class="table-modern">

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

                                <div style="display: flex; flex-wrap: wrap; gap: 6px;">

                                    @foreach ($layananAkun as $layanan)
                                        <span class="badge">
                                            {{ $layanan }}
                                        </span>
                                    @endforeach

                                </div>

                            @else

                                <span style="color: #6c757d;">
                                    Belum ada tanggung jawab
                                </span>

                            @endif
                        </td>

                        <td>
                            @if ($akun->status === 'aktif')

                                <span class="badge">
                                    Aktif
                                </span>

                            @else

                                <span class="badge">
                                    Tidak Aktif
                                </span>

                            @endif
                        </td>

                        <td>
                            <div style="display: flex; gap: 8px;">

                                <a
                                    href="/jurusan-admin/akun/detail?id={{ $akun->id }}"
                                    class="btn-secondary"
                                    style="text-decoration: none;"
                                >
                                    Detail
                                </a>

                                <a
                                    href="/jurusan-admin/akun/edit?id={{ $akun->id }}"
                                    class="btn-secondary"
                                    style="text-decoration: none;"
                                >
                                    Edit
                                </a>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr id="emptyAkunRow">
                        <td colspan="6" style="text-align: center; padding: 40px;">

                            <h3 style="color: var(--text-dark); margin-bottom: 8px;">
                                Belum Ada Akun
                            </h3>

                            <p style="color: #6c757d;">
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
        style="display: none; text-align: center; padding: 40px;"
    >
        <h3 style="color: var(--text-dark); margin-bottom: 8px;">
            Data Tidak Ditemukan
        </h3>

        <p style="color: #6c757d;">
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