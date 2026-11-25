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

    <main class="home-hero">
        <img class="avatar" src="_imgs/avatar.jpg" alt="<?= e_attr(SITE_AUTHOR) ?>">
        <h1>Lucas LAPLANCHE</h1>
        <p class="subtitle">Observations naturalistes</p>
        <p class="baseline">
            Naturaliste amateur et photographe, je documente mes découvertes parmi
            les <strong>oiseaux</strong> et les <strong>lépidoptères</strong>.
        </p>

        <div class="cards">
            <a href="oiseaux/oiseaux.php" class="card">
                <div class="icon">
                    <img src="_imgs/rousserolle.svg" alt="">
                </div>
                <h2>Oiseaux <span class="count"><?= $countOiseaux ?></span></h2>
                <p>Observations ornithologiques et leurs photographies.</p>
                <span class="go">Explorer &rarr;</span>
            </a>

            <a href="lepido/lepido.php" class="card">
                <div class="icon">
                    <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                        <path d="M31 32C24 14 8 10 6 22c-1.6 9.5 10 14 25 12z" fill="#3d6b35" opacity="0.85"/>
                        <path d="M33 32c7-18 23-22 25-10 1.6 9.5-10 14-25 12z" fill="#3d6b35" opacity="0.85"/>
                        <path d="M31 36c-8-2-18 2-16 10 1.5 6.5 11 4 16-8z" fill="#6b9c5f"/>
                        <path d="M33 36c8-2 18 2 16 10-1.5 6.5-11 4-16-8z" fill="#6b9c5f"/>
                        <rect x="30.4" y="26" width="3.2" height="20" rx="1.6" fill="#22271f"/>
                        <path d="M31 26c-2-4-5-6-8-6M33 26c2-4 5-6 8-6" stroke="#22271f" stroke-width="1.6" stroke-linecap="round"/>
                    </svg>
                </div>
                <h2>Lépidoptères <span class="count"><?= $countLepido ?></span></h2>
                <p>Papillons de jour observés et photographiés.</p>
                <span class="go">Explorer &rarr;</span>
            </a>
        </div>
    </main>

    <?php render_footer(); ?>

</body>
</html>
