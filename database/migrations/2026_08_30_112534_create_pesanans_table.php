<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('no_pesanan');
            $table->string('nama_pembeli');
            $table->string('produk_jasa');
            $table->string('jurusan');
            $table->date('tanggal');
            $table->enum('status', [ 'menunggu konfirmasi', 'konfirmasi', 'diproses', 'selesai', 'dibatalkan' ])->default('menunggu konfirmasi');     
           $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};