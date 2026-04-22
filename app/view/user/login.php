<!-- Formulaire de connexion -->
<section class="contact" aria-label="Formulaire de connexion">
    <h1>Connexion</h1>
    <form action="?action=login" method="POST">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        <!-- Champ email -->
        <label>Email</label>
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_SESSION['form_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
        <?php unset($_SESSION['form_email']); ?>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="Mot de passe" autocomplete="new-password" required>

        <?php if(isset($_SESSION['form_error'])) : ?>
            <p class="form-error"><?= htmlspecialchars($_SESSION['form_error'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php unset($_SESSION['form_error']); ?>
        <?php endif ?>
 
        <!-- Bouton envoi -->
        <button type="submit">Se connecter</button>
 
    </form>
</section>