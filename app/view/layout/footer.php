<footer>
    <div>
        <a href="/">
            <img src="public/img/logoBlanc.png" alt="Logo PrediF1" class="logo">
        </a>
        <p>Votre plateforme de paris sur la Formule 1.</p>
    </div>
    <div>
        <h2>Liens Rapides</h2>
        <ul>
            <li><a href="?action=accueil">Accueil</a></li>
            <li><a href="?action=courses">Courses</a></li>
            <li><a href="?action=pilotes">Pilotes & Écuries</a></li>
        </ul>

        <?php if (isset($_SESSION['user_logged'])) : ?>
        <ul>
            <li><a href="?action=paris">Mes Paris</a></li>
        </ul>
        <?php endif; ?>

        <ul>
            <li><a href="?action=contact">Nous contacter</a></li>
        </ul>

        <ul>
            <li><a href="?action=conditions-utilisation">Conditions d'utilisation</a></li>
            <li><a href="?action=confidentialite">Confidentialité</a></li>
            <li><a href="?action=jeu-responsable">Jeu responsable</a></li>
        </ul>
    </div>
    <div>
        <h2>Contact</h2>
        <ul>
            <li>Email: contact@f1paris.com</li>
            <li>Tél: +33 1 23 45 67 89</li>
            <li>Twitter Instagram</li>
        </ul>
    </div>
</footer>
</body>
</html>