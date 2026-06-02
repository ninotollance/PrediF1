<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TestCDA</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper"> 

        <aside class="dashboard-sidebar">
            <header class="dashboard-sidebar-header">
                <!-- Burger : ouvre/ferme le menu via toggleDashboardMenu() -->
                <button class="dashboard-burger">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </header>

            <!-- Menu de navigation — caché sur mobile, visible sur desktop -->
            <!-- Sur mobile : géré par JS via la classe .open -->
            <div class="dashboard-nav">
                <!-- Liens en bas du menu -->
                <footer class="dashboard-sidebar-footer">
                    <a href="?action=home">← Retour au site</a>
                    <a href="?action=logout">Déconnexion</a>
                </footer>
            </div>

        </aside>

        <!-- Overlay sombre derrière le menu mobile -->
        <!-- Cliquable pour fermer le menu -->
        <div class="overlay-dashboard" hidden></div>

        <!-- ════════════════════════════════════════ -->
        <!-- CONTENU PRINCIPAL                        -->
        <!-- ════════════════════════════════════════ -->
        <main class="dashboard-main">

            <!-- Messages flash succès/erreur -->
            <?php if(isset($_SESSION['success'])) : ?>
                <div class="toast"><?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            <?php if(isset($_SESSION['login_error'])) : ?>
                <div class="toast error"><?= htmlspecialchars($_SESSION['login_error'], ENT_QUOTES, 'UTF-8') ?></div>
                <?php unset($_SESSION['login_error']); ?>
            <?php endif; ?>

            <h1>Dashboard</h1>

            

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION USERS                          -->
            <!-- ════════════════════════════════════════ -->
            <section id="users" class="dashboard-section" <?= $section !== 'users' ? 'hidden' : '' ?>>

                <!-- Tableau des courses -->
                <div id="users-table">
                    <h2>Utilisateurs</h2>   
                    <div class="table-wrapper"> <!-- scroll horizontal sur mobile -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($users as $user) : // Boucle sur toutes les courses ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['firstName'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <!-- showForm affiche le formulaire de modification -->
                                            <a href="?action=admin-update-user&id=<?= $user['id'] ?>">Modifier</a>
                                            <!-- confirmDelete demande confirmation avant suppression -->
                                            <a href="?action=admin-delete-user&id=<?= $user['id'] ?>">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </section>

        </main>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>
