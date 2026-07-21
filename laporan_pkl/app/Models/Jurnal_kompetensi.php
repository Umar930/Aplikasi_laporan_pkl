<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JurnalDetail;
use App\Models\Murid;

class Jurnal_Kompetensi extends Model
{
    protected $table = 'jurnal_kompetensi';
    protected $fillable=[
        'murid_id',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class,'murid_id','id');
    }

    public function jurnaldetail(){
        return $this->hasMany(JurnalDetail::class,'jurnal_kompetensi_id','id');
    }
}