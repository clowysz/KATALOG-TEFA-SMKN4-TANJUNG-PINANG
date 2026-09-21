@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk/Jasa')

@section('content')
<div class="page-header" style="margin-bottom: 16px;">
    <a href="/jurusan-admin/katalog" class="btn-outline" style="border: none; padding-left: 0;">
        ← Kembali
    </a>
</div>

<div id="detailLoading" class="tefa-card" style="max-width: 850px; padding: 60px 20px; text-align: center;">
    <div style="font-size: 40px; margin-bottom: 12px;">⏳</div>
    <h3 style="color: #1e293b;">Memuat detail...</h3>
</div>

<div id="detailError" class="tefa-card" style="display: none; max-width: 850px; padding: 60px 20px; text-align: center;">
    <div style="font-size: 50px; margin-bottom: 16px;">⚠️</div>
    <h3 style="color: #1e293b; margin-bottom: 8px;">Data tidak ditemukan</h3>
    <p style="color: #64748b;">Produk atau jasa yang dipilih tidak ditemukan.</p>
</div>

<div id="detailContent" class="tefa-card" style="display: none; max-width: 850px; padding: 0; overflow: hidden; border-radius: 12px;">

    <div style="background: #F8FAFC; text-align: center; padding: 20px 0; border-bottom: 1px solid #E2E8F0;">

        <img
            id="detailImg"
            src=""
            alt="Gambar Utama"
            style="width: 100%; max-height: 400px; object-fit: contain; margin-bottom: 16px;"
        >

        <div
            id="thumbnailContainer"
            style="display: flex; gap: 12px; justify-content: center; padding: 0 20px; overflow-x: auto;"
        ></div>

    </div>

    <div style="padding: 32px;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; gap: 12px;">

            <h2
                id="detailTitle"
                style="color: var(--primary); font-size: 26px; margin: 0;"
            >
                Memuat...
            </h2>

            <span
                id="detailBadge"
                class="badge-tipe-produk"
            >
                Memuat...
            </span>

        </div>

        <div
            id="detailPrice"
            style="font-size: 22px; font-weight: 700; color: var(--primary); margin-bottom: 24px;"
        >
            Rp 0
        </div>

        <div
            id="detailDesc"
            style="font-size: 14px; color: var(--text-muted); line-height: 1.6; margin-bottom: 24px;"
        >
            Memuat deskripsi...
        </div>

        <div class="stat-grid-3">

            <div class="stat-box">
                <h3 id="statPesanan" style="color: var(--primary); font-size: 24px;">
                    0
                </h3>
                <p style="font-size: 12px; color: var(--text-muted);">
                    Pesanan
                </p>
            </div>

            <div class="stat-box">
                <h3 id="statPencarian" style="color: var(--accent-rpl); font-size: 24px;">
                    —
                </h3>
                <p style="font-size: 12px; color: var(--text-muted);">
                    Pencarian
                </p>
            </div>

            <div class="stat-box">
                <h3 id="statTampilan" style="color: #28a745; font-size: 24px;">
                    —
                </h3>
                <p style="font-size: 12px; color: var(--text-muted);">
                    Tampilan
                </p>
            </div>

        </div>

        <div class="info-box">

            <div class="info-box-title">
                Informasi Tambahan
            </div>

            <div
                style="font-size: 13px; color: #855b35; line-height: 1.5;"
            >
                Data produk atau jasa ini berasal dari katalog jurusan
                dan dikelola oleh Admin Jurusan.
            </div>

        </div>

    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', async function () {

    const params = new URLSearchParams(window.location.search);
    const idProdukJasa = params.get('id_produk_jasa');

    const loading = document.getElementById('detailLoading');
    const error = document.getElementById('detailError');
    const content = document.getElementById('detailContent');

    if (!idProdukJasa) {
        loading.style.display = 'none';
        error.style.display = 'block';
        return;
    }

    function formatRupiah(value) {
        if (value === null || value === undefined || value === '') {
            return 'Rp0';
        }

        const number = Number(value);

        if (isNaN(number)) {
            return value;
        }

        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    }

    function getImageUrl(gambar, jenis) {
        if (gambar && gambar.path_gambar) {
            return '/storage/' + gambar.path_gambar;
        }

        return 'https://placehold.co/800x500/E2E8F0/1E3A8A?text=' + encodeURIComponent(jenis);
    }

    try {

        const [responseProduk, responseJasa] = await Promise.all([
            fetch('/jurusan-admin/produk?jenis=produk', {
                headers: {
                    'Accept': 'application/json'
                }
            }),

            fetch('/jurusan-admin/produk?jenis=jasa', {
                headers: {
                    'Accept': 'application/json'
                }
            })
        ]);

        if (!responseProduk.ok || !responseJasa.ok) {
            throw new Error('Gagal mengambil data.');
        }

        const resultProduk = await responseProduk.json();
        const resultJasa = await responseJasa.json();

        const semuaData = [
            ...(resultProduk.data || []),
            ...(resultJasa.data || [])
        ];

        const item = semuaData.find(function (data) {
            return String(data.id_produk_jasa) === String(idProdukJasa);
        });

        if (!item) {
            throw new Error('Produk/jasa tidak ditemukan.');
        }

        const jenis = item.jenis === 'jasa' ? 'Jasa' : 'Produk';

        const detailImg = document.getElementById('detailImg');
        const thumbnailContainer = document.getElementById('thumbnailContainer');

        const gambarList = item.gambars && item.gambars.length > 0
            ? item.gambars
            : [];

        thumbnailContainer.innerHTML = '';

        if (gambarList.length > 0) {

            detailImg.src = getImageUrl(
                gambarList[0],
                jenis
            );

            gambarList.forEach(function (gambar, index) {

                const thumb = document.createElement('img');

                thumb.src = getImageUrl(
                    gambar,
                    jenis
                );

                thumb.alt = 'Gambar ' + (index + 1);

                thumb.style.width = '70px';
                thumb.style.height = '70px';
                thumb.style.objectFit = 'cover';
                thumb.style.borderRadius = '8px';
                thumb.style.cursor = 'pointer';
                thumb.style.border =
                    index === 0
                        ? '2px solid var(--primary)'
                        : '1px solid #CBD5E1';
                thumb.style.transition = '0.2s';

                thumb.addEventListener('click', function () {

                    detailImg.src = getImageUrl(
                        gambar,
                        jenis
                    );

                    Array.from(
                        thumbnailContainer.children
                    ).forEach(function (child) {
                        child.style.border =
                            '1px solid #CBD5E1';
                    });

                    this.style.border =
                        '2px solid var(--primary)';
                });

                thumbnailContainer.appendChild(thumb);
            });

        } else {

            detailImg.src = getImageUrl(
                null,
                jenis
            );
        }

        document.getElementById('detailTitle').textContent =
            item.nama_produk_jasa || '-';

        document.getElementById('detailPrice').textContent =
            formatRupiah(item.harga);

        document.getElementById('detailDesc').textContent =
            item.deskripsi || 'Tidak ada deskripsi.';

        const badge =
            document.getElementById('detailBadge');

        badge.textContent = jenis;

        badge.className =
            jenis === 'Produk'
                ? 'badge-tipe-produk'
                : 'badge-tipe-jasa';

        document.getElementById('statPesanan').textContent =
            item.pesanans_count || 0;

        loading.style.display = 'none';
        content.style.display = 'block';

    } catch (err) {

        console.error(err);

        loading.style.display = 'none';
        content.style.display = 'none';
        error.style.display = 'block';
    }

});
</script>
@endsection