<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catatan_kegiatan extends Model
{
    protected $fillable = ['nama_pekerjaan', 'perencanaan_kegiatan', 'pelaksanaan_kegiatan', 'catatan_instruktur'];
}
