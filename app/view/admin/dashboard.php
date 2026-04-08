<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PrediF1</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper"> 

        <!-- Barre latérale gauche -->
        <aside class="dashboard-sidebar"> 
            <img src="public/img/logoBlanc.png" alt="PrediF1" class="logo">
            
            <nav>
                <ul>
                    <li><a onclick="showSection('races', event)">Courses</a></li>
                    <li><a onclick="showSection('drivers', event)">Pilotes</a></li>
                    <li><a onclick="showSection('teams', event)">Écuries</a></li>
                    <li><a onclick="showSection('winner', event)">Vainqueur</a></li>
                    <li><a onclick="showSection('bets', event)">Paris</a></li>
                    <li><a onclick="showSection('users', event)">Utilisateurs</a></li>
                </ul>
            </nav>

            <!-- Liens en bas du menu -->
            <div class="dashboard-sidebar-footer">
                <a href="?action=accueil">← Retour au site</a>
                <a href="?action=deconnexion">Déconnexion</a>
            </div>
        </aside>

        <!-- Zone de contenu principale à droite -->
        <main class="dashboard-main"> <!-- main = contenu principal de la page -->
            <h1>Dashboard</h1>

            <!-- Section Courses → visible par défaut -->
            <div id="races" class="dashboard-section">
                <!-- tableau courses ici -->
                 <h2>Dashboard Admin</h2>
                    <section>
                        <h3>Courses <a href="?action=admin-creer-course">+ Ajouter</a></h3>
                            <table>
                                <thead>
                                    <tr>Nom</tr>
                                    <tr>Date</tr>
                                    <tr>status</tr>
                                    <tr>Actions</tr>
                                </thead>
                                <tbody>
                                    <?php foreach($races as $race) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td><?= date('d/m/Y', strtotime($race['raceStart'])) ?></td>
                                            <td><?= htmlspecialchars($race['status'], ENT_QUOTES, 'UTF-8') ?></td>
                                            <td>
                                                <a href="?action=admin-modifier-course&id=<?= $race['id'] ?>">Modifier</a>
                                                <a href="?action=admin-supprimer-course&id=<?= $race['id'] ?>">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                    </section>
            </div>

            <!-- Sections cachées par défaut grâce à l'attribut hidden -->
            <div id="drivers" class="dashboard-section" hidden>
                <!-- tableau pilotes ici -->
            </div>
            <div id="teams" class="dashboard-section" hidden>
                <!-- tableau écuries ici -->
            </div>
            <div id="winner" class="dashboard-section" hidden>
                <!-- formulaire vainqueur ici -->
            </div>
            <div id="bets" class="dashboard-section" hidden>
                <!-- tableau paris ici -->
            </div>
            <div id="users" class="dashboard-section" hidden>
                <!-- tableau utilisateurs ici -->
            </div>

        </main>

    </div>

    <script src="public/js/script.js"></script>
</body>
</html>