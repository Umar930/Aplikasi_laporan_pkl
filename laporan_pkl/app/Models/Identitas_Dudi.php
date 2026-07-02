<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Identitas_Dudi extends Model
{
    protected $table='identitas_dudi';
    protected $fillable=[
        'nama_dudi',
        'alamat_dudi',
        'no_telepon',
        'nama_pembimbing',
    ];
}
