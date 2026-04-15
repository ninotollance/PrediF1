<div class="profile-wrapper">
 
    <!-- Nav onglets — horizontal sur mobile, vertical sur desktop -->
    <nav class="profile-nav">
        <button class="profile-btn" data-section="profile-info">Mes informations</button>
        <button class="profile-btn" data-section="profile-bets">Mes paris</button>
    </nav>
 
    <!-- Contenu -->
    <div class="profile-content">
 
        <!-- Section infos personnelles -->
        <section id="profile-info" class="dashboard-section">
            <h1>Mes informations</h1>
                <form method="POST" action="?action=modifier-profil">
 
                    <!-- Champ prénom -->
                    <label>Prénom</label>
                    <input type="text" name="firstname"
                    value="<?= htmlspecialchars($user['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>
 
                    <!-- Champ nom -->
                    <label>Nom</label>
                    <input type="text" name="name"
                    value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>
 
                    <!-- Champ email -->
                    <label>Email</label>
                    <input type="email" name="email"
                    value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>
 
                    <!-- Bouton enregistrer -->
                    <button type="submit" class="btn-update">Enregistrer</button>
 
                </form>
 
                <!-- Section suppression de compte -->
                <div class="delete-user">
                    <p>Supprimer le compte</p>
                    <button onclick="confirmDelete('?action=supprimer-compte&id=<?= $user['id'] ?>')" 
                        class="btn-delete-user">Supprimer</button>
                </div>
 
        </section>
 
        <!-- Section paris -->
        <section id="profile-bets" class="dashboard-section" hidden>
            <h1>Mes paris</h1>
 
            <!-- Stats paris placés / gagnés -->
            <div class="bets-stats">
                <div class="bets-won">
                    <h2>Paris placés</h2>
                    <p><?= htmlspecialchars($totalBets, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="bets-won">
                    <h2>Paris gagnés</h2>
                    <p><?= htmlspecialchars($wonBets, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </div>
 
            <!-- Lien vers l'historique complet -->
            <div class="profile-betHistory">
                <a href="?action=historique-paris" class="btn-home">Voir mes paris</a>
            </div>
 
        </section>
    </div>
</div>