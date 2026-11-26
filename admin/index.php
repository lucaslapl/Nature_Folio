<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';

require_login();

$countOiseaux = count_species($conn, 'oiseaux');
$countLepido = count_species($conn, 'lepido');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Administration — ' . SITE_NAME,
        'path' => 'admin/index.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

    <?php render_header('Administration', false, 'Admin'); ?>

    <main class="container container-narrow">
        <div class="admin-hub">
            <a href="especes.php?table=oiseaux" class="card admin-hub-card">
                <h2>Oiseaux <span class="count"><?= $countOiseaux ?></span></h2>
                <p>Gérer, modifier et compléter les fiches oiseaux.</p>
                <span class="go">Gérer &rarr;</span>
            </a>
            <a href="especes.php?table=lepido" class="card admin-hub-card">
                <h2>Lépidoptères <span class="count"><?= $countLepido ?></span></h2>
                <p>Gérer, modifier et compléter les fiches lépidoptères.</p>
                <span class="go">Gérer &rarr;</span>
            </a>
        </div>
        <p class="back"><a href="logout.php">Se déconnecter</a></p>
    </main>

    <?php render_footer(); ?>

</body>
</html>
