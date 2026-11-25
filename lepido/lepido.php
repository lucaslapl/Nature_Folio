<?php require_once __DIR__ . '/../_inc/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta property="og:url" content="https://nature.lucaslaplanche.fr/">
    <meta property="og:title" content="Lucas LAPLANCHE - Portfolio Naturaliste">
    <meta property="og:description" content="Portfolio naturaliste de Lucas LAPLANCHE. Projets personnels, professionnels, réalisations et observations naturalistes.">
    <meta property="og:image" content="https://nature.lucaslaplanche.fr/_imgs/avatar.jpg">
    <meta property="og:type" content="website">

    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Lucas LAPLANCHE - Portfolio Naturaliste">
    <meta name="twitter:description" content="Site personnel de Lucas LAPLANCHE. Projets personnels, professionnels, réalisations et observations naturalistes.">
    <meta name="twitter:image" content="http://nature.lucaslaplanche.fr/_imgs/avatar.jpg">

    <meta name="author" content="Lucas Laplanche">
    <meta name="description" content="Site personnel de Lucas LAPLANCHE. Projets personnels, professionnels, réalisations et observations naturalistes.">
    <meta name="keywords" content="Lucas LAPLANCHE, portfolio, projets, réalisations, numérique, web, environnement, naturaliste, ornithologie, lépidoptère, oiseaux">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">

    <title>Lucas LAPLANCHE - Lépidoptères 🦋</title>

    <link rel="shortcut icon" href="https://nature.lucaslaplanche.fr/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="https://nature.lucaslaplanche.fr/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://nature.lucaslaplanche.fr/favicon-16x16.png">
    <link rel="icon" type="image/x-icon" href="https://nature.lucaslaplanche.fr/favicon.ico">

    <!-- Apple Touch Icon (iPhone/iPad) -->
    <link rel="apple-touch-icon" href="https://nature.lucaslaplanche.fr/apple-touch-icon.png">

    <!-- Android Chrome -->
    <link rel="icon" type="image/png" sizes="192x192" href="https://nature.lucaslaplanche.fr/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="https://nature.lucaslaplanche.fr/android-chrome-512x512.png">

    <!-- Web App Manifest -->
    <link rel="manifest" href="../site.webmanifest">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../_css/simple-lightbox.css">
    <link rel="stylesheet" type="text/css" href="_css/lepido.css">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-78XNH6CDJQ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-78XNH6CDJQ');
    </script>
</head>

<body>

    <header>
        <a href="../index.php" class="home-link">← Accueil</a>
        <span class="breadcrumb">Base de données</span>
        <h1>Lépidoptères</h1>
    </header>

    <main>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Rechercher une espèce (nom commun ou latin)..." onkeyup="filterSpecies()">
        </div>
        <div class="species-list" id="speciesList">

            <?php

            $sthandler = $conn->prepare("SELECT * FROM lepido ORDER BY nom");
            $sthandler->execute();
            $resultats = $sthandler->fetchAll();

            $familyColors = [
                'Hespéridé'   => '230, 126, 34',   // orange
                'Papilionidé' => '155, 89, 182',   // violet
                'Piéridé'     => '241, 196, 15',   // jaune
                'Riodinidé'   => '26, 188, 156',   // teal
                'Lycénidé'    => '52, 152, 219',   // bleu
                'Nymphalidé'  => '231, 76, 60',    // rouge
            ];
            $defaultColor = '102, 102, 102';

            // Affichage des résultats
            foreach ($resultats as $row) {
                $id = $row["id"];
                $name = $row["nom"];
                $name_latin = $row["nom_latin"];
                $famille = $row["famille"];
                $rarete = $row["rarete"];
                $repartition = $row["repartition"];
                $description = $row["description"];
                $first_obs = $row["premiere_obs"];
                $ficheinpn = $row["lien_inpn"];
                $datephoto = $row["date_obs"];
                $lieuphoto = $row["lieu_obs"];
                $image = $row["image_path"];
                $imageMin = $row["image_path_min"];

                $formattedFirstobs = $first_obs ? date('d/m/Y', strtotime($first_obs)) : '';
                $formattedDatephoto = $datephoto ? date('d/m/Y', strtotime($datephoto)) : '';
            ?>

                <div id="<?= $id ?>" class="species-item">
                    <div class="species-row" onclick="toggleSpecies(this)">
                        <div class="name-group">
                            <span class="common-name"><?= $name ?></span>
                            <span class="scientific-name"><?= $name_latin ?></span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <span class="family-tag" style="--tag-color: <?= $familyColors[$famille] ?? $defaultColor ?>"><?= $famille ?></span>
                            <span class="arrow">▶</span>
                        </div>
                    </div>
                    <div class="species-details">
                        <div class="details-inner">
                            <a href="<?= $image ?>">
                                <img data-src="<?= $imageMin ?>" alt="<?= $name ?>" title="<?= $name ?>, <?= $lieuphoto ?>, <?= $formattedDatephoto ?>" class="detail-img" loading="lazy" decoding="async" onerror="this.style.display='none'">
                            </a>
                            <div class="detail-info">
                                <h4>Description & Observations</h4>
                                <p><?= $repartition ?></p>
                                <p><?= $description ?></p>
                                <?php if ($ficheinpn): ?><p><a href="<?= $ficheinpn ?>" target="_blank" style="color: var(--neon-green); text-decoration: underline;">Fiche INPN</a></p><?php endif; ?>
                                <div class="meta-grid">
                                    <div class="meta-item"><span>Rareté</span><?= $rarete ?></div>
                                    <div class="meta-item"><span>Lieu d'observation</span><?= $lieuphoto ?>, le <?= $formattedDatephoto ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php
            }
            ?>

        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/2f306d349c.js" crossorigin="anonymous"></script>
    <!-- <script src="_js/jquery-3.3.1.min.js"></script> -->
    <script src="../_js/simple-lightbox.jquery.js"></script>
    <script src="../_js/main.js"></script>

    <footer>
        <p>&copy; 2026 — <a href="https://nature.lucaslaplanche.fr/">Lucas LAPLANCHE</a></p>
    </footer>

</body>

</html>