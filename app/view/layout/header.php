<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrediF1</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>
<body>
<header>
    <nav>
        <!-- Logo -->
        <a href="?action=accueil">
            <img src="public/img/logoBlanc.png" alt="F1 Paris" class="logo">
        </a>

        <!-- Liens principaux — classe active sur le lien de la page courante -->
        <ul class="nav-links">
            <?php $action = $_GET['action'] ?? 'accueil'; // Récupère l'action courante, accueil par défaut ?>
            <li><a href="?action=accueil" class="<?= $action === 'accueil' ? 'active' : '' ?>">Accueil</a></li>
            <li><a href="?action=courses" class="<?= $action === 'courses' ? 'active' : '' ?>">Courses</a></li>
            <li><a href="?action=pilotes" class="<?= $action === 'pilotes' ? 'active' : '' ?>">Pilotes & Écuries</a></li>
            <?php if (isset($_SESSION['user_logged'])) : ?>
                <li><a href="?action=historique-paris" class="<?= $action === 'historique-paris' ? 'active' : '' ?>">Mes Paris</a></li>
            <?php endif; ?>
            <li><a href="?action=contact" class="<?= $action === 'contact' ? 'active' : '' ?>">Contact</a></li>
        </ul>

        <!-- Boutons connexion/inscription ou profil/déconnexion -->
        <div class="nav-buttons">
            <?php if (isset($_SESSION['user_logged'])) : ?>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') : ?>
                    <a href="?action=admin" class="btn-login">Dashboard</a>
                <?php else : ?>
                    <a href="?action=profil" class="btn-login <?= $action === 'profil' ? 'active' : '' ?>">Profil</a>
                <?php endif; ?>
                <a href="?action=deconnexion" class="btn-register">Déconnexion</a>
            <?php else : ?>
                <a href="?action=connexion" class="btn-login <?= $action === 'connexion' ? 'active' : '' ?>">Connexion</a>
                <a href="?action=inscription" class="btn-register">Inscription</a>
            <?php endif; ?>
        </div>

        <button class="burger" onclick="toggleMenu()">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </nav>
    <div class="mobile-menu" hidden>
        <ul>
            <div class="mobile-menu-header">
                <li><a href="?action=accueil">Accueil</a></li>
                <li><a href="?action=courses">Courses</a></li>
                <li><a href="?action=pilotes">Pilotes & Écuries</a></li>
                <?php if(isset($_SESSION['user_logged'])) : ?>
                    <li><a href="?action=historique-paris">Mes Paris</a></li>
                    <li><a href="?action=contact">Contact</a></li>
                    <li><a href="?action=profil">Profil</a></li>
                <?php endif; ?>
            </div>
            <div class="mobile-menu-footer">
                
                    <?php if(isset($_SESSION['user_role'])&& $_SESSION['user_role'] === 'admin') : ?>  <!-- Si admin connecté -->
                        <a href="?action=admin">← Dashboard</a>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['user_logged'])): ?>
                        <a href="?action=deconnexion">Déconnexion</a>
                    <?php else : ?>
                        <a href="?action=connexion">Connexion</a>
                        <a href="?action=inscription">Inscription</a>
                <?php endif; ?>
            </div>
        </ul>
    </div>

    <!-- Messages flash protégés contre XSS -->
    <?php if(isset($_SESSION['success'])) : ?>
        <div class="toast"><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['login_error'])) : ?>
        <div class="toast error"><?= htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8') ?></div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>
    <!-- Overlay sombre derrière le menu mobile -->
    <div class="overlay" hidden onclick="toggleMenu()"></div>
</header>
<main>
