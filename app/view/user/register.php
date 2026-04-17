
<!-- Formulaire d'inscription -->
<section class="contact">
    <form action="?action=register" method="POST">
 
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
        <input type="email" name="email" placeholder="exemple@email.fr" required>
        <?php if(!empty($errors['email'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="mot de passe" required>
        <?php if(!empty($errors['password'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">S'inscrire</button>
 
    </form>
</section>

