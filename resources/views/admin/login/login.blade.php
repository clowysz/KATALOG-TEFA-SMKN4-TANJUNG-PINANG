<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin TEFA</title>

    <link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>

<body>

    <div class="login-container">

        <div class="login-card">

            <div class="login-header">

                <div class="login-icon">
                    TEFA
                </div>

                <h2>Login Admin</h2>

                <p>
                    Silakan masuk sebagai Admin TEFA,
                    Admin Jurusan, atau Admin Produser.
                </p>

            </div>

            @if ($errors->any())
                <div class="login-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('admin.login.proses') }}" method="POST">

                @csrf

                <div class="form-group">
                    <label for="email">Email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Masukkan email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Login
                </button>

            </form>

        </div>

    </div>

</body>
</html>