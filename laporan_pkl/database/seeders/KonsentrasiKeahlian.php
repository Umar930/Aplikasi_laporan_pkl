<?php

namespace Database\Seeders;

use App\Models\Konsentrasi_Keahlian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KonsentrasiKeahlian extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Seni rupa & ekonomi kratif',
            'konsentrasi-keahlian' => 'DKV',
        ]);
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Pengembangan perangkat lunak & gim',
            'konsentrasi-keahlian' => 'RPL',
        ]);
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Pemasaran',
            'konsentrasi-keahlian' => 'Bisnis Digital',
        ]);
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Manajemen perkantoran & layanan bisnis',
            'konsentrasi-keahlian' => 'Manajemen Perkantoran',
        ]);
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Akuntansi & keuangan lembaga',
            'konsentrasi-keahlian' => 'Akuntansi',
        ]);
        Konsentrasi_Keahlian::create([
            'program_keahlian' => 'Akuntansi & keuangan lembaga',
            'konsentrasi-keahlian' => 'Layanan Perbankan',
        ]);
    }
}
