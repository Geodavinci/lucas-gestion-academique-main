# Lucas Gestion Academique

Application Laravel pour la gestion des memoires universitaires, des etudiants, des enseignants, des soutenances et des recus de paiement.

## Fonctionnalites
- Authentification (inscription, connexion, deconnexion)
- Gestion des etudiants et de leurs memoires
- Gestion des enseignants
- Gestion des soutenances (planification, suivi)
- Gestion des recus de paiement
- Export CSV des soutenances et des recus de paiement
- Telechargement des memoires et des recus

## Stack
- PHP 8.2+
- Laravel 12
- MySQL ou SQLite (au choix)
- Node.js + npm (assets front)

## Installation rapide
1. Installer les dependances PHP et Node, puis preparer l'environnement.
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```
2. Demarrer l'application en local.
```bash
php artisan serve
```

## Scripts utiles
- `composer run setup` : installe les dependances, initialise `.env`, migre la base et build les assets
- `composer run dev` : serveur + queue + logs + Vite en mode developpement
- `composer run test` : execute la suite de tests

## Configuration
- Definir les variables dans `.env` (`APP_URL`, `DB_CONNECTION`, `DB_DATABASE`, etc.)
- Pour SQLite, vous pouvez utiliser `database/database.sqlite`

## Structure principale
- `app/Http/Controllers` : logique applicative
- `resources/views` : interfaces Blade
- `routes/web.php` : routes web
- `database/migrations` : schema de base

## Licence
Projet interne — verifier les conditions d'utilisation avec l'equipe.
