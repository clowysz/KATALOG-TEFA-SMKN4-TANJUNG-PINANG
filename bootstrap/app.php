<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // File yang berisi semua route website
        web: __DIR__.'/../routes/web.php',

        // File untuk command Artisan
        commands: __DIR__.'/../routes/console.php',

        // URL untuk pengecekan kesehatan aplikasi
        health: '/up',
    )

    // Pengaturan middleware aplikasi
    ->withMiddleware(function (Middleware $middleware) {

        // Membuat middleware "role"
        // supaya di routes/web.php kita bisa menggunakan:
        // middleware(['auth', 'role:pembeli'])
        $middleware->alias([
            'role' => CheckRole::class,
        ]);

        // Kalau user belum login dan mencoba membuka
        // halaman yang membutuhkan login,
        // arahkan ke halaman login bersama.
        //
        // URL halaman sebelumnya disimpan sebagai "back"
        // supaya tombol Kembali di halaman login
        // bisa mengembalikan user ke halaman tersebut.
        $middleware->redirectGuestsTo(function ($request) {
            return route('login', [
                'back' => $request->getRequestUri(),
            ]);
        });

    })

    // Pengaturan error/exception aplikasi
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })

    // Membuat dan menjalankan aplikasi
    ->create();