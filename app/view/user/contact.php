<section class="contact">
    <form action="?action=envoyer-contact" method="POST">
        <h1>Contact</h1>
        <label>Nom</label>
        <input type="text" name="name" placeholder="Prost">
        <label>Prénom</label>
        <input type="text" name="firstName" placeholder="Alain">
        <label>Email</label>
        <input type="text" name="email" placeholder="exemple@email.fr">
        <label>Sujet</label>
        <input type="text" name="sujet" placeholder="Faux départ">
        <label>Message</label>
        <textarea name="message" id="message" placeholder="Votre message"></textarea>
        <button class="btn-update" type="submit">Envoyer</button>
    </form>
</section>