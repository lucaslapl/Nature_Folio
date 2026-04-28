<?php
$albumName = $_GET['name'] ?? '';
$albumPath = __DIR__ . '/albums/' . $albumName;
if (!is_dir($albumPath)) {
  die("Album introuvable");
}
$images = glob($albumPath . '/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($albumName) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <a href="index.php" class="back">← Retour</a>
  <h1><?= htmlspecialchars($albumName) ?></h1>

  <div class="gallery">
    <?php foreach ($images as $index => $img): 
      $imgUrl = 'albums/' . urlencode($albumName) . '/' . rawurlencode(basename($img)); ?>
      <a href="#img<?= $index ?>">
        <img src="<?= $imgUrl ?>" alt="">
      </a>

      <!-- Lightbox -->
      <div class="lightbox" id="img<?= $index ?>">
        <a href="#" class="close">×</a>
        <img src="<?= $imgUrl ?>" alt="">
        <a href="#img<?= $index - 1 ?>" class="nav prev">‹</a>
        <a href="#img<?= $index + 1 ?>" class="nav next">›</a>
      </div>
    <?php endforeach; ?>
  </div>
<script>
document.addEventListener('click', function(e) {
  const lightbox = e.target.closest('.lightbox');
  const img = e.target.closest('.lightbox img');

  // Fermer si clic sur le fond (hors image)
  if (lightbox && !img) {
    window.location.hash = '';
  }
});

document.addEventListener('keydown', function(e) {
  const hash = window.location.hash;
  if (!hash) return;

  const currentId = parseInt(hash.replace('#img', ''), 10);
  const total = document.querySelectorAll('.lightbox').length;

  if (e.key === 'Escape') {
    window.location.hash = '';
  } else if (e.key === 'ArrowLeft') {
    const prev = (currentId - 1 + total) % total;
    window.location.hash = '#img' + prev;
  } else if (e.key === 'ArrowRight') {
    const next = (currentId + 1) % total;
    window.location.hash = '#img' + next;
  }
});

// --- Swipe tactile sur mobile ---
let startX = 0;
let startY = 0;
let endX = 0;
let endY = 0;

document.addEventListener('touchstart', function(e) {
  const touch = e.changedTouches[0];
  startX = touch.screenX;
  startY = touch.screenY;
});

document.addEventListener('touchend', function(e) {
  const touch = e.changedTouches[0];
  endX = touch.screenX;
  endY = touch.screenY;

  const diffX = endX - startX;
  const diffY = endY - startY;

  // Détecte un geste horizontal dominant
  if (Math.abs(diffX) > 50 && Math.abs(diffX) > Math.abs(diffY)) {
    const hash = window.location.hash;
    if (!hash) return;
    const currentId = parseInt(hash.replace('#img', ''), 10);
    const total = document.querySelectorAll('.lightbox').length;

    if (diffX < 0) {
      // Swipe gauche → photo suivante
      const next = (currentId + 1) % total;
      window.location.hash = '#img' + next;
    } else {
      // Swipe droite → photo précédente
      const prev = (currentId - 1 + total) % total;
      window.location.hash = '#img' + prev;
    }
  }
});
</script>



</body>
</html>

