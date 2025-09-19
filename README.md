## EcoSchool

Nachhaltige Schule leicht gemacht: EcoSchool ist eine Laravel‑App zur Selbsteinschätzung in der Berufsbildung für nachhaltige Entwicklung (BBNE). Schulen beantworten Fragen in Handlungsfeldern und erhalten eine Einstufung (Bronze/Silber/Gold) inkl. Detailauswertung und Empfehlungen.

### Kernnutzen
- **Selbsteinschätzung**: Klar strukturierte Fragen pro Handlungsfeld.
- **Ergebnis & Empfehlungen**: Bronze/Silber/Gold, Aufschlüsselung nach Kategorien, konkrete nächste Schritte.
- **Zwei Modi**: Gast (ohne Speicherung) oder registrierter Nutzer (persistente Ergebnisse).

## Tech‑Stack
- **Backend**: Laravel 12 (PHP 8.3)
- **Admin UI**: Filament 4 (Ressourcen für Kategorien/Fragen, Reordering, CRUD)
- **Frontend**: Blade, Tailwind CSS, Vite
- **DB**: MariaDB 10.11 (DDEV) • SQLite für Tests/CI
- **Auth**: Laravel Breeze Basis, E‑Mail‑Verifizierung
- **CI**: GitHub Actions (Composer, Migrations, Tests)

## Architekturüberblick
- **Routen**: `routes/web.php` (Landing, Dashboard, Fragebogen, Ergebnisse, Gastpfad)
- **Controller**: `QuestionnaireController` (Workflow), `ResultController` (Anzeige/Empfehlungen), Auth/Profile
- **Modelle**: `Category`, `Question`, `Answer`, `Result`, `User`
- **Views**: `resources/views/questionnaire/*`, `results/show.blade.php`, `landingpage.blade.php`
- **Admin (Filament)**: `app/Filament/Resources/*` + `AdminPanelProvider`
- **Middleware**: `guest.access` für Gast‑Routen

### Domänenmodell
- **Category** 1—n **Question**
- **Question** 1—n **Answer**
- **User** 1—n **Answer**, 1—n **Result** (ein `finalResult`)

Wichtige Tabellenfelder:
- `categories`: `name`, `slug` (unique), `description`, `weight`, `question_count`
- `questions`: `category_id` (FK), `question_text`, `order`, `is_active`, `points`, `help_text`, `metadata`
- `answers`: `user_id` (FK), `question_id` (FK), `answer` (bool), `points_awarded`, `answered_at` • unique (`user_id`,`question_id`)
- `results`: `user_id` (FK), `total_points`, `max_points`, `percentage`, `status` (enum: bronze/silver/gold), `category_scores` (JSON), `is_final`

### Geschäftslogik (Kurz)
- Antworten werden idempotent gespeichert/aktualisiert; Punkte=1 bei „Ja“.
- Abschluss berechnet `percentage` = Summe Punkte / aktive Fragen, Status via Schwellen: Gold ≥91, Silber ≥71, sonst Bronze.
- `category_scores` enthält je Kategorie Punkte, Max‑Punkte und Prozent.
- Gastmodus speichert Antworten/Ergebnis in der Session (`guest_answers`, `guest_result`).

## Quickstart

### Voraussetzungen
- PHP 8.3, Composer 2
- Node.js (für Vite Assets)
- Optional: DDEV (empfohlen) für MariaDB 10.11

### Setup
1) Abhängigkeiten installieren
```bash
composer install
npm install
```

2) Env & App‑Key
```bash
cp .env.example .env
php artisan key:generate
```

3) Datenbank vorbereiten (DDEV oder lokal)
```bash
# DDEV (empfohlen)
ddev start
# .env DB_* entsprechend DDEV nutzen oder SQLite für lokal/testing
```

4) Migrationen (optional: Seeds)
```bash
php artisan migrate
# optional
php artisan db:seed
```

5) Entwickeln/Starten
```bash
php artisan serve
# in zweitem Terminal: Assets
npm run dev
```

