<?php
// Définit les variables selon le contexte création ou modification
$formId = $isEdit ? 'drivers-form-edit-' . $driver['id'] : 'drivers-form-create'; // Id unique du div
$action = $isEdit ? '?action=admin-modifier-pilote&id=' . $driver['id'] : '?action=admin-creer-pilote'; // Action du formulaire
$title = $isEdit ? 'Modifier un pilote' : 'Ajouter un pilote'; // Titre du formulaire
$btnText = $isEdit ? 'Modifier le pilote' : 'Ajouter le pilote'; // Texte du bouton submit
?>

<div id="<?= $formId ?>" hidden>
    <h2><?= $title ?> <a onclick="showTable('drivers')">← Retour</a></h2>
    <form method="POST" action="<?= $action ?>" enctype="multipart/form-data"> <!-- enctype nécessaire pour l'upload d'image -->
        <input type="hidden" name="section" value="drivers"> <!-- Permet au JS de revenir sur la section drivers après soumission -->

        <label>Prénom</label>
        <!-- En modification : pré-remplit avec la valeur en BDD, sinon vide -->
        <input type="text" name="firstName"
            value="<?= $isEdit ? htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

        <label>Nom</label>
        <input type="text" name="name"
            value="<?= $isEdit ? htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') : '' ?>" required>

        <label>Numéro</label>
        <input type="number" name="number_api"
            value="<?= $isEdit ? $driver['number_api'] : '' ?>" required>

        <label>Écurie</label>
        <select name="idTeam">
            <?php foreach($teams as $team) : // Boucle sur toutes les écuries pour le select ?>
                <option value="<?= $team['id'] ?>" 
                    <?= $isEdit && $driver['idTeam'] == $team['id'] ? 'selected' : '' ?>> <!-- Pré-sélectionne l'écurie actuelle -->
                    <?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Image (nom du fichier)</label>
        <?php if($isEdit && $driver['picture']) : // Affiche l'image actuelle uniquement en modification ?>
            <img src="public/img/drivers/<?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?>" style="width: 80px;">
            <p>Image actuelle : <?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <input type="file" name="picture"> <!-- Champ upload pour changer l'image -->

        <button type="submit"><?= $btnText ?></button>
    </form>
</div>