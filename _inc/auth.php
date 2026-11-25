<?php

declare(strict_types=1);

/**
 * Authentification admin par session.
 * Le mot de passe est stocké sous forme de hash (password_hash) dans la
 * variable d'environnement ADMIN_PASSWORD_HASH (voir .env.example).
 */

function is_logged_in(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['admin_logged_in']);
}

/**
 * Exige une session admin, sinon redirige vers la page de login.
 * À appeler en haut de chaque page d'administration.
 */
function require_login(): void
{
    if (!is_logged_in()) {
        $here = $_SERVER['REQUEST_URI'] ?? '';
        header('Location: ../admin/login.php?redirect=' . urlencode($here));
        exit;
    }
}

/**
 * Tente de connecter l'admin. Retourne true si OK.
 */
function attempt_login(string $password): bool
{
    if (ADMIN_PASSWORD_HASH === '') {
        return false;
    }
    if (!password_verify($password, ADMIN_PASSWORD_HASH)) {
        return false;
    }
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_regenerate_id(true);
    $_SESSION['admin_logged_in'] = true;
    return true;
}

function logout(): void
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
