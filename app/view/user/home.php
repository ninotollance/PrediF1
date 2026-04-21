<div class="races-container">
    <?php if($lastRace) : // Vérifie si une course passée existe en BDD ?>
        <article class="race-card-home">
            <figure class="race-card-home-img">
                <figcaption class="badge">Résultats</figcaption> <!-- Badge fixe pour la dernière course -->

                <?php if($lastRace['picture']) : // Si une image est renseignée en BDD ?>
                    <img src="public/img/circuits/<?= htmlspecialchars($lastRace['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                    alt="<?= htmlspecialchars($lastRace['name'], ENT_QUOTES, 'UTF-8') ?>">
                <?php else : // Sinon on affiche une image par défaut ?>
                    <img src="public/img/circuits/default-home.webp" alt="Circuit par défaut">
                <?php endif; ?>
                <div class="date-race">
                    <p><?= date('d/m', strtotime($lastRace['gpStart'])) ?> 
                    - <?= date('d/m', strtotime($lastRace['gpEnd'])) ?></p>
                </div>
            </figure>
            <div class="race-card-home-body">
            <!-- Pays en titre principal, nom du GP en sous-titre -->
                <div class="info-gp">
                    <h2><?= htmlspecialchars($lastRace['country'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <h3><?= htmlspecialchars($lastRace['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                </div>
                <div class="winner">
                    <?php if($lastRace['winnerName']) : // Si un vainqueur est enregistré en BDD ?>
                        <p>Vainqueur 🏆 
                            <?= htmlspecialchars($lastRace['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?>
                            <?= htmlspecialchars($lastRace['winnerName'], ENT_QUOTES, 'UTF-8') ?>
                            - <?= htmlspecialchars($lastRace['teamName'], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    <?php else : // Si aucun vainqueur n'est encore renseigné ?>
                        <p>Aucun vainqueur encore enregistré</p>
                    <?php endif; ?>

                </div>
            
                <!-- Lien vers la liste complète des courses -->
                <a href="?action=courses" class="btn-home">Voir toutes les courses</a>
            </div>
        </article>
    <?php else : // Si aucune course passée n'existe en BDD ?>
        <p>Aucune course passée pour le moment.</p>
    <?php endif; ?>


    <?php if($nextRace) : // Vérifie si une prochaine course existe en BDD ?>
        <article class="race-card-home">
            <figure class="race-card-home-img">
            <!-- Badge selon le statut de la course — traduit via opérateur ternaire -->
                <figcaption class="badge">
                    <?= $nextRace['status'] === 'cancelled' ? 'Annulée' : 'Prochaine Course' ?>
                </figcaption>

                <?php if($nextRace['picture']) : // Si une image est renseignée en BDD ?>
                    <img src="public/img/circuits/<?= htmlspecialchars($nextRace['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                    alt="<?= htmlspecialchars($nextRace['name'], ENT_QUOTES, 'UTF-8') ?>">
                <?php else : // Sinon on affiche une image par défaut ?>
                    <img src="public/img/circuits/default-home.webp" alt="Circuit par défaut">
                <?php endif; ?>
                <div class="date-race">
                    <p><?= date('d/m', strtotime($nextRace['gpStart'])) ?> 
                    - <?= date('d/m', strtotime($nextRace['gpEnd'])) ?></p>
                </div>
            </figure>
            <div class="race-card-home-body">
                <!-- Pays en titre principal, dates du week-end et nom du GP -->
                <div class="info-gp">
                    <h2><?= htmlspecialchars($nextRace['country'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <h3><?= htmlspecialchars($nextRace['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                </div>
                
                <div class="winner">
                    <?php if($nextRace['status'] !== 'cancelled') : // Si la course n'est pas annulée ?>
                        <p>Placez votre pari avant le début de la course</p>
                        <p>Départ : <?= date('H:i', strtotime($nextRace['raceStart'])) ?></p>
                    </div>
                        <?php if(isset($_SESSION['user_logged'])) : // Si l'utilisateur est connecté ?>
                            <a href="?action=parier&idRace=<?= $nextRace['id'] ?>" class="btn-home">Parier</a>
                        <?php else : // Sinon on invite à se connecter ?>
                            <a href="?action=connexion" class="btn-home">Connectez-vous pour parier</a>
                        <?php endif; ?>
                    <?php else : // Si la course est annulée on affiche un message ?>
                        <span class="btn-home-cancel">Cette course a été annulée</span>
                    <?php endif; ?>
                
            </div>
        </article>
    <?php else : // Si aucune course à venir n'existe en BDD ?>
        <p>Aucune course à venir.</p>
    <?php endif; ?>
</div>
 <!-- Cards statiques Pilotes et Écuries -->
<div class="cards-container">

    <article class="race-card-home">
        <figure class="driver-card-home-img">
            <figcaption class="badge">Pilotes</figcaption>
            <img src="public/img/drivers/default.webp" alt="Pilotes F1">
        </figure>
        <div class="pilote-card-home-body">
            <h2>Pilotes</h2>
            <p>Découvrez tous les pilotes du championnat du monde de F1.</p>
            <a href="?action=pilotes" class="btn-home">Voir les pilotes</a>
        </div>
    </article>

    <article class="race-card-home">
        <figure class="race-card-home-img">
            <figcaption class="badge">Écuries</figcaption>
            <img src="public/img/teams/default.webp" alt="Écuries F1">
        </figure>
        <div class="pilote-card-home-body">
            <h2>Écuries</h2>
            <p>Découvrez toutes les écuries du championnat du monde de F1.</p>
            <a href="?action=pilotes&tab=teams" class="btn-home">Voir les écuries</a>
        </div>
    </article>
</div>

