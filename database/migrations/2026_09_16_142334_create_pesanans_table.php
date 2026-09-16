<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');

            // Pembeli
            $table->unsignedBigInteger('id_user');

            // Produk / Jasa yang dipesan
            $table->unsignedBigInteger('id_produk_jasa');

            $table->dateTime('tanggal_pesan');
            $table->decimal('total_harga', 12, 2);
            $table->string('status')->default('menunggu konfirmasi');
            $table->timestamps();

            // Jika akun pembeli dihapus, pesanan milik pembeli ikut dihapus.
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // PERBAIKAN: Diubah ke 'produk_jasas' (sesuai nama tabel migration produk/jasa)
            $table->foreign('id_produk_jasa')
                ->references('id_produk_jasa')
                ->on('produk_jasas')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};