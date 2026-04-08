<?php

namespace PrediF1\controller;
use PrediF1\model\TeamModel; // Importe le modèle Team pour gérer les Teams
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class TeamController extends Controller {

    private $teamModel; // Instance du modèle Team

    public function __construct() {
        $this->teamModel = new TeamModel(); // Instancie le modèle Team
    }

    // Crée une nouvelle écurie (Admin uniquement)
    public function create() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        try {
            $this->teamModel->create([ // Crée l'écurie en BDD
                'name' => $_POST['name'], // Nom de l'écurie
                'country' => $_POST['country'], // Pays de l'écurie
                'picture' => $_POST['picture'], // Photo de l'écurie
            ]);
            $this->success('Écurie créée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('admin'); // Redirige vers la route 'admin'
    }

    // Modifie une écurie (Admin uniquement)
    public function update() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $id = $_GET['id']; // Récupère l'id de l'écurie à modifier depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->teamModel->update($id, [ // Modifie l'écurie en BDD
                'name' => $_POST['name'], // Nom de l'écurie
                'country' => $_POST['country'], // Pays de l'écurie
                'picture' => $_POST['picture'], // Photo de l'écurie
            ]);
            $this->success('Écurie modifiée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('admin'); // Redirige vers la route 'admin'
    }

    // Supprime une écurie (Admin uniquement)
    public function delete() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $id = $_GET['id']; // Récupère l'id de l'écurie à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->teamModel->delete($id); // Supprime l'écurie en BDD
            $this->success('Écurie supprimée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('admin'); // Redirige vers la route 'admin'
    }

    // Affiche la liste des pilotes et des écuries (accessible à tous)
    public function index() {
        try {
            $drivers = $this->driverModel->getAllWithTeam(); // Récupère tous les pilotes avec le nom de leur écurie
            $teams = $this->teamModel->getAll();             // Récupère toutes les écuries
        } catch(Exception $e) {
            $this->catchError($e); // Affiche un message d'erreur générique et log l'erreur
            return;                // Arrête la fonction
        }
        require RACINE . "/app/view/layout/header.php"; // Charge le header commun
        require RACINE . "/app/view/user/drivers.php";  // Charge la vue pilotes/écuries ($drivers et $teams disponibles)
        require RACINE . "/app/view/layout/footer.php"; // Charge le footer commun
    }
}
