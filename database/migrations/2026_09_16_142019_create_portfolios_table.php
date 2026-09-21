<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio', function (Blueprint $table) {
            $table->id('id_portfolio');

            $table->foreignId('id_jurusan')
                ->constrained('jurusans', 'id_jurusan')
                ->onDelete('cascade');

            $table->string('judul');

            $table->text('deskripsi');

            $table->year('tahun')->nullable();

            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio');
    }
};