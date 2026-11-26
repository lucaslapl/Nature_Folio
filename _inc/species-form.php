<?php

declare(strict_types=1);

/**
 * Template commun du formulaire d'ajout / édition d'espèce (oiseaux / lépidoptères).
 *
 * Variables attendues :
 * @var string $action      action du formulaire (ex: 'bird_sent.php', 'espece_update.php')
 * @var string $entityLabel libellé de l'entité (ex: 'un oiseau', 'un lépidoptère')
 * @var string $nameExample exemple de nom commun
 * @var string $nameLatinExample exemple de nom latin
 * @var string $familleExample exemple de famille
 * @var array<string, array{label:string, placeholder:string}> $descFields trame guidée (clé => label + placeholder)
 * @var string $group       groupe INPN : 'oiseaux' | 'lepido' (filtre les suggestions TAXREF)
 * @var array<string, mixed> $values  valeurs actuelles en édition (row BDD), vide en ajout
 * @var bool   $edit        true en édition (images optionnelles, titre adapté)
 * @var string $imgBase     préfixe des chemins d'images existants en édition (ex: '../oiseaux/')
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

function render_species_form(string $action, string $entityLabel, string $nameExample, string $nameLatinExample, string $familleExample, array $descFields, string $group, array $values = [], bool $edit = false, string $imgBase = '', ?string $error = null, ?string $success = null): void
{
    $v = static function (string $key) use ($values): string {
        return (string) ($values[$key] ?? '');
    };

    // En édition, la description stockée ("Label : valeur\n…") est re-découpée en champs guidés
    $descValues = [];
    if ($edit && $v('description') !== '') {
        $descValues = parse_description($v('description'), $descFields)['fields'];
    }

    $title = $edit && $v('nom') !== '' ? 'Modifier : ' . $v('nom') : 'Ajouter ' . $entityLabel;
    ?>
    <div class="form-card">
        <h2><?= e($title) ?></h2>

        <?php if ($error): ?><p class="alert"><?= e($error) ?></p><?php endif; ?>
        <?php if ($success): ?><p class="alert success"><?= e($success) ?></p><?php endif; ?>

        <form action="<?= e_attr($action) ?>" method="post" enctype="multipart/form-data">
            <?php if ($edit): ?>
                <input type="hidden" name="id" value="<?= e_attr($v('id')) ?>">
                <input type="hidden" name="table" value="<?= e_attr($group === 'lepido' ? 'lepido' : 'oiseaux') ?>">
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Nom</label>
                <input type="text" id="name" name="name" required value="<?= e_attr($v('nom')) ?>" placeholder="Ex : <?= e_attr($nameExample) ?>">
            </div>

            <div class="form-group">
                <label for="namelatin">Nom latin</label>
                <input type="text" id="namelatin" name="namelatin" required list="taxref-suggest" autocomplete="off" value="<?= e_attr($v('nom_latin')) ?>" placeholder="Ex : <?= e_attr($nameLatinExample) ?>">
                <datalist id="taxref-suggest"></datalist>
                <button type="button" class="btn-ghost" id="inpnFill" data-groupe="<?= e_attr($group) ?>">Pré-remplir via l'INPN</button>
                <p class="inpn-status" id="inpnStatus" role="status"></p>
            </div>

            <div class="form-group">
                <label for="famille">Famille</label>
                <input type="text" id="famille" name="famille" required value="<?= e_attr($v('famille')) ?>" placeholder="Ex : <?= e_attr($familleExample) ?>">
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
                <textarea id="repartition" name="repartition" rows="3" placeholder="Décrivez la répartition géographique…"><?= e($v('repartition')) ?></textarea>
            </div>

            <fieldset class="desc-block">
                <legend>Description</legend>
                <?php foreach ($descFields as $key => $field): ?>
                <div class="form-group">
                    <label for="desc-<?= e_attr($key) ?>"><?= e($field['label']) ?></label>
                    <textarea id="desc-<?= e_attr($key) ?>" name="desc[<?= e_attr($key) ?>]" rows="2" placeholder="<?= e_attr($field['placeholder']) ?>"><?= e($descValues[$key] ?? '') ?></textarea>
                </div>
                <?php endforeach; ?>
            </fieldset>

            <div class="grid-2">
                <div class="form-group">
                    <label for="first-obs">Première observation</label>
                    <input type="date" id="first-obs" name="first-obs" value="<?= e_attr($v('premiere_obs')) ?>">
                </div>
                <div class="form-group">
                    <label for="date-photo">Date de la photo</label>
                    <input type="date" id="date-photo" name="date-photo" value="<?= e_attr($v('date_obs')) ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="lien-inpn">Fiche INPN (URL)</label>
                <input type="url" id="lien-inpn" name="lien-inpn" value="<?= e_attr($v('lien_inpn')) ?>" placeholder="https://inpn.mnhn.fr/...">
            </div>

            <div class="form-group">
                <label for="lieu-photo">Lieu de la photo</label>
                <input type="text" id="lieu-photo" name="lieu-photo" value="<?= e_attr($v('lieu_obs')) ?>">
            </div>

            <div class="grid-2">
                <div class="form-group">
                    <label for="imgMain">Photo principale<?= $edit ? ' (laisser vide pour conserver l’actuelle)' : '' ?></label>
                    <?php if ($edit && $v('image_path') !== ''): ?>
                        <a href="<?= e_attr($imgBase . $v('image_path')) ?>" target="_blank" class="current-img"><img src="<?= e_attr($imgBase . $v('image_path_min') !== '' ? $imgBase . $v('image_path_min') : $imgBase . $v('image_path')) ?>" alt=""></a>
                    <?php endif; ?>
                    <input type="file" id="imgMain" name="imgMain" accept="image/*"<?= $edit ? '' : ' required' ?>>
                </div>
                <div class="form-group">
                    <label for="imgMini">Miniature<?= $edit ? ' (laisser vide pour conserver l’actuelle)' : '' ?></label>
                    <input type="file" id="imgMini" name="imgMini" accept="image/*"<?= $edit ? '' : ' required' ?>>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-primary"><?= $edit ? 'Enregistrer les modifications' : 'Enregistrer l’espèce' ?></button>
        </form>
    </div>
    <?php
}
