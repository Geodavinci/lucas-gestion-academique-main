# Guide d'installation et d'exécution

Ce guide explique comment cloner et exécuter le projet en local.

## Prérequis
- PHP 8.2+ (ou 8.3) avec extensions : `pdo_mysql`, `openssl`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`
- Composer
- Node.js 18+ et npm
- MySQL ou MariaDB

## Installation (local)

1. Cloner le projet
```bash
git clone <URL_DU_REPO>
cd lucas-gestion-academique-main
```

2. Installer les dépendances PHP
```bash
composer install
```

3. Installer les dépendances front
```bash
npm install
```

4. Configurer l'environnement
```bash
cp .env.example .env
```
Ouvrir `.env` et renseigner :
```
DB_DATABASE=lucas_gestion_academique
DB_USERNAME=root
DB_PASSWORD=ton_mot_de_passe
```

5. Générer la clé Laravel
```bash
php artisan key:generate
```

6. Créer la base de données (MySQL)
```sql
CREATE DATABASE lucas_gestion_academique;
```

7. Migrer et remplir la base
```bash
php artisan migrate:fresh --seed
```

8. Créer le lien storage
```bash
php artisan storage:link
```

9. Lancer le serveur Laravel
```bash
php artisan serve
```
Accès : `http://127.0.0.1:8000`

10. Lancer Vite (React/Inertia)
Dans un autre terminal :
```bash
npm run dev
```

## Problèmes fréquents

### Erreur 413 / PostTooLargeException
Augmenter la taille d'upload dans `php.ini` :
```
upload_max_filesize = 20M
post_max_size = 25M
```
Puis relancer le serveur PHP/Laravel.

## Comptes de test
Si des seeders existent, ils créent des comptes admin/teacher/user.
Sinon, créer un compte via `/register`, puis changer son rôle dans la base.
