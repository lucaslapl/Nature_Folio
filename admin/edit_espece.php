<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/species-form.php';

require_login();

$table = $_GET['table'] ?? '';
$id = (int) ($_GET['id'] ?? 0);

if (!in_array($table, ['oiseaux', 'lepido'], true) || $id <= 0) {
    header('Location: index.php');
    exit;
}

$row = get_species_by_id($conn, $table, $id);
if (!$row) {
    header('Location: especes.php?table=' . $table);
    exit;
}

$group = $table === 'lepido' ? 'lepido' : 'oiseaux';
$descFields = desc_fields_for($group);

$entityLabel = $group === 'lepido' ? 'un lépidoptère' : 'un oiseau';
$examples = $group === 'lepido'
    ? ['Paon du jour', 'Aglais io', 'Nymphalidé']
    : ['Mésange charbonnière', 'Parus major', 'Paridae'];

$success = isset($_GET['success']) ? 'Modifications enregistrées.' : null;
$error = isset($_GET['error']) ? (string) $_GET['error'] : null;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Modifier ' . $row['nom'] . ' — ' . SITE_NAME,
        'path' => 'admin/edit_espece.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

    <?php render_header('Modifier : ' . $row['nom'], false, 'Administration'); ?>

    <main class="container container-narrow">
        <p class="admin-toolbar">
            <a href="especes.php?table=<?= e_attr($table) ?>" class="btn-ghost">&larr; Liste <?= $group === 'lepido' ? 'lépidoptères' : 'oiseaux' ?></a>
            <a href="../<?= $table ?>/<?= $table === 'lepido' ? 'lepido' : 'oiseaux' ?>.php#espece-<?= (int) $row['id'] ?>" class="btn-ghost" target="_blank">Voir sur le site &#8599;</a>
        </p>

        <?php render_species_form(
            action: 'espece_update.php',
            entityLabel: $entityLabel,
            nameExample: $examples[0],
            nameLatinExample: $examples[1],
            familleExample: $examples[2],
            descFields: $descFields,
            group: $group,
            values: $row,
            edit: true,
            imgBase: '../' . $table . '/',
            error: $error,
            success: $success
        ); ?>

        <p class="back"><a href="logout.php">Se déconnecter</a></p>
    </main>

    <?php render_footer(); ?>

    <script src="../_js/main.js" defer></script>
</body>
</html>
