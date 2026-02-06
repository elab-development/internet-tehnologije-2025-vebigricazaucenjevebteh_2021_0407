<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Hash;

class KorisnikSeeder extends Seeder
{
    public function run(): void
    {
        Korisnik::create([
            'ime' => 'Jelena',
            'email' => 'jelena@gmail.com',
            'password' => Hash::make('123456'),
            'tip_korisnika' => 'administrator',
        ]);

        Korisnik::create([
            'ime' => 'Anja',
            'email' => 'anja@gmail.com',
            'password' => Hash::make('123456'),
            'tip_korisnika' => 'administrator',
        ]);

        Korisnik::create([
            'ime' => 'Registrovani',
            'email' => 'registrovani@gmail.com',
            'password' => Hash::make('123456'),
            'tip_korisnika' => 'registrovani',
        ]);

        Korisnik::create([
            'ime' => 'Editor',
            'email' => 'editor@gmail.com',
            'password' => Hash::make('123456'),
            'tip_korisnika' => 'editor',
        ]);
    }
}

