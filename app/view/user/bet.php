<!-- Card avec les infos de la course -->
<div class="race-card">

    <!-- Image du circuit stockée dans public/img/circuits/ -->
    <?php if($race['picture']) : ?>
        <img src="public/img/circuits/<?= htmlspecialchars($race['picture'], ENT_QUOTES, 'UTF-8') ?>" 
            alt="Circuit <?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?>">
    <?php else : ?>
        <img src="public/img/circuits/default.jpg" alt="Circuit par défaut"> <!-- Affiche une image par default si rien mis en BDD -->
    <?php endif; ?>

    <!-- Infos de base -->
    <h2><?= htmlspecialchars($race['name'], ENT_QUOTES, 'UTF-8') ?></h2>
    <p><?= htmlspecialchars($race['country'], ENT_QUOTES, 'UTF-8') ?></p>
    <p>Du <?= date('d/m/Y', strtotime($race['gpStart'])) ?> 
    au <?= date('d/m/Y', strtotime($race['gpEnd'])) ?></p>
    <p>Départ : <?= date('d/m/Y à H:i', strtotime($race['raceStart'])) ?></p>

</div>

<form method="POST" action="?action=creer-pari">
    <input type="hidden" name="idRace" value="<?= $race['id'] ?>">
    <?php foreach($drivers as $driver) : ?>
        <input type="radio" name="idDriver" value="<?= $driver['id'] ?>" id="driver_<?= $driver['id'] ?>" required>
        <label for="driver_<?= $driver['id'] ?>">
            <span><?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['number_api'], ENT_QUOTES, 'UTF-8') ?></span>
            <span><?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?></span>
        </label>
    <?php endforeach; ?>

    <button type="submit">Confirmer mon pari</button>

</form>
