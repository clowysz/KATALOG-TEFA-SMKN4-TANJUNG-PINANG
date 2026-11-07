<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->id('id_pengaturan');
            $table->string('kunci', 100)->unique();
            $table->text('nilai')->nullable();
            $table->timestamps();
        });


        DB::table('pengaturan')->insert([
            [
                'kunci' => 'nomor_pdf',
                'nilai' => '6289653628650',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kunci' => 'nomor_cs',
                'nilai' => '6289653628650',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};