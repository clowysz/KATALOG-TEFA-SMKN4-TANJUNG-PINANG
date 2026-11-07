
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

            $table->unsignedBigInteger('id_pesanan');

            $table->text('alasan');

            $table->enum('status_permintaan', [
                'menunggu',
                'disetujui',
                'ditolak',
            ])->default('menunggu');

            $table->text('catatan_admin')->nullable();

            $table->timestamp('tanggal_keputusan')->nullable();

            $table->unsignedBigInteger('id_admin')->nullable();

            $table->timestamps();

            $table->foreign('id_pesanan')
                ->references('id_pesanan')
                ->on('pesanan')
                ->cascadeOnDelete();

            $table->unique('id_pesanan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_pembatalan');
    }
};
