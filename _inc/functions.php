<?php

declare(strict_types=1);

/**
 * Échappe une valeur pour un affichage HTML sûr (XSS).
 */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Échappe une valeur pour un attribut HTML (href, src, etc.).
 */
function e_attr(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Formate une date SQL (Y-m-d) en d/m/Y. Retourne '' si vide.
 */
function format_date(?string $date): string
{
    if (!$date) {
        return '';
    }
    $ts = strtotime($date);
    return $ts ? date('d/m/Y', $ts) : '';
}

/**
 * Compte les espèces d'une table. Si $withImage, ne compte que celles ayant une photo.
 */
function count_species(PDO $conn, string $table, bool $withImage = false): int
{
    $sql = "SELECT COUNT(*) FROM `$table`";
    if ($withImage) {
        $sql .= " WHERE image_path IS NOT NULL AND image_path != ''";
    }
    return (int) $conn->query($sql)->fetchColumn();
}

/**
 * Récupère toutes les espèces d'une table, triées par nom.
 */
function get_species(PDO $conn, string $table): array
{
    $stmt = $conn->query("SELECT * FROM `$table` ORDER BY nom");
    return $stmt->fetchAll();
}

/**
 * Trame de description guidée du formulaire admin, selon le groupe d'espèces.
 *
 * @return array<string, array{label:string, placeholder:string}>
 */
function desc_fields_for(string $group): array
{
    if ($group === 'lepido') {
        return [
            'envergure'   => ['label' => 'Envergure', 'placeholder' => 'Ex : 30–40 mm'],
            'ailes'       => ['label' => 'Ailes (dessus / dessous)', 'placeholder' => 'Ex : dessus orange tacheté de noir, dessous brun avec un ocelle…'],
            'plantehote'  => ['label' => 'Plante-hôte de la chenille', 'placeholder' => 'Ex : ortie, ronce, plantain…'],
            'periode'     => ['label' => 'Période de vol', 'placeholder' => 'Ex : mai–septembre, une ou deux générations'],
            'habitat'     => ['label' => 'Habitat', 'placeholder' => 'Ex : prairies fleuries, lisières, haies…'],
            'observation' => ['label' => 'Observation personnelle', 'placeholder' => 'Ex : posé sur une lavande, butinant au soleil…'],
        ];
    }

    return [
        'taille'       => ['label' => 'Taille / envergure', 'placeholder' => 'Ex : 15 cm, envergure 24–27 cm'],
        'plumage'      => ['label' => 'Plumage & signes distinctifs', 'placeholder' => 'Ex : calotte noire, joues blanches, ventre jaune…'],
        'chant'        => ['label' => 'Chant & cris', 'placeholder' => 'Ex : ti-ti-ti répété, cri de miaulement…'],
        'habitat'      => ['label' => 'Habitat', 'placeholder' => 'Ex : forêts, parcs, jardins, haies…'],
        'alimentation' => ['label' => 'Régime alimentaire', 'placeholder' => 'Ex : graines en hiver, insectes en été…'],
        'observation'  => ['label' => 'Observation personnelle', 'placeholder' => 'Ex : observé ce jour-là en lisière, en train de chasser…'],
    ];
}

/**
 * Rendu du <head> commun.
 *
 * @param array{title:string, description?:string, path:string, css?:array<string>} $page
 *        path = chemin relatif depuis la racine du site (ex: 'oiseaux/oiseaux.php')
 */
function render_head(array $page): void
{
    $title = $page['title'];
    $description = $page['description'] ?? 'Portfolio naturaliste de Lucas LAPLANCHE — observations d\'oiseaux et de lépidoptères.';
    $path = $page['path'];
    $css = $page['css'] ?? [];

    // Profondeur pour remonter à la racine ('' pour index, '../' pour oiseaux/...)
    $depth = substr_count($path, '/');
    $prefix = $depth > 0 ? str_repeat('../', $depth) : '';

    $canonical = SITE_URL . '/' . $path;
    $cssMain = $prefix . '_css/main.css';
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="author" content="<?= e_attr(SITE_AUTHOR) ?>">
    <meta name="description" content="<?= e_attr($description) ?>">
    <title><?= e($title) ?></title>

    <link rel="canonical" href="<?= e_attr($canonical) ?>">
    <meta property="og:url" content="<?= e_attr($canonical) ?>">
    <meta property="og:title" content="<?= e_attr($title) ?>">
    <meta property="og:description" content="<?= e_attr($description) ?>">
    <meta property="og:image" content="<?= e_attr(SITE_URL . '/_imgs/avatar.jpg') ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e_attr(SITE_NAME) ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="<?= e_attr($title) ?>">
    <meta name="twitter:description" content="<?= e_attr($description) ?>">
    <meta name="twitter:image" content="<?= e_attr(SITE_URL . '/_imgs/avatar.jpg') ?>">

    <link rel="shortcut icon" href="<?= e_attr($prefix) ?>favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= e_attr($prefix) ?>favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= e_attr($prefix) ?>favicon-16x16.png">
    <link rel="apple-touch-icon" href="<?= e_attr($prefix) ?>apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= e_attr($prefix) ?>android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?= e_attr($prefix) ?>android-chrome-512x512.png">
    <link rel="manifest" href="<?= e_attr($prefix) ?>site.webmanifest">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">
    <link rel="stylesheet" href="<?= e_attr($cssMain) ?>">
    <?php foreach ($css as $href): ?>
    <link rel="stylesheet" href="<?= e_attr($prefix . $href) ?>">
    <?php endforeach; ?>

    <!-- Matomo (analytics auto-hébergé, remplace Google Analytics) -->
    <script>
        var _paq = window._paq = window._paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function () {
            var u = "<?= e_attr(MATOMO_URL) ?>/";
            _paq.push(['setTrackerUrl', u + 'matomo.php']);
            _paq.push(['setSiteId', '<?= e_attr(MATOMO_SITE_ID) ?>']);
            var d = document, g = d.createElement('script'), s = d.getElementsByTagName('script')[0];
            g.async = true; g.src = u + 'matomo.js'; s.parentNode.insertBefore(g, s);
        })();
    </script>
    <?php
}

