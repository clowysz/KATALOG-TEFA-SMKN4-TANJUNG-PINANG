@extends('layouts.app-produser')

@section('title', 'Profil Saya')

@section('content')
<div style="max-width: 800px; margin: 0 auto 40px auto;">

    <!-- CARD ATAS: INFORMASI AKUN -->
    <div class="tefa-card" style="padding: 0; background: white; border-radius: 12px; overflow: hidden; margin-bottom: 24px;">
        
        <!-- Header Biru & Avatar -->
        <div style="background: var(--primary); padding: 40px 32px; display: flex; align-items: center; gap: 24px;">
            <div style="width: 80px; height: 80px; background: #D8893D; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 36px; font-weight: 700; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                R
            </div>
            <div>
                <h2 style="font-size: 28px; color: white; margin-bottom: 8px; font-weight: 700;">Rizky Pratama</h2>
                <div style="background: rgba(255,255,255,0.2); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; display: inline-block;">
                    Admin Produk/Jasa
                </div>
            </div>
        </div>

        <!-- List Informasi Akun -->
        <div style="padding: 32px;">
            <div style="font-size: 13px; font-weight: 700; color: var(--prod-text-sec); text-transform: uppercase; margin-bottom: 24px; letter-spacing: 0.5px;">Informasi Akun</div>
            
            <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--prod-border); margin-bottom: 16px;">
                <div style="color: var(--prod-text-sec); font-size: 15px;">Nama Lengkap</div>
                <div style="color: var(--prod-text-main); font-weight: 600; font-size: 15px;">Rizky Pratama</div>
            </div>
            
            <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--prod-border); margin-bottom: 16px;">
                <div style="color: var(--prod-text-sec); font-size: 15px;">Email</div>
                <div style="color: var(--prod-text-main); font-weight: 600; font-size: 15px;">admin123@gmail.com</div>
            </div>
            
            <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--prod-border); margin-bottom: 16px;">
                <div style="color: var(--prod-text-sec); font-size: 15px;">Role</div>
                <div style="color: var(--prod-text-main); font-weight: 600; font-size: 15px;">Admin Produk/Jasa</div>
            </div>
            
            <div style="display: flex; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid var(--prod-border);">
                <div style="color: var(--prod-text-sec); font-size: 15px;">Status Akun</div>
                <div style="color: var(--prod-success); font-weight: 600; font-size: 15px;">Aktif</div>
            </div>
        </div>
    </div>

    <!-- CARD BAWAH: TANGGUNG JAWAB PRODUK/JASA -->
    <div class="tefa-card" style="padding: 32px; background: white; border-radius: 12px;">
        <div style="margin-bottom: 24px; padding-bottom: 20px; border-bottom: 1px solid var(--prod-border);">
            <h3 style="font-size: 18px; color: var(--prod-text-main); margin-bottom: 4px; font-weight: 700;">Tanggung Jawab Produk/Jasa</h3>
            <p style="font-size: 14px; color: var(--prod-text-sec);">Produk dan jasa yang berada di bawah pengelolaan Anda.</p>
        </div>

        <!-- List Data Tanggung Jawab -->
        <div id="profilTanggungJawabList" style="display: flex; flex-direction: column; gap: 16px;">
            <!-- Dimuat oleh JS -->
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data Katalog Sesuai Gambar Figma
    const myKatalog = [
        { name: 'Website Edukasi', type: 'Jasa', code: 'PRD-001', price: 'Rp 3.500.000', orders: 2, img: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=100&q=80' },
        { name: 'Aplikasi Mobile Sekolah', type: 'Jasa', code: 'PRD-002', price: 'Rp 8.000.000', orders: 1, img: 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=100&q=80' },
        { name: 'Desain Logo & Branding', type: 'Produk', code: 'PRD-003', price: 'Rp 750.000', orders: 2, img: 'https://images.unsplash.com/photo-1626785774573-4b799315345d?w=100&q=80' }
    ];

    const listContainer = document.getElementById('profilTanggungJawabList');
    if (listContainer) {
        listContainer.innerHTML = '';
        myKatalog.forEach(item => {
            const badgeClass = item.type === 'Produk' ? 'badge-tipe-produk-new' : 'badge-tipe-jasa-new';
            
            listContainer.innerHTML += `
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; border: 1px solid var(--prod-border); border-radius: 12px; transition: 0.2s;">
                    
                    <div style="display: flex; align-items: center; gap: 16px;">
                        <img src="${item.img}" style="width: 56px; height: 56px; border-radius: 8px; object-fit: cover; border: 1px solid var(--prod-border);">
                        <div>
                            <div style="font-weight: 700; color: var(--prod-text-main); font-size: 16px; margin-bottom: 6px;">${item.name}</div>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <span class="${badgeClass}">${item.type}</span>
                                <span style="font-size: 12px; color: var(--prod-text-sec); font-weight: 500;">${item.code}</span>
                            </div>
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <div style="font-weight: 700; color: var(--primary); font-size: 16px; margin-bottom: 4px;">${item.price}</div>
                        <div style="font-size: 12px; color: var(--prod-text-sec);">${item.orders} pesanan</div>
                    </div>

                </div>
            `;
        });
    }
});
</script>
@endsection