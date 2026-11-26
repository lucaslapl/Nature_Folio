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
        'title' => 'Ajouter un lépidoptère — ' . SITE_NAME,
        'path' => 'lepido/new_lepido.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

    <?php render_header('Ajouter un lépidoptère', false, 'Administration'); ?>

    <main class="container container-narrow">
        <?php render_species_form(
            action: 'lepido_sent.php',
            entityLabel: 'un lépidoptère',
            nameExample: 'Paon du jour',
            nameLatinExample: 'Aglais io',
            familleExample: 'Nymphalidé',
            descFields: desc_fields_for('lepido'),
            group: 'lepido'
        ); ?>
        <p class="back"><a href="../admin/logout.php">Se déconnecter</a></p>
    </main>

    <?php render_footer(); ?>

    <script src="<?= asset_url('_js/main.js', 'lepido/new_lepido.php') ?>" defer></script>
</body>
</html>
