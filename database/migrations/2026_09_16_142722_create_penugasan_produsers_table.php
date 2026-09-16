<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_produser', function (Blueprint $table) {
            $table->id('id_penugasan');
            $table->unsignedBigInteger('id_user'); // Siswa / Produser
            $table->unsignedBigInteger('id_produk_jasa');
            $table->timestamps();

            // Relasi ke tabel users
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // PERBAIKAN: Diubah ke 'produk_jasas' (sesuai nama tabel produk/jasa)
            $table->foreign('id_produk_jasa')
                ->references('id_produk_jasa')
                ->on('produk_jasas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_produser');
    }
};