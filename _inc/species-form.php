<?php

declare(strict_types=1);

/**
 * Template commun du formulaire d'ajout d'espèce (oiseaux / lépidoptères).
 *
 * Variables attendues :
 * @var string $action      action du formulaire (ex: 'bird_sent.php')
 * @var string $entityLabel libellé de l'entité (ex: 'oiseau', 'papillon')
 * @var string $nameExample exemple de nom commun
 * @var string $nameLatinExample exemple de nom latin
 * @var string $familleExample exemple de famille
 * @var string|null $error  message d'erreur à afficher
 * @var string|null $success message de succès à afficher
 */

function render_species_form(string $action, string $entityLabel, string $nameExample, string $nameLatinExample, string $familleExample, ?string $error = null, ?string $success = null): void
{
    ?>
    <div class="form-card">
        <h2>Ajouter <?= e($entityLabel) ?></h2>

        <?php if ($error): ?><p class="alert"><?= e($error) ?></p><?php endif; ?>
        <?php if ($success): ?><p class="alert success"><?= e($success) ?></p><?php endif; ?>

        <form action="<?= e_attr($action) ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required placeholder="Ex : <?= e_attr($nameExample) ?>">
            </div>

            <div class="form-group">
                <label for="namelatin">Nom latin</label>
                <input type="text" id="namelatin" name="namelatin" required placeholder="Ex : <?= e_attr($nameLatinExample) ?>">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="famille">Famille</label>
                    <input type="text" id="famille" name="famille" required placeholder="Ex : <?= e_attr($familleExample) ?>">
                </div>
                <div class="form-group">
                    <label for="rarete">Rareté</label>
                    <select id="rarete" name="rarete">
                        <option value="Commune">Commune</option>
                        <option value="Peu commune">Peu commune</option>
                        <option value="Rare">Rare</option>
                        <option value="Très rare">Très rare</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="repartition">Répartition</label>
                <textarea id="repartition" name="repartition" rows="3"></textarea>
                <button type="button" class="btn-ghost" id="fillRepartition" data-value="Observable sur tout le territoire métropolitain.">Auto-remplir : territoire complet</button>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3"></textarea>
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="first-obs">Première observation</label>
                    <input type="date" id="first-obs" name="first-obs">
                </div>
                <div class="form-group">
                    <label for="date-photo">Date de la photo</label>
                    <input type="date" id="date-photo" name="date-photo">
                </div>
            </div>

            <div class="form-group">
                <label for="lien-inpn">Fiche INPN (URL)</label>
                <input type="url" id="lien-inpn" name="lien-inpn" placeholder="https://inpn.mnhn.fr/...">
            </div>

            <div class="form-group">
                <label for="lieu-photo">Lieu de la photo</label>
                <input type="text" id="lieu-photo" name="lieu-photo">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="imgMain">Photo principale</label>
                    <input type="file" id="imgMain" name="imgMain" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="imgMini">Miniature</label>
                    <input type="file" id="imgMini" name="imgMini" accept="image/*" required>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-primary">Enregistrer l'espèce</button>
        </form>
    </div>
    <?php
}
