<?php

namespace TestCDA\controller;
use TestCDA\model\ClientModel; // Importe le modèle Client pour gérer les données client
use TestCDA\model\UserModel; // Importe le modèle User pour gérer les données utilisateur
use Exception; // Nécessaire pour les try catch (classe native PHP, obligatoire avec les namespaces)

class ClientController extends Controller {

    private $clientModel; // Instance du modèle User
    private $userModel;

    public function __construct() {
        $this->clientModel = new ClientModel(); // Instancie le modèle User
        $this->userModel = new UserModel();

    }

    // Affiche tous les clients
    public function index() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon
        try {
            $clients = $this->clientModel->getAll(); // Récupère tous les clients
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        require RACINE . '/app/view/layout/header.php';
        require RACINE . '/app/view/client/clients.php';
        require RACINE . '/app/view/layout/footer.php';
    }

    // Affiche un client
    public function show() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté, redirige sinon

        $id = $_GET['id'];
        if (!is_numeric($id)) {
            $this->redirect('home');
        }
        $id = (int)$id;
        try {
            $client = $this->clientModel->getById($id); // Un utilisateur
        } catch(Exception $e) {
            $this->catchError($e);
            return; // Arrête la fonction
        }
        require RACINE . '/app/view/layout/header.php';
        require RACINE . '/app/view/client/show.php';
        require RACINE . '/app/view/layout/footer.php';
    }

    // Créer une fiche client (admin uniquement)
    public function create() {
        $this->checkAdmin();
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            $this->setTitle('Créer un client'); // ← titre
            require RACINE . '/app/view/layout/header.php'; 
            require RACINE . '/app/view/client/create.php';
            require RACINE . '/app/view/layout/footer.php'; 
            return;
        }
        $this->checkCsrf(); // Vérifie le token CSRF avant tout traitement du formulaire
        try {
            $this->clientModel->create( [ // Modifie l'utilisateur en BDD via son id en session
                'name' => $_POST['name'],
                'firstName' => $_POST['firstName'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'zipCode' => $_POST['zipCode'],
                'city' => $_POST['city']
            ]);
            $this->success('Client crée avec succès !'); // Message de succès
        } catch(Exception $e) {
            error_log($e->getMessage()); // ← log l'erreur
            $this->catchError($e);
            return; // Arrête la fonction
        }
        $this->redirect('clients'); //Redirige vers la route 'profil'
    }

    // Modifie une fiche client (admin uniquement)
    public function update() {
        $this->checkAdmin();
        
        $id = $_GET['id']; // ← récupère l'id dans les deux cas
        if(!is_numeric($id)) {
            $this->redirect('clients');
        }
        $id = (int)$id;

        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // GET → affiche le formulaire pré-rempli
            $this->setTitle('Modifier fiche client');
            try {
                $client = $this->clientModel->getById($id); // ← récupère le client
            } catch(Exception $e) {
                $this->catchError($e);
                return;
            }
            require RACINE . '/app/view/layout/header.php'; 
            require RACINE . '/app/view/client/update.php';
            require RACINE . '/app/view/layout/footer.php'; 
            return;
        }

        // POST → traite le formulaire
        $this->checkCsrf();
        try {
            $this->clientModel->update($id, [
                'name' => $_POST['name'],
                'firstName' => $_POST['firstName'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'zipCode' => $_POST['zipCode'],
                'city' => $_POST['city']
            ]);
            $this->success('Client modifié avec succès !');
        } catch(Exception $e) {
            error_log($e->getMessage());
            $this->catchError($e);
            return;
        }
        $this->redirect('clients');
    }

    
    // Affiche le formulaire de confirmation de suppression et supprime
    public function delete() {
        $this->checkAdmin();
        $id = $_GET['id'];
        if(!is_numeric($id)) {
            $this->redirect('clients');
        }
        $id = (int)$id;
 
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // GET → affiche le formulaire de confirmation
            try {
                $client = $this->clientModel->getById($id); // Récupère le client à supprimer
            } catch(Exception $e) {
                $this->catchError($e);
                return;
            }
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/client/delete.php'; // Formulaire des suppression
            require RACINE . '/app/view/layout/footer.php';
            return;
        }
 
        // vérifie nom + prénom avant de supprimer
        $this->checkCsrf();
        try {
            $client = $this->clientModel->getById($id); // Récupère le client pour vérification
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        // Vérifie que le nom et prénom saisis correspondent bien au client
        if(strtolower(trim($_POST['name'])) !== strtolower(trim($client['name'])) ||
           strtolower(trim($_POST['firstName'])) !== strtolower(trim($client['firstName']))) {
            $this->error('Nom ou prénom incorrect, suppression annulée');
            $this->redirect('clients');
            return;
        }
        try {
            $this->clientModel->delete($id); // Supprime le client en BDD
            $this->success('Client supprimé avec succès !');
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        $this->redirect('clients');
    }


    // Recherche un client par id ou par nom + prénom
    public function search() {
        $this->checkConnexion(); // Vérifie si l'utilisateur est connecté
        if($_SERVER['REQUEST_METHOD'] !== 'POST') { // Si le formulaire n'est pas soumis
            require RACINE . '/app/view/layout/header.php';
            require RACINE . '/app/view/client/search.php';
            require RACINE . '/app/view/layout/footer.php';
            return;
        }
        try {
            if(is_numeric($_POST['search'])) { // Si c'est un nombre → recherche par id
                $client = $this->clientModel->getById((int)$_POST['search']);
            } else { // Sinon → recherche par nom + prénom
                $client = $this->clientModel->getByName($_POST['search']);
            }
        } catch(Exception $e) {
            $this->catchError($e);
            return;
        }
        require RACINE . '/app/view/layout/header.php';
        require RACINE . '/app/view/client/search.php'; // $client disponible dans la vue
        require RACINE . '/app/view/layout/footer.php';
    }

   
}