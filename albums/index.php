<?php
$albumsDir = __DIR__ . '/albums';
$albums = array_filter(glob($albumsDir . '/*'), 'is_dir');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mes Albums Photos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>📸 Mes Albums</h1>
    <div class="albums">
    <?php foreach ($albums as $albumPath): 
        $albumName = basename($albumPath); ?>
        <a href="album.php?name=<?= urlencode($albumName) ?>" class="album">
        <div class="album-name"><?= htmlspecialchars($albumName) ?></div>
        </a>
    <?php endforeach; ?>
    </div>
</body>
</html>