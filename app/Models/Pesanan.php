<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user',
        'id_produk_jasa',
        'tanggal_pesan',
        'jumlah',
        'total_harga',
        'catatan',
        'status',
    ];

    public function pembeli()
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id'
        );
    }

    public function produkJasa()
    {
        return $this->belongsTo(
            ProdukJasa::class,
            'id_produk_jasa',
            'id_produk_jasa'
        )->withTrashed();
    }

    public function riwayatStatus()
    {
        return $this->hasMany(
            RiwayatStatusPesanan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function progressPengerjaan()
    {
        return $this->hasMany(
            ProgressPengerjaan::class,
            'id_pesanan',
            'id_pesanan'
        );
    }

    public function tahapanPengerjaan()
    {
        return $this->hasMany(
            TahapanPengerjaan::class,
            'id_pesanan',
            'id_pesanan'
        )->orderBy('urutan');
    }
}