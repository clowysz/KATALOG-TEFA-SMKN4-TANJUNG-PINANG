<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk_jasa', function (Blueprint $table) {
            $table->id('id_produk_jasa');

            $table->foreignId('id_jurusan')
                ->constrained('jurusans', 'id_jurusan')
                ->onDelete('cascade');

            $table->string('nama_produk_jasa');

            $table->enum('jenis', [
                'produk',
                'jasa'
            ]);

            $table->text('deskripsi');

            $table->decimal('harga', 12, 2);

            $table->foreignId('id_user')
                ->nullable()
                ->constrained('users')
                ->onDelete('cascade');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk_jasa');
    }
};