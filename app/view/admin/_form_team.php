<?php
// Définit les variables selon le contexte création ou modification
$formId = $isEdit ? 'teams-form-edit-' . $team['id'] : 'teams-form-create'; // Id unique du div
$action = $isEdit ? '?action=admin-modifier-ecuries&id=' . $team['id'] : '?action=admin-creer-ecuries'; // Action du formulaire
$title = $isEdit ? 'Modifier une écurie' : 'Ajouter une écurie'; // Titre du formulaire
$btnText = $isEdit ? 'Modifier l\'écurie' : 'Ajouter l\'écurie'; // Texte du bouton submit
?>

<div id="<?= $formId ?>" hidden>
    <h2><?= $title ?> <a onclick="showTable('teams')">← Retour</a></h2>
    <form method="POST" action="<?= $action ?>" enctype="multipart/form-data"> <!-- enctype nécessaire pour l'upload d'image -->
        <input type="hidden" name="section" value="teams"> <!-- Permet au JS de revenir sur la section teams après soumission -->

        <label>Nom</label>
        <!-- En modification : pré-remplit avec la valeur en BDD, sinon vide -->
        <input type="text" name="name"
            value="<?= $isEdit ? htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

        <label>Pays</label>
        <input type="text" name="country"
            value="<?= $isEdit ? htmlspecialchars($team['country'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

        <label>Image (nom du fichier)</label>
        <?php if($isEdit && $team['picture']) : // Affiche l'image actuelle uniquement en modification ?>
            <img src="public/img/teams/<?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?>" style="width: 80px;">
            <p>Image actuelle : <?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <input type="file" name="picture"> <!-- Champ upload pour changer l'image -->

        <button type="submit"><?= $btnText ?></button>
    </form>
</div>