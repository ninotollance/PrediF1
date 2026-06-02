<?php 

namespace Config;

use TestCDA\controller\HomeController;
use TestCDA\controller\AuthController;
use TestCDA\controller\ClientController;
use TestCDA\controller\AdminController;

class Route {

    public $action; // Stocke l'action récupérée depuis l'URL

    // Récupère l'action dans l'URL ex: "?action=clients"
    public function __construct() {
        $this->action = $_GET["action"] ?? "home";
    }

    public function dispatch() {
        switch ($this->action) {

            // ════════════════════════════════════════
            // HOME
            // ════════════════════════════════════════
            case 'home':
                $ctrl = new ClientController();
                $ctrl->index();
                break;

            // ════════════════════════════════════════
            // AUTHENTIFICATION
            // ════════════════════════════════════════
            case 'login':
                $ctrl = new AuthController();
                $ctrl->showLogin();
                break;

            case 'login-post':
                $ctrl = new AuthController();
                $ctrl->login();
                break;

            case 'register':
                $ctrl = new AuthController();
                $ctrl->showRegister();
                break;

            case 'register-post':
                $ctrl = new AuthController();
                $ctrl->register();
                break;

            case 'logout':
                $ctrl = new AuthController();
                $ctrl->logout();
                break;

            // ════════════════════════════════════════
            // CLIENTS
            // ════════════════════════════════════════
            case 'clients':
                $ctrl = new ClientController();
                $ctrl->index();
                break;
    
            case 'client-show':
                $ctrl = new ClientController();
                $ctrl->show();
                break;

            case 'client-search':
                $ctrl = new ClientController();
                $ctrl->search();
                break;

            case 'client-create':
                $ctrl = new ClientController();
                $ctrl->create();
                break;

            case 'client-update':
                $ctrl = new ClientController();
                $ctrl->update();
                break;

            case 'client-delete':
                $ctrl = new ClientController();
                $ctrl->delete();
                break;

            // ════════════════════════════════════════
            // ADMIN
            // ════════════════════════════════════════
            case 'admin':
                $ctrl = new AdminController();
                $ctrl->dashboard();
                break;

            case 'admin-update-user':
                $ctrl = new AdminController();
                $ctrl->updateUser();
                break;

            case 'admin-delete-user':
                $ctrl = new AdminController();
                $ctrl->deleteUser();
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