/**
 * Rendu du header de page (titre + lien accueil si sous-page).
 */
function render_header(string $title, bool $isHome = false, string $breadcrumb = ''): void
{
    ?>
    <header class="site-header">
        <div class="container">
            <?php if (!$isHome): ?>
                <a href="<?= $isHome ? '' : '../' ?>index.php" class="home-link">&larr; Accueil</a>
            <?php endif; ?>
            <?php if ($breadcrumb !== ''): ?>
                <span class="breadcrumb"><?= e($breadcrumb) ?></span>
            <?php endif; ?>
            <h1><?= e($title) ?></h1>
            <?php if ($isHome): ?>
                <p class="subtitle">Observations naturalistes</p>
            <?php endif; ?>
        </div>
    </header>
    <?php
}

/**
 * Rendu du footer commun.
 */
function render_footer(): void
{
    ?>
    <footer class="site-footer">
        <div class="container">
            <p>&copy; <?= date('Y') ?> — <a href="<?= e_attr(SITE_URL) ?>/"><?= e(SITE_AUTHOR) ?></a></p>
        </div>
    </footer>
    <?php
}

/**
 * Rendu de la liste des espèces (commune oiseaux / lépidoptères).
 *
 * @param array<int, array<string, mixed>> $rows
 * @param array<string, string> $familyColors  (optionnel) famille => "r, g, b"
 */
function render_species_list(array $rows, array $familyColors = [], bool $skipEmptyImage = false): void
{
    $defaultColor = '107, 114, 128'; // gris par défaut
    foreach ($rows as $row):
        $id = (int) $row['id'];
        $name = (string) $row['nom'];
        $nameLatin = (string) $row['nom_latin'];
        $famille = (string) $row['famille'];
        $repartition = (string) $row['repartition'];
        $description = (string) $row['description'];
        $ficheinpn = $row['lien_inpn'] ?? '';
        $datephoto = format_date($row['date_obs'] ?? null);
        $lieuphoto = (string) $row['lieu_obs'];
        $image = (string) $row['image_path'];
        $imageMin = (string) $row['image_path_min'];

        if ($skipEmptyImage && $image === '') {
            continue;
        }

        $tagColor = $familyColors[$famille] ?? $defaultColor;
        ?>
        <div id="espece-<?= $id ?>" class="species-item">
            <button type="button" class="species-row" onclick="toggleSpecies(this)" aria-expanded="false">
                <span class="name-group">
                    <span class="common-name"><?= e($name) ?></span>
                    <span class="scientific-name"><?= e($nameLatin) ?></span>
                </span>
                <span class="row-right">
                    <span class="family-tag" style="--tag-color: <?= e_attr($tagColor) ?>"><?= e($famille) ?></span>
                    <span class="arrow" aria-hidden="true">&#9656;</span>
                </span>
            </button>
            <div class="species-details">
                <div class="details-inner">
                    <?php if ($image !== ''): ?>
                        <a href="<?= e_attr($image) ?>" class="detail-link" data-caption="<?= e_attr($name . ($lieuphoto !== '' ? ' — ' . $lieuphoto : '') . ($datephoto !== '' ? ', ' . $datephoto : '')) ?>">
                            <img data-src="<?= e_attr($imageMin !== '' ? $imageMin : $image) ?>" alt="<?= e_attr($name) ?>" class="detail-img" loading="lazy" decoding="async" onerror="this.closest('.detail-link').style.display='none'">
                        </a>
                    <?php endif; ?>
                    <div class="detail-info">
                        <?php if ($repartition !== '' || $description !== '' || $ficheinpn !== ''): ?>
                        <h4>Description &amp; observations</h4>
                        <?php if ($repartition !== ''): ?><p><?= e($repartition) ?></p><?php endif; ?>
                        <?php if ($description !== ''): ?><p class="desc"><?= nl2br(e($description)) ?></p><?php endif; ?>
                        <?php if ($ficheinpn !== ''): ?>
                            <p><a href="<?= e_attr($ficheinpn) ?>" target="_blank" rel="noopener" class="inpn-link">Fiche INPN &#8599;</a></p>
                        <?php endif; ?>
                        <?php endif; ?>
                        <div class="meta-grid">
                            <?php if ($lieuphoto !== '' || $datephoto !== ''): ?>
                                <div class="meta-item"><span>Lieu d'observation</span><?= e(trim($lieuphoto . ($datephoto !== '' ? ', le ' . $datephoto : ''), ', ')) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    endforeach;
}
