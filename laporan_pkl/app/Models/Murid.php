<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $fillable=[
        'nama',
        'kelas',
        'konsentrasi_keahlian_id',
        'tempat_lahir',
        'tanggal_hari',
        'nis',
        'jenis_kelamin',
        'alamat_siswa',
        'alamat_wali_ortu',
        'golongan_darah',
        'catatan_kesehatan',
        'nama_wali_ortu',
        'no_telepon',
        'no_telepon_wali',
        'dudi_id',
        'guru_pembimbing_id',
    ];
}
