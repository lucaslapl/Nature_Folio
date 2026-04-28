<?php
include("../_inc/config.php");
?>
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

	<title>Lucas LAPLANCHE - Oiseaux 🦤</title>

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
    <link rel="stylesheet" type="text/css" href="../_css/simple-lightbox.css">
	<link rel="stylesheet" href="../_css/main.css">
	<link rel="stylesheet" href="_css/oiseaux.css">

	<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-78XNH6CDJQ"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-78XNH6CDJQ');
</script>
</head>
<body>

<nav>
    <div class="flex">
        <img class="nav-avatar" src="../_imgs/favicon2857.png" alt="Petite icône photo de profil Lucas LAPLANCHE">
        <a href="https://nature.lucaslaplanche.fr/">Lucas LAPLANCHE</a>
        <span style="margin: 7px 10px;">/</span>
        <a href="https://nature.lucaslaplanche.fr/oiseaux/oiseaux.php">Oiseaux 🦤</a>
    </div>
</nav>

<section id="oiseaux-head">
    <h1>Oiseaux 🦤</h1>
</section>

<section id="oiseaux-list">
	<div class="filters">

	</div>

	<ul>
		<?php 

			$sthandler = $conn->prepare("SELECT * FROM oiseaux ORDER BY nom");
			$sthandler->execute();
			$resultats = $sthandler->fetchAll();

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

				$timestampFirstobs = strtotime($first_obs);
				$timestampDatephoto = strtotime($datephoto);
				$formattedFirstobs = date('d/m/Y', $timestampFirstobs);
				$formattedDatephoto = date('d/m/Y', $timestampDatephoto); 
		?>
			<li id="<?= $id ?>">
				<div class="flex justify-between">
					<div class="birdname"><b><?= $name ?></b> - <i><?= $name_latin ?></i></div>
					<div class="famille"><span><?= $famille ?></span></div>
				</div>
				<div class="birdcontent">
					<i class="fa-solid fa-angles-right fa-2x" title="Fermer"></i>
					<div class="birdinfo">
						<h1><?= $name ?></h1>
						<p><i class="fa-regular fa-eye"></i> <b>Rareté de l'espèce :</b> <span><?= $rarete ?></span></p>
						<br>
						<div class="bird-desc">
							<p><i class="fa-solid fa-globe"></i> <b>Répartition :</b> <?= $repartition ?></p>
							<p><i class="fa-solid fa-align-justify"></i> <b>Description :</b> <?= $description ?></p>
							<p><i class="fa-regular fa-file-lines"></i> Fiche <a href="<?= $ficheinpn ?>">INPN<i class="fa-solid fa-up-right-from-square"></i></a></p>
						</div>
						<br>
						<p><i class="fa-solid fa-calendar-days"></i> <b>Première observation :</b> <?= $formattedFirstobs ?></p>
						<hr>
						<div class="img-status">
							<a href="<?= $image ?>">
								<img src="<?= $imageMin ?>" alt="<?= $name ?>" title="<?= $name ?>, <?= $lieuphoto ?>, <?= $formattedDatephoto ?>">
							</a>
							<p><?= $lieuphoto ?>, <?= $formattedDatephoto ?></p>
						</div>
					</div>
				</div>
            </li>

        <?php
			}
		?>
	</ul>
</section>

<footer>
    <p>
        <b><a href="https://nature.lucaslaplanche.fr/">Lucas LAPLANCHE</a></b> &copy; 2025 - Tous droits réservés. - <b><a href="../cookies.html">Cookies</a></b>
    </p>
</footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://kit.fontawesome.com/2f306d349c.js" crossorigin="anonymous"></script>
    <!-- <script src="_js/jquery-3.3.1.min.js"></script> -->
	<script src="../_js/simple-lightbox.jquery.js"></script>
	<script>
		$(document).ready(function() {
			var lightbox = $('.birdcontent a').simpleLightbox({
				captions: true,
				showCounter: false,
				nav: false,
				enableKeyboard: false,
				scrollZoom: false
			});
		});
	</script>
	<script src="../_js/main.js"></script>
	
</body>
</html>