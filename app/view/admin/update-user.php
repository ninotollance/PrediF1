<!-- Formulaire d'inscription -->
<section class="form-wrapper" aria-label="Formulaire de modification user">
    <a class="return" href="javascript:history.back()">← Retour</a>
    <h1>Modifier un User</h1>
    <form action="?action=admin-update-user&id=<?= $user['id'] ?>" method="POST">
        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        <!-- Champ nom -->
        <label>Nom</label>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['name'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ prénom -->
        <label>Prénom</label>
        <input type="text" name="firstName" value="<?= htmlspecialchars($user['firstName'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['firstName'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['firstName'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
 
        <!-- Champ email -->
        <label>Email</label>
        <input type="text" name="email" value="<?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?>" required>
        <?php if(!empty($errors['email'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <!-- Champ rôle -->
        <label>Rôle</label>
        <select name="role" required>
            <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <?php if(!empty($errors['role'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['role'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        
        <!-- Bouton envoi -->
        <button type="submit" class="btn-register">Valider</button>
 
    </form>
</section>