Hinweis: Ein Gastlauf ist ohne Registrierung möglich, persistent nur angemeldet.

## Routenüberblick
```text
/                      Landingpage
/privacy              Datenschutz
/dashboard            Dashboard (auth, verified)

# Auth‑Flow (Auswahl)
/login, /register, /verify-email, /password/*

# Fragebogen (angemeldet)
/questionnaire                        Einstieg / Next Category
/questionnaire/category/{category:slug}
/questionnaire/reset
/results/{result}

# Gast‑Flow
/guest/questionnaire
/guest/questionnaire/category/{category:slug}
/guest/questionnaire/reset
/guest/results
```

## Admin (Filament)
- Pfad: `/admin` (Login erforderlich)
- Kategorien & Fragen pflegen, Reihenfolge ändern (↑/↓ Actions)
- Ressourcen: `app/Filament/Resources/Categories/*` und verschachtelte `Questions`

## Tests & CI
- Unit/Integration Tests:
```bash
php artisan test
```
- GitHub Actions: `.github/workflows/tests.yml` (Composer, SQLite, migrate:fresh, Tests)

## Verzeichnisstruktur (Auszug)
```text
app/
  Http/Controllers/ (QuestionnaireController, ResultController, Auth, Profile)
  Models/ (Category, Question, Answer, Result, User)
  Filament/Resources/ (Admin Ressourcen)
  Http/Middleware/GuestAccess.php
resources/views/ (questionnaire, results, landingpage, layouts, auth)
database/migrations/ (categories, questions, answers, results, users+)
routes/web.php
```

## Präsentationsleitfaden (Kurz)
1) Landingpage: Ziel & Nutzen (Gast testen zeigen)
2) Gast‑Flow: 1–2 Fragen beantworten, Fortschritt, Abschluss → Ergebnis
3) Nutzer‑Flow: Dashboard → Fragebogen → Ergebnis (persistiert)
4) Admin: `/admin` Kategorien/Fragen, Reorder‑Buttons
5) Datenmodell & Statuslogik: Entities, Unique (`user_id`,`question_id`), Statusschwellen

## Internationalisierung
- Deutsch/Englisch‑Dateien unter `lang/` vorhanden; Filament Language Switch Paket integriert.

## Lizenz
MIT (siehe `composer.json`)


## Laravel Komponenten & Lifecycle

### 1) Request-Lifecycle (Überblick)
- Einstieg: `public/index.php` lädt Autoloader und startet die App aus `bootstrap/app.php`.
- `bootstrap/app.php` registriert Routen, Middleware-Aliase und erstellt die Anwendung.
- Pipeline: Global-/Gruppen-/Route-Middleware → Router (Route Model Binding) → Controller → Response → Terminierung.

Siehe Datei: `bootstrap/app.php` (Alias `guest.access`).

### 2) Routing
- HTTP-Routen: `routes/web.php`, Auth-Routen in `routes/auth.php`.
- Benannte Routen (`->name('...')`) für Redirects/Links.
- Route Model Binding: `{category:slug}` injiziert `App\Models\Category` anhand `slug`.

### 3) Middleware
- Cross-Cutting Concerns wie Auth, CSRF, Gastzugang.
- Projekt-spezifisch: `app/Http/Middleware/GuestAccess.php` erlaubt nur definierte Gast-Routen, sonst Redirect.
- Registrierung des Alias in `bootstrap/app.php`.

### 4) Controller
- Feature-Logik pro Route.
- `QuestionnaireController`: Antworten speichern (Transaktionen), Fortschritt, Abschluss (Ergebnis berechnen und speichern), Gastfluss (Session).
- `ResultController`: Ergebnis prüfen (Ownership), Empfehlungen/Ressourcen bestimmen, View rendern.

### 5) Validierung (Form Requests)
- Dedizierte Requests unter `app/Http/Requests/*` (z. B. `Auth/LoginRequest.php`, `ProfileUpdateRequest.php`).
- Alternativ Inline-Validierung im Controller (`$request->validate([...])`).

