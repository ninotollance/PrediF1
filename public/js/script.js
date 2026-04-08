// ==============================
// ONGLET Pilotes / Écuries
// ==============================

// Fonction qui affiche un onglet et cache les autres
function showTab(tabName, event) {
    console.log('showTab appelé avec :', tabName);

    // Cache tous les contenus d'onglets avec hidden
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.hidden = true; // ← plus simple que classList
    });

    // Retire la classe active de tous les boutons
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Affiche l'onglet cliqué
    document.getElementById(tabName).hidden = false;

    // Met le bouton cliqué en actif
    if(event && event.target) {
        event.target.classList.add('active');
    }
}