// =============================================
// API FETCH — Réorganisation des cards pilotes
// =============================================


// Trie les cards pilotes par classement du championnat via l'API Jolpica
function reorderByStandings() {

    // Parcourt tous les boutons de tri et retire la classe active
    // → aucun bouton n'est actif avant d'en activer un
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Lance une requête HTTP vers l'API Jolpica pour récupérer le classement actuel
    fetch('https://api.jolpi.ca/ergast/f1/current/driverStandings/')

    // La réponse est brute (HTTP) → .json() la convertit en objet JavaScript lisible
    .then(response => response.json())

    // data = l'objet JavaScript complet retourné par l'API
    .then(data => {

        // L'API retourne une structure très imbriquée :
        // data.MRData → objet principal
        // .StandingsTable → tableau des classements
        // .StandingsLists[0] → classement de la dernière course (index 0 = premier/seul élément)
        // .DriverStandings → tableau de tous les pilotes avec leur position
        const standings = data.MRData.StandingsTable.StandingsLists[0].DriverStandings;

        const activeBtn = document.querySelector('[data-sort="standings"]');

        if(activeBtn) activeBtn.classList.add('active');
        const cards = document.querySelectorAll('.driver-card');
        const container = document.querySelector('#drivers');
        const cardsArray = Array.from(cards);

        // Trie le tableau de cards en comparant les pilotes deux par deux (a et b)
        cardsArray.sort((a, b) => {

            // Récupère le numéro du pilote depuis l'attribut data-number de chaque card
            // getAttribute retourne une string → parseInt la convertit en nombre
            const numberA = parseInt(a.getAttribute('data-number'));
            const numberB = parseInt(b.getAttribute('data-number'));

            // .find() cherche dans standings le pilote dont le numéro correspond
            // Driver.permanentNumber est une string dans l'API → parseInt pour comparer avec numberA/numberB
            // ?. (optional chaining) évite une erreur si .find() retourne undefined (pilote introuvable)
            // .position = la position dans le classement (1er, 2ème, etc.)
            // ?? 99 = valeur par défaut si le pilote n'est pas dans le classement → mis à la fin
            const positionA = standings.find(p => parseInt(p.Driver.permanentNumber) === numberA)?.position ?? 99;
            const positionB = standings.find(p => parseInt(p.Driver.permanentNumber) === numberB)?.position ?? 99;

            // Retourne la différence pour déterminer l'ordre :
            // négatif → a avant b | positif → b avant a | 0 → inchangé
            return positionA - positionB;
        });

        // Réinsère chaque card dans le conteneur dans le nouvel ordre trié
        // appendChild déplace l'élément existant → pas de duplication
        cardsArray.forEach((card, index) => {
            container.appendChild(card);
            card.querySelector('.driver-number').textContent = index + 1 + 'e'; // remplace #numéro par position
        });
    });
}

// Trie les cards pilotes par numéro de voiture (ordre croissant)
// event : l'événement du clic, nécessaire pour gérer le bouton actif
function reorderByNumber() {

    // Retire la classe active de tous les boutons de tri
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Active le bon bouton
    const activeBtn = document.querySelector('[data-sort="number"]');
    if(activeBtn) activeBtn.classList.add('active');
    // Récupère toutes les cards pilotes
    const cards = document.querySelectorAll('.driver-card');
    // Récupère le conteneur
    const container = document.querySelector('#drivers');
    // Trie et réinsère...

    // Convertit NodeList en tableau pour pouvoir utiliser .sort()
    const cardsArray = Array.from(cards);

    // Trie par numéro de voiture croissant
    // Récupère data-number de chaque card et soustrait pour obtenir l'ordre
    cardsArray.sort((a, b) => {
        return parseInt(a.getAttribute('data-number')) - parseInt(b.getAttribute('data-number'));
    });

    cardsArray.forEach(card => {
        container.appendChild(card);
        const number = card.getAttribute('data-number');
        card.querySelector('.driver-number').textContent = '#' + number; // remet le numéro
    });

}

