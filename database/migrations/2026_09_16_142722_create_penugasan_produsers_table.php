<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan_produser', function (Blueprint $table) {
            $table->id('id_penugasan');

            $table->foreignId('id_user_produser')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('id_produk_jasa')
                ->constrained('produk_jasa', 'id_produk_jasa')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_produser');
    }
};