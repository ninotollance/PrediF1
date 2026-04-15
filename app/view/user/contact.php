<section class="contact">
    <form action="?action=envoyer-contact" method="POST">
        <h1>Contact</h1>
        <label>Nom</label>
        <input type="text" name="name">
        <label>Prénom</label>
        <input type="text" name="firstName">
        <label>Email</label>
        <input type="text" name="email">
        <label>Sujet</label>
        <input type="text" name="sujet">
        <label>Message</label>
        <textarea name="message" id="message"></textarea>
        <button class="btn-update" type="submit">Envoyer</button>
    </form>
</section>