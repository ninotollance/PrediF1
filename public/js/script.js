// Ouvre/ferme le menu mobile au clic sur le burger
document.addEventListener('DOMContentLoaded', function() {

    // Burger menu principal
    const burger = document.querySelector('.burger');
    const menu = document.querySelector('.mobile-menu');

    if(burger && menu) {
        burger.addEventListener('click', function() {
            menu.hidden = !menu.hidden; // Affiche/cache le menu
        });
    }

    // Burger menu dashboard
    const dashBurger = document.querySelector('.dashboard-burger');
    const dashNav = document.querySelector('.dashboard-nav');

    if(dashBurger && dashNav) {
        dashBurger.addEventListener('click', function() {
            dashNav.classList.toggle('open'); // Affiche/cache le menu dashboard
        });
    }

    // Toast — disparaît après 3 secondes
    const toast = document.querySelector('.toast');
    if(toast) {
        setTimeout(function() {
            toast.remove();
        }, 3000);
    }

});

