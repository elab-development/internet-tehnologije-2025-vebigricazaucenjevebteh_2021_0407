<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            KorisnikSeeder::class,
            NivoSeeder::class,
            //PhaseSeeder::class,
            //LevelSeeder::class,
        ]);
    }
}
