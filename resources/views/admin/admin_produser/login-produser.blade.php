<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login TEFA - Admin Produk/Jasa</title>
    <!-- Memanggil Font Clean & Menarik -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <style>
        /* Desain Khusus Sesuai Prompt Figma */
        :root {
            --primary: #3B698F;
            --primary-dark: #2D5472;
            --bg-color: #F5F7FA;
            --white: #FFFFFF;
            --border: #E2E8F0;
            --text-primary: #1E2D3D;
            --text-secondary: #64748B;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
            padding: 20px;
        }

        .login-admin-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 48px 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        /* Badge Kotak Rounded TEFA */
        .tefa-logo-badge {
            width: 72px;
            height: 72px;
            background: var(--primary);
            color: var(--white);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 2px;
            margin: 0 auto 24px auto;
            font-family: 'Poppins', sans-serif;
            box-shadow: 0 8px 16px rgba(59, 105, 143, 0.2);
        }

        h2 {
            font-size: 24px;
            color: var(--text-primary);
            margin-bottom: 8px;
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        p.subtitle {
            font-size: 14px;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        .login-form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .login-form-group label {
            display: block;
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-input-box {
            display: flex;
            align-items: center;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            transition: 0.2s;
        }

        .login-input-box:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 105, 143, 0.1);
        }

        .login-input-box i { 
            color: var(--text-secondary); 
            font-size: 20px; 
            margin-right: 12px; 
        }

        .login-input-box input { 
            border: none; 
            background: transparent; 
            outline: none; 
            width: 100%; 
            font-size: 14px; 
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
        }

        .login-input-box input::placeholder {
            color: #94A3B8;
        }

        .btn-login-admin {
            width: 100%;
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
            margin-top: 12px;
            font-family: 'Poppins', sans-serif;
        }

        .btn-login-admin:hover {
            background: var(--primary-dark);
        }
    </style>
</head>
<body>

    <div class="login-admin-card">
        <!-- Badge Kotak TEFA -->
        <div class="tefa-logo-badge">TEFA</div>
        
        <h2>Login TEFA</h2>
        <p class="subtitle">Masuk untuk mengelola Teaching Factory</p>

        <!-- Form dialihkan menggunakan JavaScript agar URL rapi (tanpa '?') -->
        <form onsubmit="event.preventDefault(); window.location.href='/produser/dashboard';">
            <div class="login-form-group">
                <label>Email</label>
                <div class="login-input-box">
                    <i class="ph ph-envelope"></i>
                    <!-- Sesuai dengan contoh akun prototype -->
                    <input type="email" placeholder="Contoh: admin123@gmail.com" required>
                </div>
            </div>

            <div class="login-form-group">
                <label>Password</label>
                <div class="login-input-box">
                    <i class="ph ph-lock-key"></i>
                    <input type="password" id="passwordField" placeholder="Masukkan password" required>
                    <i class="ph ph-eye" id="togglePassword" style="cursor: pointer; margin-right: 0; margin-left: 12px;" title="Tampilkan Password"></i>
                </div>
            </div>

            <button type="submit" class="btn-login-admin">Masuk</button>
        </form>
    </div>

    <!-- Script Show/Hide Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            if (type === 'password') {
                this.classList.remove('ph-eye-slash');
                this.classList.add('ph-eye');
            } else {
                this.classList.remove('ph-eye');
                this.classList.add('ph-eye-slash');
            }
        });
    </script>

</body>
</html>