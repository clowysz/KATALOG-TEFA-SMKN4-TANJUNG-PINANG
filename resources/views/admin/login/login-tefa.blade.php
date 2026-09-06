<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login TEFA</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-produser.css') }}">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body style="background-color: #F5F7FA;">

<div class="login-container">
    <div class="tefa-card login-box" style="padding: 40px; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        
        <div class="tefa-logo-box">TEFA</div>
        
        <div class="login-header" style="text-align: center; margin-bottom: 32px;">
            <h2 style="color: #1E2D3D; font-size: 24px; margin-bottom: 8px;">Login TEFA</h2>
            <p style="color: #64748B; font-size: 14px;">Masuk untuk mengelola Teaching Factory</p>
        </div>

        <form id="formLoginProduser">
            <label class="detail-label" style="color: #1E2D3D;">Email</label>
            <input type="email" id="loginEmail" class="form-control" placeholder="Masukkan email" required>

            <label class="detail-label" style="color: #1E2D3D;">Password</label>
            <div style="position: relative;">
                <input type="password" id="loginPass" class="form-control" placeholder="Masukkan password" required>
                <span id="toggleLoginPass" style="position: absolute; right: 16px; top: 12px; cursor: pointer; color: #94A3B8;"><i class="ph ph-eye"></i></span>
            </div>

            <div id="loginError" style="color: #DC2626; font-size: 13px; margin-top: 12px; display: none; background: #FEE2E2; padding: 10px; border-radius: 8px;">Email atau password salah.</div>

            <button type="submit" id="btnLogin" class="btn-primary" style="margin-top: 24px; width: 100%; border-radius: 8px; padding: 14px;">Masuk</button>
        </form>
    </div>
</div>

<script>
    // Fitur Show/Hide Password
    const toggleEye = document.getElementById('toggleLoginPass');
    const passInput = document.getElementById('loginPass');
    toggleEye.addEventListener('click', function() {
        if(passInput.type === 'password') {
            passInput.type = 'text';
            toggleEye.innerHTML = '<i class="ph ph-eye-slash"></i>';
        } else {
            passInput.type = 'password';
            toggleEye.innerHTML = '<i class="ph ph-eye"></i>';
        }
    });

    // Simulasi Login Loading & Validasi (admin123@gmail.com / admin123)
    document.getElementById('formLoginProduser').addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const pass = document.getElementById('loginPass').value;
        const btn = document.getElementById('btnLogin');
        const errorBox = document.getElementById('loginError');

        btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Memproses...';
        btn.style.opacity = '0.8';
        errorBox.style.display = 'none';

        setTimeout(() => {
            if(email === 'admin123@gmail.com' && pass === 'admin123') {
                // PERBAIKAN: Arahkan ke rute Dashboard TEFA Utama
                window.location.href = '/dashboard';
            } else {
                errorBox.textContent = 'Email atau password tidak sesuai.';
                errorBox.style.display = 'block';
                btn.innerHTML = 'Masuk';
                btn.style.opacity = '1';
            }
        }, 1000); // Simulasi loading 1 detik
    });
</script>
</body>
</html>