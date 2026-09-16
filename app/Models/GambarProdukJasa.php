<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarProdukJasa extends Model
{
    protected $table = 'gambar_produk_jasas';

    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'id_produk_jasa',
        'path_gambar',
    ];

    public function produkJasa()
    {
        return $this->belongsTo(
            ProdukJasa::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }
}