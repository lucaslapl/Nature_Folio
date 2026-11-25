<?php

declare(strict_types=1);

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';

$rows = get_species($conn, 'oiseaux');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php render_head([
        'title' => 'Oiseaux — ' . SITE_NAME,
        'description' => 'Observations ornithologiques de Lucas LAPLANCHE : espèces vues et photographiées, avec fiches INPN.',
        'path' => 'oiseaux/oiseaux.php',
    ]); ?>
</head>
<body>

    <?php render_header('Oiseaux', false, 'Observations'); ?>

    <main class="container container-narrow">
        <div class="search-container">
            <input type="search" id="searchInput" placeholder="Rechercher une espèce (nom commun ou latin)..." oninput="filterSpecies()" aria-label="Rechercher une espèce">
        </div>

        <div class="species-list" id="speciesList">
            <?php render_species_list($rows, [], true); ?>
        </div>

        <p id="noResult" class="no-result" hidden>Aucune espèce ne correspond à la recherche.</p>
    </main>

    <?php render_footer(); ?>

    <script src="../_js/main.js" defer></script>
</body>
</html>
