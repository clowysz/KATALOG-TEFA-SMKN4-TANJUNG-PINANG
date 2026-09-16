<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Jurusan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Buat Admin TEFA
        |--------------------------------------------------------------------------
        */

        User::updateOrCreate(
            ['email' => 'admin.tefa@gmail.com'],
            [
                'nama' => 'Admin TEFA',
                'password' => Hash::make('password'),
                'role' => 'admin_tefa',
                'id_jurusan_asal' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | 2. Buat Akun Admin Jurusan DULU (belum terhubung ke jurusan manapun)
        |--------------------------------------------------------------------------
        */

        $adminRpl = User::updateOrCreate(
            ['email' => 'admin.rpl@gmail.com'],
            ['nama' => 'Admin Jurusan RPL', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        $adminTkj = User::updateOrCreate(
            ['email' => 'admin.tkj@gmail.com'],
            ['nama' => 'Admin Jurusan TKJ', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        $adminDkv = User::updateOrCreate(
            ['email' => 'admin.dkv@gmail.com'],
            ['nama' => 'Admin Jurusan DKV', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        $adminGim = User::updateOrCreate(
            ['email' => 'admin.gim@gmail.com'],
            ['nama' => 'Admin Jurusan GIM', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        $adminPspt = User::updateOrCreate(
            ['email' => 'admin.pspt@gmail.com'],
            ['nama' => 'Admin Jurusan PSPT', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        $adminAnimasi = User::updateOrCreate(
            ['email' => 'admin.animasi@gmail.com'],
            ['nama' => 'Admin Jurusan Animasi', 'password' => Hash::make('password'), 'role' => 'admin_jurusan']
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Baru buat 6 Jurusan, id_user diisi dari admin jurusan yang sudah dibuat
        |--------------------------------------------------------------------------
        */

        Jurusan::updateOrCreate(
            ['slug' => 'rpl'],
            [
                'nama_jurusan' => 'Rekayasa Perangkat Lunak',
                'kode_jurusan' => 'RPL',
                'deskripsi' => 'Jurusan Rekayasa Perangkat Lunak.',
                'id_user' => $adminRpl->id,
            ]
        );

        Jurusan::updateOrCreate(
            ['slug' => 'tkj'],
            [
                'nama_jurusan' => 'Teknik Komputer dan Jaringan',
                'kode_jurusan' => 'TKJ',
                'deskripsi' => 'Jurusan Teknik Komputer dan Jaringan.',
                'id_user' => $adminTkj->id,
            ]
        );

        Jurusan::updateOrCreate(
            ['slug' => 'dkv'],
            [
                'nama_jurusan' => 'Desain Komunikasi Visual',
                'kode_jurusan' => 'DKV',
                'deskripsi' => 'Jurusan Desain Komunikasi Visual.',
                'id_user' => $adminDkv->id,
            ]
        );

        Jurusan::updateOrCreate(
            ['slug' => 'gim'],
            [
                'nama_jurusan' => 'Pengembangan Gim',
                'kode_jurusan' => 'GIM',
                'deskripsi' => 'Jurusan Pengembangan Gim.',
                'id_user' => $adminGim->id,
            ]
        );

        Jurusan::updateOrCreate(
            ['slug' => 'pspt'],
            [
                'nama_jurusan' => 'Produksi dan Siaran Program Televisi',
                'kode_jurusan' => 'PSPT',
                'deskripsi' => 'Jurusan Produksi dan Siaran Program Televisi.',
                'id_user' => $adminPspt->id,
            ]
        );

        Jurusan::updateOrCreate(
            ['slug' => 'animasi'],
            [
                'nama_jurusan' => 'Animasi',
                'kode_jurusan' => 'ANIMASI',
                'deskripsi' => 'Jurusan Animasi.',
                'id_user' => $adminAnimasi->id,
            ]
        );
    }
}