<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';

$error = null;
$redirect = $_GET['redirect'] ?? '../index.php';

// Sécurité : le redirect ne doit pointer que vers une page interne
if (!preg_match('#^/[a-zA-Z0-9/_.-]*$#', $redirect) && !str_starts_with($redirect, '/')) {
    $redirect = '../index.php';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if (attempt_login($password)) {
        // Redirige vers la page d'origine (new_bird.php, etc.) ou l'accueil
        $target = $_POST['redirect'] ?? '../index.php';
        if (!str_starts_with($target, '/') && !preg_match('#^\.\./#', $target)) {
            $target = '../index.php';
        }
        header('Location: ' . $target);
        exit;
    }
    $error = 'Mot de passe incorrect.';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Connexion admin — ' . SITE_NAME,
        'description' => 'Accès réservé à l\'administration.',
        'path' => 'admin/login.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body class="login-page">
    <main class="login-box">
        <h1>Connexion</h1>
        <?php if (ADMIN_PASSWORD_HASH === ''): ?>
            <p class="alert">La variable d'environnement <code>ADMIN_PASSWORD_HASH</code> n'est pas définie. Consultez <code>.env.example</code>.</p>
        <?php elseif ($error): ?>
            <p class="alert"><?= e($error) ?></p>
        <?php endif; ?>
        <form method="post" action="login.php">
            <input type="hidden" name="redirect" value="<?= e_attr($redirect) ?>">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required autofocus autocomplete="current-password">
            <button type="submit" class="btn-primary">Se connecter</button>
        </form>
        <p class="back"><a href="../index.php">&larr; Retour au site</a></p>
    </main>
</body>
</html>
