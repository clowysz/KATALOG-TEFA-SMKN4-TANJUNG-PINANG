<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'no_pesanan',
        'nama_pembeli',
        'produk_jasa',
        'jurusan',
        'tanggal',
        'status',
    ];
}
