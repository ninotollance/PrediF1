
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
 
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">S'inscrire</button>
 
    </form>
</section>
<?php if(isset($_SESSION['login_error'])) : ?>
    <p><?= $_SESSION['login_error'] ?></p>
    <?php endif ?>
