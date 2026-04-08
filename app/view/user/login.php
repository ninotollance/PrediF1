<!-- <?php require RACINE . ("/app/view/layout/header.php"); ?> -->


<!-- Formulaire de connexion du RH -->
<form action="?action=login" method="POST">

    <!-- Champ pour le username -->
    <label>Email</label>
    <input type="text" name="email" required>

    <!-- Champ pour le mot de passe -->
    <label>Password</label>
    <input type="password" name="password" required>

    <!-- Bouton pour envoyer le formulaire -->
    <button type="submit">Se connecter</button>

</form>
<?php if(isset($_SESSION['login_error'])) : ?>
    <p><?= $_SESSION['login_error'] ?></p>
    <?php unset($_SESSION['login_error']); ?>
    <?php endif ?>

<!-- <?php require RACINE . ("/app/view/layout/footer.php"); ?>
 -->