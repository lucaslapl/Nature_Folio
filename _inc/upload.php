<?php

declare(strict_types=1);

/**
 * Upload sécurisé d'une image.
 *
 * - vérifie que le fichier a bien été uploadé (UPLOAD_ERR_OK)
 * - vérifie la taille réelle
 * - vérifie l'extension (liste blanche)
 * - vérifie le contenu réel via getimagesize()
 * - génère un nom de fichier aléatoire (jamais le nom d'origine)
 *
 * @return string|null chemin relatif de l'image enregistrée, ou null + message d'erreur dans $error
 */
function secure_upload(array $file, string $destFolder, ?string &$error): ?string
{
    $error = null;

    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        $error = 'Erreur lors de l\'envoi du fichier (code ' . ($file['error'] ?? -1) . ').';
        return null;
    }

    if ($file['size'] > UPLOAD_MAX_BYTES) {
        $error = 'Le fichier dépasse la taille maximale autorisée (' . round(UPLOAD_MAX_BYTES / 1024 / 1024, 1) . ' Mo).';
        return null;
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, UPLOAD_ALLOWED_EXT, true)) {
        $error = 'Extension non autorisée. Formats acceptés : ' . implode(', ', UPLOAD_ALLOWED_EXT) . '.';
        return null;
    }

    // Vérifie que c'est réellement une image (et pas un script renommé)
    $info = @getimagesize($file['tmp_name']);
    if ($info === false) {
        $error = 'Le fichier n\'est pas une image valide.';
        return null;
    }

    if (!is_dir($destFolder)) {
        mkdir($destFolder, 0755, true);
    }

    $newName = bin2hex(random_bytes(8)) . '.' . $ext;
    $dest = $destFolder . $newName;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        $error = 'Impossible d\'enregistrer le fichier sur le serveur.';
        return null;
    }

    // Chemin renvoyé = dossier + nom (le chemin BDD est retravaillé par l'appelant)
    return $dest;
}

/**
 * Upload optionnel (édition) : si aucun fichier n'est envoyé, $kept = true
 * et on conserve l'image actuelle.
 */
function secure_upload_optional(array $file, string $destFolder, ?string &$error, ?bool &$kept): ?string
{
    $kept = false;
    if (!isset($file['tmp_name']) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $kept = true;
        return null;
    }
    return secure_upload($file, $destFolder, $error);
}

/**
 * Construit la description textuelle à partir des champs guidés du formulaire.
 * Chaque champ non vide devient une ligne « Label : valeur ».
 *
 * @param array<string, string> $descLabels clé => libellé (ex: 'taille' => 'Taille / envergure')
 * @param array<string, mixed> $post
 */
function build_description(array $post, array $descLabels): string
{
    $parts = [];
    foreach ($descLabels as $key => $label) {
        $val = trim((string) ($post['desc'][$key] ?? ''));
        if ($val !== '') {
            $parts[] = $label . ' : ' . $val;
        }
    }
    return implode("\n", $parts);
}

/**
 * Handler générique d'enregistrement d'espèce : INSERT (ajout) ou UPDATE (édition).
 * Les données sont stockées BRUTES en BDD (l'échappement se fait à l'affichage).
 *
 * @param array<string, string> $descLabels clés des champs guidés => libellés (pour la description)
 * @param int|null $id id de l'espèce en édition, null en ajout
 * @param array<string, mixed>|null $current row actuelle en édition (pour conserver les images si non remplacées)
 * @return array{ok:bool, error:?string}
 */
