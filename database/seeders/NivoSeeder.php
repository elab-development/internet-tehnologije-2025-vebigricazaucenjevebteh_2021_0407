<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivoSeeder extends Seeder
{
    public function run(): void
    {
       DB::table('nivos')->delete();
        DB::table('nivos')->insert([


            [
                'naziv' => 'Level 1 – Basic HTML',
                'opis' => 'Sastavi osnovnu HTML strukturu stranice.',
                'tezina' => 1,
                'hint' => 'Head sadrži informacije, body sadrži sadržaj.',
                'is_active' => true,
                'level_config' => json_encode([
                    'blocks' => [
                        'html_open' => ['label' => '<html>', 'tag' => 'html'],
                        'html_close' => ['label' => '</html>', 'tag' => 'html'],
                        'head_open' => ['label' => '<head>', 'tag' => 'head'],
                        'head_close' => ['label' => '</head>', 'tag' => 'head'],
                        'title' => ['label' => '<title>Moja prva stranica</title>', 'tag' => 'title'],
                        'body_open' => ['label' => '<body>', 'tag' => 'body'],
                        'body_close' => ['label' => '</body>', 'tag' => 'body'],
                        'h1' => ['label' => '<h1>Zdravo svete!</h1>', 'tag' => 'h1'],
                        'p' => ['label' => '<p>Ovo je moj prvi HTML dokument.</p>', 'tag' => 'p'],
                    ],
                    'phases' => [
                        [
                            'title' => 'Osnovna HTML struktura',
                            'taskText' => 'Prevuci HTML blokove i sastavi ispravnu stranicu.',
                            'palette' => [
                                'html_open','html_close',
                                'head_open','head_close',
                                'title',
                                'body_open','body_close',
                                'h1','p'
                            ],
                            'slots' => ['root', 'head', 'body'],
                            'rules' => [
                                ['type' => 'requireBlocks', 'blocks' => ['html_open','head_open','body_open']],
                                ['type' => 'forbidTag', 'tag' => 'h1', 'slot' => 'head'],
                            ],
                            'success' => '✅ Tačno! HTML struktura je ispravna.'
                        ]
                    ]
                ])
            ],


            [
                'naziv' => 'Level 2 – Links and Lists',
                'opis' => 'Linkovi, liste i pravilno ugnježđivanje.',
                'tezina' => 2,
                'hint' => 'Link je deo stavke liste.',
                'is_active' => true,
                'level_config' => json_encode([
                    'blocks' => [
                        'nav_open' => ['label' => '<nav>', 'tag' => 'nav'],
                        'nav_close' => ['label' => '</nav>', 'tag' => 'nav'],
                        'ul_open' => ['label' => '<ul>', 'tag' => 'ul'],
                        'ul_close' => ['label' => '</ul>', 'tag' => 'ul'],
                        'li_open' => ['label' => '<li>', 'tag' => 'li'],
                        'li_close' => ['label' => '</li>', 'tag' => 'li'],
                        'a_home' => ['label' => '<a href="index.html">Home</a>', 'tag' => 'a'],
                        'a_about' => ['label' => '<a href="about.html">About</a>', 'tag' => 'a'],
                        'a_contact' => ['label' => '<a href="contact.html">Contact</a>', 'tag' => 'a'],
                    ],
                    'phases' => [


                        [
                            'title' => 'Navigacioni meni',
                            'taskText' => 'Napravi navigacioni meni sa tri linka.',
                            'palette' => [
                                'nav_open','nav_close',
                                'ul_open','ul_close',
                                'li_open','li_close',
                                'a_home','a_about','a_contact'
                            ],
                            'slots' => ['root'],
                            'rules' => [
                                ['type' => 'aMustBeInsideLi'],
                                ['type' => 'liMustBeInsideUl'],
                            ],
                            'success' => '✅ Navigacija je ispravna.'
                        ],


                        [
                            'title' => 'Uređena lista',
                            'taskText' => 'Napravi listu koraka za pravljenje čaja.',
                            'palette' => [
                                'li_open','li_close'
                            ],
                            'slots' => ['root'],
                            'rules' => [],
                            'success' => '✅ Koraci su pravilno složeni.'
                        ],


                        [
                            'title' => 'Eksterni link',
                            'taskText' => 'Napravi link ka Google sajtu.',
                            'palette' => ['a_home'],
                            'slots' => ['root'],
                            'rules' => [],
                            'success' => '✅ Link je ispravan.'
                        ]
                    ]
                ])
            ],


            [
                'naziv' => 'Level 3 – Semantic HTML',
                'opis' => 'Korišćenje semantičkih HTML tagova.',
                'tezina' => 3,
                'hint' => 'Semantički tag opisuje značenje.',
                'is_active' => true,
                'level_config' => json_encode([
                    'blocks' => [
                        'header_open' => ['label' => '<header>', 'tag' => 'header'],
                        'header_close' => ['label' => '</header>', 'tag' => 'header'],
                        'nav_open' => ['label' => '<nav>', 'tag' => 'nav'],
                        'nav_close' => ['label' => '</nav>', 'tag' => 'nav'],
                        'main_open' => ['label' => '<main>', 'tag' => 'main'],
                        'main_close' => ['label' => '</main>', 'tag' => 'main'],
                        'article_open' => ['label' => '<article>', 'tag' => 'article'],
                        'article_close' => ['label' => '</article>', 'tag' => 'article'],
                        'aside_open' => ['label' => '<aside>', 'tag' => 'aside'],
                        'aside_close' => ['label' => '</aside>', 'tag' => 'aside'],
                        'footer_open' => ['label' => '<footer>', 'tag' => 'footer'],
                        'footer_close' => ['label' => '</footer>', 'tag' => 'footer'],
                    ],
                    'phases' => [


                        [
                            'title' => 'Osnovna semantička struktura',
                            'taskText' => 'Zameni divove semantičkim tagovima.',
                            'palette' => [
                                'header_open','header_close',
                                'nav_open','nav_close',
                                'main_open','main_close',
                                'footer_open','footer_close'
                            ],
                            'slots' => ['root'],
                            'rules' => [],
                            'success' => '✅ Struktura je ispravna.'
                        ],


                        [
                            'title' => 'Blog stranica',
                            'taskText' => 'Složi strukturu blog stranice.',
                            'palette' => [
                                'article_open','article_close',
                                'aside_open','aside_close'
                            ],
                            'slots' => ['root'],
                            'rules' => [],
                            'success' => '🎉 Pišeš HTML kao pravi web developer!'
                        ]
                    ]
                ])
            ],

        ]);
    }
}
