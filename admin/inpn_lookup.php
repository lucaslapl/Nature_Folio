<?php

declare(strict_types=1);

/**
 * Endpoint JSON (admin uniquement) : recherche dans l'extrait TAXREF local.
 *
 * GET admin/inpn_lookup.php?q=Parus%20major&groupe=oiseaux
 *   q      : nom latin, nom vernaculaire, cd_nom ou URL INPN (cd_nom extrait)
 *   groupe : "oiseaux" | "lepido" (optionnel, filtre l'extrait)
 *
 * Réponse : { "results": [ { cd_nom, cd_ref, nom, nom_vern, famille, rang, fr, url_inpn, groupe } ] }
 */

require_once __DIR__ . '/../_inc/config.php';
require_once __DIR__ . '/../_inc/functions.php';
require_once __DIR__ . '/../_inc/auth.php';
require_once __DIR__ . '/../_inc/taxref.php';

require_login();

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

$q = (string) ($_GET['q'] ?? '');
$groupe = (string) ($_GET['groupe'] ?? '');
if (!in_array($groupe, ['oiseaux', 'lepido'], true)) {
    $groupe = '';
}

echo json_encode(['results' => taxref_search($q, $groupe !== '' ? $groupe : null)], JSON_UNESCAPED_UNICODE);
