<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('progress_pengerjaan', function (Blueprint $table) {
            $table->id('id_progress');
            $table->unsignedBigInteger('id_pesanan');
            $table->integer('persentase_progress'); 
            $table->text('keterangan_progress');
            $table->dateTime('tanggal_update');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id_pesanan')->on('pesanan')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('progress_pengerjaan');
    }
};