<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tujuan_Pembelajaran_Indikator extends Model
{
    protected $table='tujuan_pembelajaran_indikator';
    protected $fillable=[
        'point_utama',
        'point_details'
    ];
}
