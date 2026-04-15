<!-- Formulaire de connexion -->
<section class="contact">
    <form action="?action=login" method="POST">
 
        <!-- Champ email -->
        <label>Email</label>
        <input type="email" name="email" required>
 
        <!-- Champ mot de passe -->
        <label>Mot de passe</label>
        <input type="password" name="password" required>
 
        <!-- Bouton envoi -->
        <button type="submit">Se connecter</button>
 
    </form>
</section>
<?php if(isset($_SESSION['login_error'])) : ?>
    <p><?= $_SESSION['login_error'] ?></p>
    <?php unset($_SESSION['login_error']); ?>
    <?php endif ?>
