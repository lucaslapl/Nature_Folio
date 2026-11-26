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

- `admin/index.php` — hub admin (listes oiseaux / lépidoptères)
- `admin/especes.php?table=oiseaux|lepido[&filtre=incomplets]` — liste des espèces avec badge de complétude (champs manquants) et lien « Modifier »
- `admin/edit_espece.php?table=…&id=…` — édition d'une fiche existante : formulaire pré-rempli (la description structurée est re-découpée en champs guidés), images optionnelles (l'actuelle est conservée si on n'en renvoie pas), bouton « Pré-remplir via l'INPN » pour compléter les champs vides depuis TAXREF
- `admin/espece_update.php` — enregistre les modifications (UPDATE)
- Formulaires d'ajout : `oiseaux/new_bird.php`, `lepido/new_lepido.php`

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
  taxref.php            Recherche dans l'extrait TAXREF local (pré-remplissage INPN)
_data/                  Extrait TAXREF (NON servi directement, bloqué par .htaccess)
  taxref_fr.csv         Oiseaux + papillons de jour présents en France métro (~4 900 taxons)
  build_taxref_extract.php  Script CLI de régénération depuis le TAXREF v18 complet
admin/                  login.php / logout.php / inpn_lookup.php (endpoint JSON TAXREF, session requise)
                        index.php / especes.php / edit_espece.php / espece_update.php (gestion des fiches existantes)
oiseaux/  lepido/       Listes publiques + formulaires admin + _photos/
_css/main.css           Thème (clair) en CSS pur — édité directement, servi tel quel
_js/main.js             Filtre, accordéon, lightbox (vanilla, sans dépendance)
```

## CSS

Le thème est en **CSS pur** (`_css/main.css`, servi directement par `_inc/functions.php`) : custom properties dans `:root`, nesting natif. Aucun build, aucune dépendance npm.

## Pré-remplissage INPN (TAXREF)

Les formulaires admin (`new_bird.php`, `new_lepido.php`) proposent une autocomplétion
du nom latin et un bouton « Pré-remplir via l'INPN » : recherche dans `_data/taxref_fr.csv`
(extrait du TAXREF v18 INPN, licence ouverte) via `admin/inpn_lookup.php`, puis remplissage
automatique des champs vides (nom vernaculaire, famille, lien INPN, préréglage de répartition
si l'espèce est présente en France métropolitaine).

Régénérer l'extrait quand TAXREF évolue :

```bash
php _data/build_taxref_extract.php /chemin/vers/TAXREFv18.txt
```

Le TAXREF complet (~300 Mo) n'est pas versionné ; seul l'extrait CSV l'est.

## Sécurité

- Toutes les sorties HTML sont échappées (`htmlspecialchars` via `e()`)
- Requêtes préparées PDO partout
- Formulaires admin protégés par session + `noindex`
- Upload : extension + contenu réel vérifiés, nom aléatoire
- `.htaccess` : bloque `_inc/`, `_data/`, `.env`, fichiers sensibles ; headers de sécurité ; cache statiques

## Photos

Les dossiers `oiseaux/_photos/` et `lepido/_photos/` ne sont pas versionnés (`.gitignore`) et sont montés en volume dans Docker.
