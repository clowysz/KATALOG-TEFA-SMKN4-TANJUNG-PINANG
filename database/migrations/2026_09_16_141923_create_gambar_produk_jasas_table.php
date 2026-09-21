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

            $table->unsignedBigInteger('id_produk_jasa');

            $table->string('path_gambar');

            $table->timestamps();

            $table->foreign('id_produk_jasa')
                ->references('id_produk_jasa')
                ->on('produk_jasa')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_produk_jasa');
    }
};