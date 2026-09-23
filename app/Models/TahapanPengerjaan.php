<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapanPengerjaan extends Model
{
    protected $table = 'tahapan_pengerjaans';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pesanan',
        'nama_tahapan',
        'urutan',
        'status',
        'persentase_progress',
    ];

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }
}