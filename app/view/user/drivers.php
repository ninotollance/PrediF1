<!-- Onglets de navigation pour switcher entre pilotes et écuries -->
<section class="driver-team" aria-label="Pilotes et Écuries">
    <div class="tabs">
        <button class="tab-btn" data-tab="drivers">Pilotes</button>
        <button class="tab-btn" data-tab="teams">Écuries</button>
    </div>

    <!-- Contenu de l'onglet Pilotes, affiché par défaut grâce à la classe active -->
    <div id="drivers" class="tab-content">
        <div class="sort-buttons">
            <button class="sort-btn active" data-sort="number">Par numéro</button>
            <button class="sort-btn" data-sort="standings">Par classement</button>
        </div>
        <?php foreach($drivers as $driver) : // Boucle sur chaque pilote récupéré en BDD ?>
            <article class="driver-card" data-number="<?= $driver['number_api'] ?>">
                <figure class="card-img">
                    <?php if($driver['picture']) : // Si une photo est renseignée en BDD ?>
                        <img src="public/img/drivers/<?= htmlspecialchars($driver['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                            alt="<?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php else : // Sinon on affiche une photo par défaut ?>
                        <img src="public/img/drivers/default.webp" alt="Pilote">
                    <?php endif; ?>

                    <!-- Numéro du pilote -->
                    <figcaption class="driver-number">#<?= $driver['number_api'] ?></figcaption>
                </figure>

                <!-- Prénom, nom et écurie du pilote, échappés contre les failles XSS -->
                 <div class="driver-info">
                    <div class="driver-name">
                        <p><?= htmlspecialchars($driver['firstName'], ENT_QUOTES, 'UTF-8') ?></p>
                        <p><?= htmlspecialchars($driver['name'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <p><?= htmlspecialchars($driver['teamName'], ENT_QUOTES, 'UTF-8') ?></p> <!-- teamName vient du JOIN avec TEAM -->
                 </div>

            </article>
        <?php endforeach; ?>
    </div>

    <!-- Contenu de l'onglet Écuries, caché par défaut -->
    <div id="teams" class="tab-content" hidden>
        <?php foreach($teams as $team) : // Boucle sur chaque écurie récupérée en BDD ?>
            <article class="team-card">
                <figure class="card-img">
                    <?php if($team['picture']) : // Si une photo est renseignée en BDD ?>
                        <img src="public/img/teams/<?= htmlspecialchars($team['picture'], ENT_QUOTES, 'UTF-8') ?>" 
                            alt="<?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php else : // Sinon on affiche une photo par défaut ?>
                        <img src="public/img/teams/default.webp" alt="Écurie">
                    <?php endif; ?>
                </figure>
                <!-- Nom de l'écurie en titre et pays en sous-titre, échappés contre les failles XSS -->
                <div class="team-info">
                    <h2><?= htmlspecialchars($team['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <p><?= htmlspecialchars($team['country'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

