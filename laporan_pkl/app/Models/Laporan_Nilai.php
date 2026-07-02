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
}
