<!-- Formulaire d'inscription -->
<section class="form-wrapper" aria-label="Formulaire de modification client">
    <a class="return" href="javascript:history.back()">← Retour</a>
    <h1>Modifier un client</h1>
    <form action="?action=client-update&id=<?= $client['id'] ?>" method="POST">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        <!-- Champ nom -->
        <label>Nom</label>
        <input type="text" name="name" value="<?= htmlspecialchars($client['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['name'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ prénom -->
        <label>Prénom</label>
        <input type="text" name="firstName" value="<?= htmlspecialchars($client['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['firstName'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['firstName'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ téléphone -->
        <label>Téléphone</label>
        <input type="tel" name="phone" value="<?= htmlspecialchars($client['phone'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['phone'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['phone'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ adresse -->
        <label>Adresse</label>
        <input type="text" name="address" value="<?= htmlspecialchars($client['address'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['address'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['address'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <!-- Champ adresse -->
        <label>Code postal</label>
        <input type="text" name="zipCode" value="<?= htmlspecialchars($client['zipCode'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['zipCode'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['zipCode'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <!-- Champ adresse -->
        <label>Ville</label>
        <input type="text" name="city" value="<?= htmlspecialchars($client['city'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['city'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['city'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">Valider</button>
 
    </form>
</section>