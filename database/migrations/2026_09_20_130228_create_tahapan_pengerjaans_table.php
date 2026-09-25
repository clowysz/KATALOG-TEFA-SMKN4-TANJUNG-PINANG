<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahapan_pengerjaans', function (Blueprint $table) {
            $table->id();

            // Terhubung ke pesanan
            $table->foreignId('id_pesanan')
                ->constrained('pesanan', 'id_pesanan')
                ->onDelete('cascade');

            // Nama tahapan pengerjaan
            $table->string('nama_tahapan');

            // Urutan tahapan
            $table->integer('urutan');

            // Status pengerjaan
            $table->string('status')->default('belum');

            // Persentase progress
            $table->integer('persentase_progress')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahapan_pengerjaans');
    }
};