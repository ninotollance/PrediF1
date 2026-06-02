<div class="profile-wrapper">
    <h1>Rechercher un client</h1>
    <form action="?action=client-search" method="POST">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
        <input type="text" name="search" placeholder="Nom ou identifiant">
        <button type="submit">Rechercher</button>
    </form>
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
                <?php if(isset($client) && $client) : ?>
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
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</div>