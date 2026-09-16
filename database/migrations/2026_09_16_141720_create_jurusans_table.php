<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            // Wajib sebutkan nama kolom 'id_jurusan' di dalam id()
            $table->id('id_jurusan'); // atau $table->id('id_jurusan');
            $table->string('nama_jurusan');
            $table->string('kode_jurusan');
            $table->string('slug')->unique(); // <-- Tambahkan kolom ini
            $table->text('deskripsi')->nullable();
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};