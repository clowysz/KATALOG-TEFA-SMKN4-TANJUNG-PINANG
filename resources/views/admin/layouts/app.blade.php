<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin_tefa.css') }}?v=1">  
</head>
<body>

    <!-- Header -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()">☰</span>
        <h2>@yield('title')</h2>
    </header>

    <!-- Navigation Drawer -->
    <nav class="drawer" id="navDrawer">
        <ul class="drawer-menu">    
            <li><a href="/dashboard">Dashboard</a></li>
            <li><a href="/pesanan">Kelola Pesanan</a></li>
            <li><a href="/tefa/jurusan">Jurusan</a></li>
            <li><a href="/akun">Daftar Akun</a></li>
            <!-- INI BARIS YANG DITAMBAHKAN UNTUK MENU FAQ -->
            <li><a href="/tefa/faq">Kelola FAQ</a></li>
            <li><a href="/profil">Profil</a></li>
            <li>
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-link">
                    Logout
                </button>
            </form>
</li>
        </ul>
    </nav>
    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <!-- Konten Halaman yang akan berubah-ubah -->
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
                <!-- Tombol Logout akan mengarahkan ke halaman login TEFA -->
                <a href="/login-tefa" class="btn-modal-logout">Logout</a>
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

    <!-- Memanggil JavaScript Global -->
    <script src="{{ asset('js/script.js') }}"></script>
    
    <!-- Tempat untuk Script Khusus per Halaman -->
    @yield('scripts')
    
</body>
</html>