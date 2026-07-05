<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal_kompetensi extends Model
{
    protected $fillable=[
        'murid_id',
        'kompetensi_dasar_id',
        'pelaksanaan_pembelajaran',
        'nilai_minimal_kompetensi',
        'nilai_kompetensi',
        'tanggal',
        'keterangan',
        'status_diverifikasi',
        'diverifikasi_oleh_guru',
        'diverifikasi_oleh_dudi',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class,'murid_id','id');
    }

    public function kompetensi(){
        return $this->belongsTo(Kompetensi_Dasar::class,'kompetensi_dasar_id','id');
    }
}