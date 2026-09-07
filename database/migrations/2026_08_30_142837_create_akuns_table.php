
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
        Schema::create('akuns', function (Blueprint $table) {

            $table->id();

            $table->string('nama_pengguna');

            $table->string('email')->unique();

            $table->string('password');

            $table->enum('role', [
                'Admin TEFA',
                'Admin Jurusan'
            ])->default('Admin TEFA');

            $table->string('jurusan')->nullable();

            $table->enum('status', [
                'Aktif',
                'Tidak Aktif'
            ])->default('Aktif');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
