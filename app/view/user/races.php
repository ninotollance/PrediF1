<section class="bets">
    <h1>Courses</h1>
 <!-- Grille de 3 colonnes pour les courses -->
    <div class="races-grid">
        <?php foreach($races as $race) : // Boucle sur chaque course ?>

            <?php if($nextRace && $race['id'] === $nextRace['id'] && isset($_SESSION['user_logged'])) : // Si c'est la prochaine course et connecté ?>
                <a href="?action=parier&idRace=<?= $race['id'] ?>">
            <?php endif; ?>

            <article class="race-card-home <?= ($nextRace && $race['id'] === $nextRace['id']) ? 'race-next' : '' ?>">
                <!-- <figure class="race-card-home-img">
                    <figcaption class="badge"><?= translateStatus($race['status']) ?></figcaption>
                    <?php if($race['picture']) : ?>
                        <img src="public/img/circuits/<?= htmlspecialchars($race['picture'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php else : ?>
                        <img src="public/img/circuits/default.webp" alt="Circuit par défaut">
                    <?php endif; ?>
                    <figcaption class="date-race">
                        <p><?= date('d/m', strtotime($race['gpStart'])) ?> - <?= date('d/m', strtotime($race['gpEnd'])) ?></p>
                    </figcaption>
                </figure> -->

                <figure class="race-card-home-img">
    <figcaption class="badge"><?= translateStatus($race['status']) ?></figcaption>

    <?php if($race['name'] === 'Formula 1 Crypto.com Miami Grand Prix') : // Vidéo pour Miami ?>
        <video autoplay muted loop class="race-video">
            <source src="public/video/miami.webm" type="video/webm">
            <source src="public/video/miami.mp4" type="video/mp4">
        </video>
    <?php elseif($race['picture']) : // Sinon image normale ?>
        <img src="public/img/circuits/<?= htmlspecialchars($race['picture'], ENT_QUOTES, 'UTF-8') ?>" 
            alt="<?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>">
    <?php else : // Image par défaut ?>
        <img src="public/img/circuits/default.webp" alt="Circuit par défaut">
    <?php endif; ?>

    <figcaption class="date-race">
        <p><?= date('d/m', strtotime($race['gpStart'])) ?> 
        - <?= date('d/m', strtotime($race['gpEnd'])) ?></p>
    </figcaption>
</figure>
                <div class="race-card-home-body <?= ($nextRace && $race['id'] === $nextRace['id']) ? 'race-next' : '' ?>">
                    <div class="info-gp">
                        <h2><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <div class="info-gp-start">
                            <hp><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></hp>
                            <?php if($race['status'] === 'scheduled') : ?>
                                <p>Départ : <?= date('H:i', strtotime($race['raceStart'])) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="winner">
                        <?php if($race['status'] === 'finished' && $race['winnerName']) : ?>
                            <p>Vainqueur 🏆 <?= htmlspecialchars($race['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?> <?= htmlspecialchars($race['winnerName'], ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if($nextRace && $race['id'] === $nextRace['id']) : ?>
                                <p class="next-race-label">Prochaine course →</p>
                            <?php endif; ?>
                    <?php if($nextRace && $race['id'] === $nextRace['id'] && !isset($_SESSION['user_logged'])) : // Pas connecté ?>
                        <a href="?action=connexion" class="btn-home">Connectez-vous pour parier</a>
                    <?php endif; ?>
                </div>
            </article>

            <?php if($nextRace && $race['id'] === $nextRace['id'] && isset($_SESSION['user_logged'])) : ?>
                </a>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>
</section>