</main>
<footer>
    <div class="footer-inner">
        <div class="footer-logo">
            <a href="?action=accueil">
                <img src="public/img/logoBlanc.png" alt="Logo PrediF1" class="logo">
            </a>
            <p>Votre plateforme de paris sur la Formule 1.</p>
        </div>
        <section>
            <h2>Liens Rapides</h2>
            <ul>
                <li><a href="?action=accueil">Accueil</a></li>
                <li><a href="?action=courses">Courses</a></li>
                <li><a href="?action=pilotes">Pilotes & Écuries</a></li>
                <?php if (isset($_SESSION['user_logged'])) : ?>
                    <li><a href="?action=paris">Mes Paris</a></li>
                
                <?php endif; ?>
            </ul>
        </section>
        <section>
            <h2>Information</h2>
            <ul>
                <li><a href="?action=conditions-utilisation">Conditions d'utilisation</a></li>
                <li><a href="?action=confidentialite">Confidentialité</a></li>
                <li><a href="?action=jeu-responsable">Jeu responsable</a></li>
            </ul>
        </section>
        <section>
            <h2>Contact</h2>
            <ul>
                <li><a href="?action=contact">Nous contacter</a></li>
                <li><a href="https://twitter.com/...">Twitter</a></li>
                <li><a href="https://instagram.com/...">Instagram</a></li>
            </ul>
        </section>
    </div>
</footer>
<script src="public/js/script.js"></script>
</body>
</html>