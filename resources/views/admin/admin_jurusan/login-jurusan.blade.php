<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Jurusan</title>
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-jurusan.css') }}">
    <style>
        .login-jurusan-header h2 { color: var(--accent-rpl); margin-bottom: 8px; }
    </style>
</head>
<body>

<div class="login-container">
    <div class="tefa-card login-box">
        <div class="login-header login-jurusan-header">
            <h2>Login Admin Jurusan</h2>
            <p>Masuk untuk mengelola informasi jurusan</p>
        </div>

        <form action="/jurusan-admin/dashboard" method="GET">
            <label for="email" class="detail-label">Email</label>
            <input type="email" id="email" class="form-control" placeholder="Masukkan email" required>

            <label for="password" class="detail-label">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Masukkan password" required>

            <div class="show-password">
                <input type="checkbox" id="togglePassword">
                <label for="togglePassword">Perlihatkan Password</label>
            </div>

            <button type="submit" class="btn-primary">Masuk</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>