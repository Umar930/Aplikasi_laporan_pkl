<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi_Dasar extends Model
{
    protected $fillable=[
        'kategori_utama',
        'nama_kompetensi'
    ];

    public function jurnal_kompetensi(){
        return $this->hasMany(Jurnal_kompetensi::class);
    }
}
