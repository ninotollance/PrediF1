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
                <button class="dashboard-burger" onclick="toggleDashboardMenu()">
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
        <div class="overlay-dashboard" hidden onclick="toggleDashboardMenu()"></div>

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
                <div id="races-form-create" hidden>
                    <h2>Créer une course <a onclick="showTable('races')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-creer-course">
                        <input type="hidden" name="section" value="races">

                        <label>Nom du Grand Prix</label>
                        <input type="text" name="name" placeholder="Grand Prix d'Australie" required>

                        <label>Pays</label>
                        <input type="text" name="country" placeholder="Australie" required>

                        <label>Début du week-end</label>
                        <input type="date" name="gpStart" required>

                        <label>Fin du week-end</label>
                        <input type="date" name="gpEnd" required>

                        <label>Heure de départ</label>
                        <input type="datetime-local" name="raceStart" required>

                        <label>Circuit Key API</label>
                        <input type="number" name="circuitKey_api" required>

                        <label>Image (nom du fichier)</label>
                        <input type="text" name="picture" placeholder="australie.webp">

                        <label>Statut</label>
                        <select name="status">
                            <option value="scheduled">À venir</option>
                            <option value="cancelled">Annulée</option>
                            <option value="finished">Terminée</option>
                        </select>

                        <button type="submit">Créer la course</button>
                    </form>
                </div>

                <!-- Formulaire modification — un par course, caché par défaut -->
                <?php foreach($races as $race) : ?>
                <div id="races-form-edit-<?= $race['id'] ?>" hidden>
                    <h2>Modifier une course <a onclick="showTable('races')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-modifier-course&id=<?= $race['id'] ?>">
                        <input type="hidden" name="section" value="races">

                        <label>Nom du Grand Prix</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Pays</label>
                        <input type="text" name="country" value="<?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Début du week-end</label>
                        <input type="date" name="gpStart" value="<?= $race['gpStart'] ?>" required>

                        <label>Fin du week-end</label>
                        <input type="date" name="gpEnd" value="<?= $race['gpEnd'] ?>" required>

                        <label>Heure de départ</label>
                        <!-- str_replace remplace l'espace par T pour le format datetime-local -->
                        <input type="datetime-local" name="raceStart" value="<?= str_replace(' ', 'T', $race['raceStart']) ?>" required>

                        <label>Circuit Key API</label>
                        <input type="number" name="circuitKey_api" value="<?= $race['circuitKey_api'] ?>" required>

                        <label>Image (nom du fichier)</label>
                        <input type="text" name="picture" value="<?= htmlspecialchars($race['picture'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

                        <label>Statut</label>
                        <select name="status">
                            <!-- selected : pré-sélectionne le statut actuel -->
                            <option value="scheduled" <?= $race['status'] === 'scheduled' ? 'selected' : '' ?>>À venir</option>
                            <option value="cancelled" <?= $race['status'] === 'cancelled' ? 'selected' : '' ?>>Annulée</option>
                            <option value="finished" <?= $race['status'] === 'finished' ? 'selected' : '' ?>>Terminée</option>
                        </select>

                        <button type="submit">Modifier la course</button>
                    </form>
                </div>
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
                <div id="drivers-form-create" hidden>
                    <h2>Ajouter un pilote <a onclick="showTable('drivers')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-creer-pilote" enctype="multipart/form-data">
                        <input type="hidden" name="section" value="drivers">

                        <label>Prénom</label>
                        <input type="text" name="firstName" required>

                        <label>Nom</label>
                        <input type="text" name="name" required>

                        <label>Numéro</label>
                        <input type="number" name="number_api" required>

                        <label>Écurie</label>
                        <select name="idTeam">
                            <?php foreach($teams as $team) : ?>
                                <option value="<?= $team['id'] ?>"><?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endforeach; ?>
                        </select>

                        <label>Image (nom du fichier)</label>
                        <input type="file" name="picture">

                        <button type="submit">Ajouter le pilote</button>
                    </form>
                </div>

                <!-- Formulaire modification — un par pilote -->
                <?php foreach($drivers as $driver) : ?>
                <div id="drivers-form-edit-<?= $driver['id'] ?>" hidden>
                    <h2>Modifier un pilote <a onclick="showTable('drivers')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-modifier-pilote&id=<?= $driver['id'] ?>" enctype="multipart/form-data">
                        <input type="hidden" name="section" value="drivers">

                        <label>Prénom</label>
                        <input type="text" name="firstName" value="<?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Nom</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Numéro</label>
                        <input type="number" name="number_api" value="<?= $driver['number_api'] ?>" required>

                        <label>Écurie</label>
                        <select name="idTeam">
                            <?php foreach($teams as $team) : ?>
                                <!-- selected : pré-sélectionne l'écurie actuelle du pilote -->
                                <option value="<?= $team['id'] ?>" <?= $driver['idTeam'] == $team['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <label>Image (nom du fichier)</label>
                        <?php if($driver['picture']) : ?>
                            <img src="public/img/drivers/<?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                                style="width: 80px;">
                            <p>Image actuelle : <?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                        <input type="file" name="picture">

                        <button type="submit">Modifier le pilote</button>
                    </form>
                </div>
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
                <div id="teams-form-create" hidden>
                    <h2>Ajouter une écurie <a onclick="showTable('teams')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-creer-ecuries" enctype="multipart/form-data">
                        <input type="hidden" name="section" value="teams">

                        <label>Nom</label>
                        <input type="text" name="name" required>

                        <label>Pays</label>
                        <input type="text" name="country" required>

                        <label>Image (nom du fichier)</label>
                        <input type="file" name="picture">

                        <button type="submit">Ajouter l'écurie</button>
                    </form>
                </div>

                <!-- Formulaire modification — un par écurie -->
                <?php foreach($teams as $team) : ?>
                <div id="teams-form-edit-<?= $team['id'] ?>" hidden>
                    <h2>Modifier une écurie <a onclick="showTable('teams')">← Retour</a></h2>
                    <form method="POST" action="?action=admin-modifier-ecuries&id=<?= $team['id'] ?>" enctype="multipart/form-data">
                        <input type="hidden" name="section" value="teams">

                        <label>Nom</label>
                        <input type="text" name="name" value="<?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Pays</label>
                        <input type="text" name="country" value="<?= htmlspecialchars($team['country'], ENT_QUOTES, 'UTF-8') ?>" required>

                        <label>Image (nom du fichier)</label>
                        <?php if($team['picture']) : ?>
                            <img src="public/img/teams/<?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                                style="width: 80px;">
                            <p>Image actuelle : <?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                        <input type="file" name="picture">

                        <button type="submit">Modifier l'écurie</button>
                    </form>
                </div>
                <?php endforeach; ?>

            </section>

            <!-- ════════════════════════════════════════ -->
            <!-- SECTION VAINQUEUR — caché par défaut     -->
            <!-- Permet d'enregistrer le gagnant d'une    -->
            <!-- course terminée                          -->
            <!-- ════════════════════════════════════════ -->
            <section id="winner" class="dashboard-section" hidden>
                <h2>Ajouter un vainqueur</h2>
                <form method="POST" action="?action=admin-ajouter-vainqueur&id=0">
                    <input type="hidden" name="section" value="winner">

                    <label>Course terminée</label>
                    <!-- onchange : met à jour l'action du formulaire avec l'id de la course sélectionnée -->
                    <select name="idRace" onchange="this.form.action='?action=admin-ajouter-vainqueur&id=' + this.value">
                        <?php foreach($races as $race) : ?>
                            <?php if($race['status'] === 'finished') : // Seulement les courses terminées ?>
                                <option value="<?= $race['id'] ?>"><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endif; ?>
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
                                        <a onclick="confirmDelete('?action=admin-supprimer-pari&id=<?= $bet['id'] ?>&section=users')">Supprimer</a>
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
