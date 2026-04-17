<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PrediF1</title>
    <link rel="stylesheet" href="public/css/main.css">
</head>
<body class="dashboard-body">
    <div class="dashboard-wrapper"> <!-- Layout grid : sidebar + contenu -->

        <!-- ════════════════════════════════════════ -->
        <!-- SIDEBAR — Navigation admin               -->
        <!-- Sur mobile : logo + burger               -->
        <!-- Sur desktop : menu vertical complet      -->
        <!-- ════════════════════════════════════════ -->
        <aside class="dashboard-sidebar">

            <!-- Logo + burger (mobile) -->
            <header class="dashboard-sidebar-header">
                <a href="?action=accueil">
                    <img src="public/img/logoBlanc.png" alt="PrediF1" class="logo">
                </a>
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
                <nav>
                    <ul>
                        <!-- data-section : récupéré par JS pour afficher la bonne section -->
                        <li><a data-section="races">Courses</a></li>
                        <li><a data-section="drivers">Pilotes</a></li>
                        <li><a data-section="teams">Écuries</a></li>
                        <li><a data-section="winner">Vainqueur</a></li>
                        <li><a data-section="bets">Paris</a></li>
                        <li><a data-section="users">Utilisateurs</a></li>
                    </ul>
                </nav>

                <!-- Liens en bas du menu -->
                <footer class="dashboard-sidebar-footer">
                    <a href="?action=accueil">← Retour au site</a>
                    <a href="?action=deconnexion">Déconnexion</a>
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
            <!-- SECTION COURSES                          -->
            <!-- Visible par défaut                       -->
            <!-- ════════════════════════════════════════ -->
            <section id="races" class="dashboard-section">

                <!-- Tableau des courses -->
                <div id="races-table">
                    <h2>Courses <a onclick="showForm('races', 'create')">+ Ajouter</a></h2>
                    <div class="table-wrapper"> <!-- scroll horizontal sur mobile -->
                        <table>
                            <thead>
                                <tr>
                                    <th>Pays</th>
                                    <th>Nom</th>
                                    <th>Date</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($races as $race) : // Boucle sur toutes les courses ?>
                                    <tr>
                                        <td><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= date('d/m/Y', strtotime($race['raceStart'])) ?></td>
                                        <td><?= translateStatus($race['status']) ?></td>
                                        <td>
                                            <!-- showForm affiche le formulaire de modification -->
                                            <a onclick="showForm('races', 'edit-<?= $race['id'] ?>')">Modifier</a>
                                            <!-- confirmDelete demande confirmation avant suppression -->
                                            <a onclick="confirmDelete('?action=admin-supprimer-course&id=<?= $race['id'] ?>&section=races')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Formulaire création course — caché par défaut -->
                <!-- Formulaire création -->
                <?php $isEdit = false; $race = null; ?>
                <?php include '_form_race.php'; ?>

                <!-- Formulaires modification — un par course -->
                <?php foreach($races as $race) : ?>
                    <?php $isEdit = true; ?>
                    <?php include '_form_race.php'; ?>
                <?php endforeach; ?>

            </section>

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION PILOTES — caché par défaut       -->
            <!-- ════════════════════════════════════════ -->
            <section id="drivers" class="dashboard-section" hidden>

                <div id="drivers-table">
                    <h2>Pilotes <a onclick="showForm('drivers', 'create')">+ Ajouter</a></h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Prénom</th>
                                    <th>Nom</th>
                                    <th>Numéro</th>
                                    <th>Écurie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($drivers as $driver) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>#<?= $driver['number_api'] ?></td>
                                        <td><?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <a onclick="showForm('drivers', 'edit-<?= $driver['id'] ?>')">Modifier</a>
                                            <a onclick="confirmDelete('?action=admin-supprimer-pilote&id=<?= $driver['id'] ?>&section=drivers')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Formulaire création pilote -->
                <?php $isEdit = false; $driver = null; ?>
                <?php include '_form_driver.php'; ?>

                <!-- Formulaires modification — un par pilote -->
                <?php foreach($drivers as $driver) : ?>
                    <?php $isEdit = true; ?>
                    <?php include '_form_driver.php'; ?>
                <?php endforeach; ?>

            </section>
            <!-- ════════════════════════════════════════ -->
            <!-- SECTION ÉCURIES — caché par défaut       -->
            <!-- ════════════════════════════════════════ -->
            <section id="teams" class="dashboard-section" hidden>

                <div id="teams-table">
                    <h2>Écuries <a onclick="showForm('teams', 'create')">+ Ajouter</a></h2>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Pays</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($teams as $team) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td><?= htmlspecialchars($team['country'], ENT_QUOTES, 'UTF-8') ?></td>
                                        <td>
                                            <a onclick="showForm('teams', 'edit-<?= $team['id'] ?>')">Modifier</a>
                                            <a onclick="confirmDelete('?action=admin-supprimer-ecuries&id=<?= $team['id'] ?>&section=teams')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                
                <!-- Formulaire création écurie -->
                <?php $isEdit = false; $team = null; ?>
                <?php include '_form_team.php'; ?>

                <!-- Formulaires modification — un par écurie -->
                <?php foreach($teams as $team) : ?>
                    <?php $isEdit = true; ?>
                    <?php include '_form_team.php'; ?>
                <?php endforeach; ?>

            </section>

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION VAINQUEUR — caché par défaut     -->
            <!-- Permet d'enregistrer le gagnant d'une    -->
            <!-- course terminée                          -->
            <!-- ════════════════════════════════════════ -->
            <section id="winner" class="dashboard-section" hidden>
                <h2>Ajouter un vainqueur</h2>
                <form method="POST" action="?action=admin-ajouter-vainqueur">
                    <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
                    <!-- Le serveur vérifiera que ce token correspond à celui en session -->
                    <input type="hidden" name="csrf_token" 
                    value="<?= $_SESSION['csrf_token'] ?>">

                    <input type="hidden" name="section" value="winner">
                    <!-- Champ caché qui stocke l'id de la course sélectionnée -->
                    <input type="hidden" name="id" id="idRace" value="<?= isset($finishedRaces[0]) ? $finishedRaces[0]['id'] : '' ?>">
                    
                    <label>Course terminée</label>
                    <!-- onchange : met à jour le champ caché avec l'id de la course sélectionnée -->
                    <select name="idRace" onchange="document.getElementById('idRace').value = this.value">
                        <?php foreach($finishedRaces as $race) : ?>
                            <option value="<?= $race['id'] ?>"><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label>Pilote vainqueur</label>
                    <select name="idWinner">
                        <?php foreach($drivers as $driver) : ?>
                            <option value="<?= $driver['id'] ?>">
                                <?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?>
                                <?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Enregistrer le vainqueur</button>
                </form>
            </section>

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION PARIS — caché par défaut         -->
            <!-- ════════════════════════════════════════ -->
            <section id="bets" class="dashboard-section" hidden>
                <h2>Paris</h2>

                <!-- Barre de recherche — filtre en JS -->
                <input type="text" id="bets-search" placeholder="Rechercher par nom..." 
                    onkeyup="filterBets('bets-search', 'bets-table')" style="margin-bottom: 15px;">

                <div class="table-wrapper">
                    <table id="bets-table">
                        <thead>
                            <tr>
                                <th>Utilisateur</th>
                                <th>Course</th>
                                <th>Pilote parié</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($bets as $bet) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($bet['userFirstName'], ENT_QUOTES, 'UTF-8') ?>
                                        <?= htmlspecialchars($bet['userName'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($bet['nameRace'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= htmlspecialchars($bet['driverFirstName'], ENT_QUOTES, 'UTF-8') ?>
                                        <?= htmlspecialchars($bet['nameDriver'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td><?= date('d/m/Y', strtotime($bet['date_'])) ?></td>
                                    <td>
                                        <a onclick="confirmDelete('?action=admin-supprimer-pari&id=<?= $bet['id'] ?>&section=bets')">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION USERS                          -->
            <!-- ════════════════════════════════════════ -->
            <section id="users" class="dashboard-section" hidden>

                <!-- Tableau des courses -->
                <div id="users-table">
                    <h2>Utilisateurs <a onclick="showForm('users', 'create')">+ Ajouter</a></h2>
                    <!-- Barre de recherche — filtre en JS -->
                    <input type="text" id="users-search" placeholder="Rechercher par nom..." 
                        onkeyup="filterTable('users-search', 'users-table')" style="margin-bottom: 15px;">
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
                                            <a onclick="showForm('users', 'edit-<?= $user['id'] ?>')">Modifier</a>
                                            <!-- confirmDelete demande confirmation avant suppression -->
                                            <a onclick="confirmDelete('?action=admin-supprimer-user&id=<?= $user['id'] ?>&section=users')">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Formulaire modification — un par course, caché par défaut -->
                <?php foreach($users as $user) : ?>
                <div id="users-form-edit-<?= $user['id'] ?>" hidden>
                    <h2>Modifier un utilisateur <a onclick="showTable('users')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-modifier-user&id=<?= $user['id'] ?>">
                        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
                        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
                        <input type="hidden" name="csrf_token" 
                        value="<?= $_SESSION['csrf_token'] ?>">
                        
                        <input type="hidden" name="section" value="users">

                        <label>Nom</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Prénom</label>
                        <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Email</label>
                        <input type="date" name="email" value="<?= $user['email'] ?>" required>

                        <label>Rôle</label>
                        <input type="date" name="role" value="<?= $user['role'] ?>" required>


                        <button type="submit">Modifier l'utilisateur</button>
                    </form>
                </div>
                <?php endforeach; ?>

            </section>

        </main>
    </div>

    <script src="public/js/script.js"></script>
</body>
</html>
