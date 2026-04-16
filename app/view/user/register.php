
<!-- Formulaire d'inscription -->
<section class="contact">
    <form action="?action=register" method="POST">
 
        <!-- Champ nom -->
        <label>Nom</label>
        <input type="text" name="name" required>
 
        <!-- Champ prénom -->
        <label>Prénom</label>
        <input type="text" name="firstname" required>
 
        <!-- Champ email -->
        <label>Email</label>
        <input type="email" name="email" required>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" required>
        <!-- Message d'erreur affiché dans le formulaire -->

        <?php if(isset($_SESSION['form_error'])) : ?>
            <p class="form-error"><?= htmlspecialchars($_SESSION['form_error'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php unset($_SESSION['form_error']); ?>
        <?php endif ?>
 
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">S'inscrire</button>
 
    </form>
</section>

