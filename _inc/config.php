<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '0');

require_once __DIR__ . '/env.php';

// Fallback hors Docker : si les variables ne sont pas injectées dans
// l'environnement (docker-compose le fait via env_file), on lit .env
// à la racine du projet. Les variables déjà définies ne sont pas écrasées.
if (getenv('DB_DSN') === false) {
    load_env_file(__DIR__ . '/../.env');
}

// --- Base de données (via variables d'environnement, voir .env / docker-compose.yml) ---
$dbDsn = getenv('DB_DSN');
$dbUsername = getenv('DB_USERNAME');
$dbPassword = getenv('DB_PASSWORD');

if ($dbDsn === false || $dbUsername === false) {
    die('Configuration manquante : les variables d\'environnement DB_DSN et DB_USERNAME doivent être définies (voir .env.example).');
}

try {
    $conn = new PDO($dbDsn, $dbUsername, $dbPassword, [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
    ]);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log('DB connection failed: ' . $e->getMessage());
    die('Erreur de connexion à la base de données.');
}

// --- Session (démarrée avant tout output pour pouvoir lire l'état admin partout) ---
// Durée de vie longue (défaut 7 jours, surchargeable via ADMIN_SESSION_LIFETIME en secondes) :
// le cookie de session persiste et le garbage collector serveur garde la session.
$sessionLifetime = (int) (getenv('ADMIN_SESSION_LIFETIME') ?: 7 * 24 * 3600);
ini_set('session.gc_maxlifetime', (string) $sessionLifetime);

// En local Docker, on peut monter un dossier persistant pour les sessions
// (PHP_SESSION_SAVE_PATH) afin qu'un rebuild du conteneur ne déconnecte pas.
if (getenv('PHP_SESSION_SAVE_PATH')) {
    session_save_path(getenv('PHP_SESSION_SAVE_PATH'));
}

session_set_cookie_params([
    'lifetime' => $sessionLifetime,
    'path' => '/',
    'domain' => '',
    'secure' => str_starts_with((string) (getenv('SITE_URL') ?: ''), 'https://'),
    'httponly' => true,
    'samesite' => 'Lax',
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- Constantes du site ---
define('SITE_NAME', 'Lucas LAPLANCHE — Portfolio naturaliste');
define('SITE_URL', getenv('SITE_URL') ?: 'https://nature.lucaslaplanche.fr');
define('SITE_AUTHOR', 'Lucas Laplanche');

// --- Matomo (remplace Google Analytics) ---
define('MATOMO_URL', rtrim(getenv('MATOMO_URL') ?: 'https://matomo.example.com', '/'));
define('MATOMO_SITE_ID', getenv('MATOMO_SITE_ID') ?: '1');

// --- Admin : hash du mot de passe (password_hash) défini via ADMIN_PASSWORD_HASH ---
define('ADMIN_PASSWORD_HASH', getenv('ADMIN_PASSWORD_HASH') ?: '');

// --- Upload ---
define('UPLOAD_MAX_BYTES', 5 * 1024 * 1024); // 5 Mo
define('UPLOAD_ALLOWED_EXT', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
