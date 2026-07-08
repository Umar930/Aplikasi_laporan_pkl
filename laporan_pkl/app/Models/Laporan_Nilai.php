<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan_Nilai extends Model
{
    protected $fillable=[
        'murid_id',
        'nisn',
        'tanggal_mulai',
        'tanggal_berakhir',
        'catatan',
        'kehadiran_sakit',
        'kehadiran_ijin',
        'kehadiran_tanpa_keterangan',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class,'murid_id','id');        
    }

    public function nilai_details(){
        return $this->hasMany(Laporan_nilai_details::class,'laporan_nilai_id','id');
    }
}