<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusans';

     protected $primaryKey = 'id_jurusan';

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produkJasas()
    {
        return $this->hasMany(ProdukJasa::class, 'id_jurusan');
    }

    public function portfolios()
    {
        return $this->hasMany(
            Portfolio::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function members()
    {
        return $this->hasMany(User::class, 'id_jurusan_asal');
    }
}