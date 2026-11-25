<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '0');

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
