<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurnal_kegiatan extends Model
{
    protected $fillable = ['hari_tanggal','kompetensi','topik_pekerjaan','nilai_karakter'];
}
