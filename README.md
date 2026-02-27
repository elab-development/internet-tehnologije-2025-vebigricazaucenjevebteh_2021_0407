# Backend – Laravel API

## Opis projekta
Backend aplikacija je razvijena korišćenjem Laravel framework‑a. 
Služi za obradu zahteva, komunikaciju sa bazom podataka i pružanje REST API servisa frontend aplikaciji.

## Tehnologije
- PHP 8.2
- Laravel
- Laravel sanctum
- MySQL
- PHPUnit (testiranje)
- Docker
- GitHub Actions (CI/CD)
- Composer

## Pokretanje projekta (lokalno)

1. Klonirati repozitorijum:
   git clone <https://github.com/elab-development/internet-tehnologije-2025-vebigricazaucenjevebteh_2021_0407.git>

2. Ući u backend folder:
   cd internet-tehnologije-2025-vebigricazaucenjevebteh_2021_0407

3. Instalirati zavisnosti:
   composer install

4. Kopirati .env fajl:
   cp .env.example .env

5. Generisati application key:
   php artisan key:generate

6. Pokrenuti migracije:
   php artisan migrate

7. Pokrenuti server:
   php artisan serve

Aplikacija će biti dostupna na:
http://localhost:8000

## API Dokumentacija

Swagger dokumentacija je dostupna na:
http://localhost:8000/api/documentation

## Testiranje

Pokretanje testova:
php artisan test

Testovi obuhvataju:
- Unit testove
- Integration testove

Testovi se automatski pokreću putem GitHub Actions CI pipeline‑a pri svakom push/pull request‑u.

## CI/CD

Pipeline:
- Pokreće testove
- Build‑uje frontend
- Gradi Docker image

Definisan u:
.github/workflows/

## Deployment

Aplikacija je deploy‑ovana na Render platformi korišćenjem Docker‑a.
