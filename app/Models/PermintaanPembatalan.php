<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanPembatalan extends Model
{
    protected $table = 'permintaan_pembatalan';

    protected $primaryKey = 'id_permintaan';

    protected $fillable = [
        'id_pesanan',
        'alasan',
        'status_permintaan',
        'catatan_admin',
        'tanggal_keputusan',
        'id_admin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_keputusan' => 'datetime',
        ];
    }

    public function pesanan()
    {
        return $this->belongsTo(
            Pesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            User::class,
            'id_admin',
            'id'
        );
    }
}
