<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id('id_portfolio');
            
            // Mengacu ke tabel 'jurusans' (pake huruf S di akhir)
            $table->foreignId('id_jurusan')
                  ->constrained('jurusans', 'id_jurusan')
                  ->onDelete('cascade');

            $table->string('judul_portfolio');
            $table->text('deskripsi_portfolio');
            $table->string('gambar_portfolio')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};