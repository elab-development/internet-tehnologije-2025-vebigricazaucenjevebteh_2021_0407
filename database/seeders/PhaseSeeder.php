<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Phase;

class PhaseSeeder extends Seeder
{
    public function run(): void
    {

        $l1Blocks = [
            "html_open"  => ["label" => "<html>", "tag" => "html"],
            "html_close" => ["label" => "</html>", "tag" => "/html"],
            "head_open"  => ["label" => "<head>", "tag" => "head"],
            "head_close" => ["label" => "</head>", "tag" => "/head"],
            "title"      => ["label" => "<title>Moja prva stranica</title>", "tag" => "title"],
            "body_open"  => ["label" => "<body>", "tag" => "body"],
            "body_close" => ["label" => "</body>", "tag" => "/body"],
            "h1"         => ["label" => "<h1>Zdravo svete!</h1>", "tag" => "h1"],
            "p"          => ["label" => "<p>Ovo je moj prvi HTML dokument.</p>", "tag" => "p"],
        ];

        Phase::create([
            'nivo_id' => 1,
            'naziv'   => 'Faza 1 – Sastavi osnovnu HTML stranicu',
            'opis'    => 'Prevuci HTML blokove na odgovarajuća mesta i napravi ispravnu osnovnu HTML stranicu.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l1Blocks,
                'palette' => ["html_open","html_close","head_open","head_close","title","body_open","body_close","h1","p"],
                'slots'   => ["root","head","body"],
            ],
            'rules'   => [
                ["type" => "childOfTag", "parentTag" => "head", "childTag" => "title"],
                ["type" => "childOfTag", "parentTag" => "body", "childTag" => "h1"],
                ["type" => "childOfTag", "parentTag" => "body", "childTag" => "p"],
                ["type" => "forbidChildOfTag", "parentTag" => "head", "childTag" => "h1"],
                ["type" => "forbidChildOfTag", "parentTag" => "head", "childTag" => "p"],
            ],
            'solution' => [
                'success' => "🎉 Tačno! Napravio si ispravnu HTML stranicu."
            ],
            'hint'   => 'Head sadrži informacije o stranici, a body sadrži ono što korisnik vidi.',
            'order'  => 1,
        ]);


        $l2Blocks = [
            "nav_open"   => ["label" => "<nav>", "tag" => "nav"],
            "nav_close"  => ["label" => "</nav>", "tag" => "/nav"],
            "ul_open"    => ["label" => "<ul>", "tag" => "ul"],
            "ul_close"   => ["label" => "</ul>", "tag" => "/ul"],
            "li_open"    => ["label" => "<li>", "tag" => "li"],
            "li_close"   => ["label" => "</li>", "tag" => "/li"],
            "a_home"     => ["label" => "<a href=\"index.html\">Home</a>", "tag" => "a"],
            "a_about"    => ["label" => "<a href=\"about.html\">About</a>", "tag" => "a"],
            "a_contact"  => ["label" => "<a href=\"contact.html\">Contact</a>", "tag" => "a"],
            "ol_open"    => ["label" => "<ol>", "tag" => "ol"],
            "ol_close"   => ["label" => "</ol>", "tag" => "/ol"],
            "ul2_open"   => ["label" => "<ul>", "tag" => "ul"],
            "ul2_close"  => ["label" => "</ul>", "tag" => "/ul"],
            "tea1"       => ["label" => "<li>Zagrej vodu</li>", "tag" => "li"],
            "tea2"       => ["label" => "<li>Ubaci čaj</li>", "tag" => "li"],
            "tea3"       => ["label" => "<li>Sipaj u šolju</li>", "tag" => "li"],
            "a_google"   => ["label" => "<a href=\"https://google.com\"> Google </a>", "tag" => "a"],
            "target_blank" => ["label" => "target=\"_blank\"", "tag" => "attr_target_blank"],
        ];


