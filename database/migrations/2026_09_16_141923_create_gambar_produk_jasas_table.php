<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_produk_jasa', function (Blueprint $table) {
            $table->id('id_gambar');
            
            // Menggunakan unsignedBigInteger agar tipe datanya cocok persis dengan id_produk_jasa
            $table->unsignedBigInteger('id_produk_jasa'); 
            $table->string('foto');
            $table->timestamps();

            // Definisi Foreign Key
            $table->foreign('id_produk_jasa')
                  ->references('id_produk_jasa')
                  ->on('produk_jasas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_produk_jasa');
    }
};