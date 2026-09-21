<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Admin TEFA</title>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}?v=1">
    <link rel="stylesheet" href="{{ asset('css/admin_tefa.css') }}?v=1">

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <style>
        .drawer-menu a{
            display:flex;
            align-items:center;
            gap:12px;
            font-size:15px;
            text-decoration:none;
        }
        .drawer-menu a i{
            font-size:20px;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <span class="hamburger" onclick="toggleDrawer()">☰</span>
        <h2>@yield('title')</h2>
    </header>

    <!-- NAVIGATION DRAWER -->
    <nav class="drawer" id="navDrawer">
        <div class="drawer-top-header" style="display:flex;justify-content:space-between;align-items:center;padding:20px;border-bottom:1px solid #4a5568;">
            <h3 style="color:white;margin:0;font-size:20px;">TEFA Admin</h3>
            <span class="close-drawer" onclick="toggleDrawer()" style="cursor:pointer;color:white;font-size:18px;">✖</span>
        </div>

        <ul class="drawer-menu">
            <li>
                <a href="/dashboard">
                    <i class="ph ph-house"></i> Dashboard
                </a>
            </li>

            <li>
                <a href="/pesanan">
                    <i class="ph ph-shopping-bag"></i> Kelola Pesanan
                </a>
            </li>

            <li>
                <a href="/tefa/jurusan">
                    <i class="ph ph-graduation-cap"></i> Jurusan
                </a>
            </li>

            <li>
                <a href="/akun">
                    <i class="ph ph-users"></i> Daftar Akun
                </a>
            </li>

            <li>
                <a href="/tefa/faq">
                    <i class="ph ph-question"></i> Kelola FAQ
                </a>
            </li>

            <div style="margin-top:15px;padding-top:15px;border-top:1px solid rgba(255,255,255,0.1);"></div>

            <li>
                <a href="/profil">
                    <i class="ph ph-user-circle"></i> Profil
                </a>
            </li>

            <li>
                <a href="javascript:void(0)" onclick="openLogoutModal()" style="color:#F87171;">
                    <i class="ph ph-sign-out"></i> Logout
                </a>
            </li>
        </ul>
    </nav>

    <div class="overlay" id="overlay" onclick="toggleDrawer()"></div>

    <!-- KONTEN HALAMAN -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- MODAL LOGOUT -->
    <div id="logoutModal" class="modal-logout-overlay" style="display:none;">
        <div class="modal-logout-box">
            <h3 class="modal-logout-title">Keluar dari akun?</h3>

            <p class="modal-logout-desc">
                Anda akan diarahkan kembali ke halaman login.
            </p>

            <div class="modal-logout-actions">
                <button type="button" class="btn-modal-cancel" onclick="closeLogoutModal()">
                    Batal
                </button>

                <form action="{{ route('admin.logout') }}" method="POST" style="flex:1;margin:0;">
                    @csrf
                    <button type="submit" class="btn-modal-logout" style="width:100%;cursor:pointer;">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .modal-logout-overlay{
            position:fixed;
            inset:0;
            background:rgba(15,23,42,0.45);
            backdrop-filter:blur(2px);
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:99999;
        }

        .modal-logout-box{
            background:#fff;
            padding:32px;
            border-radius:20px;
            width:90%;
            max-width:440px;
            box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);
            text-align:left;
            animation:modalFadeIn .2s ease-out;
        }

        @keyframes modalFadeIn{
            from{
                opacity:0;
                transform:scale(.95);
            }
            to{
                opacity:1;
                transform:scale(1);
            }
        }

        .modal-logout-title{
            font-size:20px;
            font-weight:700;
            color:#20456E;
            margin:0 0 8px;
            font-family:sans-serif;
        }

        .modal-logout-desc{
            font-size:14px;
            color:#64748B;
            margin:0 0 24px;
            font-family:sans-serif;
        }

        .modal-logout-actions{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .btn-modal-cancel{
            background:#fff;
            color:#334155;
            border:1px solid #CBD5E1;
            padding:12px 24px;
            border-radius:10px;
            font-size:14px;
            font-weight:600;
            cursor:pointer;
            transition:.2s;
        }

        .btn-modal-cancel:hover{
            background:#F8FAFC;
        }

        .btn-modal-logout{
            display:block;
            background:#DC2626;
            color:#fff;
            border:none;
            padding:12px 24px;
            border-radius:10px;
            font-size:15px;
            font-weight:700;
            text-align:center;
            transition:.2s;
        }

        .btn-modal-logout:hover{
            background:#B91C1C;
        }
    </style>

    <script>
        function openLogoutModal(){
            document.getElementById('logoutModal').style.display='flex';
        }

        function closeLogoutModal(){
            document.getElementById('logoutModal').style.display='none';
        }

        window.addEventListener('click',function(e){
            const modal=document.getElementById('logoutModal');
            if(e.target===modal){
                closeLogoutModal();
            }
        });
    </script>

    <!-- JAVASCRIPT GLOBAL -->
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- JAVASCRIPT KHUSUS HALAMAN -->
    @yield('scripts')

</body>
</html>