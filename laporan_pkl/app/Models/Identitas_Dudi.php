<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Model;

class Identitas_Dudi extends Authenticatable
{
    protected $table='identitas_dudi';
    protected $fillable=[
        'nama_dudi',
        'alamat_dudi',
        'no_telepon',
        'nama_pembimbing',
        'email',
        'password',
    ];

    public function murid(){
        return $this->hasMany(Murid::class);
    }
}
