<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/species-form.php';

require_login();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Ajouter un oiseau — ' . SITE_NAME,
        'path' => 'oiseaux/new_bird.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

    <?php render_header('Ajouter un oiseau', false, 'Administration'); ?>

    <main class="container container-narrow">
        <?php render_species_form(
            action: 'bird_sent.php',
            entityLabel: 'un oiseau',
            nameExample: 'Mésange charbonnière',
            nameLatinExample: 'Parus major',
            familleExample: 'Paridae',
            descFields: desc_fields_for('oiseaux'),
            group: 'oiseaux'
        ); ?>
        <p class="back"><a href="../admin/logout.php">Se déconnecter</a></p>
    </main>

    <?php render_footer(); ?>

    <script src="../_js/main.js" defer></script>
</body>
</html>
