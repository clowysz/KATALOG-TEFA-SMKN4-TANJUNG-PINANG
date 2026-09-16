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
        Schema::create('produk_jasas', function (Blueprint $table) {
            $table->id('id_produk_jasa');

            $table->string('nama_produk_jasa');

            $table->enum('jenis', ['produk', 'jasa']);

            $table->text('deskripsi')->nullable();

            $table->decimal('harga', 15, 2)->nullable();

            $table->string('estimasi')->nullable();

            $table->unsignedBigInteger('id_jurusan');

            $table->unsignedBigInteger('id_user');

            $table->timestamps();

            $table->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusans')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_jasas');
    }
};