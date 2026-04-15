<section class="bets">
    <h1>Mes paris</h1>
    <div class="bets-stats">
        <div class="bets-won">
            <h2>Paris placés</h2>
            <p><?= htmlspecialchars($totalBets, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="bets-won">
            <h2>Paris gagnés</h2>
            <p><?= htmlspecialchars($wonBets, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>
        <div class="bets-history">
            <h2>Historique des paris</h2>
            <?php foreach($bets as $bet) : ?>
            <?php  if($bet['status'] === 'scheduled') {
                    $betClass = 'bet-pending';
                } elseif($bet['status'] === 'cancelled') {
                    $betClass = 'bet-cancelled';
                } elseif($bet['won'] === 1) {
                    $betClass = 'bet-won';
                } else {
                    $betClass = 'bet-lost';
                }?>
                <article class="bet-card <?= $betClass ?>">
                    <div class="bet-country">
                        <p><?= htmlspecialchars($bet['country'], ENT_QUOTES, 'UTF-8') ?>
                        <span class="separator">-</span>
                            <?= htmlspecialchars($bet['nameRace'], ENT_QUOTES, 'UTF-8') ?></p>
                    </div>
                    <div class="bet-driver">
                    <?php if($bet['status'] === 'scheduled') : ?>
                        <p>Pari : <?= htmlspecialchars($bet['firstName'], ENT_QUOTES, 'UTF-8') ?>
                        <?= htmlspecialchars($bet['nameDriver'], ENT_QUOTES, 'UTF-8') ?></p>
                        
                    <?php elseif($bet['status'] === 'finished') : ?>
                        <p>Vainqueur : <?= htmlspecialchars($bet['winnerFirstName'], ENT_QUOTES, 'UTF-8') ?>
                        <?= htmlspecialchars($bet['winnerName'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                    </div>
                    <div class="bet-status <?= $betClass ?>">
                        <?= translateBetStatus($bet['status'], $bet['won']) ?>
                    </div>
                    <?php if($bet['status'] === 'scheduled') : ?>
                            <button onclick="confirmDelete('?action=supprimer-pari&id=<?= $bet['id'] ?>')" 
                            class="btn-delete">
                                Annuler le pari
                            </button>
                        <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
</section>