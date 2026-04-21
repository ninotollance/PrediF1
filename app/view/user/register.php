
<!-- Formulaire d'inscription -->
<section class="contact" aria-label="Formulaire d'inscription">
    <form action="?action=register" method="POST">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        <!-- Champ nom -->
        <label>Nom</label>
        <input type="text" name="name" placeholder="Senna" required>
        <?php if(!empty($errors['name'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ prénom -->
        <label>Prénom</label>
        <input type="text" name="firstname" placeholder="Ayrton" required>
        <?php if(!empty($errors['firstname'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['firstname'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ email -->
        <label>Email</label>
        <input type="email" name="email" placeholder="Exemple@email.fr" required>
        <?php if(!empty($errors['email'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <?php if(!empty($errors['password'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <!-- Checkbox obligatoire RGPD -->
        <label class="valid">
            <input type="checkbox" name="rgpd" required>
            J'accepte les <a href="?action=conditions-utilisation">conditions d'utilisation</a> et la <a href="?action=confidentialite">politique de confidentialité</a>
        </label>
        
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">S'inscrire</button>
 
    </form>
</section>

