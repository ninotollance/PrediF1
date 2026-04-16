<!-- Formulaire de connexion -->
<section class="contact">
    <form action="?action=login" method="POST">
 
        <!-- Champ email -->
        <label>Email</label>
        <input type="email" name="email" required>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" required>

        <?php if(isset($_SESSION['form_error'])) : ?>
            <p class="form-error"><?= htmlspecialchars($_SESSION['form_error'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php unset($_SESSION['form_error']); ?>
        <?php endif ?>
 
        <!-- Bouton envoi -->
        <button type="submit">Se connecter</button>
 
    </form>
</section>