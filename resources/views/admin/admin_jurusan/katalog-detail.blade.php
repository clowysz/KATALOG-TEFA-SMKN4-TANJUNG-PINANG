@extends('admin.layouts.app-jurusan')

@section('title', 'Detail Produk/Jasa')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding-bottom: 2rem; font-family: 'Inter', -apple-system, sans-serif;">

    <!-- Navigation Header -->
    <div style="margin-bottom: 16px;">
        <a href="/jurusan-admin/katalog" style="display: inline-flex; align-items: center; gap: 8px; color: #475569; font-size: 13px; font-weight: 600; text-decoration: none; padding: 8px 16px; background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; transition: all 0.2s ease;">
            <i class="ph ph-arrow-left" style="font-size: 16px;"></i> Kembali ke Katalog
        </a>
    </div>

    <!-- State Loading -->
    <div id="detailLoading" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 50px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);">
        <div style="font-size: 36px; margin-bottom: 12px; animation: spin 2s linear infinite;">⏳</div>
        <h3 style="color: #0f172a; font-size: 16px; font-weight: 700; margin-bottom: 4px;">Memuat detail...</h3>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Mohon tunggu sebentar, sedang mengambil data produk/jasa.</p>
    </div>

    <!-- State Error -->
    <div id="detailError" style="display: none; background: #ffffff; border: 1px solid #fee2e2; border-radius: 14px; padding: 50px 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);">
        <div style="font-size: 40px; margin-bottom: 12px; color: #ef4444;">⚠️</div>
        <h3 style="color: #0f172a; font-size: 18px; font-weight: 700; margin-bottom: 6px;">Data tidak ditemukan</h3>
        <p style="color: #64748b; font-size: 13px; margin: 0;">Produk atau jasa yang dipilih tidak tersedia atau telah dihapus.</p>
    </div>

    <!-- Main Detail Content Card -->
    <div id="detailContent" style="display: none; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03); padding: 20px;">

        <!-- Header Gambar Utama (Full Cover, tanpa gap) -->
        <div id="mainImageContainer" style="width: 100%; height: 320px; background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; display: flex; align-items: center; justify-content: center; padding: 0;">
            <img id="detailImg" src="" alt="Gambar Utama" style="width: 100%; height: 100%; object-fit: cover; display: block;">
        </div>

        <!-- Container Galeri Thumbnail -->
        <div id="thumbnailContainer" style="display: flex; gap: 10px; justify-content: center; padding: 12px 0 0 0; overflow-x: auto;"></div>

        <!-- Section Informasi Detail -->
        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #e2e8f0;">

            <!-- Title & Badge -->
            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 16px; margin-bottom: 8px;">
                <h2 id="detailTitle" style="color: #0f172a; font-size: 20px; font-weight: 800; line-height: 1.3; margin: 0;">
                    Memuat...
                </h2>

                <span id="detailBadge" class="badge-tipe-produk" style="display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: #e0f2fe; color: #0369a1; white-space: nowrap;">
                    Memuat...
                </span>
            </div>

            <!-- Price -->
            <div id="detailPrice" style="font-size: 22px; font-weight: 800; color: #2563eb; margin-bottom: 20px;">
                Rp 0
            </div>

            <!-- Description Box -->
            <div style="margin-bottom: 20px;">
                <h3 style="font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 6px;">Deskripsi</h3>
                <div id="detailDesc" style="font-size: 13.5px; color: #334155; line-height: 1.6; white-space: pre-line; background: #fafafa; padding: 14px; border-radius: 8px; border: 1px solid #f1f5f9;">
                    Memuat deskripsi...
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stat-grid-3" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 20px;">

                <div class="stat-box" style="background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; padding: 14px 12px; text-align: center;">
                    <h3 id="statPesanan" style="color: #2563eb; font-size: 20px; font-weight: 800; margin: 0 0 2px 0;">
                        0
                    </h3>
                    <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        Total Pesanan
                    </p>
                </div>

                <div class="stat-box" style="background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; padding: 14px 12px; text-align: center;">
                    <h3 id="statPencarian" style="color: #0284c7; font-size: 20px; font-weight: 800; margin: 0 0 2px 0;">
                        —
                    </h3>
                    <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        Pencarian
                    </p>
                </div>

                <div class="stat-box" style="background: #f8fafc; border: 1px solid #f1f5f9; border-radius: 10px; padding: 14px 12px; text-align: center;">
                    <h3 id="statTampilan" style="color: #16a34a; font-size: 20px; font-weight: 800; margin: 0 0 2px 0;">
                        —
                    </h3>
                    <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">
                        Tampilan Halaman
                    </p>
                </div>

            </div>

            <!-- Info Box Callout -->
            <div class="info-box" style="background: #fefce8; border: 1px solid #fef08a; border-radius: 10px; padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px;">
                <span style="font-size: 18px;">💡</span>
                <div>
                    <div class="info-box-title" style="font-size: 12px; font-weight: 700; color: #854d0e; margin-bottom: 2px;">
                        Informasi Pengelolaan
                    </div>
                    <div style="font-size: 12px; color: #a16207; line-height: 1.5;">
                        Data produk atau jasa ini berasal dari katalog jurusan dan dikelola penuh oleh Admin Jurusan.
                    </div>
                </div>
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

                thumb.style.width = '56px';
                thumb.style.height = '56px';
                thumb.style.objectFit = 'cover';
                thumb.style.borderRadius = '8px';
                thumb.style.cursor = 'pointer';
                thumb.style.border =
                    index === 0
                        ? '2px solid #2563eb'
                        : '1px solid #cbd5e1';
                thumb.style.transition = 'all 0.2s ease';

                thumb.addEventListener('click', function () {

                    detailImg.src = getImageUrl(
                        gambar,
                        jenis
                    );

                    Array.from(
                        thumbnailContainer.children
                    ).forEach(function (child) {
                        child.style.border =
                            '1px solid #cbd5e1';
                    });

                    this.style.border =
                        '2px solid #2563eb';
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

        badge.style.background = jenis === 'Produk' ? '#dcfce7' : '#e0f2fe';
        badge.style.color = jenis === 'Produk' ? '#15803d' : '#0369a1';

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