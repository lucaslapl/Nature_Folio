<?php

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

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
 * Récupère une espèce par son id (table restreinte aux deux tables du site).
 */
function get_species_by_id(PDO $conn, string $table, int $id): ?array
{
    if (!in_array($table, ['oiseaux', 'lepido'], true)) {
        return null;
    }
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

/**
 * Champs attendus pour une fiche complète (hors id/images gérées à part).
 */
function species_missing_fields(array $row): array
{
    $fields = [
        'nom'         => 'Nom',
        'nom_latin'   => 'Nom latin',
        'famille'     => 'Famille',
        'repartition' => 'Répartition',
        'description' => 'Description',
        'lien_inpn'   => 'Fiche INPN',
    ];
    $missing = [];
    foreach ($fields as $key => $label) {
        if (trim((string) ($row[$key] ?? '')) === '') {
            $missing[] = $label;
        }
    }
    if (trim((string) ($row['image_path'] ?? '')) === '') {
        $missing[] = 'Photo';
    }
    return $missing;
}

/**
 * Découpe une description stockée ("Label : valeur\nLabel2 : valeur2…") en champs
 * guidés. Les lignes qui ne correspondent à aucun label connu sont renvoyées dans
 * 'libre' (texte historique non structuré).
 *
 * @param array<string, array{label:string, placeholder:string}> $descFields
 * @return array{fields: array<string, string>, libre: string}
 */
function parse_description(string $description, array $descFields): array
{
    $fields = [];
    $libre = [];
    $labelByKey = [];
    foreach ($descFields as $key => $f) {
        $labelByKey[mb_strtolower($f['label'])] = $key;
    }

    foreach (preg_split('/\r?\n/', $description) ?: [] as $line) {
        $line = trim($line);
        if ($line === '') {
            continue;
        }
        if (preg_match('/^(.+?)\s*:\s*(.*)$/u', $line, $m) && isset($labelByKey[mb_strtolower($m[1])])) {
            $fields[$labelByKey[mb_strtolower($m[1])]] = $m[2];
        } else {
            $libre[] = $line;
        }
    }

    // Le texte libre historique part dans le champ observation s'il est vide
    if ($libre !== [] && empty($fields['observation'])) {
        $fields['observation'] = implode("\n", $libre);
    } elseif ($libre !== []) {
        $fields['observation'] = trim(($fields['observation'] ?? '') . "\n" . implode("\n", $libre));
    }

    return ['fields' => $fields, 'libre' => implode("\n", $libre)];
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
 * URL d'un asset (css/js) avec cache-busting par date de fichier :
 * chaque déploiement change le filemtime, donc l'URL change et le
 * navigateur recharge l'asset malgré le cache long posé par .htaccess.
 */
function asset_url(string $path, string $pagePath): string
{
    $depth = substr_count($pagePath, '/');
    $prefix = $depth > 0 ? str_repeat('../', $depth) : '';
    $file = __DIR__ . '/../' . $path;
    $v = is_file($file) ? filemtime($file) : time();
    return $prefix . $path . '?v=' . $v;
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
    <link rel="stylesheet" href="<?= e_attr(asset_url('_css/main.css', $path)) ?>">
    <?php foreach ($css as $href): ?>
    <link rel="stylesheet" href="<?= e_attr(asset_url($href, $path)) ?>">
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
            <?php if (is_logged_in()): ?>
                <p class="admin-link"><a href="<?= e_attr(SITE_URL) ?>/admin/index.php">Administration</a> · <a href="<?= e_attr(SITE_URL) ?>/admin/logout.php">Se déconnecter</a></p>
            <?php endif; ?>
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
