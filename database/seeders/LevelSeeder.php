<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{

    public function run(): void
{
    DB::table('nivos')->insert([

        [
            'naziv' => 'Level 1: Header/Main/Footer',
            'opis' => 'Napraviti osnovnu stranicu sa header, main i footer.',
            'tezina' => 1,
            'tezinaNivoa' => 1,
            'expected' => json_encode([
                'tag' => 'main',
                'children' => [['tag' => 'header'], ['tag' => 'section'], ['tag' => 'footer']]
            ]),
            'hint' => 'Koristi semantičke tagove: header, main/section, footer.',
            'is_active' => true,
        ],
        [
            'naziv' => 'Level 2: Navigacija (ul/li)',
            'opis' => 'Dodaj nav sa listom linkova (ul > li > a).',
            'tezina' => 1,
            'tezinaNivoa' => 1,
            'expected' => json_encode([
                'tag' => 'nav',
                'children' => [['tag' => 'ul']]
            ]),
            'hint' => 'nav -> ul -> li -> a',
            'is_active' => true,
        ],


        [
            'naziv' => 'Level 3: Section/Article/Aside',
            'opis' => 'Stranica treba da sadrži section, article i aside u ispravnom rasporedu.',
            'tezina' => 2,
            'tezinaNivoa' => 2,
            'expected' => json_encode([
                'tag' => 'main',
                'children' => [['tag' => 'section'], ['tag' => 'article'], ['tag' => 'aside']]
            ]),
            'hint' => 'main sadrži section + article + aside',
            'is_active' => true,
        ],
        [
            'naziv' => 'Level 4: Forma',
            'opis' => 'Napravi formu sa label + input (required) + button.',
            'tezina' => 2,
            'tezinaNivoa' => 2,
            'expected' => json_encode([
                'tag' => 'form',
                'children' => [['tag' => 'label'], ['tag' => 'input'], ['tag' => 'button']]
            ]),
            'hint' => 'input mora imati required.',
            'is_active' => true,
        ],


        [
            'naziv' => 'Level 5: Figure',
            'opis' => 'Koristi figure sa img i figcaption.',
            'tezina' => 3,
            'tezinaNivoa' => 3,
            'expected' => json_encode([
                'tag' => 'figure',
                'children' => [['tag' => 'img'], ['tag' => 'figcaption']]
            ]),
            'hint' => 'figure -> img + figcaption',
            'is_active' => true,
        ],
        [
            'naziv' => 'Level 6: Kompleksno ugnježđavanje',
            'opis' => 'main > section > article, plus aside. Pazi redosled.',
            'tezina' => 3,
            'tezinaNivoa' => 3,
            'expected' => json_encode([
                'tag' => 'main',
                'children' => [
                    ['tag' => 'section', 'children' => [['tag' => 'article']]],
                    ['tag' => 'aside']
                ]
            ]),
            'hint' => 'section sadrži article, aside je pored.',
            'is_active' => true,
        ],
    ]);
}
}
