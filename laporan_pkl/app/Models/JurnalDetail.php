<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use APP\Models\Jurnal_Kompetensi;
use APP\Models\Kompetensi_Dasar;

class JurnalDetail extends Model
{
    protected $table='details_jurnal';
    protected $fillable=[
        'jurnal_kompetensi_id',
        'kompetensi_dasar_id',
        'pelaksanaan_pembelajaran',
        'nilai_minimal_kompetensi',
        'nilai_kompetensi',
        'tanggal',
        'keterangan',
    ];


    public function jurnal(){
        return $this->belongsTo(Jurnal_Kompetensi::class,'jurnal_kompetensi_id');
    }

    public function kompetensi(){
        return $this->belongsTo(Kompetensi_Dasar::class,'kompetensi_dasar');
    }
}