<?php

namespace PrediF1\controller;
use PrediF1\model\DriverModel; // Importe le modèle Driver
use PrediF1\model\TeamModel; // Importe le modèle Team
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class DriverController extends Controller {

    private $driverModel;
    private $teamModel;

    public function __construct(){
        $this->driverModel = new DriverModel();
        $this->teamModel = new TeamModel();
    }

    // Crée un nouveau pilote (Admin uniquement)
    public function create() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        try {
            // Récupère le nom original du fichier
            $filename = $_FILES['picture']['name'];

            // Récupère l'extension du fichier en minuscules ex: "jpg", "png"
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            
            // Liste des extensions autorisées
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            
            // Vérifie que l'extension est bien dans la liste autorisée
            if(!in_array($extension, $allowedExtensions)) {
                $this->error('Format de fichier non autorisé');
                $this->redirect('admin');
                return;
            }

            // Déplace le fichier :
            // - depuis le dossier temporaire → $_FILES['picture']['tmp_name']
            // - vers notre dossier           → 'public/img/drivers/' . $filename
            move_uploaded_file($_FILES['picture']['tmp_name'], 'public/img/drivers/' . $filename);

            $this->driverModel->create([ // Crée le pilote en BDD
                'name' => $_POST['name'], // Nom du pilote
                'firstName' => $_POST['firstName'], // Prénom du pilote
                'number_api' => $_POST['number_api'], // Numéro du pilote dans l'API
                'idTeam' => $_POST['idTeam'], // Écurie du pilotes
                'picture' => $filename, // Photo du pilote
            ]);
            $this->success('Pilote ajouté avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'drivers'; // Récupère la section ou 'drivers' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Modifie un pilote (Admin uniquement)
    public function update() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        $id = $_GET['id']; // Récupère l'id du pilote à modifier depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
        // Récupère le pilote actuel en BDD pour avoir l'ancienne image
        $driver = $this->driverModel->getById($id);

        // Cas 1 : l'admin a uploadé une nouvelle image
        if(!empty($_FILES['picture']['name'])) {
            $filename = $_FILES['picture']['name'];
            $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
            if(!in_array($extension, $allowedExtensions)) {
                $this->error('Format de fichier non autorisé');
                $this->redirect('admin');
                return;
            }
            move_uploaded_file($_FILES['picture']['tmp_name'], 'public/img/drivers/' . $filename);
        
        // Cas 2 : l'admin n'a pas changé la photo
        } else {
            $filename = $driver['picture']; // Récupère l'ancienne image 
        }

            $this->driverModel->update($id, [ // Modifie le pilote en BDD
                'name' => $_POST['name'], // Nom du pilote
                'firstName' => $_POST['firstName'], // Prénom du pilote
                'number_api' => $_POST['number_api'], // Numéro du pilote dans l'API
                'picture' => $filename, // Photo du pilote
                'idTeam' => $_POST['idTeam'], // Écurie du pilotes
            ]);
            $this->success('Pilote mis à jour avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
            
        }
        $section = $_POST['section'] ?? 'drivers'; // Récupère la section ou 'drivers' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Supprime un pilote (Admin uniquement)
    public function delete() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        $id = $_GET['id']; // Récupère l'id du pilote à supprimer depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            $this->driverModel->delete($id); // Supprime le pilote en BDD
            $this->success('Pilote supprimé avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_GET['section'] ?? 'drivers'; // Récupère la section ou 'drivers' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
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
        $this->setTitle('Pilotes & Écuries - PrediF1');
        require RACINE . "/app/view/layout/header.php"; // Charge le header commun
        require RACINE . "/app/view/user/drivers.php";  // Charge la vue pilotes/écuries ($drivers et $teams disponibles)
        require RACINE . "/app/view/layout/footer.php"; // Charge le footer commun
    }
}
