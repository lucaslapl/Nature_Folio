<?php require_once __DIR__ . '/../_inc/config.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lépidoptères | Inventaire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../_css/simple-lightbox.css">
    <style>
        :root {
            --bg: #070707;
            --surface: #0f0f0f;
            --text-main: #ffffff;
            --text-muted: #666666;
            --neon-green: #a0ff8e;
            --border: #1a1a1a;
            --row-hover: #141414;
            --transition: all 0.2s ease;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            line-height: 1.6;
        }

        header {
            max-width: 800px;
            margin: 0 auto;
            padding: 4rem 1.5rem 2rem;
        }

        .breadcrumb {
            font-size: 0.7rem;
            color: var(--neon-green);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 0.5rem;
            display: block;
        }

        h1 { font-size: 2rem; font-weight: 700; letter-spacing: -1px; }

        /* Style de la Liste */
        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 1.5rem 5rem;
        }

        .species-list {
            border-top: 1px solid var(--border);
            margin-top: 2rem;
        }

        .species-row {
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border);
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
            cursor: pointer;
            position: relative;
        }

        .species-row:hover {
            background-color: var(--row-hover);
            padding-left: 2rem; /* Petit décalage au survol */
        }

        /* Indicateur néon au survol */
        .species-row::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--neon-green);
            transform: scaleY(0);
            transition: var(--transition);
        }

        .species-row:hover::before {
            transform: scaleY(1);
        }

        .name-group {
            display: flex;
            flex-direction: column;
        }

        .common-name {
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: -0.01em;
        }

        .scientific-name {
            font-family: 'Inter', sans-serif;
            font-style: italic;
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 300;
        }

        .family-tag {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-muted);
            background: rgba(255,255,255,0.03);
            padding: 4px 10px;
            border-radius: 4px;
            border: 1px solid var(--border);
            transition: var(--transition);
        }

        .species-row:hover .family-tag {
            color: var(--neon-green);
            border-color: rgba(160, 255, 142, 0.3);
            background: rgba(160, 255, 142, 0.05);
        }

        /* Petit chevron discret */
        .arrow {
            margin-left: 1.5rem;
            font-size: 0.8rem;
            color: var(--border);
            transition: var(--transition);
        }

        .species-row:hover .arrow {
            color: var(--neon-green);
            transform: translateX(5px);
        }

        .species-row.active .arrow {
            transform: rotate(90deg);
            color: var(--neon-green);
        }

        /* Détails (Cachés par défaut) */
        .species-details {
            max-height: 0;
            overflow: hidden;
            transition: var(--transition);
            background-color: #0c0c0c;
            opacity: 0;
        }

        .species-item.open .species-details {
            max-height: 500px; /* Valeur arbitraire haute pour l'animation */
            opacity: 1;
            border-top: 1px solid #1a1a1a;
        }

        .details-inner {
            padding: 2rem;
            display: grid;
            grid-template-columns: 180px 1fr;
            gap: 2rem;
        }

        .detail-img {
            width: 100%;
            border-radius: 8px;
            border: 1px solid var(--border);
            filter: grayscale(0.2);
        }

        .detail-info h4 {
            font-size: 0.7rem;
            text-transform: uppercase;
            color: var(--neon-green);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .detail-info p {
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            font-size: 0.8rem;
        }

        .meta-item span { display: block; color: var(--text-muted); font-size: 0.65rem; text-transform: uppercase; }

        @media (max-width: 600px) {
            .details-inner { grid-template-columns: 1fr; }
            .detail-img { height: 150px; object-fit: cover; }
        }

    </style>
</head>
<body>

<header>
    <span class="breadcrumb">Base de données</span>
    <h1>Lépidoptères</h1>
</header>

<main>
    <div class="species-list">

    		<?php 

			$sthandler = $conn->prepare("SELECT * FROM lepido ORDER BY nom");
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
        
        <div id="<?= $id ?>" class="species-item">
            <div class="species-row" onclick="toggleSpecies(this)">
                <div class="name-group">
                    <span class="common-name"><?= $name ?></span>
                    <span class="scientific-name"><?= $name_latin ?></span>
                </div>
                <div style="display: flex; align-items: center;">
                    <span class="family-tag"><?= $famille ?></span>
                    <span class="arrow">▶</span>
                </div>
            </div>
            <div class="species-details">
                <div class="details-inner">
                    <a href="<?= $image ?>">
						<img src="<?= $imageMin ?>" alt="<?= $name ?>" title="<?= $name ?>, <?= $lieuphoto ?>, <?= $formattedDatephoto ?>" class="detail-img">
					</a>
                    <div class="detail-info">
                        <h4>Description & Observations</h4>
                        <p><?= $repartition ?></p>
                        <p><?= $description ?></p>
                        <p><a href="<?= $ficheinpn ?>" target="_blank" style="color: var(--neon-blue); text-decoration: underline;">Fiche INPN</a></p>
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
    <script>
        function toggleSpecies(element) {
            // Récupérer le parent .species-item
            const parent = element.parentElement;
            
            // Fermer les autres (optionnel, si tu veux un vrai accordéon)
            /*
            document.querySelectorAll('.species-item').forEach(item => {
                if(item !== parent) item.classList.remove('open');
                if(item !== parent) item.querySelector('.species-row').classList.remove('active');
            });
            */

            // Basculer la classe sur la ligne et le parent
            element.classList.toggle('active');
            parent.classList.toggle('open');
        }

        $(document).ready(function() {
			var lightbox = $('.details-inner a').simpleLightbox({
				captions: true,
				showCounter: false,
				nav: false,
				enableKeyboard: false,
				scrollZoom: false
			});
		});
    </script>

</body>
</html>