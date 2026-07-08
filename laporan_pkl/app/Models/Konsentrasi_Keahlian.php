<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsentrasi_Keahlian extends Model
{
    protected $table='konsentrasi_keahlian';
    protected $fillable=[
        'program_keahlian',
        'konsentrasi-keahlian',
    ];

    public function murid(){
        return $this->hasMany(Murid::class,'konsentrasi_keahlian_id','id');
    }
}
