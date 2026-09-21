<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id('id_jurusan');

            $table->string('nama_jurusan');
            $table->string('kode_jurusan')->unique();
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();

            $table->unsignedBigInteger('id_user')->nullable();

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};