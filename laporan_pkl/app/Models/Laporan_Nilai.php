<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Murid;
use App\Models\Laporan_nilai_details;

class Laporan_Nilai extends Model
{
    protected $table = 'laporan_nilais';
    protected $fillable=[
        'murid_id',
        'nisn',
        'program_keahlian',
        'konsentrasi_keahlian',
        'tempat_pkl',
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