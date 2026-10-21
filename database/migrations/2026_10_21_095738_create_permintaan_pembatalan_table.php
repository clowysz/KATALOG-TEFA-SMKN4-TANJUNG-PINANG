
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permintaan_pembatalan', function (Blueprint $table) {
            $table->id('id_permintaan');

            // Pesanan yang ingin dibatalkan
            $table->unsignedBigInteger('id_pesanan');

            // Pembeli mengisi alasan pembatalan
            $table->text('alasan');

            // Status permintaan pembatalan
            $table->enum('status_permintaan', [
                'menunggu',
                'disetujui',
                'ditolak',
            ])->default('menunggu');

            // Catatan keputusan dari Admin TEFA
            $table->text('catatan_admin')->nullable();

            // Waktu keputusan admin
            $table->timestamp('tanggal_keputusan')->nullable();

            // ID admin yang memutuskan
            $table->unsignedBigInteger('id_admin')->nullable();

            $table->timestamps();

            // Relasi ke tabel pesanan
            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->cascadeOnDelete();

            // Satu pesanan hanya memiliki satu permintaan pembatalan
            $table->unique('id_pesanan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_pembatalan');
    }
};
