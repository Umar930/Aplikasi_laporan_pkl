<?php

namespace Database\Seeders;

use App\Models\Kompetensi_Dasar;
use App\Models\Tujuan_Pembelajaran_Indikator;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            KonsentrasiKeahlian::class,
            kompetensiSeeder::class,
            indikatorSeeder::class,
        ]);
    }
}
