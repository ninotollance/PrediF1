<?php 

namespace Config;

use PrediF1\controller\HomeController;
use PrediF1\controller\RaceController;
use PrediF1\controller\DriverController;
use PrediF1\controller\UserController;
use PrediF1\controller\BetController;
use PrediF1\controller\AuthController;
use PrediF1\controller\AdminController;
use PrediF1\controller\ContactController;
use PrediF1\controller\TeamController;

class Route {

    public $action; // Stocke l'action récupérée depuis l'URL

    // Récupère l'action dans l'URL ex: "?action=courses"
    // Si aucune action n'est précisée, affiche l'accueil par défaut
    public function __construct() {
        $this->action = $_GET["action"] ?? "accueil";
    }

    public function dispatch() {
        switch ($this->action) {

            // ════════════════════════════════════════
            // HOME
            // ════════════════════════════════════════
            case 'accueil':
                $ctrl = new HomeController();
                $ctrl->index();
                break;

            case 'conditions-utilisation':
                $ctrl = new HomeController();
                $ctrl->terms();
                break;

            case 'confidentialite':
                $ctrl = new HomeController();
                $ctrl->privacy();
                break;

            case 'jeu-responsable':
                $ctrl = new HomeController();
                $ctrl->responsibleGambling();
                break;

            // ════════════════════════════════════════
            // AUTHENTIFICATION
            // ════════════════════════════════════════
            case 'connexion':
                $ctrl = new AuthController();
                $ctrl->showLogin();
                break;

            case 'login':
                $ctrl = new AuthController();
                $ctrl->login();
                break;

            case 'inscription':
                $ctrl = new AuthController();
                $ctrl->showRegister();
                break;

            case 'register':
                $ctrl = new AuthController();
                $ctrl->register();
                break;

            case 'deconnexion':
                $ctrl = new AuthController();
                $ctrl->logout();
                break;

            // ════════════════════════════════════════
            // UTILISATEUR
            // ════════════════════════════════════════
            case 'profil':
                $ctrl = new UserController();
                $ctrl->profile();
                break;

            case 'modifier-profil':
                $ctrl = new UserController();
                $ctrl->update();
                break;

            case 'supprimer-compte':
                $ctrl = new UserController();
                $ctrl->deleteUser();
                break;

            case 'historique-paris':
                $ctrl = new UserController();
                $ctrl->betHistory();
                break;

            // ════════════════════════════════════════
            // COURSES
            // ════════════════════════════════════════

            case 'admin-creer-course':
                $ctrl = new RaceController();
                $ctrl->create();
                break;

            case 'admin-modifier-course':
                $ctrl = new RaceController();
                $ctrl->update();
                break;

            case 'admin-supprimer-course':
                $ctrl = new RaceController();
                $ctrl->delete();
                break;

            case 'admin-ajouter-vainqueur':
                $ctrl = new RaceController();
                $ctrl->addWinner();
                break;

            case 'courses':
                $ctrl = new RaceController();
                $ctrl->index();
                break;

            // ════════════════════════════════════════
            // PILOTES
            // ════════════════════════════════════════

            case 'admin-creer-pilote':
                $ctrl = new DriverController();
                $ctrl->create();
                break;

            case 'admin-modifier-pilote':
                $ctrl = new DriverController();
                $ctrl->update();
                break;

            case 'admin-supprimer-pilote':
                $ctrl = new DriverController();
                $ctrl->delete();
                break;

            case 'pilotes':
                $ctrl = new DriverController();
                $ctrl->index();
                break;

            // ════════════════════════════════════════
            // ÉCURIES
            // ════════════════════════════════════════
            case 'admin-creer-ecuries':
                $ctrl = new TeamController();
                $ctrl->create();
                break;

            case 'admin-modifier-ecuries':
                $ctrl = new TeamController();
                $ctrl->update();
                break;

            case 'admin-supprimer-ecuries':
                $ctrl = new TeamController();
                $ctrl->delete();
                break;

            case 'ecuries':
                $ctrl = new TeamController();
                $ctrl->index();
                break;

            // ════════════════════════════════════════
            // PARIS
            // ════════════════════════════════════════
            case 'parier':
                $ctrl = new BetController();
                $ctrl->showBet();
                break;
                
            case 'creer-pari':
                $ctrl = new BetController();
                $ctrl->createByUser();
                break;

            case 'supprimer-pari':
                $ctrl = new BetController();
                $ctrl->deleteByUser();
                break;

            case 'admin-creer-pari':
                $ctrl = new BetController();
                $ctrl->createByAdmin();
                break;

            case 'admin-supprimer-pari':
                $ctrl = new BetController();
                $ctrl->deleteByAdmin();
                break;

            // ════════════════════════════════════════
            // ADMIN
            // ════════════════════════════════════════
            case 'admin':
                $ctrl = new AdminController();
                $ctrl->dashboard();
                break;

            case 'admin-modifier-user':
                $ctrl = new AdminController();
                $ctrl->updateUser();
                break;

            case 'admin-supprimer-user':
                $ctrl = new AdminController();
                $ctrl->deleteUser();
                break;

            // ════════════════════════════════════════
            // CONTACT
            // ════════════════════════════════════════
            case 'contact':
                $ctrl = new ContactController();
                $ctrl->show();
                break;

            case 'envoyer-contact':
                $ctrl = new ContactController();
                $ctrl->send();
                break;

            // ════════════════════════════════════════
            // 404
            // ════════════════════════════════════════
            default:
                require_once RACINE . '/app/view/user/404.php';
                break;
        }
    }
}