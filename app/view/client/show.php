<div class="profile-wrapper">
    <a class="return" href="javascript:history.back()">← Retour</a>
    <h1>Fiche client</h1>
    
    <section>
        
            <table>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro de téléphone</th>
                        <th>Adresse</th>
                        <th>Ville</th>
                        <th>CP</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                            <td><?= htmlspecialchars($client['id'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['name'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['firstName'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['phone'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['address'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['zipCode'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($client['city'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="?action=client-update&id=<?= $client['id'] ?>">Modifier</a>
                                <a href="?action=client-delete&id=<?= $client['id'] ?>">Supprimer</a>
                            </td>
                        </tr>
                </tbody>

            </table>
    </section>
</div>