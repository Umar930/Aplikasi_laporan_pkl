<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi_Dasar extends Model
{
    protected $fillable=[
        'kategori_utama',
        'nama_kompetensi'
    ];

    public function kompetensi(){
        return $this->belongsTo(Kompetensi_Dasar::class,'kompetensi_dasar_id','id');
    }
}
