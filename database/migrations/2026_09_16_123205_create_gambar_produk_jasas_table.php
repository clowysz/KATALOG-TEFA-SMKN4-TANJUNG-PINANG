<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('gambar_produk_jasas', function (Blueprint $table) {
        $table->id('id_gambar');

        $table->unsignedBigInteger('id_produk_jasa');

        $table->string('path_gambar');

        $table->timestamps();

        $table->foreign('id_produk_jasa')
            ->references('id_produk_jasa')
            ->on('produk_jasas')
            ->onDelete('cascade');
    });
}
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_produk_jasas');
    }
};
