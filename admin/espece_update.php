<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/upload.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit'])) {
    header('Location: index.php');
    exit;
}

$table = $_POST['table'] ?? '';
$id = (int) ($_POST['id'] ?? 0);

if (!in_array($table, ['oiseaux', 'lepido'], true) || $id <= 0) {
    header('Location: index.php');
    exit;
}

$current = get_species_by_id($conn, $table, $id);
if (!$current) {
    header('Location: especes.php?table=' . $table);
    exit;
}

$group = $table === 'lepido' ? 'lepido' : 'oiseaux';
$descFields = desc_fields_for($group);
$descLabels = array_map(fn($f) => $f['label'], $descFields);

$result = handle_species_save($conn, $table, $_POST, $_FILES, $descLabels, $id, $current);

if ($result['ok']) {
    header('Location: edit_espece.php?table=' . $table . '&id=' . $id . '&success=1');
    exit;
}

// En cas d'erreur, on réaffiche le formulaire d'édition avec le message
$error = $result['error'];
$success = null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Modifier ' . $current['nom'] . ' — ' . SITE_NAME,
        'path' => 'admin/edit_espece.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>
    <?php render_header('Modifier : ' . $current['nom'], false, 'Administration'); ?>
    <main class="container container-narrow">
        <?php
        require_once __DIR__ . '/../_inc/species-form.php';
        render_species_form(
            action: 'espece_update.php',
            entityLabel: $group === 'lepido' ? 'un lépidoptère' : 'un oiseau',
            nameExample: $group === 'lepido' ? 'Paon du jour' : 'Mésange charbonnière',
            nameLatinExample: $group === 'lepido' ? 'Aglais io' : 'Parus major',
            familleExample: $group === 'lepido' ? 'Nymphalidé' : 'Paridae',
            descFields: $descFields,
            group: $group,
            values: $current,
            edit: true,
            imgBase: '../' . $table . '/',
            error: $error
        );
        ?>
    </main>
    <?php render_footer(); ?>
    <script src="../_js/main.js" defer></script>
</body>
</html>
