<?php

error_reporting(E_ALL);

// Configuration via variables d'environnement (définies dans docker-compose.yml)
$dbDsn = getenv("DB_DSN");
$dbUsername = getenv("DB_USERNAME");
$dbPassword = getenv("DB_PASSWORD");

if ($dbDsn === false || $dbUsername === false) {
    die("Configuration manquante : les variables d'environnement DB_DSN et DB_USERNAME doivent être définies (voir docker-compose.yml).");
}

try {
    $conn = new PDO($dbDsn, $dbUsername, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Échec lors de la connexion : " . $e->getMessage());
}
