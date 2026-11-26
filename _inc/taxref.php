<?php

declare(strict_types=1);

/**
 * Recherche dans l'extrait TAXREF local (_data/taxref_fr.csv).
 *
 * L'extrait est généré par _data/build_taxref_extract.php à partir du TAXREF v18
 * de l'INPN (oiseaux + papillons de jour présents en France métropolitaine).
 */

/**
 * Charge l'extrait CSV (mis en cache statique pour la requête courante).
 *
 * @return array<int, array<string, string>>
 */
function taxref_rows(): array
{
    static $rows = null;
    if ($rows !== null) {
        return $rows;
    }

    $rows = [];
    $path = __DIR__ . '/../_data/taxref_fr.csv';
    $h = fopen($path, 'r');
    if (!$h) {
        return $rows;
    }
    fgetcsv($h, 0, ';'); // en-tête
    while (($r = fgetcsv($h, 0, ';')) !== false) {
        if (count($r) < 12) {
            continue;
        }
        $rows[] = [
            'cd_nom'   => $r[0],
            'cd_ref'   => $r[1],
            'lb_nom'   => trim($r[2], '"'),
            'nom_valide' => trim($r[3], '"'),
            'nom_vern' => $r[4],
            'famille'  => $r[5],
            'ordre'    => $r[6],
            'classe'   => $r[7],
            'rang'     => $r[8],
            'fr'       => $r[9],
            'url_inpn' => $r[10],
            'groupe'   => $r[11],
        ];
    }
    fclose($h);
    return $rows;
}

/**
 * Normalise une chaîne pour la comparaison (minuscules, sans accents).
 */
function taxref_norm(string $s): string
{
    $s = mb_strtolower(trim($s));
    $t = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s);
    return $t !== false ? $t : $s;
}

/**
 * Nom valide sans l'auteur (ex: "Parus major Linnaeus, 1758" -> "Parus major").
 */
function taxref_short_name(string $nomValide): string
{
    return trim(preg_replace('/\s+(Linnaeus|\(Linnaeus.*|[A-Z][a-z]+,?\s*\d{4}\)?)$/u', '', $nomValide) ?? $nomValide);
}

/**
 * Affichage "joli" d'un nom vernaculaire TAXREF : "Paon-du-jour (Le)" -> "Paon du jour".
 */
function taxref_pretty_vern(string $vern): string
{
    $v = preg_replace('/\s*\((Le|La|Les|L\')\s*\)\s*$/iu', '', $vern) ?? $vern;
    $v = str_replace('-', ' ', $v);
    return trim($v);
}

/**
 * Famille affichée selon le groupe (noms français usuels pour les lépidoptères).
 */
function taxref_famille_display(array $row): string
{
    static $mapLepido = [
        'Nymphalidae'  => 'Nymphalidé',
        'Papilionidae' => 'Papilionidé',
        'Pieridae'     => 'Piéridé',
        'Lycaenidae'   => 'Lycénidé',
        'Riodinidae'   => 'Riodinidé',
        'Hesperiidae'  => 'Hespéridé',
    ];
    if ($row['groupe'] === 'lepido') {
        return $mapLepido[$row['famille']] ?? $row['famille'];
    }
    return $row['famille'];
}

/**
 * Recherche par nom latin, nom vernaculaire ou cd_nom (ou URL INPN contenant cd_nom).
 *
 * @return array<int, array<string, string>> résultats dédupliqués par cd_ref
 */
function taxref_search(string $q, ?string $groupe = null, int $limit = 8): array
{
    $q = trim($q);
    if ($q === '') {
        return [];
    }

    // Extrait un cd_nom d'une URL INPN ou d'un nombre saisi directement
    $cd = null;
    if (preg_match('#cd_nom/(\d+)#', $q, $m)) {
        $cd = $m[1];
    } elseif (preg_match('#^\d+$#', $q)) {
        $cd = $q;
    }

    $qn = taxref_norm($q);
    $results = [];
    $seen = [];

    foreach (taxref_rows() as $row) {
        if ($groupe !== null && $groupe !== '' && $row['groupe'] !== $groupe) {
            continue;
        }

        $match = false;
        if ($cd !== null && ($row['cd_nom'] === $cd || $row['cd_ref'] === $cd)) {
            $match = true;
        } else {
            $latin = taxref_norm($row['lb_nom']);
            $valide = taxref_norm(taxref_short_name($row['nom_valide']));
            $vern = taxref_norm($row['nom_vern']);
            if ($latin === $qn || $valide === $qn || $vern === $qn) {
                $match = true; // exact
            } elseif ($cd === null && (str_starts_with($latin, $qn) || str_starts_with($vern, $qn))) {
                $match = true; // préfixe
            }
        }

        if (!$match) {
            continue;
        }

        // Dédoublonne par cd_ref en privilégiant le nom valide (cd_nom == cd_ref)
        $key = $row['cd_ref'] . '|' . $row['groupe'];
        if (isset($seen[$key])) {
            if ($row['cd_nom'] === $row['cd_ref']) {
                $results[$seen[$key]] = $row; // remplace le synonyme par le nom valide
            }
            continue;
        }
        $seen[$key] = count($results);
        $results[] = $row;
        if (count($results) >= $limit * 4) {
            break;
        }
    }

    // Trie : correspondances exactes d'abord
    usort($results, function ($a, $b) use ($qn, $cd) {
        $score = function ($r) use ($qn, $cd) {
            if ($cd !== null && ($r['cd_nom'] === $cd || $r['cd_ref'] === $cd)) return 0;
            $latin = taxref_norm($r['lb_nom']);
            $vern = taxref_norm($r['nom_vern']);
            if ($latin === $qn || $vern === $qn) return 1;
            return 2;
        };
        return $score($a) <=> $score($b);
    });

    return array_slice(array_map(function ($r) {
        return [
            'cd_nom'   => $r['cd_nom'],
            'cd_ref'   => $r['cd_ref'],
            'nom'      => taxref_short_name($r['nom_valide']),
            'nom_vern' => taxref_pretty_vern($r['nom_vern']),
            'famille'  => taxref_famille_display($r),
            'rang'     => $r['rang'],
            'fr'       => $r['fr'],
            'url_inpn' => $r['url_inpn'],
            'groupe'   => $r['groupe'],
        ];
    }, $results), 0, $limit);
}
