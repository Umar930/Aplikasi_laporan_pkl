<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal_Kompetensi extends Model
{
    protected $fillable=[
        'murid_id',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class,'murid_id','id');
    }

    public function jurnaldetail(){
        return $this->hasMany(JurnalDetail::class,'kompetensi_dasar_id','id');
    }
}