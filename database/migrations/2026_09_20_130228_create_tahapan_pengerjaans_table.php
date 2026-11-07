<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahapan_pengerjaans', function (Blueprint $table) {
            $table->id();


            $table->foreignId('id_pesanan')
                ->constrained('pesanan', 'id_pesanan')
                ->onDelete('cascade');


            $table->string('nama_tahapan');


            $table->integer('urutan');


            $table->string('status')->default('belum');


            $table->integer('persentase_progress')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan_pengerjaans');
    }
};