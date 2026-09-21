<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\CheckRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'role' => CheckRole::class,
        ]);

        $middleware->redirectGuestsTo(function ($request) {

            // Route admin_jurusan dan admin_produser sudah punya prefix sendiri,
            // jadi aman dicek dengan wildcard.
            if (
                $request->is('jurusan-admin/*') ||
                $request->is('produser/*')
            ) {
                return route('admin.login');
            }

            // Route pembeli yang namanya mirip route admin_tefa
            // (misal 'profil-pembeli' vs 'profil') harus dicek
            // LEBIH DULU supaya tidak salah dianggap halaman admin.
            $rutePembeliMiripAdmin = [
                'profil-pembeli',
                'riwayat-pesanan',
                'riwayat-pesanan/*',
            ];

            foreach ($rutePembeliMiripAdmin as $ruteMirip) {
                if ($request->is($ruteMirip)) {
                    return route('pembeli.login');
                }
            }

            // Route admin_tefa TIDAK punya prefix seragam (contoh: /dashboard,
            // /pesanan, /akun, /profil, /tefa/*), jadi daftar rutenya
            // dicek satu per satu supaya tidak ada yang kelewat.
            $ruteAdminTefa = [
                'admin',
                'admin/*',
                'dashboard',
                'pesanan',
                'pesanan/*',
                'akun',
                'akun/*',
                'profil',
                'tefa/*',
            ];

            foreach ($ruteAdminTefa as $ruteAdmin) {
                if ($request->is($ruteAdmin)) {
                    return route('admin.login');
                }
            }

            return route('pembeli.login');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();