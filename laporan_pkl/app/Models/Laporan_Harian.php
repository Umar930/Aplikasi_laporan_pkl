<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporan_harian extends Model
{
    protected $fillable=[
      'murid_id',
      'tanggal_hari',
      'kompetensi_dasar',
      'Topik_pembelajaran',
      'nilai_karakter_budaya',
      'status_verifikasi',
      'diverifikasi_oleh_admin',
      'diverifikasi_oleh_dudi',
      'diverifikasi_oleh_guru',
      'waktu_diverifikasi',
    ];

    public function murid(){
      return $this->belongsTo(Murid::class,'murid_id','id');        
  }
}
