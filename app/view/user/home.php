<?php if($lastRace) : // Vérifie si une course passée existe en BDD ?>
    <div class="race-card">
        <span class="badge">Résultats</span>

        <?php if($lastRace['picture']) : // Si une image est renseignée en BDD ?>
            <img src="public/img/circuits/<?= htmlspecialchars($lastRace['picture'], ENT_QUOTES, 'UTF-8') ?>" 
            alt="<?= htmlspecialchars($lastRace['name'], ENT_QUOTES, 'UTF-8') ?>">
        <?php else : // Sinon on affiche une image par défaut ?>
            <img src="public/img/circuits/default.webp" alt="Circuit par défaut">
        <?php endif; ?>

        <!-- Pays en titre principal, nom du GP en sous-titre -->
        <h2><?= htmlspecialchars($lastRace['country'], ENT_QUOTES, 'UTF-8') ?></h2>
        <p><?= htmlspecialchars($lastRace['name'], ENT_QUOTES, 'UTF-8') ?></p>

        <?php if($lastRace['winnerName']) : // Si un vainqueur est enregistré en BDD ?>
            <p>Vainqueur : 
                <?= htmlspecialchars($lastRace['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($lastRace['winnerName'], ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php else : // Si aucun vainqueur n'est encore renseigné ?>
            <p>Aucun vainqueur encore enregistré</p>
        <?php endif; ?>

        <!-- Dates du week-end formatées en français -->
        <p>Du <?= date('d/m/Y', strtotime($lastRace['gpStart'])) ?> 
        au <?= date('d/m/Y', strtotime($lastRace['gpEnd'])) ?></p>

        <!-- Lien vers la liste complète des courses -->
        <a href="?action=courses">Voir toutes les courses</a>
    </div>
<?php else : // Si aucune course passée n'existe en BDD ?>
    <p>Aucune course passée pour le moment.</p>
<?php endif; ?>


<?php if($nextRace) : // Vérifie si une prochaine course existe en BDD ?>
    <div class="race-card">

        <?php if($nextRace['status'] === 'cancelled') : // Si la course est annulée ?>
            <span class="badge">Course annulée</span>
        <?php else : // Sinon c'est une course à venir ?>
            <span class="badge">Prochaine Course</span>
        <?php endif; ?>

        <?php if($nextRace['picture']) : // Si une image est renseignée en BDD ?>
            <img src="public/img/circuits/<?= htmlspecialchars($nextRace['picture'], ENT_QUOTES, 'UTF-8') ?>" 
            alt="<?= htmlspecialchars($nextRace['name'], ENT_QUOTES, 'UTF-8') ?>">
        <?php else : // Sinon on affiche une image par défaut ?>
            <img src="public/img/circuits/default.webp" alt="Circuit par défaut">
        <?php endif; ?>

        <!-- Pays en titre principal, dates du week-end et nom du GP -->
        <h2><?= htmlspecialchars($nextRace['country'], ENT_QUOTES, 'UTF-8') ?></h2>
        <p>Du <?= date('d/m/Y', strtotime($nextRace['gpStart'])) ?> 
        au <?= date('d/m/Y', strtotime($nextRace['gpEnd'])) ?></p>
        <p><?= htmlspecialchars($nextRace['name'], ENT_QUOTES, 'UTF-8') ?></p>

        <?php if($nextRace['status'] !== 'cancelled') : // Si la course n'est pas annulée ?>
            <p>Placez votre pari avant le début de la course</p>
            <?php if(isset($_SESSION['user_logged'])) : // Si l'utilisateur est connecté ?>
                <a href="?action=parier&idRace=<?= $nextRace['id'] ?>">Parier</a>
            <?php else : // Sinon on invite à se connecter ?>
                <a href="?action=connexion">Connectez-vous pour parier</a>
            <?php endif; ?>
        <?php else : // Si la course est annulée on affiche un message ?>
            <span>Cette course a été annulée</span>
        <?php endif; ?>

    </div>
<?php else : // Si aucune course à venir n'existe en BDD ?>
    <p>Aucune course à venir.</p>
<?php endif; ?>

<div class="cards-container">

    <div class="race-card">
        <span class="badge">Pilotes</span>
        <img src="public/img/drivers/pilotes.jpg" alt="Pilotes F1">
        <h2>Pilotes</h2>
        <p>Découvrez tous les pilotes du championnat du monde de F1.</p>
        <a href="?action=pilotes">Voir les pilotes</a>
    </div>

    <div class="race-card">
        <span class="badge">Écuries</span>
        <img src="public/img/teams/ecuries.jpg" alt="Écuries F1">
        <h2>Écuries</h2>
        <p>Découvrez toutes les écuries du championnat du monde de F1.</p>
        <a href="?action=ecuries">Voir les écuries</a>
    </div>

</div>

