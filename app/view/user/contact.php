<section class="contact" aria-label="Formulaire de contact">
    <h1>Contact</h1>
    <form action="?action=envoyer-contact" method="POST">

        <!-- Champ caché qui envoie le token CSRF avec le formulaire -->
        <!-- Le serveur vérifiera que ce token correspond à celui en session -->
        <input type="hidden" name="csrf_token" 
        value="<?= $_SESSION['csrf_token'] ?>">

        
        <label>Nom</label>
        <input type="text" name="name" placeholder="Prost" required>
        <?php if(!empty($errors['name'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <label>Prénom</label>
        <input type="text" name="firstName" placeholder="Alain" required>
        <?php if(!empty($errors['firstName'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['firstName'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <label>Email</label>
        <input type="email" name="email" placeholder="exemple@email.fr" required>
        <?php if(!empty($errors['email'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <label>Sujet</label>
        <input type="text" name="sujet" placeholder="Faux départ" required>
        <?php if(!empty($errors['sujet'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['sujet'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <label>Message</label>
        <textarea name="message" id="message" placeholder="Votre message" required></textarea>
        <?php if(!empty($errors['message'])) : ?>
            <p class="form-error"><?= htmlspecialchars($errors['message'], ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>
        <button class="btn-update" type="submit">Envoyer</button>
    </form>
</section>