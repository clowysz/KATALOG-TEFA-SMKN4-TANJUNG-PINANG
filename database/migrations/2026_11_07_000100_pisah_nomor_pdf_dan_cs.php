<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {

        DB::table('pengaturan')
            ->where('kunci', 'nomor_kontak')
            ->update(['kunci' => 'nomor_pdf', 'updated_at' => now()]);

        $nomorPdf = DB::table('pengaturan')
            ->where('kunci', 'nomor_pdf')
            ->value('nilai') ?? '6289653628650';


        DB::table('pengaturan')->updateOrInsert(
            ['kunci' => 'nomor_pdf'],
            ['nilai' => $nomorPdf, 'updated_at' => now(), 'created_at' => now()]
        );

        DB::table('pengaturan')->updateOrInsert(
            ['kunci' => 'nomor_cs'],
            ['nilai' => $nomorPdf, 'updated_at' => now(), 'created_at' => now()]
        );
    }

    public function down(): void
    {
        DB::table('pengaturan')->where('kunci', 'nomor_cs')->delete();

        DB::table('pengaturan')
            ->where('kunci', 'nomor_pdf')
            ->update(['kunci' => 'nomor_kontak', 'updated_at' => now()]);
    }
};