<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JurnalDetail;

class Kompetensi_Dasar extends Model
{
    protected $table='kompetensi_dasars';
    protected $fillable=[
        'kategori_utama',
        'nama_kompetensi'
    ];

    public function kompetensi(){
        return $this->hasMany(JurnalDetail::class);
    }
}