### 6) Views (Blade)
- Templates unter `resources/views/*` mit Layouts und Komponenten.
- Kernansichten: `questionnaire/category.blade.php`, `results/show.blade.php`, `landingpage.blade.php`.
- Accessiblity-Elemente (Progressbar mit ARIA) und Tailwind UI.

### 7) Eloquent-Modelle & Beziehungen
- Modelle: `app/Models/*`.
- Beziehungen: `Category` hasMany `Question`; `Question` hasMany `Answer`; `User` hasMany `Answer`/`Result` (ein `finalResult`).
- Scopes/Logik: `Question::active()`, Order-Handling (move up/down), `Result::calculateStatus()`.
- Observer: `QuestionObserver` (Reorder nach Löschung), registriert in `AppServiceProvider::boot()`.

### 8) Datenbank: Migrations, Seeder
- Migrations definieren Schema/Indizes/FKs unter `database/migrations/*`.
- Beispiele: `answers` mit unique (`user_id`,`question_id`); `results.status` Enum, `is_final` Index.
- Seeds: `database/seeders/*` (z. B. Kategorien/Fragen initial).

### 9) Service Container, Provider, Facades
- DI über Service Container; Bindings/Bootstrapping in Providern.
- `AppServiceProvider`: LanguageSwitch-Lokalisierung, Observer-Registrierung.
- Filament `AdminPanelProvider`: Panel `/admin`, Ressourcen/Widgets/Middleware.
- Facades: `Auth`, `DB`, `Route` usw. als statische Schnittstellen.

### 10) Authentifizierung & Autorisierung
- Konfig: `config/auth.php` (Guard `web`, Provider `users`).
- Nutzer: `App\Models\User implements MustVerifyEmail` (Verifizierungs-Mail), Password Reset Notification.
- Schutz: Middleware `auth`, `verified`; Ergebnis-Ownership-Check (`abort(403)`).

### 11) Benachrichtigungen & Mails
- Notifications: `app/Notifications/VerifyEmail.php`, `ResetPassword.php`.
- Versand via `User::notify(...)`.

### 12) Queues & Jobs
- Queue-Unterstützung vorhanden; Dev-Script sieht `queue:listen` vor (siehe Composer-Script `dev`).
- Für produktive Nutzung Queue-Driver in `.env` konfigurieren.

### 13) Konfiguration & Umgebungen
- `.env` steuert Laufzeitwerte; Defaults in `config/*` (z. B. `config/app.php`, `config/database.php`).
- Konfigurations-Cache: `php artisan config:cache` (Deployment).

### 14) Logging & Fehlerbehandlung
- Logging via `config/logging.php` (Monolog).
- Exception-Handling-Entry in `bootstrap/app.php` (`withExceptions`).

### 15) Tests
- Unit/Integration unter `tests/*`.
- SQLite DB in CI; Workflow: `.github/workflows/tests.yml` (Key, SQLite, `migrate:fresh`, `php artisan test`).

### 16) Frontend-Build
- Vite (`resources/js`, `resources/css`, `vite.config.js`).
- Development: `npm run dev`; Production: `npm run build` (Assets in `public/build`).

### 17) Admin-Panel (Filament)
- Ressourcen unter `app/Filament/Resources/*`.
- Verschachtelte Fragenressource je Kategorie; Tabellen-Actions für Reihung (`moveOrderUp/Down`).

### 18) Typischer Flow in diesem Projekt
1. Gast klickt „Anonym testen“ → `guest.questionnaire.show` (Middleware `guest.access`).
2. Controller leitet zur ersten unvollständigen Kategorie (per gewichteter Reihenfolge) weiter.
3. Kategorie-View rendert Fragen; POST speichert (Session/DB) und navigiert zur nächsten.
4. Abschluss berechnet Ergebnis, speichert (User) oder legt in Session (Gast) und zeigt `results.show` an.

