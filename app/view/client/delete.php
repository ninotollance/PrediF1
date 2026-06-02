<!-- Formulaire de confirmation de suppression client -->
<section class="contact" aria-label="Formulaire de suppression client">
    <h1>Supprimer un client</h1>
    <p>Veuillez saisir le nom et le prénom du client pour confirmer la suppression.</p>

    <form action="?action=client-delete&id=<?= $client['id'] ?>" method="POST">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

        <!-- Champ nom -->
        <label>Nom</label>
        <input type="text" name="name" placeholder="<?= htmlspecialchars($client['name'], ENT_QUOTES, 'UTF-8') ?>" required>

        <!-- Champ prénom -->
        <label>Prénom</label>
        <input type="text" name="firstName" placeholder="<?= htmlspecialchars($client['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>

        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">Confirmer la suppression</button>
        <a href="?action=clients">Annuler</a>
    </form>
</section>