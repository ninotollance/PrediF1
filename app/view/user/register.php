<!-- <?php require RACINE . ("/app/view/layout/header.php"); ?>
 -->
<!-- Formulaire de inscription -->
<form action="?action=register" method="POST">

    <!-- Champ pour le username -->
    <label>Name</label>
    <input type="text" name="name" required>

    <!-- Champ pour le username -->
    <label>Firstname</label>
    <input type="text" name="firstname" required>

    <!-- Champ pour le email -->
    <label>Email</label>
    <input type="text" name="email" required>

    <!-- Champ pour le mot de passe -->
    <label>Password</label>
    <input type="password" name="password" required>

    <!-- Bouton pour envoyer le formulaire -->
    <button type="submit">S'inscrire</button>

</form>
<?php if(isset($_SESSION['login_error'])) : ?>
    <p><?= $_SESSION['login_error'] ?></p>
    <?php endif ?>

<!-- <?php require RACINE . ("/app/view/layout/footer.php"); ?>
 -->