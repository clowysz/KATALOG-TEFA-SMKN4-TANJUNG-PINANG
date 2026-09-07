<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin</title>

    <!-- CSS Global -->
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <!-- CSS Admin TEFA -->
    <link rel="stylesheet" href="{{ asset('css/admin_tefa.css') }}">
</head>

<body>

<div class="login-container">

    <div class="tefa-card login-box">

        <!-- HEADER LOGIN -->
        <div class="login-header">

            <h2>Login Admin</h2>

            <p>
                Masuk untuk mengelola Teaching Factory
            </p>

        </div>


        <!-- FORM LOGIN -->
        <form action="/dashboard" method="GET">

            <!-- EMAIL -->
            <label for="email">
                Email
            </label>

            <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                placeholder="Masukkan email"
                required
            >


            <!-- PASSWORD -->
            <label for="password">
                Password
            </label>

            <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >


            <!-- SHOW PASSWORD -->
            <div class="show-password">

                <input
                    type="checkbox"
                    id="togglePassword"
                >

                <label for="togglePassword">
                    Perlihatkan Password
                </label>

            </div>


            <!-- TOMBOL LOGIN -->
            <button
                type="submit"
                class="btn-primary"
            >
                Masuk
            </button>

        </form>

    </div>

</div>


<!-- JAVASCRIPT -->
<script src="{{ asset('js/script.js') }}"></script>

</body>
</html>