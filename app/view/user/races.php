<div class="races-grid">
    <?php foreach($races as $race) : ?>
        <div class="race-card">
            <?php if($race['status'] === 'finished') : ?>
                <span class="badge">Fini</span>
            <?php elseif($race['status'] === 'cancelled') : ?>
                <span class="badge">Annulée</span>
            <?php else : ?>
                <span class="badge">À venir</span>
            <?php endif; ?>
            <?php if($race['picture']) : ?>
                <img src="public/img/circuits/<?= htmlspecialchars($race['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                    alt="<?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>">
            <?php else : ?>
                <img src="public/img/circuits/default.wep" alt="Circuit par défaut">
            <?php endif; ?>
            <h2><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p>Du <?= date('d/m/Y', strtotime($race['gpStart'])) ?> 
            au <?= date('d/m/Y', strtotime($race['gpEnd'])) ?></p>
            <p><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></p>

            <?php if($race['status'] === 'finished' && $race['winnerName']) : ?>
                <p>Vainqueur : <?= htmlspecialchars($race['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($race['winnerName'], ENT_QUOTES, 'UTF-8') ?></p>
            <?php endif; ?>
            <?php if($race['status'] === 'scheduled') : ?>
                <?php if(isset($_SESSION['user_logged'])) : ?>
                    <a href="?action=parier&idRace=<?= $race['id'] ?>">Parier</a>
                <?php else : ?>
                    <a href="?action=connexion">Connectez-vous pour parier</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>