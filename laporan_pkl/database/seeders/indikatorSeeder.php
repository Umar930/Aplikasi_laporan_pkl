<?php

namespace Database\Seeders;

use App\Models\Tujuan_Pembelajaran_Indikator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class indikatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.1 Melaksanakan komunikasi telepon sesuai kaidah'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.2 Menunjukan integritas'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.3 Memiliki etos kerja'
        ]);

        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.4 Melaksanakan Kemandirian'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.5 Menunjukan Kerjasama'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan soft skill yang dibutuhkan di dalam dunia kerja',
            'point_details'=>'1.6 Menunjukan kepedulian sosial dan lingkungan'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan norma,POS dan K3LH yang ada pada dunia kerja',
            'point_details'=>'2.1 Menggunakan APD dengan tertib dan benar'
        ]);
        
        Tujuan_Pembelajaran_Indikator::create([
            'point_utama'=>'Menerapkan norma,POS dan K3LH yang ada pada dunia kerja',
            'point_details'=>'2.2 Melaksanakan pekerjaan sesuai POS'
        ]);
    }
}
