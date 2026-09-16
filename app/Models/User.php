<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'nomor_hp',
        'id_jurusan_asal',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: User (Admin Jurusan) memegang satu Jurusan
    public function jurusanDipegang()
    {
        return $this->hasOne(
            Jurusan::class,
            'id_user',
            'id'
        );
    }

    // Relasi: User (Admin Produser) berasal dari satu Jurusan
    public function jurusanAsal()
    {
        return $this->belongsTo(
            Jurusan::class,
            'id_jurusan_asal',
            'id_jurusan'
        );
    }

    // Relasi: User (Admin Produksi) memiliki penugasan produk/jasa
    public function penugasanProduser()
    {
        return $this->hasMany(
            PenugasanProduser::class,
            'id_user_produser',
            'id'
        );
    }
}