// =====================
// BURGER MENU — Mobile
// =====================

// Ouvre/ferme le menu mobile au clic sur le burger
function toggleMenu() {
    const menu = document.querySelector('.mobile-menu');    // Récupère le menu déroulant
    const burger = document.querySelector('.burger');       // Récupère le bouton burger
    const overlay = document.querySelector('.overlay');     // Récupère l'overlay sombre

    menu.hidden = !menu.hidden;        // Inverse l'état du menu
    overlay.hidden = !overlay.hidden;  // Inverse l'état de l'overlay
    burger.classList.toggle('active'); // Animation X
}

// ============================
// ONGLETS — Pilotes / Écuries
// ============================

// Fonction qui affiche un onglet et cache les autres
// tabName : l'id du div à afficher ('drivers' ou 'teams')
function showTab(tabName) {

    // Cache tous les éléments avec la classe tab-content
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.hidden = true;
    });

    // Retire la classe active de tous les boutons d'onglets
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Affiche le div de l'onglet s'il existe sur cette page
    const content = document.getElementById(tabName);
    if(content) content.hidden = false;

    // Active le bouton correspondant s'il existe sur cette page
    const activeBtn = document.querySelector('[data-tab="' + tabName + '"]');
    if(activeBtn) activeBtn.classList.add('active');

}

// ======================
// CHARGEMENT DE LA PAGE
// ======================

// Au chargement complet du DOM, vérifie les paramètres URL
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);

    // Ouvre l'onglet pilotes/écuries demandé dans l'URL
    // Ex: ?action=pilotes&tab=teams → ouvre l'onglet Écuries
    const tab = urlParams.get('tab'); // récupère le paramètre 'tab' dans l'URL
    if(document.querySelector('.driver-team')) { // seulement sur la page pilotes
        showTab(tab ?? 'drivers');
        reorderByNumber();
    }

    // Ouvre la section dashboard demandée dans l'URL
    // Ex: ?action=admin&section=drivers → ouvre la section Pilotes
    const section = urlParams.get('section');
    if(section) {
        showSection(section); // Section demandée dans l'URL
    }
    // Onglets pilotes/écuries — addEventListener au lieu de onclick
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const tab = this.getAttribute('data-tab');
            if(tab) showTab(tab);
        });
    });
    // tri pilotes par numéro ou classement
    document.querySelectorAll('.sort-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const sort = this.getAttribute('data-sort');
        if(sort === 'number') reorderByNumber();
        if(sort === 'standings') reorderByStandings();
        });
    });
    // Active le bon lien dans la nav au chargement
    document.querySelectorAll('.dashboard-nav a').forEach(a => {
        if(a.getAttribute('data-section') === (section || 'races')) {
            a.classList.add('active');
        }
    });

    // Fait disparaître le toast après 3 secondes
    const toast = document.querySelector('.toast');
    if(toast) {
        setTimeout(function() {
            toast.style.transition = 'opacity 0.5s ease'; // Transition douce
            toast.style.opacity = '0';                    // Rend invisible
            setTimeout(function() {
                toast.remove(); // Supprime du DOM après la transition
            }, 500);
        }, 3000); // Attend 3 secondes
    }

    // Liens du dashboard — addEventListener au lieu de onclick
    // data-section : attribut HTML qui définit la section à afficher
    document.querySelectorAll('.dashboard-nav a').forEach(a => {
        a.addEventListener('click', function() {
            const section = this.getAttribute('data-section');
            if(section) showSection(section);
            // Si pas de data-section → lien normal (retour au site, déconnexion)
        });
    });

    document.querySelectorAll('.profile-nav .profile-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = this.getAttribute('data-section');
            if(section) showSection(section);
        });
    });
    // Burger menu — addEventListener
    document.querySelector('.burger')?.addEventListener('click', toggleMenu);
    document.querySelector('.overlay')?.addEventListener('click', toggleMenu);

    // Burger menu Dashboard — addEventListener
    document.querySelector('.dashboard-burger')?.addEventListener('click', toggleDashboardMenu);
    document.querySelector('.overlay-dashboard')?.addEventListener('click', toggleDashboardMenu);
});

