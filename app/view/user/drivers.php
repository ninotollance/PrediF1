<!-- Onglets de navigation pour switcher entre pilotes et écuries -->
<div class="tabs">
    <button class="tab-btn active" onclick="showTab('drivers', event)">Pilotes</button> <!-- Onglet actif par défaut -->
    <button class="tab-btn" onclick="showTab('teams', event)">Écuries</button>
</div>

<!-- Contenu de l'onglet Pilotes, affiché par défaut grâce à la classe active -->
<div id="drivers" class="tab-content active">
    <?php foreach($drivers as $driver) : // Boucle sur chaque pilote récupéré en BDD ?>
        <div class="driver-card">

            <?php if($driver['picture']) : // Si une photo est renseignée en BDD ?>
                <img src="public/img/drivers/<?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?>">
            <?php else : // Sinon on affiche une photo par défaut ?>
                <img src="public/img/drivers/default.webp" alt="Pilote">
            <?php endif; ?>

            <!-- Numéro du pilote -->
            <span class="driver-number">#<?= $driver['number_api'] ?></span>

            <!-- Prénom, nom et écurie du pilote, échappés contre les failles XSS -->
            <p><?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?></p> <!-- teamName vient du JOIN avec TEAM -->

        </div>
    <?php endforeach; ?>
</div>

<!-- Contenu de l'onglet Écuries, caché par défaut -->
<div id="teams" class="tab-content" hidden>
    <?php foreach($teams as $team) : // Boucle sur chaque écurie récupérée en BDD ?>
        <div class="team-card">

            <?php if($team['picture']) : // Si une photo est renseignée en BDD ?>
                <img src="public/img/teams/<?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                     alt="<?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?>">
            <?php else : // Sinon on affiche une photo par défaut ?>
                <img src="public/img/teams/default.webp" alt="Écurie">
            <?php endif; ?>

            <!-- Nom de l'écurie en titre et pays en sous-titre, échappés contre les failles XSS -->
            <h2><?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p><?= htmlspecialchars($team['country'], ENT_QUOTES, 'UTF-8') ?></p>

        </div>
    <?php endforeach; ?>
</div>

