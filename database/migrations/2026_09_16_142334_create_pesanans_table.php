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
            $table->foreignId('id_user')
                ->constrained('users')
                ->onDelete('cascade');

            // Produk / Jasa yang dipesan
            $table->foreignId('id_produk_jasa')
                ->constrained('produk_jasa', 'id_produk_jasa')
                ->onDelete('restrict');

            $table->dateTime('tanggal_pesan');

            $table->unsignedInteger('jumlah')->default(1);

            $table->decimal('total_harga', 12, 2);

            $table->text('catatan')->nullable();

            $table->string('status')
                ->default('menunggu konfirmasi');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};