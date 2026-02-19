# Web Igra za Učenje Web Tehnologija

## 📌 Opis projekta

Ova aplikacija predstavlja web igru za učenje web tehnologija kroz interaktivne nivoe i dnevne izazove (Daily Challenge).  
Korisnici mogu da prolaze kroz različite nivoe sa pitanjima i zadacima, kao i da rešavaju dnevni trivia izazov.

Projekat je razvijen kao seminarski rad iz predmeta Internet Tehnologije.

---

## 🛠 Tehnologije

- Frontend: React
- Backend: Laravel
- Baza podataka: MySQL
- Web server: Nginx
- Docker & Docker Compose
- REST API komunikacija (JSON)

---

## 🐳 Pokretanje aplikacije (Docker)

### 1️⃣ Kloniranje repozitorijuma

git clone <https://github.com/elab-development/internet-tehnologije-2025-vebigricazaucenjevebteh_2021_0407.git>
cd <internet-tehnologije-2025-vebigricazaucenjevebteh_2021_0407>


### 2️⃣ Pokretanje aplikacije

docker compose up --build


### 3️⃣ Pristup aplikaciji

Frontend (Vite dev server):  
http://localhost:5173  

Backend (Nginx + Laravel):  
http://localhost:8000  

phpMyAdmin:  
http://localhost:8080  

---

## 📂 Arhitektura sistema

- React aplikacija koristi Vite kao development server tokom razvoja.
- Laravel backend radi unutar Docker kontejnera.
- Nginx služi kao web server i prosleđuje zahteve Laravel aplikaciji.
- Frontend i backend komuniciraju putem REST API-ja.

---

## 🌿 Git Grane   !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

- main – stabilna verzija
- develop – integraciona grana
- feature/daily-challenge
- feature/nivoi

---

## 🔐 Bezbednost

Aplikacija je zaštićena od najčešćih bezbednosnih napada:

- CORS zaštita (Laravel CORS konfiguracija)
- SQL Injection zaštita (Eloquent ORM)
- Validacija podataka na backend-u
- XSS zaštita (bez nesanitizovanog HTML prikaza)

---

## 🧪 Testiranje

Backend testovi:

php artisan test


Frontend build test:

npm run build


---

## 🔄 CI/CD

CI/CD pipeline automatski:

- Pokreće testove na svaki push i pull request
- Gradi Docker image
- Omogućava deployment na Cloud platformu

---

## 👩‍💻 Autori

- Jelena Maksimović  
- Anja Milenović  

---

Projekat je razvijen u obrazovne svrhe.
