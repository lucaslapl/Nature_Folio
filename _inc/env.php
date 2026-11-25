<?php

declare(strict_types=1);

/**
 * Charge un fichier .env dans l'environnement du process.
 *
 * Utilisé en fallback quand les variables ne sont pas déjà injectées
 * (ex: hors Docker, où docker-compose ne fait pas env_file).
 * Les variables déjà définies dans l'environnement ne sont PAS écrasées.
 */
function load_env_file(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);

        // ignore les commentaires et les lignes sans '='
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
            continue;
        }

        [$key, $value] = explode('=', $line, 2);
        $key = trim($key);
        $value = trim($value);

        // retire les quotes simples/doubles encadrantes
        if (strlen($value) >= 2) {
            $first = $value[0];
            if (($first === '"' || $first === "'") && str_ends_with($value, $first)) {
                $value = substr($value, 1, -1);
            }
        }

        if ($key !== '' && getenv($key) === false) {
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
        }
    }
}
