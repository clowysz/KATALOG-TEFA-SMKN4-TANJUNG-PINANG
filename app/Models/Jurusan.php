<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    // Menentukan nama tabel fisik di database
    protected $table = 'jurusans';

    // Sesuaikan primary key (default Laravel adalah 'id')
    // Jika di migration kamu memakai $table->id('id_jurusan'), aktifkan baris di bawah ini:
     protected $primaryKey = 'id_jurusan';

    // Mengizinkan semua kolom diisi secara mass-assignment
    protected $guarded = [];

    /**
     * Relasi ke User (Admin Jurusan / Penanggung Jawab Jurusan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke Produk & Jasa milik Jurusan ini
     */
    public function produkJasas()
    {
        return $this->hasMany(ProdukJasa::class, 'id_jurusan');
    }

    /**
     * Relasi ke Portfolio milik Jurusan ini
     */
    public function portfolios()
    {
        return $this->hasMany(
            Portfolio::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    /**
     * Relasi ke Anggota / User yang berasal dari jurusan ini
     */
    public function members()
    {
        return $this->hasMany(User::class, 'id_jurusan_asal');
    }
}