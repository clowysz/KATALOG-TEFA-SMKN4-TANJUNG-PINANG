<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_jasas', function (Blueprint $table) {
            $table->id('id_produk_jasa');
            
            // Relasi ke tabel jurusans (kolom id_jurusan)
            $table->foreignId('id_jurusan')
                  ->constrained('jurusans', 'id_jurusan')
                  ->onDelete('cascade');

            $table->string('nama_produk_jasa');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->enum('tipe', ['produk', 'jasa']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_jasas');
    }
};