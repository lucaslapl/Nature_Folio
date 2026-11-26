<?php

declare(strict_types=1);

/**
 * Script CLI de génération de l'extrait TAXREF utilisé par le pré-remplissage INPN.
 *
 * Usage :
 *   php _data/build_taxref_extract.php /chemin/vers/TAXREFv18.txt
 *
 * Génère _data/taxref_fr.csv (à côté de ce script) à partir du TAXREF v18 complet :
 *   - oiseaux        : GROUP2_INPN = "Oiseaux" et présents en France métropolitaine (FR = "P")
 *   - papillons de jour : GROUP3_INPN = "Lépidoptères", FR = "P", famille parmi les
 *     6 familles de rhopalocères (Papilionidae, Pieridae, Nymphalidae, Lycaenidae,
 *     Riodinidae, Hesperiidae)
 *
 * Source TAXREF (licence ouverte INPN/MNHN) : https://inpn.mnhn.fr/telechargement/referentielEspece/taxref
 * Le fichier complet (~300 Mo) n'est PAS versionné ; seul l'extrait CSV l'est.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit("CLI uniquement.\n");
}

$src = $argv[1] ?? null;
if (!$src || !is_file($src)) {
    fwrite(STDERR, "Usage: php build_taxref_extract.php /chemin/vers/TAXREFv18.txt\n");
    exit(1);
}

$diurnes = ['Papilionidae', 'Pieridae', 'Nymphalidae', 'Lycaenidae', 'Riodinidae', 'Hesperiidae'];

$outPath = __DIR__ . '/taxref_fr.csv';
$in = fopen($src, 'r');
$out = fopen($outPath, 'w');
if (!$in || !$out) {
    fwrite(STDERR, "Impossible d'ouvrir les fichiers.\n");
    exit(1);
}

// En-tête du CSV extrait
fputcsv($out, ['cd_nom', 'cd_ref', 'lb_nom', 'nom_valide', 'nom_vern', 'famille', 'ordre', 'classe', 'rang', 'fr', 'url_inpn', 'groupe'], ';');

$header = fgetcsv($in, 0, "\t");
$count = 0;
while (($row = fgetcsv($in, 0, "\t")) !== false) {
    $classe  = trim($row[2]  ?? '', '"');
    $famille = trim($row[4]  ?? '', '"');
    $group2  = trim($row[8]  ?? '', '"'); // GROUP2_INPN : "Oiseaux", "Insectes", ...
    $group3  = trim($row[9]  ?? '', '"'); // GROUP3_INPN : "Lépidoptères", ...
    $cdNom   = trim($row[10] ?? '', '"');
    $rang    = trim($row[15] ?? '', '"');
    $lbNom   = trim($row[16] ?? '', '"');
    $nomVal  = trim($row[21] ?? '', '"');
    $nomVern = trim($row[22] ?? '', '"');
    $fr      = trim($row[25] ?? '', '"');
    $urlInpn = trim($row[43] ?? '', '"');
    $cdRef   = trim($row[13] ?? '', '"');
    $ordre   = trim($row[3]  ?? '', '"');

    if ($fr !== 'P') {
        continue;
    }

    if ($group2 === 'Oiseaux') {
        $groupe = 'oiseaux';
    } elseif ($group3 === 'Lépidoptères' && in_array($famille, $diurnes, true)) {
        $groupe = 'lepido';
    } else {
        continue;
    }

    // Premier nom vernaculaire uniquement (NOM_VERN liste plusieurs variantes)
    $vern = trim(explode(',', $nomVern)[0] ?? '');

    if ($urlInpn === '') {
        $urlInpn = 'https://inpn.mnhn.fr/espece/cd_nom/' . ($cdRef !== '' ? $cdRef : $cdNom);
    }

    fputcsv($out, [$cdNom, $cdRef, $lbNom, $nomVal, $vern, $famille, $ordre, $classe, $rang, $fr, $urlInpn, $groupe], ';');
    $count++;
}

fclose($in);
fclose($out);

// Tri par groupe puis nom latin
$lines = file($outPath, FILE_IGNORE_NEW_LINES);
$head = array_shift($lines);
sort($lines);
file_put_contents($outPath, $head . "\n" . implode("\n", $lines) . "\n");

echo "Extrait généré : $outPath ($count taxons)\n";
