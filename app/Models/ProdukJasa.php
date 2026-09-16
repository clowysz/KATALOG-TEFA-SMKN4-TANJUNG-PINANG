<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdukJasa extends Model
{
    protected $table = 'produk_jasas';

    protected $primaryKey = 'id_produk_jasa';

    protected $fillable = [
        'nama_produk_jasa',
        'jenis',
        'deskripsi',
        'harga',
        'estimasi',
        'id_jurusan',
        'id_user',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    public function gambar()
    {
        return $this->hasMany(
            GambarProdukJasa::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }
}