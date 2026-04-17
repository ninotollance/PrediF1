<?php
// Définit les variables selon le contexte création ou modification
$formId = $isEdit ? 'races-form-edit-' . $race['id'] : 'races-form-create'; // Id unique du div
$action = $isEdit ? '?action=admin-modifier-course&id=' . $race['id'] : '?action=admin-creer-course'; // Action du formulaire
$title = $isEdit ? 'Modifier une course' : 'Créer une course'; // Titre du formulaire
$btnText = $isEdit ? 'Modifier la course' : 'Créer la course'; // Texte du bouton submit
?>

<div id="<?= $formId ?>" hidden>
    <h2><?= $title ?> <a onclick="showTable('races')">← Retour</a></h2>
    <form method="POST" action="<?= $action ?>">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        <input type="hidden" name="section" value="races"> <!-- Permet au JS de revenir sur la section races après soumission -->

        <label>Nom du Grand Prix</label>
        <!-- En modification : pré-remplit avec la valeur en BDD, sinon vide -->
        <input type="text" name="name" 
            value="<?= $isEdit ? htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') : '' ?>" 
            placeholder="Grand Prix d'Australie" required>

        <label>Pays</label>
        <input type="text" name="country" 
            value="<?= $isEdit ? htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') : '' ?>" 
            placeholder="Australie" required>

        <label>Début du week-end</label>
        <input type="date" name="gpStart" 
            value="<?= $isEdit ? $race['gpStart'] : '' ?>" required>

        <label>Fin du week-end</label>
        <input type="date" name="gpEnd" 
            value="<?= $isEdit ? $race['gpEnd'] : '' ?>" required>

        <label>Heure de départ</label>
        <!-- str_replace remplace l'espace par T pour le format datetime-local attendu par le navigateur -->
        <input type="datetime-local" name="raceStart" 
            value="<?= $isEdit ? str_replace(' ', 'T', $race['raceStart']) : '' ?>" required>

        <label>Circuit Key API</label>
        <input type="number" name="circuitKey_api" 
            value="<?= $isEdit ? $race['circuitKey_api'] : '' ?>" required>

        <label>Image (nom du fichier)</label>
        <input type="text" name="picture" 
            value="<?= $isEdit ? htmlspecialchars($race['picture'] ?? '', ENT_QUOTES, 'UTF-8') : '' ?>" 
            placeholder="australie.webp">

        <label>Statut</label>
        <select name="status">
            <!-- selected : pré-sélectionne le statut actuel en modification -->
            <option value="scheduled" <?= $isEdit && $race['status'] === 'scheduled' ? 'selected' : '' ?>>À venir</option>
            <option value="cancelled" <?= $isEdit && $race['status'] === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
            <option value="finished" <?= $isEdit && $race['status'] === 'finished' ? 'selected' : '' ?>>Terminée</option>
        </select>

        <button type="submit"><?= $btnText ?></button>
    </form>
</div>