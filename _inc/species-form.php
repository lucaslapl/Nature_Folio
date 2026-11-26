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
 * @var array<string, array{label:string, placeholder:string}> $descFields trame guidée (clé => label + placeholder)
 * @var string $group       groupe INPN : 'oiseaux' | 'lepido' (filtre les suggestions TAXREF)
 * @var string|null $error  message d'erreur à afficher
 * @var string|null $success message de succès à afficher
 */

/**
 * Préréglages de répartition proposés dans le formulaire admin.
 *
 * @return array<int, string>
 */
function repartition_presets(): array
{
    return [
        'Observable sur tout le territoire métropolitain.',
        'Observable sur tout le territoire métropolitain, sauf sur la côte méditerranéenne.',
        'Présent sur les côtes atlantique et de la Manche.',
        'Présent sur la côte méditerranéenne et en Corse.',
        'Espèce de montagne : Alpes, Pyrénées, Massif central, Jura.',
        'Présent dans le nord et l’est de la France.',
    ];
}

function render_species_form(string $action, string $entityLabel, string $nameExample, string $nameLatinExample, string $familleExample, array $descFields, string $group, ?string $error = null, ?string $success = null): void
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
                <input type="text" id="namelatin" name="namelatin" required list="taxref-suggest" autocomplete="off" placeholder="Ex : <?= e_attr($nameLatinExample) ?>">
                <datalist id="taxref-suggest"></datalist>
                <button type="button" class="btn-ghost" id="inpnFill" data-groupe="<?= e_attr($group) ?>">Pré-remplir via l'INPN</button>
                <p class="inpn-status" id="inpnStatus" role="status"></p>
            </div>

            <div class="form-group">
                <label for="famille">Famille</label>
                <input type="text" id="famille" name="famille" required placeholder="Ex : <?= e_attr($familleExample) ?>">
            </div>

            <div class="form-group">
                <label for="repartition">Répartition</label>
                <select id="repartitionPreset" aria-label="Préréglage de répartition">
                    <option value="">— Choisir un préréglage…</option>
                    <?php foreach (repartition_presets() as $preset): ?>
                        <option value="<?= e_attr($preset) ?>"><?= e($preset) ?></option>
                    <?php endforeach; ?>
                    <option value="__autre__">Autre (saisie libre ci-dessous)</option>
                </select>
                <textarea id="repartition" name="repartition" rows="3" placeholder="Décrivez la répartition géographique…"></textarea>
            </div>

            <fieldset class="desc-block">
                <legend>Description</legend>
                <?php foreach ($descFields as $key => $field): ?>
                <div class="form-group">
                    <label for="desc-<?= e_attr($key) ?>"><?= e($field['label']) ?></label>
                    <textarea id="desc-<?= e_attr($key) ?>" name="desc[<?= e_attr($key) ?>]" rows="2" placeholder="<?= e_attr($field['placeholder']) ?>"></textarea>
                </div>
                <?php endforeach; ?>
            </fieldset>

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
