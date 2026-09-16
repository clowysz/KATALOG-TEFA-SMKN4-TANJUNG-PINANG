<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarPortfolio extends Model
{
    protected $table = 'gambar_portfolio';
    protected $primaryKey = 'id_gambar_portfolio';

    protected $fillable = [
        'id_portfolio',
        'path_gambar',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class, 'id_portfolio', 'id_portfolio');
    }
}