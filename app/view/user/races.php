<section class="bets">
    <h1>Courses</h1>
 <!-- Grille de 3 colonnes pour les courses -->
    <div class="races-grid">
        <?php foreach($races as $race) : // Boucle sur chaque course récupérée en BDD ?>
            <article class="race-card-home">

                <!-- Badge avec statut traduit en français via la fonction helper translateStatus() -->
                <figure class="race-card-home-img">
                    <figcaption class="badge"><?= translateStatus($race['status']) ?></figcaption>

                    <?php if($race['picture']) : // Si une image est renseignée en BDD ?>
                        <img src="public/img/circuits/<?= htmlspecialchars($race['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                            alt="<?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php else : // Sinon on affiche une image par défaut ?>
                        <img src="public/img/circuits/default.webp" alt="Circuit par défaut">
                    <?php endif; ?>
                    <figcaption class="date-race">
                            <p> <?= date('d/m', strtotime($race['gpStart'])) ?> 
                            - <?= date('d/m', strtotime($race['gpEnd'])) ?></p>
                    </figcaption>
                </figure>
                
                <!-- Pays en titre, dates du week-end et nom du GP -->
                <div class="race-card-home-body">
                    <div class="info-gp">
                        <h2><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <div class="info-gp-start">
                            <p><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php if($race['status'] === 'scheduled') : ?>
                                <p>Départ : <?= date('H:i', strtotime($race['raceStart'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="winner">
                        <?php if($race['status'] === 'finished' && $race['winnerName']) : // Si la course est terminée et qu'un vainqueur est enregistré ?>
                            <p>Vainqueur 🏆 <?= htmlspecialchars($race['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?>
                            <?= htmlspecialchars($race['winnerName'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                    </div>
                            
                    <?php if($race['status'] === 'scheduled') : // Si la course est à venir ?>
                        <?php if(isset($_SESSION['user_logged'])) : // Si l'utilisateur est connecté ?>
                            <a href="?action=parier&idRace=<?= $race['id'] ?>" class="btn-home">Parier</a>
                        <?php else : // Sinon on invite à se connecter ?>
                            <a href="?action=connexion" class="btn-home">Connectez-vous pour parier</a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

            </article>
        <?php endforeach; ?>
    </div>
</section>