// ==========================
// DASHBOARD — Burger mobile
// ==========================

// Ouvre/ferme le menu du dashboard sur mobile
function toggleDashboardMenu() {
    const nav = document.querySelector('.dashboard-nav');           // Récupère le menu
    const burger = document.querySelector('.dashboard-burger');     // Récupère le burger
    const overlay = document.querySelector('.overlay-dashboard');   // Récupère l'overlay

    nav.classList.toggle('open');      // Ajoute/retire la classe open
    overlay.hidden = !overlay.hidden;  // Inverse l'état de l'overlay
    burger.classList.toggle('active'); // Animation X
}

// ====================================
// DASHBOARD — Sections et formulaires
// ====================================

// Affiche une section du dashboard et cache les autres
function showSection(sectionName) {
    document.querySelectorAll('.dashboard-nav a').forEach(a => {
        a.classList.remove('active'); // Retire active de tous les liens
    });

    const activeLink = document.querySelector('[data-section="' + sectionName + '"]');
    if(activeLink) activeLink.classList.add('active');

    document.querySelectorAll('.profile-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Met à jour l'URL sans recharger la page
    // Comme ça si tu rafraîchis, tu restes sur le bon onglet
    history.pushState(null, '', '?action=admin&section=' + sectionName);

    // Cache toutes les sections
    document.querySelectorAll('.dashboard-section').forEach(section => {
        section.hidden = true; // Cache chaque section
    });

    // Affiche la section demandée
    const el = document.getElementById(sectionName);
    if(el) el.hidden = false; // Vérifie que l'élément existe avant de l'afficher

    // Ferme le menu mobile si ouvert
    const nav = document.querySelector('.dashboard-nav');
    const overlay = document.querySelector('.overlay-dashboard');
    const burger = document.querySelector('.dashboard-burger');

    if(nav && nav.classList.contains('open')) {
        nav.classList.remove('open');      // Ferme le menu
        overlay.hidden = true;             // Cache l'overlay
        burger.classList.remove('active'); // Retire l'animation X
    }
}

// Affiche un formulaire et cache le tableau
function showForm(sectionName, type) {
    document.getElementById(sectionName + '-table').hidden = true;          // Cache le tableau
    document.getElementById(sectionName + '-form-' + type).hidden = false;  // Affiche le formulaire
}

// Cache tous les formulaires et affiche le tableau
function showTable(sectionName) {
    // Cache tous les formulaires de la section
    document.querySelectorAll('[id^="' + sectionName + '-form"]').forEach(form => {
        form.hidden = true;
    });
    // Affiche le tableau
    document.getElementById(sectionName + '-table').hidden = false;
}

// Demande confirmation avant suppression puis redirige
function confirmDelete(url) {
    if(confirm('Êtes-vous sûr de vouloir supprimer ?')) { // Demande confirmation
        window.location.href = url; // Redirige vers l'URL de suppression
    }
}

// ============================
// DASHBOARD — Recherche paris
// ============================

// Filtre les lignes d'un tableau selon le texte saisi
// tableId : l'id du tableau à filtrer
// inputId : l'id du champ de recherche
function filterTable(inputId, tableId) {
    const input = document.getElementById(inputId).value.toLowerCase(); // Récupère la valeur saisie
    const rows = document.querySelectorAll('#' + tableId + ' tbody tr'); // Récupère toutes les lignes

    rows.forEach(row => {
        const text = row.textContent.toLowerCase(); // Récupère tout le texte de la ligne
        row.style.display = text.includes(input) ? '' : 'none'; // Affiche/cache la ligne
    });
}

