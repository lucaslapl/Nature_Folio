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

    // Chemin relatif depuis la racine du site (ex: oiseaux/_photos/xxx.jpg)
    return $dest;
}

/**
 * Handler générique d'ajout d'espèce : upload des 2 images + INSERT.
 * Les données sont stockées BRUTES en BDD (l'échappement se fait à l'affichage).
 *
 * @return array{ok:bool, error:?string}
 */
function handle_species_insert(PDO $conn, string $table, array $post, array $files): array
{
    $required = ['name', 'namelatin', 'famille'];
    foreach ($required as $field) {
        if (trim($post[$field] ?? '') === '') {
            return ['ok' => false, 'error' => 'Le champ "' . $field . '" est obligatoire.'];
        }
    }

    if (empty($files['imgMain']['tmp_name']) || empty($files['imgMini']['tmp_name'])) {
        return ['ok' => false, 'error' => 'La photo principale et la miniature sont obligatoires.'];
    }

    // Dossier filesystem relatif depuis la page handler (oiseaux/ ou lepido/)
    $fsFolder = '_photos/';

    $error = null;
    $image = secure_upload($files['imgMain'], $fsFolder, $error);
    if ($image === null) {
        return ['ok' => false, 'error' => 'Photo principale : ' . $error];
    }
    $imageMin = secure_upload($files['imgMini'], $fsFolder, $error);
    if ($imageMin === null) {
        return ['ok' => false, 'error' => 'Miniature : ' . $error];
    }

    // Chemins stockés en BDD relatifs à la page d'affichage (oiseaux/ ou lepido/)
    $imageDb = $fsFolder . basename($image);
    $imageMinDb = $fsFolder . basename($imageMin);

    $sql = "INSERT INTO `$table`
        (nom, nom_latin, famille, rarete, repartition, description, premiere_obs, lien_inpn, image_path, image_path_min, date_obs, lieu_obs)
        VALUES
        (:nom, :nom_latin, :famille, :rarete, :repartition, :description, :premiere_obs, :lien_inpn, :image_path, :image_path_min, :date_obs, :lieu_obs)";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nom' => trim($post['name']),
            ':nom_latin' => trim($post['namelatin']),
            ':famille' => trim($post['famille']),
            ':rarete' => $post['rarete'] ?? 'Commune',
            ':repartition' => trim($post['repartition'] ?? ''),
            ':description' => trim($post['description'] ?? ''),
            ':premiere_obs' => $post['first-obs'] ?: null,
            ':lien_inpn' => trim($post['lien-inpn'] ?? ''),
            ':image_path' => $imageDb,
            ':image_path_min' => $imageMinDb,
            ':date_obs' => $post['date-photo'] ?: null,
            ':lieu_obs' => trim($post['lieu-photo'] ?? ''),
        ]);
    } catch (PDOException $e) {
        error_log('Insert failed: ' . $e->getMessage());
        return ['ok' => false, 'error' => 'Erreur lors de l\'enregistrement en base de données.'];
    }

    return ['ok' => true, 'error' => null];
}
