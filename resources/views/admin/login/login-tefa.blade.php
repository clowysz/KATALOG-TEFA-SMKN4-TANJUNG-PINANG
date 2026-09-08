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

<div class="login-container" style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
    <div class="tefa-card login-box" style="background: white; width: 100%; max-width: 400px; padding: 40px; border-radius: 16px; border: 1px solid #E2E8F0; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
        
        <div class="login-header" style="text-align: center; margin-bottom: 32px;">
            <!-- Desain Baru Tulisan TEFA -->
            <div style="background: #1E3A8A; color: white; width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; margin: 0 auto 16px auto; box-shadow: 0 10px 25px rgba(30,58,138,0.2); letter-spacing: 2px;">
                TEFA
            </div>
            
            <h2 style="color: #1E2D3D; font-size: 24px; margin-bottom: 8px;">Login Admin TEFA</h2>
            <p style="color: #64748B; font-size: 14px; line-height: 1.5;">Masuk ke akun Anda untuk mengelola sistem Teaching Factory</p>
        </div>

        <form id="formLoginProduser">
            <label class="detail-label" style="color: #1E2D3D; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Email</label>
            <input type="email" id="loginEmail" class="form-control" placeholder="Masukkan email" required style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #E2E8F0; margin-bottom: 16px; box-sizing: border-box;">

            <label class="detail-label" style="color: #1E2D3D; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block;">Password</label>
            <div style="position: relative;">
                <input type="password" id="loginPass" class="form-control" placeholder="Masukkan password" required style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid #E2E8F0; box-sizing: border-box;">
                <span id="toggleLoginPass" style="position: absolute; right: 16px; top: 12px; cursor: pointer; color: #94A3B8; font-size: 18px;"><i class="ph ph-eye"></i></span>
            </div>

            <div id="loginError" style="color: #DC2626; font-size: 13px; margin-top: 12px; display: none; background: #FEE2E2; padding: 10px; border-radius: 8px; text-align: center;">Email atau password salah.</div>

            <button type="submit" id="btnLogin" class="btn-primary" style="background: #1E3A8A; color: white; border: none; font-weight: 600; margin-top: 24px; width: 100%; border-radius: 8px; padding: 14px; cursor: pointer; transition: 0.3s;">Masuk</button>
        </form>
    </div>
</div>

<script>

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
                window.location.href = '/dashboard';
            } else {
                errorBox.textContent = 'Email atau password tidak sesuai.';
                errorBox.style.display = 'block';
                btn.innerHTML = 'Masuk';
                btn.style.opacity = '1';
            }
        }, 1000);
    });
</script>
</body>
</html> 