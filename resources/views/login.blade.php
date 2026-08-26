<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin TEFA</title>
    <!-- Memanggil CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="login-container">
    <div class="tefa-card login-box">
        <div class="login-header">
            <h2>Login Admin TEFA</h2>
            <p>Masuk untuk mengelola Teaching Factory</p>
        </div>

        <form action="/dashboard" method="GET">
            <label for="email">Email</label>
            <input type="email" id="email" class="form-control" placeholder="Masukkan email" required>

            <label for="password">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Masukkan password" required>

            <div class="show-password">
                <input type="checkbox" id="togglePassword">
                <label for="togglePassword">Perlihatkan Password</label>
            </div>

            <button type="submit" class="btn-primary">Masuk</button>
        </form>
    </div>
</div>

<!-- Memanggil JavaScript -->
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>