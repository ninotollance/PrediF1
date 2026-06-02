<div class="profile-wrapper">
    <h1>Fiche clients</h1>
    <section>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($clients as $client) : ?>
                <tr>
                    <td><?= htmlspecialchars($client['id'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($client['name'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($client['firstName'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a href="?action=client-show&id=<?= $client['id'] ?>">Voir</a>
                        <a href="?action=client-update&id=<?= $client['id'] ?>">Modifier</a>
                        <a href="?action=client-delete&id=<?= $client['id'] ?>">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>