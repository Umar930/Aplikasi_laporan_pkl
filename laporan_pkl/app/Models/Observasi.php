<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observasi extends Model
{
    protected $table='observasi';
    protected $fillable = [
        'murid_id',
        'guru_pembimbing_id',
        'pekerjaan_proyek',
        'indikator_id',
        'ketercapaian',
        'status_verifikasi',
        'diverifikasi_oleh_guru',
        'diverifikasi_oleh_dudi',
    ];

    public function murid(){
        return $this->belongsTo(Murid::class,'murid_id','id');
    }

    public function pembimbing(){
        return $this->belongsTo(Guru_Pembimbing::class,'guru_pembimbing_id','id');
    }

    public function details(){
        return $this->hasMany(Observasi_details::class);
    }

}
