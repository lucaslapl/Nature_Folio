<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/upload.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: new_bird.php');
    exit;
}

$descFields = desc_fields_for('oiseaux');
$descLabels = array_map(fn($f) => $f['label'], $descFields);

$result = handle_species_insert($conn, 'oiseaux', $_POST, $_FILES, $descLabels);

if ($result['ok']) {
    header('Location: new_bird.php?success=1');
    exit;
}

// En cas d'erreur, on réaffiche le formulaire avec le message
$error = $result['error'];
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
        <?php
        require_once __DIR__ . '/../_inc/species-form.php';
        render_species_form(
            action: 'bird_sent.php',
            entityLabel: 'un oiseau',
            nameExample: 'Mésange charbonnière',
            nameLatinExample: 'Parus major',
            familleExample: 'Paridae',
            descFields: $descFields,
            error: $error
        );
        ?>
    </main>
    <?php render_footer(); ?>
</body>
</html>
