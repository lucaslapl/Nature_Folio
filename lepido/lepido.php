<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';

$rows = get_species($conn, 'lepido');

$familyColors = [
    'Hespéridé'   => '230, 126, 34',
    'Papilionidé' => '155, 89, 182',
    'Piéridé'     => '176, 141, 10',
    'Riodinidé'   => '26, 188, 156',
    'Lycénidé'    => '52, 152, 219',
    'Nymphalidé'  => '192, 57, 43',
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Lépidoptères — ' . SITE_NAME,
        'description' => 'Observations de lépidoptères (papillons de jour) de Lucas LAPLANCHE : espèces vues et photographiées, avec fiches INPN.',
        'path' => 'lepido/lepido.php',
    ]); ?>
</head>
<body>

    <?php render_header('Lépidoptères', false, 'Observations'); ?>

    <main class="container container-narrow">
        <div class="search-container">
            <input type="search" id="searchInput" placeholder="Rechercher une espèce (nom commun ou latin)..." oninput="filterSpecies()" aria-label="Rechercher une espèce">
        </div>

        <div class="species-list" id="speciesList">
            <?php render_species_list($rows, $familyColors); ?>
        </div>

        <p id="noResult" class="no-result" hidden>Aucune espèce ne correspond à la recherche.</p>
    </main>

    <?php render_footer(); ?>

    <script src="<?= asset_url('_js/main.js', 'lepido/lepido.php') ?>" defer></script>
</body>
</html>
