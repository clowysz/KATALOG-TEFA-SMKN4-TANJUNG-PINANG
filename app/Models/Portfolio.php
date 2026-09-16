<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $table = 'portfolio';
    protected $primaryKey = 'id_portfolio';

    protected $fillable = [
        'id_jurusan',
        'judul',
        'deskripsi',
        'tahun',
        'id_user',
    ];

    // Relasi ke Jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }

    // Relasi ke User (pembuat portofolio)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Relasi ke gambar-gambar portofolio (multiple images)
    public function gambars()
    {
        return $this->hasMany(GambarPortfolio::class, 'id_portfolio', 'id_portfolio');
    }
}