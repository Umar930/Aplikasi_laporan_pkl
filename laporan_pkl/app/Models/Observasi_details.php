<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observasi_details extends Model
{
    protected $table='observasi_details';
    protected $fillable=[
        'observasi_id',
        'indikator_id',
        'ketercapaian',
        'deskripsi',
        ];

    

        public function indikator(){
            return $this->belongsTo(Tujuan_Pembelajaran_Indikator::class,'indikator_id','id');
        }

        public function observasi(){
            return $this->belongsTo(Observasi::class,'observasi_id');
        }
}
