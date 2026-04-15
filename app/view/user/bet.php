<!--  Card avec les infos de la course -->
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
                    <p>Grand Prix : Du <?= date('d/m/Y', strtotime($race['gpStart'])) ?> 
                        au <?= date('d/m/Y', strtotime($race['gpEnd'])) ?></p>
                        <p>Départ : <?= date('d/m/Y à H:i', strtotime($race['raceStart'])) ?></p>

                <?php endif; ?>
            </div>
        </div>
    </div>

<!-- Formulaire de pari -->
<section id="profile-info" class="dashboard-section">
<form method="POST" action="?action=creer-pari">
    <input type="hidden" name="idRace" value="<?= $race['id'] ?>">
 
    <!-- Liste des pilotes sous forme de boutons radio -->
    <!-- <?php foreach($drivers as $driver) : ?>
        <input type="radio" name="idDriver" value="<?= $driver['id'] ?>" 
            id="driver_<?= $driver['id'] ?>" required>
        <label for="driver_<?= $driver['id'] ?>">
            <span><?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['number_api'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?></span>
        </label>
    <?php endforeach; ?> -->
    <select name="idDriver" value="<?= $driver['id'] ?>" 
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
    <button type="submit">Confirmer mon pari</button>
 
</form>
</section>

