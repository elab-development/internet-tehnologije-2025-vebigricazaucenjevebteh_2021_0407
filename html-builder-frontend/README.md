# Frontend – React aplikacija

## Opis projekta
Frontend aplikacija omogućava korisnicima interakciju sa sistemom putem grafičkog interfejsa. 
Komunicira sa backend REST API‑jem.

## Tehnologije
- React
- Node.js
- Vite
- Docker
- HTML/CSS
- fetch API

## Pokretanje projekta (lokalno)

1. Klonirati repozitorijum:
   git clone <https://github.com/elab-development/internet-tehnologije-2025-vebigricazaucenjevebteh_2021_0407.git>

2. Ući u frontend folder:
   cd html-builder-frontend

3. Instalirati zavisnosti:
   npm install

4. Pokrenuti aplikaciju:
   npm start

Aplikacija će biti dostupna na:
http://localhost:5173

## Build verzija

Za produkcioni build:
npm run build

## Komunikacija sa backend‑om

Frontend šalje HTTP zahteve ka backend API‑ju, npr:
GET /api/nivos
GET /api/korisnik

Podaci se razmenjuju u JSON formatu.
