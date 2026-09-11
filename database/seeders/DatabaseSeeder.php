<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin TEFA',
            'email' => 'admintefa@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin_tefa',
        ]);

        User::create([
            'name' => 'Admin Jurusan',
            'email' => 'adminjurusan@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin_jurusan',
        ]);

        User::create([
            'name' => 'Admin Produser',
            'email' => 'adminproduser@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin_produser',
        ]);
    }
}