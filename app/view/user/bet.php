<!--  Card avec les infos de la course -->
<article class="race-card-home" aria-label="Formulaire de pari">

    <!-- Badge avec statut traduit en français via la fonction helper translateStatus() -->
     <figure class="race-card-home-img">
        <figcaption class="badge"><?= translateStatus($race['status']) ?></figcaption>

        <?php if($race['name'] === 'Formula 1 Crypto.com Miami Grand Prix') : // Vidéo pour Miami ?> <!-- à ameliorer avec colonne dans table RACE BDD -->
            <video autoplay muted loop class="race-video">
                <source src="public/video/miami.webm" type="video/webm">
                <source src="public/video/miami.mp4" type="video/mp4" onerror="this.parentNode.outerHTML = '<img src=\'public/img/circuits/default.     webp\'> alt=\'Circuit par défaut\'>'"> <!-- si erreur sur la 2ème vidéo photo par défaut -->
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

    <!-- Code pour uniquement les images 
    
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
    </figure> -->
            
    <!-- Pays en titre, dates du week-end et nom du GP -->
    <div class="race-card-home-body">
        <div class="info-gp">
            <h2><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></h2>
            <div class="info-gp-start">
                <h3><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                <?php if($race['status'] === 'scheduled') : ?>
                    <p>Grand Prix : Du <?= date('d/m/Y', strtotime($race['gpStart'])) ?> 
                        au <?= date('d/m/Y', strtotime($race['gpEnd'])) ?></p>
                        <p>Départ : <?= date('d/m/Y à H:i', strtotime($race['raceStart'])) ?></p>

                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
<!-- Formulaire de pari -->
<section id="profile-info" class="bet-section">
<form method="POST" action="?action=creer-pari">
    <input type="hidden" name="idRace" value="<?= $race['id'] ?>">
 
    <!-- Liste des pilotes sous forme de boutons radio -->
    <select class="choice-driver" name="idDriver" value="<?= $driver['id'] ?>" 
        id="driver_<?= $driver['id'] ?>" required>
        <?php foreach($drivers as $driver) : ?>
            <option value="<?= $driver['id'] ?>">
                #<?= htmlspecialchars($driver['number_api'], ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?>
                <?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?>
                - <?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?>
            </option>
        <?php endforeach; ?>
    </select>

 
    <!-- Bouton confirmation -->
    <button class="btn-register" type="submit">Confirmer mon pari</button>
    <br>
 
</form>
</section>
</article>