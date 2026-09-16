<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_portfolio', function (Blueprint $table) {
            $table->id('id_gambar_portfolio');
            
            // Mengacu ke nama tabel 'portfolio' (tanpa s)
            $table->foreignId('id_portfolio')
                  ->constrained('portfolio', 'id_portfolio')
                  ->onDelete('cascade');

            $table->string('foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_portfolio');
    }
};