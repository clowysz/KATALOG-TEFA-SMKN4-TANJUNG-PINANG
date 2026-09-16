<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';
    protected $primaryKey = 'id_faq';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'id_user',
    ];

    public function pengelola()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}