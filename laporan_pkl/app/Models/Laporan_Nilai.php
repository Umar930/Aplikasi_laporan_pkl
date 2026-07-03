<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporan_nilai extends Model
{
    protected $fillable=[
        'murid_id',
        'nisn',
        'tanggal_mulai',
        'tanggal_berakhir',
        'indikator_id',
        'skor',
        'deskripsi',
        'catatan',
        'kehadiran_sakit',
        'kehadiran_ijin',
        'kehadiran_tanpa_keterangan',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class);        
    }

    public function indikator(){
        return $this->belongsTo(Tujuan_Pembelajaran_Indikator::class);
    }
}