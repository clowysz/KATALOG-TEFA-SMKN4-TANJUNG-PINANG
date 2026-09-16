<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenugasanProduser extends Model
{
    protected $table = 'penugasan_produser';

    protected $primaryKey = 'id_penugasan';

    protected $fillable = [
        'id_user_produser',
        'id_produk_jasa',
    ];

    public function produser()
    {
        return $this->belongsTo(User::class, 'id_user_produser', 'id');
    }

    public function produkJasa()
    {
        return $this->belongsTo(
            ProdukJasa::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }
}