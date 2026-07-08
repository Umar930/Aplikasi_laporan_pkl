<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Laporan_nilai_details;

class Tujuan_Pembelajaran_Indikator extends Model
{
    protected $table='tujuan_pembelajaran_indikator';
    protected $fillable=[
        'point_utama',
        'point_details'
    ];

    public function laporan_nilai(){
        return $this->hasMany(Laporan_nilai_details::class);
    }

    public function observasi_details(){
        return $this->hasMany(Observasi::class);
    }
}
