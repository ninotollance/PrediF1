<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TestCDA</title>
    <link rel="stylesheet" href="public/css/main.css">
    <script src="public/js/script.js" defer></script>
</head>
<body>
<header>
    <nav>

        <!-- Liens principaux -->
        <ul class="nav-links">
            <li><a href="?action=home">Afficher les clients</a></li>
            <li><a href="?action=client-search">Rechercher un client</a></li>
            <li><a href="?action=client-create">Créer un client</a></li>
        </ul>

        <!-- Boutons connexion/déconnexion -->
        <div class="nav-buttons">
            <?php if(isset($_SESSION['user_logged'])) : ?>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                    <a href="?action=admin" class="btn-login">Dashboard</a>
                <?php endif; ?>
                <a href="?action=logout" class="btn-register">Déconnexion</a>
            <?php else : ?>
                <a href="?action=login" class="btn-login">Connexion</a>
                <a href="?action=register" class="btn-register">Inscription</a>
            <?php endif; ?>
        </div>

        <button class="burger" aria-label="bouton burger">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>

    <!-- Menu mobile -->
    <div class="mobile-menu" hidden>
        <ul>
            <div class="mobile-menu-header">
                <li><a href="?action=home">Affichage clients</a></li>
                <li><a href="?action=client-search">Rechercher un client</a></li>
                <li><a href="?action=client-create">Ajouter un client</a></li>
            </div>
            <div class="mobile-menu-footer">
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                    <a href="?action=admin">← Dashboard</a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_logged'])) : ?>
                    <a href="?action=logout">Déconnexion</a>
                <?php else : ?>
                    <a href="?action=login">Connexion</a>
                    <a href="?action=register">Inscription</a>
                <?php endif; ?>
            </div>
        </ul>
    </div>

    <!-- Messages flash -->
    <?php if(isset($_SESSION['success'])) : ?>
        <div class="toast"><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
    <?php if(isset($_SESSION['login_error'])) : ?>
        <div class="toast error"><?= htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <div class="overlay" hidden></div>
</header>
<main>