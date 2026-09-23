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
    Schema::table('tahapan_pengerjaans', function (Blueprint $table) {
        $table->unsignedBigInteger('id_pesanan')->after('id');
        $table->string('nama_tahapan')->after('id_pesanan');
        $table->integer('urutan')->default(1)->after('nama_tahapan');
        $table->string('status', 50)->after('urutan');
        $table->integer('persentase_progress')->default(0)->after('status');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('tahapan_pengerjaans', function (Blueprint $table) {
        $table->dropColumn([
            'id_pesanan',
            'nama_tahapan',
            'urutan',
            'status',
            'persentase_progress',
        ]);
    });
}
};
