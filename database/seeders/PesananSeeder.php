<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pesanans')->insert([
            [
                'no_pesanan' => 'PSN001',
                'nama_pembeli' => 'Haura',
                'produk_jasa' => 'Pembuatan Website',
                'jurusan' => 'RPL',
                'tanggal' => '2026-08-30',
                'status' => 'menunggu konfirmasi',
            ],
            [
                'no_pesanan' => 'PSN002',
                'nama_pembeli' => 'Aisyah',
                'produk_jasa' => 'Desain Logo',
                'jurusan' => 'DKV',
                'tanggal' => '2026-08-30',
                'status' => 'konfirmasi',
            ],
        ]);
    }
}