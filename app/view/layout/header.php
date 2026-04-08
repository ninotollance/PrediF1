<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrediF1</title>
    <link rel="stylesheet" href="public/css/main.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
<header>
    <nav>
        <a href="?action=accueil">
            <img src="public/img/logoBlanc.png" alt="F1 Paris" class="logo">
        </a>

        <ul>
            <li><a href="?action=accueil">Accueil</a></li>
            <li><a href="?action=courses">Courses</a></li>
            <li><a href="?action=pilotes">Pilotes & Écuries</a></li>
        </ul>

        <?php if (isset($_SESSION['user_logged'])) : ?>
        <ul>
            <li><a href="?action=paris">Mes Paris</a></li>
            <li><a href="?action=profil">Profil</a></li>
            <li><a href="?action=deconnexion">Déconnexion</a></li>
        </ul>
        <?php else : ?>
        <ul>
            <li><a href="?action=connexion">Connexion</a></li>
            <li><a href="?action=inscription">Inscription</a></li>
        </ul>
        <?php endif; ?>
    </nav>

    <?php if(isset($_SESSION['success'])) : ?>
        <div class="toast"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['login_error'])) : ?>
        <div class="toast error"><?= $_SESSION['login_error'] ?></div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
</header>
