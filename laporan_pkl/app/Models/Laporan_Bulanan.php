<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporan_bulanan extends Model
{
    protected $fillable=[
        'murid_id',
        'dudi_id',
        'guru_pembimbing_id',
        'nama_pekerjaan',
        'perencanaan_kegiatan',
        'pelaksanaa_kegiatan',
        'catatan_instruktur',
        'status_verifikasi',
        'diverifikasi_oleh_dudi',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class);
    }

    public function dudi(){
        return $this->belongsTo(Identitas_Dudi::class);
    }

    public function pembimbing(){
        return $this->belongsTo(Guru_Pembimbing::class);
    }
}