        Phase::create([
            'nivo_id' => 2,
            'naziv'   => 'Faza 1 – Navigacioni meni',
            'opis'    => 'Napravi navigacioni meni sa tri linka koristeći listu.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l2Blocks,
                'palette' => ["nav_open","nav_close","ul_open","ul_close","li_open","li_close","a_home","a_about","a_contact"],
                'slots'   => ["root"],
            ],
            'rules' => [
                [
                    "type" => "slotOrder",
                    "slot" => "root",
                    "order" => ["nav_open","ul_open","li_open","a_home","li_close","li_open","a_about","li_close","li_open","a_contact","li_close","ul_close","nav_close"]
                ]
            ],
            'solution' => ['success' => '🚀 Navigacija je ispravna!'],
            'hint' => 'Link je deo stavke liste, ne obrnuto.',
            'order' => 1,
        ]);


        Phase::create([
            'nivo_id' => 2,
            'naziv'   => 'Faza 2 – Izaberi pravu listu',
            'opis'    => 'Napravi listu koraka za pravljenje čaja.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l2Blocks,
                'palette' => ["ol_open","ol_close","ul2_open","ul2_close","tea1","tea2","tea3"],
                'slots'   => ["root"],
            ],
            'rules' => [
                [
                    "type" => "slotOrder",
                    "slot" => "root",
                    "order" => ["ol_open","tea1","tea2","tea3","ol_close"]
                ]
            ],
            'solution' => ['success' => '✅ Tačno – za korake ide <ol>.'],
            'hint' => 'Pošto su u pitanju koraci, koristi se uređena lista (<ol>).',
            'order' => 2,
        ]);


        Phase::create([
            'nivo_id' => 2,
            'naziv'   => 'Faza 3 – Eksterni link',
            'opis'    => 'Napravi link ka Google sajtu koji se otvara u novom tabu.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l2Blocks,
                'palette' => ["a_google","target_blank"],
                'slots'   => ["root"],
            ],
            'rules' => [
                ["type" => "requireBlocks", "blocks" => ["a_google","target_blank"]]
            ],
            'solution' => ['success' => '✅ Eksterni link se otvara u novom tabu!'],
            'hint' => null,
            'order' => 3,
        ]);


        $l3Blocks = [
            "header_open"  => ["label" => "<header>", "tag" => "header"],
            "header_close" => ["label" => "</header>", "tag" => "/header"],
            "nav_open"     => ["label" => "<nav>", "tag" => "nav"],
            "nav_close"    => ["label" => "</nav>", "tag" => "/nav"],
            "main_open"    => ["label" => "<main>", "tag" => "main"],
            "main_close"   => ["label" => "</main>", "tag" => "/main"],
            "footer_open"  => ["label" => "<footer>", "tag" => "footer"],
            "footer_close" => ["label" => "</footer>", "tag" => "/footer"],
            "header_blog"  => ["label" => "<header>Blog</header>", "tag" => "header"],
            "article_full" => ["label" => "<article><h2>Prvi post</h2><p>Ovo je tekst posta.</p></article>", "tag" => "article"],
            "aside_full"   => ["label" => "<aside><p>Reklama</p></aside>", "tag" => "aside"],
            "footer_full"  => ["label" => "<footer><p>© 2026</p></footer>", "tag" => "footer"],
        ];


        Phase::create([
            'nivo_id' => 3,
            'naziv'   => 'Faza 1 – Zameni divove semantičkim tagovima',
            'opis'    => 'Zameni generičke div elemente odgovarajućim semantičkim tagovima.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l3Blocks,
                'palette' => ["header_open","header_close","nav_open","nav_close","main_open","main_close","footer_open","footer_close"],
                'slots'   => ["root"],
            ],
            'rules' => [
                ["type" => "slotOrder", "slot" => "root", "order" => ["header_open","header_close","nav_open","nav_close","main_open","main_close","footer_open","footer_close"]]
            ],
            'solution' => ['success' => '✅ Semantički tagovi su postavljeni!'],
            'hint' => 'Semantički tag opisuje šta sadržaj znači, ne kako izgleda.',
            'order' => 1,
        ]);


        Phase::create([
            'nivo_id' => 3,
            'naziv'   => 'Faza 2 – Struktura blog stranice',
            'opis'    => 'Složi strukturu blog stranice koristeći semantičke tagove.',
            'blocks'  => [
                'mode'    => 'dragdrop',
                'blocks'  => $l3Blocks,
                'palette' => ["header_blog","main_open","main_close","article_full","aside_full","footer_full"],
                'slots'   => ["root","main"],
            ],
            'rules' => [
                ["type" => "slotOrder", "slot" => "root", "order" => ["header_blog","main_open","main_close","aside_full","footer_full"]],
                ["type" => "blockInSlot", "slot" => "main", "block" => "article_full"],
            ],
            'solution' => ['success' => '🎉 Sada pišeš HTML kao pravi web developer.'],
            'hint' => '<article> ide u <main>, <aside> je pored glavnog sadržaja, <footer> je na dnu stranice.',
            'order' => 2,
        ]);
    }
}

