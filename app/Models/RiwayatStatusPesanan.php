<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStatusPesanan extends Model
{
    protected $table = 'riwayat_status_pesanan';
    protected $primaryKey = 'id_riwayat_status';

    protected $fillable = [
        'id_pesanan',
        'status',
        'keterangan',
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