function handle_species_save(PDO $conn, string $table, array $post, array $files, array $descLabels, ?int $id = null, ?array $current = null): array
{
    if (!in_array($table, ['oiseaux', 'lepido'], true)) {
        return ['ok' => false, 'error' => 'Table inconnue.'];
    }

    $required = ['name', 'namelatin', 'famille'];
    foreach ($required as $field) {
        if (trim($post[$field] ?? '') === '') {
            return ['ok' => false, 'error' => 'Le champ "' . $field . '" est obligatoire.'];
        }
    }

    $editing = $id !== null;

    if (!$editing && (empty($files['imgMain']['tmp_name']) || empty($files['imgMini']['tmp_name']))) {
        return ['ok' => false, 'error' => 'La photo principale et la miniature sont obligatoires.'];
    }

    // Dossier filesystem des photos : relatif à la page handler
    // (ajout depuis oiseaux/lepido/ -> '_photos/', édition depuis admin/ -> '../<table>/_photos/')
    $fsFolder = ($editing ? '../' : '') . $table . '/_photos/';

    $error = null;
    $kept = false;

    // Chemins stockés en BDD, relatifs à la page d'affichage (oiseaux/ ou lepido/)
    $imageDb = (string) ($current['image_path'] ?? '');
    $imageMinDb = (string) ($current['image_path_min'] ?? '');

    $image = secure_upload_optional($files['imgMain'] ?? [], $fsFolder, $error, $kept);
    if ($image === null && !$kept) {
        return ['ok' => false, 'error' => 'Photo principale : ' . $error];
    }
    if ($image !== null) {
        $imageDb = '_photos/' . basename($image);
    }

    $imageMin = secure_upload_optional($files['imgMini'] ?? [], $fsFolder, $error, $kept);
    if ($imageMin === null && !$kept) {
        return ['ok' => false, 'error' => 'Miniature : ' . $error];
    }
    if ($imageMin !== null) {
        $imageMinDb = '_photos/' . basename($imageMin);
    }

    if (!$editing && ($imageDb === '' || $imageMinDb === '')) {
        return ['ok' => false, 'error' => 'La photo principale et la miniature sont obligatoires.'];
    }

    $params = [
        ':nom' => trim($post['name']),
        ':nom_latin' => trim($post['namelatin']),
        ':famille' => trim($post['famille']),
        ':repartition' => trim($post['repartition'] ?? ''),
        ':description' => build_description($post, $descLabels),
        ':premiere_obs' => ($post['first-obs'] ?? '') ?: null,
        ':lien_inpn' => trim($post['lien-inpn'] ?? ''),
        ':image_path' => $imageDb,
        ':image_path_min' => $imageMinDb,
        ':date_obs' => ($post['date-photo'] ?? '') ?: null,
        ':lieu_obs' => trim($post['lieu-photo'] ?? ''),
    ];

    if ($editing) {
        $sql = "UPDATE `$table` SET
            nom = :nom, nom_latin = :nom_latin, famille = :famille, repartition = :repartition,
            description = :description, premiere_obs = :premiere_obs, lien_inpn = :lien_inpn,
            image_path = :image_path, image_path_min = :image_path_min, date_obs = :date_obs, lieu_obs = :lieu_obs
            WHERE id = :id";
        $params[':id'] = $id;
    } else {
        $sql = "INSERT INTO `$table`
            (nom, nom_latin, famille, repartition, description, premiere_obs, lien_inpn, image_path, image_path_min, date_obs, lieu_obs)
            VALUES
            (:nom, :nom_latin, :famille, :repartition, :description, :premiere_obs, :lien_inpn, :image_path, :image_path_min, :date_obs, :lieu_obs)";
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
    } catch (PDOException $e) {
        error_log(($editing ? 'Update' : 'Insert') . ' failed: ' . $e->getMessage());
        return ['ok' => false, 'error' => 'Erreur lors de l\'enregistrement en base de données.'];
    }

    return ['ok' => true, 'error' => null];
}

/**
 * Handler d'ajout d'espèce : délègue à handle_species_save (rétrocompatible).
 *
 * @param array<string, string> $descLabels
 * @return array{ok:bool, error:?string}
 */
function handle_species_insert(PDO $conn, string $table, array $post, array $files, array $descLabels): array
{
    return handle_species_save($conn, $table, $post, $files, $descLabels);
}
