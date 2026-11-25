<?php require_once '_inc/config.php'; ?>
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

    <title>Lucas LAPLANCHE - Portfolio Naturaliste</title>

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
    <link rel="manifest" href="/site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="_css/main.css">


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
        <div class="profile-header">
            <div>
                <h1>Lucas LAPLANCHE</h1>
                <span class="subtitle">Observations naturalistes</span>
            </div>
        </div>
    </header>

    <main>
        <section class="intro">
            Naturaliste amateur et photographe, je liste et documente mes découvertes parmi les <strong>oiseaux</strong> et les <strong>lépidoptères</strong>.
        </section>

        <div class="section-label">
            <span>Observations</span>
            <div class="line"></div>
        </div>

        <div class="grid">
            <a href="oiseaux/oiseaux.php" class="card">
                <h3>🐦 Oiseaux -
                    <span>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM oiseaux WHERE image_path IS NOT NULL AND image_path != ''");
                        $stmt->execute();
                        $count = $stmt->fetchColumn();
                        echo $count;
                        ?>
                    </span>
                </h3>
                <!--<p>Description</p>-->
                <div class="card-status">
                    <span class="status-dot"></span> STATUT : EN COURS DE RÉDACTION
                </div>
            </a>

            <a href="lepido/lepido.php" class="card">
                <h3>🦋 Lépidoptères -
                    <span>
                        <?php
                        $stmt = $conn->prepare("SELECT COUNT(*) FROM lepido");
                        $stmt->execute();
                        $count = $stmt->fetchColumn();
                        echo $count;
                        ?>
                    </span>
                </h3>
                <!--<p>Description</p>-->
                <div class="card-status">
                    <span class="status-dot"></span> STATUT : RÉDIGÉ
                </div>
            </a>
        </div>
    </main>

    <footer>
        <p>&copy; 2026 — <a href="https://nature.lucaslaplanche.fr/">Lucas LAPLANCHE</a></p>
    </footer>

</body>

</html>