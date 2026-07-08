<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Murid extends Authenticatable
{
    protected $table='murid';
    protected $fillable=[
        'nama_murid',
        'kelas',
        'konsentrasi_keahlian_id',
        'tempat_lahir',
        'tanggal_lahir',
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

    public function dudi(){
        return $this->belongsTo(Identitas_Dudi::class,'dudi_id','id');
    }

    public function pembimbing(){
        return $this->belongsTo(Guru_Pembimbing::class,'guru_pembimbing_id','id');
    }

    public function konsentrasi_keahlian(){
        return $this->belongsTo(Konsentrasi_Keahlian::class,'konsentrasi_keahlian_id','id');
    }

    public function laporanNilai(){
        return $this->hasMany(laporan_nilai::class);
    }

    public function laporanHarian(){
        return $this->hasMany(laporan_harian::class);
    }

    public function laporanBulanan(){
        return $this->hasMany(laporan_bulanan::class);
    }

    public function observasi(){
        return $this->hasMany(Observasi::class);
    }


}


