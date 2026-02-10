# Guide de demarrage - Lucas Gestion Academique

Ce document explique :
- ce qu'il faut installer sur une nouvelle machine
- comment lancer le projet
- comment utiliser l'application si on ne connait rien

## 1) Prerequis (a installer)
- PHP 8.2+ (recommande 8.3)
- Composer
- Node.js 18+ et npm
- MySQL 8+ (ou MariaDB)
- Git

Optionnel (pour PDF) :
- package `barryvdh/laravel-dompdf`

## 2) Installation rapide (nouvelle machine)

1. Cloner le projet
```
git clone <URL_DU_PROJET>
cd lucas-gestion-academique-main
```

2. Installer les dependances
```
composer install
npm install
```

3. Configurer l'environnement
```
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de donnees (dans `.env`)
Exemple MySQL :
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lucas_gestion_academique
DB_USERNAME=root
DB_PASSWORD=
```

5. Creer la base (si besoin)
Dans MySQL :
```
CREATE DATABASE lucas_gestion_academique;
```

6. Migrations + seeders (donnees de demo)
```
php artisan migrate
php artisan db:seed
```

7. Compiler les assets front
```
npm run build
```

8. Lancer l'application
```
php artisan serve
```
Acces : `http://127.0.0.1:8000`

## 3) Comptes de test (seeders)
- Admin
  - email : `admin@lucas.edu`
  - mot de passe : `admin123`
- Users
  - `user1@lucas.edu` / `password`
  - `user2@lucas.edu` / `password`
  - `user3@lucas.edu` / `password`
  - `user4@lucas.edu` / `password`

## 4) Utilisation (pour quelqu'un qui ne connait pas le projet)

### 4.1 Connexion
- Aller sur `/login`
- Se connecter avec un compte admin ou user

### 4.2 Role admin
- L'admin est redirige vers `/dashboard`
- Le dashboard donne acces aux sections :
  - Etudiants
  - Enseignants
  - Memoires
  - Soutenances
  - Recus
- L'admin peut :
  - creer / modifier / supprimer
  - lier un user a un etudiant (section "Gestion des roles")

### 4.3 Role user
- Un user est redirige vers `/mon-dossier`
- Il voit ses informations personnelles + memoire + soutenance
- Il peut telecharger son dossier en PDF (si PDF active)

## 5) Lier un user a un etudiant
C'est obligatoire pour que `/mon-dossier` fonctionne.

Depuis le dashboard admin :
1. Aller sur `/dashboard`
2. Section "Gestion des roles"
3. Choisir l'etudiant a lier dans la colonne "Etudiant lie"
4. Cliquer sur **Lier**

## 6) Activer la generation PDF
Le bouton "Telecharger PDF" utilise Dompdf.

Installer :
```
composer require barryvdh/laravel-dompdf
```

Si Dompdf n'est pas installe, l'application affiche un message d'erreur clair.

## 7) Commandes utiles
- Migrations : `php artisan migrate`
- Reinitialiser + seed : `php artisan migrate:fresh --seed`
- Lancer vite + assets dev : `npm run dev`
- Lancer serveur : `php artisan serve`

## 8) Depannage rapide
- Vite manifest not found :
  - faire `npm install` puis `npm run build`
- Erreur 500 apres ajout migration :
  - verifier que la base est creee et accesible
- /mon-dossier vide :
  - verifier la liaison user_id dans `students`

## 9) Structure du projet
- `app/Models` : models Eloquent
- `app/Http/Controllers` : logique metier
- `resources/views` : pages Blade
- `routes/web.php` : routes
- `database/migrations` : schema
- `database/seeders` : donnees de demo

