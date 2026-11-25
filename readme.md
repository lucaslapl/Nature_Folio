# Nature Folio V2

Portfolio naturaliste de **Lucas LAPLANCHE** — observations et photos d'**oiseaux** et de **lépidoptères**.

Site en PHP vanilla (PDO/MySQL), thème clair, analytics avec **Matomo** (auto-hébergé). Conteneurisé avec Docker.

## Démarrage rapide (Docker)

```bash
cp .env.example .env        # puis éditer .env (mots de passe, Matomo, hash admin)
docker compose up -d --build
```

Le site est dispo sur **http://localhost:8100**.

La base est initialisée automatiquement depuis `_docker/naturanim_dump.sql` (tables `oiseaux` et `lepido`, moteur InnoDB).

## Configuration

Toutes les variables passent par le fichier `.env` à la racine (voir `.env.example`).

- **Avec Docker** : `docker-compose.yml` injecte `.env` via `env_file`.
- **Hors Docker** (prod Apache/PHP direct) : `_inc/env.php` lit automatiquement `.env` à la racine si les variables ne sont pas déjà dans l'environnement. Le fichier `.env` est protégé (403) par le `.htaccess`.

| Variable | Rôle |
|---|---|
| `DB_DSN`, `DB_USERNAME`, `DB_PASSWORD` | Connexion PDO du site |
| `MYSQL_*` | Initialisation du conteneur MySQL |
| `SITE_URL` | URL publique (canonical, OG tags) |
| `MATOMO_URL`, `MATOMO_SITE_ID` | Analytics Matomo |
| `ADMIN_PASSWORD_HASH` | Hash bcrypt du mot de passe admin |

Générer le hash admin :

```bash
php -r "echo password_hash('ton-mot-de-passe', PASSWORD_DEFAULT);"
```

## Administration

Les formulaires d'ajout d'espèces sont protégés par une session admin :

- `oiseaux/new_bird.php` — ajouter un oiseau
- `lepido/new_lepido.php` — ajouter un lépidoptère

Accès via `admin/login.php` (mot de passe défini par `ADMIN_PASSWORD_HASH`). Déconnexion : `admin/logout.php`.

Les uploads sont sécurisés : extension whitelist, vérification `getimagesize()`, taille max 5 Mo, nom de fichier aléatoire.

## Structure

```
index.php               Accueil (compteurs d'espèces)
_inc/                   Code partagé (NON servi directement, bloqué par .htaccess)
  config.php            Connexion PDO + constantes (depuis .env)
  functions.php         Helpers : échappement HTML, head/footer, liste d'espèces
  auth.php              Session admin (login/logout/require_login)
  upload.php            Upload sécurisé + insertion générique
  species-form.php      Template du formulaire d'ajout
admin/                  login.php / logout.php
oiseaux/  lepido/       Listes publiques + formulaires admin + _photos/
_scss/main.scss         Source du thème (clair)
_css/main.css           CSS compilé (généré, ne pas éditer à la main)
_js/main.js             Filtre, accordéon, lightbox (vanilla, sans dépendance)
```

## Build CSS

Le SCSS est compilé avec [sass](https://sass-lang.com/) :

```bash
npm install
npm run css          # compile _scss/main.scss → _css/main.css (minifié)
npm run css:watch    # mode watch
```

## Sécurité

- Toutes les sorties HTML sont échappées (`htmlspecialchars` via `e()`)
- Requêtes préparées PDO partout
- Formulaires admin protégés par session + `noindex`
- Upload : extension + contenu réel vérifiés, nom aléatoire
- `.htaccess` : bloque `_inc/`, `.env`, fichiers sensibles ; headers de sécurité ; cache statiques

## Photos

Les dossiers `oiseaux/_photos/` et `lepido/_photos/` ne sont pas versionnés (`.gitignore`) et sont montés en volume dans Docker.
