<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Jurusan TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-jurusan.css') }}">
    <!-- Memanggil Library Ikon Modern (Sama persis dengan desainmu) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body>

    <!-- Header Atas -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()"><i class="ph ph-list"></i></span>
        <h2>@yield('title')</h2>
    </header>

    <!-- Navigation Drawer (Sesuai Desain Figma) -->
    <nav class="drawer" id="navDrawer">
        <!-- Header Drawer -->
        <div class="drawer-top-header">
            <h3>TEFA Admin Jurusan</h3>
            <span class="close-drawer" onclick="toggleDrawer()"><i class="ph ph-x"></i></span>
        </div>

       <!-- Daftar Menu -->
        <ul class="drawer-menu">
            <li><a href="/jurusan-admin/dashboard" class="{{ request()->is('jurusan-admin/dashboard') ? 'active' : '' }}"><i class="ph ph-house"></i> Dashboard</a></li>
            <li><a href="/jurusan-admin/katalog" class="{{ request()->is('jurusan-admin/katalog') ? 'active' : '' }}"><i class="ph ph-tote"></i> Produk dan Jasa</a></li>
            
            <!-- Sub menu (Menjorok ke dalam) -->
            <li class="sub-menu"><a href="/jurusan-admin/kelola-produk" class="{{ request()->is('jurusan-admin/kelola-produk') ? 'active' : '' }}"><i class="ph ph-hexagon"></i> Kelola Produk</a></li>
            <li class="sub-menu"><a href="/jurusan-admin/kelola-jasa" class="{{ request()->is('jurusan-admin/kelola-jasa') ? 'active' : '' }}"><i class="ph ph-wrench"></i> Kelola Jasa</a></li>
            <li class="sub-menu"><a href="/jurusan-admin/kelola-portofolio" class="{{ request()->is('jurusan-admin/kelola-portofolio') ? 'active' : '' }}"><i class="ph ph-image"></i> Kelola Portofolio</a></li>

            <li class="menu-divider"></li>

            <li><a href="/jurusan-admin/kelola-deskripsi" class="{{ request()->is('jurusan-admin/kelola-deskripsi') ? 'active' : '' }}"><i class="ph ph-file-text"></i> Deskripsi Jurusan</a></li>
            <li><a href="/jurusan-admin/akun/tambah" class="{{ request()->is('jurusan-admin/akun/tambah') ? 'active' : '' }}"><i class="ph ph-user-plus"></i> Tambah Akun</a></li>
            
            <!-- PERUBAHAN: Menu aktif sekarang otomatis mendeteksi URL -->
            <li><a href="/jurusan-admin/akun" class="{{ request()->is('jurusan-admin/akun') ? 'active' : '' }}"><i class="ph ph-users"></i> Daftar Akun</a></li>

            <li class="menu-divider"></li>

            <li><a href="/jurusan-admin/profil" class="{{ request()->is('jurusan-admin/profil') ? 'active' : '' }}"><i class="ph ph-user-circle"></i> Profil</a></li>
          
            <!-- PERUBAHAN: Link href diubah untuk memanggil modal -->
            <li><a href="javascript:void(0)" onclick="openLogoutModal()" class="logout-link"><i class="ph ph-sign-out"></i> Logout</a></li>
        </ul>

        <!-- Footer Drawer -->
        <div class="drawer-footer">
            SMKN 4 Tanjungpinang © 2026
        </div>
    </nav>
    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <!-- Konten Utama -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- ================= MODAL LOGOUT ================= -->
    <div id="logoutModal" class="modal-logout-overlay" style="display: none;">
        <div class="modal-logout-box">
            <h3 class="modal-logout-title">Keluar dari akun?</h3>
            <p class="modal-logout-desc">Anda akan diarahkan kembali ke halaman login.</p>
            
            <div class="modal-logout-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeLogoutModal()">Batal</button>
                <!-- Tombol Logout mengarah ke halaman login jurusan -->
                <a href="/login-jurusan" class="btn-modal-logout">Logout</a>
            </div>
        </div>
    </div>

    <style>
        /* Desain Background Modal (Overlay) */
        .modal-logout-overlay {
            position: fixed; inset: 0; 
            background: rgba(15, 23, 42, 0.45); 
            backdrop-filter: blur(2px);
            display: flex; align-items: center; justify-content: center; 
            z-index: 99999; /* Z-index tinggi agar menutupi sidebar */
        }
        /* Desain Kotak Modal */
        .modal-logout-box {
            background: #ffffff; padding: 32px; border-radius: 20px; 
            width: 90%; max-width: 440px; 
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); 
            text-align: left;
            animation: modalFadeIn 0.2s ease-out;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
        .modal-logout-title { font-size: 20px; font-weight: 700; color: #20456E; margin: 0 0 8px 0; font-family: sans-serif; }
        .modal-logout-desc { font-size: 14px; color: #64748B; margin: 0 0 24px 0; font-family: sans-serif; }
        .modal-logout-actions { display: flex; align-items: center; gap: 12px; }
        
        .btn-modal-cancel {
            background: #ffffff; color: #334155; border: 1px solid #CBD5E1; 
            padding: 12px 24px; border-radius: 10px; font-size: 14px; font-weight: 600; 
            cursor: pointer; transition: 0.2s;
        }
        .btn-modal-cancel:hover { background: #F8FAFC; }
        
        .btn-modal-logout {
            flex: 1; background: #DC2626; color: #ffffff; border: none; 
            padding: 12px 24px; border-radius: 10px; font-size: 15px; font-weight: 700; 
            text-align: center; text-decoration: none; transition: 0.2s;
        }
        .btn-modal-logout:hover { background: #B91C1C; }
    </style>

    <script>
        function openLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
        // Menutup modal otomatis jika area di luar kotak putih diklik
        window.addEventListener('click', function(e) {
            const modal = document.getElementById('logoutModal');
            if (e.target === modal) {
                closeLogoutModal();
            }
        });
    </script>
    <!-- ================================================ -->

    <!-- Script Global -->
    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
</body>
</html>