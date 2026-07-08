<?php

namespace Database\Seeders;

use App\Models\Kompetensi_Dasar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class kompetensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Algoritma',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Bahasa pemrograman',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Percabangan',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Pengulangan',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Array',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'pemrograman dasar',
            'nama_kompetensi'=>'Procedure dan Function',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'Pemodelan Perangkat',
            'nama_kompetensi'=>'Konsep Pemodelan ber',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'Pemodelan Perangkat',
            'nama_kompetensi'=>'Relasi antar kelas dalam sistem berorientasi obyek',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'Pemodelan Perangkat',
            'nama_kompetensi'=>'Dokumen pengembangan aplikasi berorientasi obyek',
        ]);
        Kompetensi_Dasar::create([
            'kategori_utama'=>'Pemodelan Perangkat',
            'nama_kompetensi'=>'Dokumen pengembangan sistem aplikasi berbasis meta data',
        ]);

        
    }
}
