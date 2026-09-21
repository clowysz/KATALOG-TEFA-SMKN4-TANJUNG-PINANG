<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_portfolio', function (Blueprint $table) {
            $table->id('id_gambar_portfolio');

            $table->foreignId('id_portfolio')
                ->constrained('portfolio', 'id_portfolio')
                ->onDelete('cascade');

            $table->string('path_gambar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_portfolio');
    }
};