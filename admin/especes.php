<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';

require_login();

$table = $_GET['table'] ?? 'oiseaux';
if (!in_array($table, ['oiseaux', 'lepido'], true)) {
    $table = 'oiseaux';
}
$filtre = $_GET['filtre'] ?? 'tout'; // 'tout' | 'incomplets'
$label = $table === 'lepido' ? 'Lépidoptères' : 'Oiseaux';

$rows = get_species($conn, $table);

$total = count($rows);
$incomplets = 0;
foreach ($rows as $r) {
    if (species_missing_fields($r) !== []) {
        $incomplets++;
    }
}

if ($filtre === 'incomplets') {
    $rows = array_values(array_filter($rows, fn($r) => species_missing_fields($r) !== []));
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Gestion des ' . mb_strtolower($label) . ' — ' . SITE_NAME,
        'path' => 'admin/especes.php',
    ]); ?>
    <meta name="robots" content="noindex, nofollow">
</head>
<body>

    <?php render_header('Gestion des ' . mb_strtolower($label), false, 'Administration'); ?>

    <main class="container container-narrow">

        <p class="admin-toolbar">
            <a href="especes.php?table=<?= $table ?>&filtre=tout" class="btn-ghost<?= $filtre === 'tout' ? ' active' : '' ?>">Tout (<?= $total ?>)</a>
            <a href="especes.php?table=<?= $table ?>&filtre=incomplets" class="btn-ghost<?= $filtre === 'incomplets' ? ' active' : '' ?>">Incomplets (<?= $incomplets ?>)</a>
            <a href="index.php" class="btn-ghost">&larr; Admin</a>
            <a href="../<?= $table === 'lepido' ? 'lepido/new_lepido.php' : 'oiseaux/new_bird.php' ?>" class="btn-ghost">+ Ajouter</a>
        </p>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Espèce</th>
                    <th>Famille</th>
                    <th>Complétude</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <?php $missing = species_missing_fields($row); ?>
                <tr>
                    <td>
                        <strong><?= e($row['nom']) ?></strong><br>
                        <span class="scientific-name"><?= e($row['nom_latin']) ?></span>
                    </td>
                    <td><?= e($row['famille']) ?></td>
                    <td>
                        <?php if ($missing === []): ?>
                            <span class="badge badge-ok">Complète</span>
                        <?php else: ?>
                            <span class="badge badge-wip" title="<?= e_attr(implode(', ', $missing)) ?>">Incomplète — <?= count($missing) ?> champ<?= count($missing) > 1 ? 's' : '' ?></span>
                        <?php endif; ?>
                    </td>
                    <td><a href="edit_espece.php?table=<?= $table ?>&id=<?= (int) $row['id'] ?>" class="btn-ghost">Modifier</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($rows === []): ?>
            <p class="no-result">Aucune espèce dans cette liste.</p>
        <?php endif; ?>

    </main>

    <?php render_footer(); ?>

</body>
</html>
