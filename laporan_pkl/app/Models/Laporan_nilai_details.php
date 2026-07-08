<?php

namespace App\Models;

use App\Models\Laporan_Nilai; 
use Illuminate\Database\Eloquent\Model;

class Laporan_nilai_details extends Model
{
    protected $table='laporan_nilai_details';
    protected $fillable=[
        'laporan_nilai_id',
        'indikator_id',
        'skor',
        'deskripsi',
    ];

    public function laporan_nilai(){
        return $this->belongsTo(Laporan_Nilai::class,'laporan_nilai_id');
    }

    public function indikator(){
        return $this->belongsTo(Tujuan_Pembelajaran_Indikator::class,'indikator_id','id');
    }
}
