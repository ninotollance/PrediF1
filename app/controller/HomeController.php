<?php
namespace TestCDA\controller;

class HomeController extends Controller {

    // Affiche la page d'accueil
    public function index() {
        $this->checkConnexion();
        require RACINE . '/app/view/layout/header.php';
        require RACINE . '/app/view/home/home.php';
        require RACINE . '/app/view/layout/footer.php';
    }
}