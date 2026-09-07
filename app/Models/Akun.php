<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Hash;

   class Akun extends Model 
   { 
    protected $table = 'akuns';
    protected $fillable = [ 'nama_pengguna', 'email', 'password', 'role', 'jurusan', 'status', ]; 

    protected $hidden = 
    [ 'password', ]; 

    protected function password(): Attribute
     { 
        return Attribute::make( set: fn ($value) => Hash::make($value), 
        );
         
    }
 }
