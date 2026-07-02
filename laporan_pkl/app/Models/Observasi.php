<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observasi extends Model
{
    protected $fillable = [
        'murid_id',
        'guru_pembimbing_id',
        'pekerjaan_proyek',
        'tujuan_pembelajaran_indikator_id',
        'pekerjaan_proyek',
        'indikator_id',
        'ketercapaian',
        'status_verifikasi',
        'diverifikasi_oleh_guru',
        'diverifikasi_oleh_dudi',
    ];
}
