<?php

declare(strict_types=1);

require_once __DIR__ . '/_inc/config.php';
require_once __DIR__ . '/_inc/functions.php';

$countOiseaux = count_species($conn, 'oiseaux', true);
$countLepido = count_species($conn, 'lepido');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => SITE_NAME,
        'path' => 'index.php',
    ]); ?>
</head>
<body>

    <?php render_header('Lucas LAPLANCHE', true); ?>

    <main class="container">
        <section class="intro">
            Naturaliste amateur et photographe, je liste et documente mes découvertes
            parmi les <strong>oiseaux</strong> et les <strong>lépidoptères</strong>.
        </section>

        <div class="section-label">
            <span>Observations</span>
            <div class="line"></div>
        </div>

        <div class="grid">
            <a href="oiseaux/oiseaux.php" class="card">
                <h3>Oiseaux <span class="count"><?= $countOiseaux ?></span></h3>
                <p>Observations ornithologiques, photos et fiches INPN.</p>
            </a>

            <a href="lepido/lepido.php" class="card">
                <h3>Lépidoptères <span class="count"><?= $countLepido ?></span></h3>
                <p>Papillons de jour observés et photographiés.</p>
            </a>
        </div>
    </main>

    <?php render_footer(); ?>

</body>
</html>
