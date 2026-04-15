<?php

namespace PrediF1\controller;
use PrediF1\model\RaceModel; // Importe le modèle Race pour gérer les courses
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class RaceController extends Controller {

    private $raceModel; // Instance du modèle Race

    public function __construct() {
        $this->raceModel = new RaceModel(); // Instancie le modèle Race
    }

    // Crée une nouvelle course (Admin uniquement)
    public function create() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . "/app/view/layout/header.php";
            require RACINE . "/app/view/admin/createRace.php";
            require RACINE . "/app/view/layout/footer.php";
            return; 
        }
        try {
            $this->raceModel->create([ // Crée la course en BDD
                'name' => $_POST['name'], // Nom du Grand Prix
                'country' => $_POST['country'], // Pays de la course
                'gpStart' => $_POST['gpStart'], // Date de début du GP
                'gpEnd' => $_POST['gpEnd'], // Date de fin du GP
                'raceStart' => $_POST['raceStart'], // Date de la course
                'circuitKey_api' => $_POST['circuitKey_api'], // Identifiant du circuit dans l'API
                'picture' => $_POST['picture'], // Photo du gp
                'status' => $_POST['status'], // statu de la course
            ]);
            $this->success('Course créée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'races'; // Récupère la section ou 'races' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Modifie une course (Admin uniquement)
    public function update() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $id = $_GET['id']; // Récupère l'id de la course à modifier depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->raceModel->update($id, [ // Modifie la course en BDD
                'name' => $_POST['name'], // Nom du Grand Prix
                'country' => $_POST['country'], // Pays de la course
                'gpStart' => $_POST['gpStart'], // Date de début du GP 
                'gpEnd' => $_POST['gpEnd'], // Date de fin du GP
                'raceStart' => $_POST['raceStart'], // Date de la course
                'circuitKey_api' => $_POST['circuitKey_api'], // Identifiant du circuit dans l'API
                'picture' => $_POST['picture'], // Photo du gp
                'status' => $_POST['status'], // statu de la course
            ]);
            $this->success('Course modifiée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'races'; // Récupère la section ou 'races' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Supprime une course (Admin uniquement)
    public function delete() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $id = $_GET['id']; // Récupère l'id de la course à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->raceModel->delete($id); // Supprime la course en BDD
            $this->success('Course supprimée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'races'; // Récupère la section ou 'races' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Ajoute le vainqueur d'une course (Admin uniquement)
    public function addWinner() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $id = $_GET['id']; // Récupère l'id de la course depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        $idWinner = $_POST['idWinner']; // Récupère l'id du pilote vainqueur depuis le formulaire
        if(!is_numeric($idWinner)) { // Vérifie que l'id du vainqueur est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $idWinner = (int)$idWinner; // Convertit l'id en entier
        try {
            $this->raceModel->addWinner($id, $idWinner); // Met à jour le vainqueur en BDD
            $this->success('Vainqueur ajouté avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_GET['section'] ?? 'winner'; // Récupère la section ou 'races' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    public function index() {
        try {
            $races = $this->raceModel->getAllWithWinner();
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        require RACINE . "/app/view/layout/header.php";
        require RACINE . "/app/view/user/races.php"; 
        require RACINE . "/app/view/layout/footer.php";

    }
}


