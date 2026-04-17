<?php
namespace PrediF1\controller;
use Exception;

abstract class Controller {

    // Vérifie si l'utilisateur est connecté, redirige vers connexion sinon
    protected function checkConnexion() {
        if(empty($_SESSION['user_logged'])) { // Vérifie si l'utilisateur est connecté
            $this->redirect('connexion'); // Redirige vers la page de connexion
        }
    }

    // Vérifie si l'utilisateur est admin, redirige vers accueil sinon
    protected function checkAdmin() {
        $this->checkConnexion(); // Vérifie d'abord si l'utilisateur est connecté
        if($_SESSION['user_role'] !== 'admin') { // Vérifie si le rôle est admin
            $this->redirect('accueil'); // Redirige vers l'accueil si pas admin
        }
    }

    // Redirige vers une action du router et arrête l'exécution
    protected function redirect(string $action) {
        header('location: ?action=' . $action); // Construit l'URL de redirection
        exit; // Arrête l'exécution du script
    }

    // Pour les try/catch message générique
    protected function catchError(Exception $e) {
        $_SESSION['login_error'] = $e->getMessage(); // Message générique pour ne pas exposer les détails techniques
        error_log($e->getMessage()); // Log l'erreur complète pour le développeur
    }

    // Pour les erreurs métier message spécifique passé en paramètre
    protected function error(string $message) {
        $_SESSION['login_error'] = $message; // Message spécifique passé en paramètre
    }

    // Stocke un message de succès en session pour l'afficher à l'utilisateur
    protected function success(string $message) {
        $_SESSION['success'] = $message; // Message spécifique passé en paramètre
    }

    // Stocke une erreur de formulaire — affichée dans le formulaire, pas en toast
    protected function formError(string $message) {
        $_SESSION['form_error'] = $message;
    }
    // Définit le titre de la page pour le SEO
    protected function setTitle(string $title) {
        $GLOBALS['pageTitle'] = $title;
    }
    // Vérifie que le token CSRF du formulaire correspond à celui en session
    protected function checkCsrf() {
        if(empty($_POST['csrf_token']) || 
        $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            $this->error('Requête invalide'); // Token absent ou incorrect
            $this->redirect('accueil');
        }
    }
}
