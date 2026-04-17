<?php

namespace PrediF1\controller;
use PrediF1\model\TeamModel; // Importe le modèle Team pour gérer les Teams
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class TeamController extends Controller {

    private $teamModel; // Instance du modèle Team
    private $driverModel;

    public function __construct() {
        $this->teamModel = new TeamModel(); // Instancie le modèle Team
        
    }

    // Crée une nouvelle écurie (Admin uniquement)
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
            move_uploaded_file($_FILES['picture']['tmp_name'], 'public/img/teams/' . $filename);
            $this->teamModel->create([ // Crée l'écurie en BDD
                'name' => $_POST['name'], // Nom de l'écurie
                'country' => $_POST['country'], // Pays de l'écurie
                'picture' => $filename, // Photo de la voiture
            ]);
            $this->success('Écurie créée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'teams'; // Récupère la section ou 'teams' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }

    // Modifie une écurie (Admin uniquement)
    public function update() {
        $this->checkAdmin(); // Vérifie si l'utilisateur est admin, redirige sinon
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->redirect('admin'); // Redirige vers la route 'admin'
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        $id = $_GET['id']; // Récupère l'id de l'écurie à modifier depuis l'URL
        if(!is_numeric($id)) { // Vérifie que l'id est bien un nombre
            $this->redirect('admin'); // Redirige vers la route 'admin' si l'id est invalide
        }
        $id = (int)$id; // Convertit l'id en entier
        try {
            // Récupère le pilote actuel en BDD pour avoir l'ancienne image
        $team = $this->teamModel->getById($id);

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
            move_uploaded_file($_FILES['picture']['tmp_name'], 'public/img/teams/' . $filename);
        
        // Cas 2 : l'admin n'a pas changé la photo
        } else {
            $filename = $team['picture']; // Récupère l'ancienne image 
        }
            $this->teamModel->update($id, [ // Modifie l'écurie en BDD
                'name' => $_POST['name'], // Nom de l'écurie
                'country' => $_POST['country'], // Pays de l'écurie
                'picture' => $filename, // Photo de l'écurie
            ]);
            $this->success('Écurie modifiée avec succès !'); // Message de succès
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $section = $_POST['section'] ?? 'teams'; // Récupère la section ou 'teams' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
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
        $section = $_GET['section'] ?? 'teams'; // Récupère la section ou 'teams' par défaut
        $this->redirect('admin&section=' . $section); // Redirige vers la bonne section
    }
}
