<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produk_jasa', function (Blueprint $table) {
            $table->unsignedInteger('jumlah_pencarian')->default(0);
            $table->unsignedInteger('jumlah_tampilan')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('produk_jasa', function (Blueprint $table) {
            $table->dropColumn([
                'jumlah_pencarian',
                'jumlah_tampilan',
            ]);
        });
    }
};