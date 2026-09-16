<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukJasa extends Model
{
    use SoftDeletes;

    protected $table = 'produk_jasa';
    protected $primaryKey = 'id_produk_jasa';

    protected $fillable = [
        'nama_produk_jasa',
        'jenis',
        'deskripsi',
        'harga',
        'id_jurusan',
        'id_user',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function jurusan()
    {
        return $this->belongsTo(
            Jurusan::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function pengelola()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id'
        );
    }

    public function gambars()
    {
        return $this->hasMany(
            GambarProdukJasa::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }

    public function pesanans()
    {
        return $this->hasMany(
            Pesanan::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }

    public function penugasanProduser()
    {
        return $this->hasMany(
            PenugasanProduser::class,
            'id_produk_jasa',
            'id_produk_jasa'
        );
    }
}