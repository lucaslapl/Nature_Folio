<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/upload.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: new_lepido.php');
    exit;
}

$descFields = desc_fields_for('lepido');
$descLabels = array_map(fn($f) => $f['label'], $descFields);

$result = handle_species_insert($conn, 'lepido', $_POST, $_FILES, $descLabels);

if ($result['ok']) {
    header('Location: new_lepido.php?success=1');
    exit;
}

$error = $result['error'];
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
        <?php
        require_once __DIR__ . '/../_inc/species-form.php';
        render_species_form(
            action: 'lepido_sent.php',
            entityLabel: 'un lépidoptère',
            nameExample: 'Paon du jour',
            nameLatinExample: 'Aglais io',
            familleExample: 'Nymphalidé',
            descFields: $descFields,
            error: $error
        );
        ?>
    </main>
    <?php render_footer(); ?>
</body>
</html>
