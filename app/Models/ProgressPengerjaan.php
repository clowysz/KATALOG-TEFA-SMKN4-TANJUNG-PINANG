<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressPengerjaan extends Model
{
    protected $table = 'progress_pengerjaan';
    protected $primaryKey = 'id_progress';

    protected $fillable = [
        'id_pesanan',
        'persentase_progress',
        'keterangan_progress',
        'tanggal_update',
        'id_user',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pelaksana()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}